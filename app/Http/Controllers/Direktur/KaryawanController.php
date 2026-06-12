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


class DirekturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = User::with('divisi')
            ->latest()
            ->paginate(10);;

        return view('hrd.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
}
