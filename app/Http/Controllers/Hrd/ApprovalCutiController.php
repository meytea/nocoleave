<?php

namespace App\Http\Controllers\Hrd;

use App\Models\ApprovalCuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApprovalCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $pengajuan_cuti = PengajuanCuti::with(['user', 'jenisCuti'])
            ->where('status', 'pending_hrd')
            ->latest()
            ->paginate(10);

        return view('hrd.approval_cuti.index', compact('pengajuan_cuti'));
    }

    public function pengajuanDitolak()
    {
        $user = Auth::user();
        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'ditolak')
            ->latest()
            ->paginate(10);

        return view('hrd.approval_cuti.ditolak', compact('pengajuan_cuti'));

        //return "Halaman pengajuan cuti yang ditolak oleh lead. Fitur ini masih dalam pengembangan.";
    }
    public function pengajuanDisetujui()
    {
        $user = Auth::user();

        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->whereIn('status', [
                'pending_head',
                'disetujui'
            ])
            ->latest()
            ->paginate(10);

        return view('hrd.approval_cuti.disetujui', compact('pengajuan_cuti'));

        //return "Halaman pengajuan cuti yang ditolak oleh lead. Fitur ini masih dalam pengembangan.";
    }

    public function setuju(PengajuanCuti $pengajuanCuti)
    {
        if ($pengajuanCuti->status !== 'pending_hrd') {
            return redirect()->back()
                ->with('error', 'Pengajuan sudah diproses.');
        }

        $head = User::role('head')->first();

        if (!$head) {
            return redirect()->back()
                ->with('error', 'User Head tidak ditemukan.');
        }

        ApprovalCuti::create([
            'pengajuan_cuti_id' => $pengajuanCuti->id,
            'approver_id'       => Auth::id(),
            'status'            => 'disetujui',
            'catatan'           => null,
            'created_at'        => now(),
        ]);

        $pengajuanCuti->update([
            'status'              => 'pending_head',
            'current_approver_id' => $head->id,
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan berhasil diteruskan ke Head.');
    }

    public function tolak(Request $request, PengajuanCuti $pengajuanCuti)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        if ($pengajuanCuti->status !== 'pending_hrd') {
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
            'status'               => 'ditolak',
            'ditolak_oleh'         => Auth::id(),
            'alasan_penolakan'     => $request->alasan_penolakan,
            'current_approver_id'  => null,
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
