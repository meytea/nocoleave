<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\ApprovalCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\JenisCuti;


class RiwayatApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jenisCuti = JenisCuti::orderBy('nama_cuti')->get();

        $riwayatApproval = ApprovalCuti::with([
            'approver.roles',
            'pengajuanCuti.user',
            'pengajuanCuti.jenisCuti'
        ])

            // Search
            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Nama Karyawan
                    $q->whereHas('pengajuanCuti.user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%");
                    })

                        // Jenis Cuti
                        ->orWhereHas('pengajuanCuti.jenisCuti', function ($jenis) use ($search) {

                            $jenis->where(
                                'nama_cuti',
                                'like',
                                "%{$search}%"
                            );
                        })

                        // Nama Approver
                        ->orWhereHas('approver', function ($approver) use ($search) {

                            $approver->where('name', 'like', "%{$search}%");
                        })

                        // Jabatan Approver
                        ->orWhereHas('approver.roles', function ($role) use ($search) {

                            $role->where('name', 'like', "%{$search}%");
                        })

                        // Status
                        ->orWhere(
                            'status',
                            'like',
                            "%{$search}%"
                        )

                        // Catatan
                        ->orWhere(
                            'catatan',
                            'like',
                            "%{$search}%"
                        );
                });
            })

            // Filter Status
            ->when($request->status, function ($query) use ($request) {

                $query->where('status', $request->status);
            })

            // Filter Jenis Cuti
            ->when($request->jenis_cuti, function ($query) use ($request) {

                $query->whereHas('pengajuanCuti.jenisCuti', function ($jenis) use ($request) {

                    $jenis->where('id', $request->jenis_cuti);
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'hrd.riwayat_approval.index',
            compact(
                'riwayatApproval',
                'jenisCuti'
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
    public function show(string $id)
    {
        //
    }

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
