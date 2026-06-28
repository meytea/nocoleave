<?php

namespace App\Http\Controllers\Direktur;

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
            $query->whereIn('name', ['karyawan', 'lead', 'head', 'hrd']);
        })
            ->count();

        // Sedang Cuti Hari Ini
        $sedangCutiHariIni = PengajuanCuti::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_selesai', '>=', Carbon::today())
            ->count();

        // Pending Direktur
        $pendingDirektur = PengajuanCuti::where('status', 'pending_direktur')
            ->count();

        // Tabel pengajuan Cuti
        $pengajuanCuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'pending_direktur')
            ->latest()
            ->paginate(10);

        return view(
            'dashboard.direktur',
            compact(
                'totalKaryawan',
                'sedangCutiHariIni',
                'pendingDirektur',
                'pengajuanCuti'
            )
        );
    }
}
