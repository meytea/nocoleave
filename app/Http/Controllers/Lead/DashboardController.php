<?php

namespace App\Http\Controllers\Lead;

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
        $totalKaryawan = User::where(
            'divisi_id',
            Auth::user()->divisi_id
        )
            ->role('karyawan')
            ->count();

        // Sedang Cuti Hari Ini
        $sedangCutiHariIni = PengajuanCuti::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_selesai', '>=', Carbon::today())
            ->whereHas('user', function ($query) {
                $query->where('divisi_id', Auth::user()->divisi_id);
            })
            ->count();

        // Pending Lead
        $pendingLead = PengajuanCuti::where('status', 'pending_lead')
            ->whereHas('user', function ($query) {
                $query->where('divisi_id', Auth::user()->divisi_id);
            })
            ->count();

        // Tabel pengajuan Cuti
        $pengajuanCuti = PengajuanCuti::with(['user', 'jenisCuti'])
            ->where('status', 'pending_lead')
            ->whereHas('user', function ($query) {
                $query->where('divisi_id', Auth::user()->divisi_id);
            })
            ->latest()
            ->paginate(10);

        return view(
            'dashboard.lead',
            compact(
                'totalKaryawan',
                'sedangCutiHariIni',
                'pendingLead',
                'pengajuanCuti'
            )
        );
    }
}
