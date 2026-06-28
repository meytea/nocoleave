<?php

namespace App\Http\Controllers\Direktur;

use App\Models\ApprovalCuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\HakCuti;

class ApprovalCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'pending_direktur')
            ->latest()
            ->paginate(10);

        return view('direktur.approval_cuti.index', compact('pengajuan_cuti'));
    }

    public function pengajuanDitolak()
    {
        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'ditolak')
            ->latest()
            ->paginate(10);

        return view('direktur.approval_cuti.ditolak', compact('pengajuan_cuti'));
    }

    public function pengajuanDisetujui()
    {
        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'disetujui')
            ->latest()
            ->paginate(10);

        return view('direktur.approval_cuti.disetujui', compact('pengajuan_cuti'));
    }

    public function setuju(PengajuanCuti $pengajuanCuti)
    {
        if ($pengajuanCuti->status !== 'pending_direktur') {
            return redirect()->back()
                ->with('error', 'Pengajuan sudah diproses.');
        }

        ApprovalCuti::create([
            'pengajuan_cuti_id' => $pengajuanCuti->id,
            'approver_id'       => Auth::id(),
            'status'            => 'disetujui',
            'catatan'           => null,
            'created_at'        => now(),
        ]);

        // Ambil relasi jenis cuti
        $pengajuanCuti->load('jenisCuti');

        // Hanya cuti tahunan yang mengurangi kuota
        if ($pengajuanCuti->jenisCuti->is_tahunan) {

            $tahunCuti = \Carbon\Carbon::parse(
                $pengajuanCuti->tanggal_mulai
            )->year;

            $hakCuti = HakCuti::where('user_id', $pengajuanCuti->user_id)
                ->where('jenis_cuti_id', $pengajuanCuti->jenis_cuti_id)
                ->where('tahun', $tahunCuti)
                ->first();

            if ($hakCuti) {
                $hakCuti->update([
                    'terpakai' => $hakCuti->terpakai + $pengajuanCuti->jumlah_hari,
                    'sisa'     => $hakCuti->sisa - $pengajuanCuti->jumlah_hari,
                ]);
            }
        }

        $pengajuanCuti->update([
            'status'              => 'disetujui',
            'approved_at'         => now(),
            'current_approver_id' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    public function tolak(Request $request, PengajuanCuti $pengajuanCuti)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        if ($pengajuanCuti->status !== 'pending_direktur') {
            return redirect()->back()
                ->with('error', 'Pengajuan sudah diproses.');
        }

        ApprovalCuti::create([
            'pengajuan_cuti_id' => $pengajuanCuti->id,
            'approver_id'       => Auth::id(),
            'status'            => 'ditolak',
            'catatan'           => $request->alasan_penolakan,
            'created_at'        => now(),
        ]);

        $pengajuanCuti->update([
            'status'             => 'ditolak',
            'ditolak_oleh'       => Auth::id(),
            'alasan_penolakan'   => $request->alasan_penolakan,
            'current_approver_id' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
