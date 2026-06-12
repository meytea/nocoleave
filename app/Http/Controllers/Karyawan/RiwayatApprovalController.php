<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\ApprovalCuti;
use Illuminate\Support\Facades\Auth;


class RiwayatApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $riwayatApproval = ApprovalCuti::with([
            'approver',
            'pengajuanCuti.user',
            'pengajuanCuti.jenisCuti'
        ])
            ->where('approver_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('karyawan.riwayat_approval.index', compact('riwayatApproval'));
    }

    public function show(PengajuanCuti $pengajuanCuti)
    {
        $user = Auth::user();

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
            'karyawan.pengajuan_cuti.detail',
            compact(
                'riwayatApproval',
                'pengajuanCuti'
            )
        );
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
