<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApprovalCuti;
use App\Models\JenisCuti;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanCutiTahunanExport;
use App\Exports\LaporanCutiNonTahunanExport;


class RiwayatCutiController extends Controller
{
    public function index(Request $request)
{
    $pengajuanCuti = PengajuanCuti::with([
        'user.roles',
        'user.divisi',
        'jenisCuti'
    ])
        ->where('status', 'disetujui')
        ->whereDate('tanggal_mulai', '<=', today())
        ->whereDate('tanggal_selesai', '>=', today())

        ->when($request->search, function ($query) use ($request) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Nama, NIK, Jabatan, Divisi
                $q->whereHas('user', function ($user) use ($search) {

                    $user->where('name', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhereHas('roles', function ($role) use ($search) {
                            $role->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('divisi', function ($divisi) use ($search) {
                            $divisi->where('nama_divisi', 'like', "%{$search}%");
                        });
                })

                // Jenis cuti
                ->orWhereHas('jenisCuti', function ($jenis) use ($search) {

                    $jenis->where(
                        'nama_cuti',
                        'like',
                        "%{$search}%"
                    );

                });

            });

        })

        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view(
        'direktur.riwayat_cuti.index',
        compact('pengajuanCuti')
    );
}

public function show($id)
    {
        $pengajuanCuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])->findOrFail($id);

        $riwayatApproval = ApprovalCuti::with([
            'approver.roles'
        ])
            ->where('pengajuan_cuti_id', $pengajuanCuti->id)
            ->latest()
            ->get();

        return view(
            'direktur.riwayat_cuti.detail',
            compact(
                'riwayatApproval',
                'pengajuanCuti'
            )
        );
    }

    public function laporan()
    {
        $jenisCuti = JenisCuti::orderBy('nama_cuti')->get();

        return view(
            'direktur.riwayat_cuti.laporan',
            compact('jenisCuti')
        );
    }

    public function export(Request $request)
    {
        if ($request->jenis_laporan == 'tahunan') {

            return Excel::download(
                new LaporanCutiTahunanExport($request->tahun),
                'Laporan_Cuti_Tahunan_' . $request->tahun . '.xlsx'
            );
        }

        return Excel::download(
            new LaporanCutiNonTahunanExport(
                $request->tahun,
                $request->jenis_cuti_id
            ),
            'Laporan_Cuti_Non_Tahunan_' . $request->tahun . '.xlsx'
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


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
}
