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
    public function index(Request $request)
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

        // Tabel Pengajuan Cuti
        $pengajuanCuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'pending_lead')

            ->whereHas('user', function ($query) {
                $query->where('divisi_id', Auth::user()->divisi_id);
            })

            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Cari berdasarkan nama karyawan
                    $q->whereHas('user', function ($user) use ($search) {

                        $user->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    })

                        // Cari berdasarkan jenis cuti
                        ->orWhereHas('jenisCuti', function ($jenis) use ($search) {

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
                        );
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();


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
