<?php

namespace App\Http\Controllers\Direktur;

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


class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $karyawan = User::with('divisi')
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

        return view('hrd.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
}
