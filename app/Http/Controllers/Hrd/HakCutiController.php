<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Models\HakCuti;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JenisCuti;

class HakCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $daftarTahun = HakCuti::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $tahun = $request->tahun ?? $daftarTahun->first();

        $hak_cuti = HakCuti::with([
            'user.roles',
            'user.divisi',
            'jenisCuti'
        ])
            ->when($tahun, function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            })
            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->whereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%")
                            ->orWhereHas('roles', function ($role) use ($search) {
                                $role->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('divisi', function ($divisi) use ($search) {
                                $divisi->where('nama_divisi', 'like', "%{$search}%");
                            });
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'hrd.hak_cuti.index',
            compact(
                'hak_cuti',
                'daftarTahun',
                'tahun'
            )
        );
    }

    public function edit(HakCuti $hakCuti)
    {
        $hakCuti->load([
            'user.roles',
            'user.divisi',
            'jenisCuti',
        ]);

        return view(
            'hrd.hak_cuti.edit',
            compact('hakCuti')
        );
    }

    public function update(Request $request, HakCuti $hakCuti)
    {
        $request->validate([
            'terpakai' => 'required|integer|min:0',
            'sisa' => 'required|integer|min:0',
        ]);

        $hakCuti->update([
            'terpakai' => $request->terpakai,
            'sisa' => $request->sisa,
        ]);

        return redirect()
            ->route('hak_cuti.index')
            ->with(
                'success',
                'Hak cuti berhasil diperbarui.'
            );
    }
    public function generate()
    {
        $tahunTerakhir = HakCuti::max('tahun');

        $tahunBaru = $tahunTerakhir + 1;

        $jenisCutiTahunan = JenisCuti::where(
            'is_tahunan',
            true
        )->get();

        $karyawan = User::role([
            'karyawan',
            'lead',
            'head',
            'hrd',
        ])->get();

        foreach ($karyawan as $user) {

            foreach ($jenisCutiTahunan as $jenis) {

                HakCuti::firstOrCreate(

                    [
                        'user_id' => $user->id,
                        'jenis_cuti_id' => $jenis->id,
                        'tahun' => $tahunBaru,
                    ],

                    [
                        'terpakai' => 0,
                        'sisa' => $jenis->kuota,
                    ]

                );
            }
        }

        return redirect()
            ->route('hak_cuti.index', [
                'tahun' => $tahunBaru,
            ])
            ->with(
                'success',
                "Hak cuti tahun {$tahunBaru} berhasil dibuat."
            );
    }

    // public function generateTahunBaru(Request $request)
    // {
    //     $request->validate([
    //         'tahun' => 'required|integer|min:2025',
    //     ]);

    //     $tahunBaru = $request->tahun;

    //     $jenisCutiTahunan = JenisCuti::where('is_tahunan', true)
    //         ->first();

    //     if (!$jenisCutiTahunan) {
    //         return redirect()
    //             ->back()
    //             ->with('error', 'Jenis cuti tahunan tidak ditemukan.');
    //     }

    //     $users = User::whereHas('roles', function ($query) {
    //         $query->whereIn('name', [
    //             'karyawan',
    //             'lead',
    //             'head',
    //             'hrd',
    //         ]);
    //     })->get();

    //     $jumlahDibuat = 0;

    //     foreach ($users as $user) {

    //         $hakCuti = HakCuti::firstOrCreate(
    //             [
    //                 'user_id' => $user->id,
    //                 'jenis_cuti_id' => $jenisCutiTahunan->id,
    //                 'tahun' => $tahunBaru,
    //             ],
    //             [
    //                 'terpakai' => 0,
    //                 'sisa' => $jenisCutiTahunan->kuota,
    //             ]
    //         );

    //         if ($hakCuti->wasRecentlyCreated) {
    //             $jumlahDibuat++;
    //         }
    //     }

    //     return redirect()
    //         ->route('hak_cuti.index')
    //         ->with(
    //             'success',
    //             "Berhasil membuat {$jumlahDibuat} hak cuti tahun {$tahunBaru}."
    //         );
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }





    public function destroy(HakCuti $hak_cuti)
    {
        $hak_cuti->delete();

        return redirect()
            ->route('hak_cuti.index')
            ->with('success', 'Hak Cuti berhasil dihapus');
    }
}
