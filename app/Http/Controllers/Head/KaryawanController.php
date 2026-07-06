<?php

namespace App\Http\Controllers\Head;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\User;
use App\Models\HakCuti;
use App\Models\JenisCuti;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Head;




class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $divisi = Head::where('user_id', $user->id)
            ->pluck('divisi_id');

        $karyawan = User::with('divisi')
            ->whereIn('divisi_id', $divisi)
            ->where('id', '!=', $user->id)
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [
                    'lead',
                    'karyawan'
                ]);
            })
            ->when($request->search, function ($query) use ($request) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Nama
                $q->where('name', 'like', "%{$search}%")

                    // Email
                    ->orWhere('email', 'like', "%{$search}%")

                    // NIK
                    ->orWhere('nik', 'like', "%{$search}%")

                    // Divisi
                    ->orWhereHas('divisi', function ($divisi) use ($search) {

                        $divisi->where(
                            'nama_divisi',
                            'like',
                            "%{$search}%"
                        );

                    })

                    // Jabatan
                    ->orWhereHas('roles', function ($role) use ($search) {

                        $role->where(
                            'name',
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
            'head.karyawan.index',
            compact('karyawan')
        );
    }

    public function show(User $karyawan)
    {
        return view(
            'head.karyawan.detail',
            compact('karyawan')
        );
    }
}
