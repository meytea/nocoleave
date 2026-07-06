<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HakCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanCuti;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $sisaCutiTahunan = HakCuti::where('user_id', $user->id)
            ->whereHas('jenisCuti', function ($query) {
                $query->where('is_tahunan', true);
            })
            ->sum('sisa');

        $pengajuanDisetujui = PengajuanCuti::where(
            'user_id',
            $user->id
        )
            ->where('status', 'disetujui')
            ->count();

        $pengajuanDitolak = PengajuanCuti::where(
            'user_id',
            $user->id
        )
            ->where('status', 'ditolak')
            ->count();


        // $pengajuanTerbaru = PengajuanCuti::with('jenisCuti')
        //     ->where('user_id', $user->id)
        //     ->latest()
        //     ->take(5)
        //     ->get();

        $pengajuanCuti = PengajuanCuti::with('jenisCuti')
            ->where('user_id', $user->id)

            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Cari berdasarkan jenis cuti
                    $q->whereHas('jenisCuti', function ($jenis) use ($search) {

                        $jenis->where(
                            'nama_cuti',
                            'like',
                            "%{$search}%"
                        );
                    })

                        // Cari berdasarkan status
                        ->orWhere(
                            'status',
                            'like',
                            "%{$search}%"
                        )

                        // Cari berdasarkan tanggal
                        ->orWhere(
                            'tanggal_mulai',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'tanggal_selesai',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'tanggal_masuk',
                            'like',
                            "%{$search}%"
                        );
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'dashboard.karyawan',
            compact(
                'sisaCutiTahunan',
                'pengajuanDisetujui',
                'pengajuanDitolak',
                // 'pengajuanTerbaru',
                'pengajuanCuti'
            )
        );
    }
}
