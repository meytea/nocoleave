<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HakCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanCuti;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Head;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $divisi = Head::where('user_id', $user->id)
            ->pluck('divisi_id');

        // Total Karyawan
        $totalKaryawan = User::whereIn('divisi_id', $divisi)
            ->where('id', '!=', $user->id)
            ->count();

        // Sedang Cuti Hari Ini
        $sedangCutiHariIni = PengajuanCuti::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_selesai', '>=', Carbon::today())
            ->whereHas('user', function ($query) use ($divisi) {
                $query->whereIn('divisi_id', $divisi);
            })
            ->count();

        // Pending Head
        $pendingHead = PengajuanCuti::where('status', 'pending_head')
            ->whereHas('user', function ($query) use ($divisi) {
                $query->whereIn('divisi_id', $divisi);
            })
            ->count();

        // Tabel pengajuan Cuti
        $pengajuanCuti = PengajuanCuti::with(['user','jenisCuti'])
            ->where('status', 'pending_head')
            ->whereHas('user', function ($query) use ($divisi) {
                $query->whereIn('divisi_id', $divisi);
            })
            ->latest()
            ->paginate(10);

        return view(
            'dashboard.head',
            compact(
                'totalKaryawan',
                'sedangCutiHariIni',
                'pendingHead',
                'pengajuanCuti'
            )
        );
    }
}
