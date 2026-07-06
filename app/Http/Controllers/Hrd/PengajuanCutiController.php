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
    //Tampilan Index Pengajuan Cuti
    public function index(Request $request)
    {
        $user = Auth::user();
        $jenisCutiList = JenisCuti::all();

        $query = PengajuanCuti::where('user_id', $user->id)
            ->with(['user', 'jenisCuti'])
            ->latest();

        if ($request->filled('jenis_cuti_id')) {
            $query->where('jenis_cuti_id', $request->jenis_cuti_id);
        }

        $pengajuanCuti = $query->paginate(10)->withQueryString();

        return view('hrd.pengajuan_cuti.index', compact('pengajuanCuti', 'jenisCutiList'));
    }

    // Tambah Pengajuan Cuti
    public function create()
    {

        $user = Auth::user();
        $jenisCuti = JenisCuti::all();
        $hakCuti = HakCuti::with('jenisCuti')->where('user_id', $user->id)->get();

        // compact : buat ngirim data yang di panggil ke view, kalo ga ada ini, cuma dipanggil aja tapi ga ditampilin
        return view('hrd.pengajuan_cuti.create', compact('jenisCuti', 'hakCuti'));
    }

    // Simpan Pengajuan Cuti
    public function store(Request $request)
    {
        $user = Auth::user();
        // Validasi input
        $validated = $request->validate([
            'jenis_cuti_id' => 'required|exists:jenis_cuti,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_masuk' => 'required|date',
            'alasan' => 'required|string|min:1',
        ]);

        // Dapatkan jenis cuti
        $jenisCuti = JenisCuti::findOrFail($validated['jenis_cuti_id']);

        // Hitung jumlah hari kerja (exclude Sunday)
        $jumlahHari = $this->calculateWorkDays(
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai']
        );

        $tahunCuti = Carbon::parse(
            $validated['tanggal_mulai']
        )->year;

        // Validasi sisa cuti jika jenis cuti adalah tahunan
        if ($jenisCuti->is_tahunan) {
            $hakCuti = HakCuti::where('user_id', $user->id)
                ->where('jenis_cuti_id', $validated['jenis_cuti_id'])
                ->where('tahun', $tahunCuti)
                ->first();

            if (!$hakCuti || $hakCuti->sisa < $jumlahHari) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Sisa cuti tidak mencukupi untuk jenis cuti yang dipilih');
            }
        }

        // Hitung tanggal masuk (hari kerja pertama setelah cuti selesai)
        $tanggalMasukCalculated = $this->calculateTanggalMasuk($validated['tanggal_selesai']);

        // Simpan pengajuan cuti
        PengajuanCuti::create([
            'user_id' => $user->id,
            'jenis_cuti_id' => $validated['jenis_cuti_id'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'tanggal_masuk' => $tanggalMasukCalculated,
            'jumlah_hari' => $jumlahHari,
            'alasan' => $validated['alasan'],
            'status' => 'pending_direktur',
        ]);

        return redirect()
            ->route('hrd.pengajuan_cuti.index')
            ->with('success', 'Pengajuan cuti berhasil dibuat dan menunggu persetujuan');
    }

    // Detail Pengajuan Cuti
    // public function show(PengajuanCuti $pengajuanCuti)
    // {
    //     $user = Auth::user();

    //     if ($pengajuanCuti->user_id != $user->id) {
    //         abort(403);
    //     }

    //     $pengajuanCuti->load([
    //         'user',
    //         'jenisCuti'
    //     ]);

    //     $riwayatApproval = ApprovalCuti::with([
    //         'approver'
    //     ])
    //         ->where('pengajuan_cuti_id', $pengajuanCuti->id)
    //         ->latest()
    //         ->get();

    //     return view(
    //         'hrd.pengajuan_cuti.detail',
    //         compact(
    //             'riwayatApproval',
    //             'pengajuanCuti'
    //         )
    //     );
    // }

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



        $rolePengaju = $pengajuanCuti
            ->user
            ->getRoleNames()
            ->first();

        $workflow = match ($rolePengaju) {
            'karyawan' => ['Pengajuan', 'Lead', 'HRD', 'Head'],
            'lead' => ['Pengajuan', 'HRD', 'Head'],
            'head' => ['Pengajuan', 'HRD', 'Direktur'],
            'hrd' => ['Pengajuan', 'Direktur'],
            default => ['Pengajuan'],
        };

        $currentStep = match ($pengajuanCuti->status) {

            'pending_direktur' => 1,

            'disetujui' => count($workflow),

            'ditolak' => -1,

            default => 1,
        };

        $rejectedStep = null;

        if (
            $pengajuanCuti->status === 'ditolak'
            && $riwayatApproval->isNotEmpty()
        ) {

            $rejectedRole = $riwayatApproval
                ->first()
                ->approver
                ->getRoleNames()
                ->first();

            $rejectedStep = match ($rejectedRole) {

                'direktur' => 1,

                default => null,
            };
        }

        return view(
            'hrd.pengajuan_cuti.detail',
            compact(
                'riwayatApproval',
                'pengajuanCuti',
                'rolePengaju',
                'workflow',
                'currentStep',
                'rejectedStep'
            )
        );
    }

    // Edit Pengajuan Cuti
    public function edit(PengajuanCuti $pengajuanCuti)
    {
        if ($pengajuanCuti->status !== 'pending_direktur') {

            return redirect()
                ->route('hrd.pengajuan_cuti.index')
                ->with('error', 'Pengajuan sudah diproses dan tidak dapat diubah.');
        }

        $user = Auth::user();

        $jenisCuti = JenisCuti::all();

        $hakCuti = HakCuti::with('jenisCuti')
            ->where('user_id', $user->id)
            ->get();

        return view(
            'hrd.pengajuan_cuti.edit',
            compact(
                'pengajuanCuti',
                'jenisCuti',
                'hakCuti'
            )
        );
    }

    // Edit Pengajuan Cuti
    public function update(
        Request $request,
        PengajuanCuti $pengajuanCuti
    ) {
        if ($pengajuanCuti->status !== 'pending_direktur') {

            return redirect()
                ->route('hrd.pengajuan_cuti.index')
                ->with('error', 'Pengajuan sudah diproses dan tidak dapat diubah.');
        }

        $user = Auth::user();

        $validated = $request->validate([
            'jenis_cuti_id' => 'required|exists:jenis_cuti,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_masuk' => 'required|date',
            'alasan' => 'required|string|min:1',
        ]);

        $jenisCuti = JenisCuti::findOrFail(
            $validated['jenis_cuti_id']
        );

        $jumlahHari = $this->calculateWorkDays(
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai']
        );

        $tahunCuti = Carbon::parse(
            $validated['tanggal_mulai']
        )->year;

        if ($jenisCuti->is_tahunan) {

            $hakCuti = HakCuti::where('user_id', $user->id)
                ->where('jenis_cuti_id', $validated['jenis_cuti_id'])
                ->where('tahun', $tahunCuti)
                ->first();

            if (!$hakCuti || $hakCuti->sisa < $jumlahHari) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Sisa cuti tidak mencukupi untuk jenis cuti yang dipilih'
                    );
            }
        }

        $tanggalMasukCalculated =
            $this->calculateTanggalMasuk(
                $validated['tanggal_selesai']
            );

        $pengajuanCuti->update([
            'jenis_cuti_id' => $validated['jenis_cuti_id'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'tanggal_masuk' => $tanggalMasukCalculated,
            'jumlah_hari' => $jumlahHari,
            'alasan' => $validated['alasan'],
        ]);

        return redirect()
            ->route('hrd.pengajuan_cuti.index')
            ->with(
                'success',
                'Pengajuan cuti berhasil diperbarui.'
            );
    }


    // Tampilan Pengajuan Disetujui
    public function pengajuanDisetujui(Request $request)
    {
        $user = Auth::user();

        $jenisCutiList = JenisCuti::all();

        $query = PengajuanCuti::with('jenisCuti')
            ->where('user_id', $user->id)
            ->whereIn('status', [
                'pending_head',
                'disetujui'
            ]);

        if ($request->filled('jenis_cuti_id')) {

            $query->where(
                'jenis_cuti_id',
                $request->jenis_cuti_id
            );
        }

        $pengajuanCuti = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'hrd.pengajuan_cuti.disetujui',
            compact(
                'pengajuanCuti',
                'jenisCutiList'
            )
        );
    }

    // Tampilan Pengajuan Ditolak
    public function pengajuanDitolak(Request $request)
    {
        $user = Auth::user();

        $jenisCutiList = JenisCuti::all();

        $query = PengajuanCuti::with('jenisCuti')
            ->where('user_id', $user->id)
            ->where('status', 'ditolak');

        if ($request->filled('jenis_cuti_id')) {

            $query->where(
                'jenis_cuti_id',
                $request->jenis_cuti_id
            );
        }

        $pengajuanCuti = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'hrd.pengajuan_cuti.ditolak',
            compact(
                'pengajuanCuti',
                'jenisCutiList'
            )
        );
    }


    // Untuk menghitung jumlah hari kerja (exclude Sunday) antara tanggal mulai dan tanggal selesai
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

    // Untuk menghitung tanggal masuk (hari kerja pertama setelah cuti selesai)
    private function calculateTanggalMasuk($tanggalSelesai)
    {
        $tanggalMasuk = Carbon::parse($tanggalSelesai)->addDay();

        // Jika Minggu (0), lompat ke Senin
        if ($tanggalMasuk->dayOfWeek === Carbon::SUNDAY) {
            $tanggalMasuk->addDay();
        }

        return $tanggalMasuk;
    }

    // Hapus Pengajuan Cuti 
    public function destroy(
        PengajuanCuti $pengajuanCuti
    ) {
        if ($pengajuanCuti->status !== 'pending_direktur') {

            return redirect()
                ->route('hrd.pengajuan_cuti.index')
                ->with(
                    'error',
                    'Pengajuan sudah diproses dan tidak dapat dihapus.'
                );
        }

        $pengajuanCuti->delete();

        return redirect()
            ->route('hrd.pengajuan_cuti.index')
            ->with(
                'success',
                'Pengajuan cuti berhasil dihapus.'
            );
    }
}
