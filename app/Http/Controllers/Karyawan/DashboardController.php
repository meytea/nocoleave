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


        $pengajuanTerbaru = PengajuanCuti::with('jenisCuti')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $pengajuanCuti = PengajuanCuti::where('user_id', $user->id)
            ->paginate(10)
            ->withQueryString();

        return view(
            'dashboard.karyawan',
            compact(
                'sisaCutiTahunan',
                'pengajuanDisetujui',
                'pengajuanDitolak',
                'pengajuanTerbaru',
                'pengajuanCuti'
            )
        );
    }
}
