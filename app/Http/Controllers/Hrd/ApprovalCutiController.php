<?php

namespace App\Http\Controllers\Hrd;

use App\Models\ApprovalCuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\JenisCuti;
use App\Models\HakCuti;

class ApprovalCutiController extends Controller
{
    // Tampilan halaman index untuk approval cuti
    public function index(Request $request)
    {
        $pengajuanCuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'pending_hrd')
            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Nama dan Jabatan
                    $q->whereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%")
                            ->orWhereHas('roles', function ($role) use ($search) {
                                $role->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('divisi', function ($divisi) use ($search) {
                                $divisi->where('nama_divisi', 'like', "%{$search}%");
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
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view(
            'hrd.approval_cuti.index',
            compact('pengajuanCuti')
        );
    }

    // Tampilan halaman untuk pengajuan cuti yang ditolak
    public function pengajuanDitolak(Request $request)
    {
        $user = Auth::user();

        $pengajuanCuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->whereHas('approvalCuti', function ($query) use ($user) {

                $query->where('approver_id', $user->id)
                    ->where('status', 'ditolak');
            })

            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->whereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%")
                            ->orWhereHas('roles', function ($role) use ($search) {
                                $role->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('divisi', function ($divisi) use ($search) {
                                $divisi->where('nama_divisi', 'like', "%{$search}%");
                            });
                    })

                        ->orWhereHas('jenisCuti', function ($jenis) use ($search) {

                            $jenis->where(
                                'nama_cuti',
                                'like',
                                "%{$search}%"
                            );
                        })

                        ->orWhere('status', 'like', "%{$search}%");
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'hrd.approval_cuti.ditolak',
            compact('pengajuanCuti')
        );
    }

    //return "Halaman pengajuan cuti yang ditolak oleh lead. Fitur ini masih dalam pengembangan.";


    // Tampilan halaman untuk pengajuan cuti yang disetujui
    public function pengajuanDisetujui(Request $request)
    {
        $user = Auth::user();

        $pengajuanCuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->whereHas('approvalCuti', function ($query) use ($user) {

                $query->where('approver_id', $user->id)
                    ->where('status', 'disetujui');
            })

            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->whereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%")
                            ->orWhereHas('roles', function ($role) use ($search) {
                                $role->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('divisi', function ($divisi) use ($search) {
                                $divisi->where('nama_divisi', 'like', "%{$search}%");
                            });
                    })

                        ->orWhereHas('jenisCuti', function ($jenis) use ($search) {

                            $jenis->where(
                                'nama_cuti',
                                'like',
                                "%{$search}%"
                            );
                        })

                        ->orWhere('status', 'like', "%{$search}%");
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'hrd.approval_cuti.disetujui',
            compact('pengajuanCuti')
        );
    }

    // Proses setuju pengajuan cuti oleh HRD
    public function setuju(PengajuanCuti $pengajuanCuti)
    {
        if ($pengajuanCuti->status !== 'pending_hrd') {
            return redirect()->back()
                ->with('error', 'Pengajuan sudah diproses.');
        }

        $userPengaju = $pengajuanCuti->user;

        if ($userPengaju->hasRole('head')) {

            $direktur = User::role('direktur')->first();

            if (!$direktur) {
                return redirect()->back()
                    ->with('error', 'User Direktur tidak ditemukan.');
            }

            ApprovalCuti::create([
                'pengajuan_cuti_id' => $pengajuanCuti->id,
                'approver_id'       => Auth::id(),
                'status'            => 'disetujui',
                'catatan'           => null,
                'created_at'        => now(),
            ]);

            $pengajuanCuti->update([
                'status'              => 'pending_direktur',
                'current_approver_id' => $direktur->id,
            ]);

            return redirect()->back()
                ->with('success', 'Pengajuan berhasil disetujui dan diteruskan ke Direktur.');
        }

        $head = User::role('head')->first();

        if (!$head) {
            return redirect()->back()
                ->with('error', 'User Head tidak ditemukan.');
        }

        ApprovalCuti::create([
            'pengajuan_cuti_id' => $pengajuanCuti->id,
            'approver_id'       => Auth::id(),
            'status'            => 'disetujui',
            'catatan'           => null,
            'created_at'        => now(),
        ]);

        $pengajuanCuti->update([
            'status'              => 'pending_head',
            'current_approver_id' => $head->id,
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan berhasil disetujui dan diteruskan ke Head.');
    }

    // Proses tolak pengajuan cuti oleh HRD
    public function tolak(Request $request, PengajuanCuti $pengajuanCuti)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        if ($pengajuanCuti->status !== 'pending_hrd') {
            return redirect()->back()
                ->with('error', 'Pengajuan sudah diproses.');
        }

        ApprovalCuti::create([
            'pengajuan_cuti_id' => $pengajuanCuti->id,
            'approver_id'       => Auth::id(),
            'status'            => 'ditolak',
            'catatan'           => $request->alasan_penolakan,
            'created_at'        => now(),
        ]);

        $pengajuanCuti->update([
            'status'               => 'ditolak',
            'ditolak_oleh'         => Auth::id(),
            'alasan_penolakan'     => $request->alasan_penolakan,
            'current_approver_id'  => null,
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan berhasil ditolak.');
    }


    // Tampilam detail pada Approval Cuti

    public function show($id)
    {
        $pengajuanCuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])->findOrFail($id);

        $riwayatApproval = ApprovalCuti::with([
            'approver.roles'
        ])
            ->where('pengajuan_cuti_id', $pengajuanCuti->id)
            ->latest()
            ->get();

        return view(
            'hrd.approval_cuti.detail',
            compact(
                'pengajuanCuti',
                'riwayatApproval'
            )
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApprovalCuti $approvalCuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApprovalCuti $approvalCuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApprovalCuti $approvalCuti)
    {
        //
    }
}
