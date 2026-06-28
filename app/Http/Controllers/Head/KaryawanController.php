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
    public function index()
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
            ->latest()
            ->paginate(10);

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
