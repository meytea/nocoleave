<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HakCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanCuti;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Karyawan
        $totalKaryawan = User::whereHas('roles', function ($query) {
            $query->whereIn('name', [ 'karyawan', 'lead', 'head', 'hrd']);
             })
             ->count();

        // Sedang Cuti Hari Ini
        $sedangCutiHariIni = PengajuanCuti::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_selesai', '>=', Carbon::today())
            ->count();

        // Pending HRD
        $pendingHrd = PengajuanCuti::where('status', 'pending_hrd')
            ->count();

        // Tabel pengajuan Cuti
        $pengajuanCuti = PengajuanCuti::with(['user', 'jenisCuti'])
            ->latest()
            ->paginate(10);

        return view(
            'dashboard.hrd',
            compact(
                'totalKaryawan',
                'sedangCutiHariIni',
                'pendingHrd',
                'pengajuanCuti'
            )
        );
    }
}
