<?php

namespace App\Http\Controllers\Head;

use App\Models\ApprovalCuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Head;
use App\Models\HakCuti;

class ApprovalCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $divisi = Head::where('user_id', $user->id)
            ->pluck('divisi_id');

        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'pending_head')
            ->whereHas('user', function ($query) use ($divisi) {
                $query->whereIn('divisi_id', $divisi);
            })
            ->latest()
            ->paginate(10);

        return view(
            'head.approval_cuti.index',
            compact('pengajuan_cuti')
        );
    }

    public function pengajuanDitolak()
    {
        $user = Auth::user();

        $divisi = Head::where('user_id', $user->id)
            ->pluck('divisi_id');

        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'ditolak')
            ->whereHas('user', function ($query) use ($divisi) {
                $query->whereIn('divisi_id', $divisi);
            })
            ->latest()
            ->paginate(10);

        return view(
            'head.approval_cuti.ditolak',
            compact('pengajuan_cuti')
        );
    }

    public function pengajuanDisetujui()
    {
        $user = Auth::user();

        $divisi = Head::where('user_id', $user->id)
            ->pluck('divisi_id');

        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->whereIn('status', [
                'pending_head',
                'disetujui'
            ])
            ->whereHas('user', function ($query) use ($divisi) {
                $query->whereIn('divisi_id', $divisi);
            })
            ->latest()
            ->paginate(10);

        return view(
            'head.approval_cuti.disetujui',
            compact('pengajuan_cuti')
        );

        //return "Halaman pengajuan cuti yang ditolak oleh lead. Fitur ini masih dalam pengembangan.";
    }

    public function setuju(PengajuanCuti $pengajuanCuti)
    {
        if ($pengajuanCuti->status !== 'pending_head') {
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

            $hakCuti = HakCuti::where('user_id', $pengajuanCuti->user_id)
                ->where('jenis_cuti_id', $pengajuanCuti->jenis_cuti_id)
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

        if ($pengajuanCuti->status !== 'pending_lead') {
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ApprovalCuti $approvalCuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApprovalCuti $approvalCuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApprovalCuti $approvalCuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApprovalCuti $approvalCuti)
    {
        //
    }
}
