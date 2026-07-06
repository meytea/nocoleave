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
    public function index(Request $request)
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
        ->when($request->search, function ($query) use ($request) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Nama, Jabatan, dan Divisi
                $q->whereHas('user', function ($user) use ($search) {

                    $user->where('name', 'like', "%{$search}%")

                        ->orWhereHas('roles', function ($role) use ($search) {
                            $role->where('name', 'like', "%{$search}%");
                        })

                        ->orWhereHas('divisi', function ($divisi) use ($search) {
                            $divisi->where(
                                'nama_divisi',
                                'like',
                                "%{$search}%"
                            );
                        });

                })

                // Jenis Cuti
                ->orWhereHas('jenisCuti', function ($jenis) use ($search) {

                    $jenis->where(
                        'nama_cuti',
                        'like',
                        "%{$search}%"
                    );

                })

                // Status
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
