<?php

namespace App\Http\Controllers\Lead;

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
        $user = Auth::user();

        $karyawan = User::with('divisi')
            ->where('divisi_id', $user->divisi_id)
            ->where('id', '!=', $user->id)
            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Cari berdasarkan nama
                    $q->where('name', 'like', "%{$search}%")

                        // Cari berdasarkan email
                        ->orWhere('email', 'like', "%{$search}%")

                        // Cari berdasarkan NIK
                        ->orWhere('nik', 'like', "%{$search}%")

                        // Cari berdasarkan divisi
                        ->orWhereHas('divisi', function ($divisi) use ($search) {

                            $divisi->where(
                                'nama_divisi',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('lead.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(User $karyawan)
    {
        return view(
            'lead.karyawan.detail',
            compact('karyawan')
        );
    }
}
