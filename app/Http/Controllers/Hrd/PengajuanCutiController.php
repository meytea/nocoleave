<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\JenisCuti;
use App\Models\HakCuti;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use App\Models\ApprovalCuti;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of pengajuan cuti milik user login
     */
    public function index()
    {
        $user = Auth::user();
        $pengajuanCuti = PengajuanCuti::where('user_id', $user->id)
            ->with(['user', 'jenisCuti'])
            ->latest()
            ->paginate(10);

        return view('hrd.pengajuan_cuti.index', compact('pengajuanCuti'));
    }

    /**
     * Show the form for creating a new pengajuan cuti
     */
    public function create()
    {

        $user= Auth::user();
        $jenisCuti = JenisCuti::all();
        $hakCuti = HakCuti::with('jenisCuti')->where('user_id', $user->id)->get();

        // compact : buat ngirim data yang di panggil ke view, kalo ga ada ini, cuma dipanggil aja tapi ga ditampilin
        return view('hrd.pengajuan_cuti.create', compact('jenisCuti', 'hakCuti'));
    }

    /**
     * Store a newly created pengajuan cuti in database
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        // Validasi input
        $validated = $request->validate([
            'jenis_cuti_id' => 'required|exists:jenis_cuti,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|min:10',
        ]);

        // Dapatkan jenis cuti
        $jenisCuti = JenisCuti::findOrFail($validated['jenis_cuti_id']);

        // Hitung jumlah hari kerja (exclude Sunday)
        $jumlahHari = $this->calculateWorkDays(
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai']
        );

        // Validasi sisa cuti jika jenis cuti adalah tahunan
        if ($jenisCuti->is_tahunan) {
            $hakCuti = HakCuti::where('user_id', $user->id)
                ->where('jenis_cuti_id', $validated['jenis_cuti_id'])
                ->where('tahun', now()->year)
                ->first();

            if (!$hakCuti || $hakCuti->sisa < $jumlahHari) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Sisa cuti tidak mencukupi untuk jenis cuti yang dipilih');
            }
        }


        // Simpan pengajuan cuti
        PengajuanCuti::create([
            'user_id' => $user->id,
            'jenis_cuti_id' => $validated['jenis_cuti_id'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'jumlah_hari' => $jumlahHari,
            'alasan' => $validated['alasan'],
            'status' => 'pending_direktur',
        ]);

        return redirect()
            ->route('hrd.pengajuan_cuti.index')
            ->with('success', 'Pengajuan cuti berhasil dibuat dan menunggu persetujuan');
    }

    public function show(PengajuanCuti $pengajuanCuti)
    {
        $user = Auth::user();

        if ($pengajuanCuti->user_id != $user->id) {
            abort(403);
        }

        $pengajuanCuti->load([
            'user',
            'jenisCuti'
        ]);

        $riwayatApproval = ApprovalCuti::with([
            'approver'
        ])
            ->where('pengajuan_cuti_id', $pengajuanCuti->id)
            ->latest()
            ->get();

        return view(
            'lead.pengajuan_cuti.detail',
            compact(
                'riwayatApproval',
                'pengajuanCuti'
            )
        );
    }

    public function pengajuanDisetujui()
    {
        $user = Auth::user();

        $pengajuanCuti = PengajuanCuti::with([
            'jenisCuti'
        ])
            ->where('user_id', $user->id)
            ->whereIn('status', [
                'pending_hrd',
                'pending_head',
                'disetujui'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'karyawan.pengajuan_cuti.disetujui',
            compact('pengajuanCuti')
        );
    }

    public function pengajuanDitolak()
    {
        $user = Auth::user();

        $pengajuanCuti = PengajuanCuti::with([
            'jenisCuti'
        ])
            ->where('user_id', $user->id)
            ->where('status', 'ditolak')
            ->latest()
            ->paginate(10);

        return view(
            'karyawan.pengajuan_cuti.ditolak',
            compact('pengajuanCuti')
        );
    }
    /**
     * Calculate work days between two dates (exclude Sundays)
     */
    private function calculateWorkDays($tanggalMulai, $tanggalSelesai)
    {
        $count = 0;
        $current = Carbon::parse($tanggalMulai);
        $end = Carbon::parse($tanggalSelesai);

        while ($current <= $end) {
            // Jika bukan hari Minggu (0 = Sunday)
            if ($current->dayOfWeek != Carbon::SUNDAY) {
                $count++;
            }
            $current->addDay();
        }

        return $count;
    }

    
}
