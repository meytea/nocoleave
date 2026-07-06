<?php

namespace App\Http\Controllers\Lead;

use App\Models\ApprovalCuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Head;

class ApprovalCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'pending_lead')

            ->whereHas('user', function ($query) use ($user) {
                $query->where('divisi_id', $user->divisi_id);
            })

            ->when($request->filled('search'), function ($query) use ($request) {

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
                            $jenis->where('nama_cuti', 'like', "%{$search}%");
                        })

                        ->orWhere('status', 'like', "%{$search}%");
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'lead.approval_cuti.index',
            compact('pengajuan_cuti')
        );
    }

    public function pengajuanDitolak(Request $request)
    {
        $user = Auth::user();

        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->where('status', 'ditolak')

            ->whereHas('user', function ($query) use ($user) {
                $query->where('divisi_id', $user->divisi_id);
            })

            ->when($request->filled('search'), function ($query) use ($request) {

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
            'lead.approval_cuti.ditolak',
            compact('pengajuan_cuti')
        );
    }


    public function pengajuanDisetujui(Request $request)
    {
        $user = Auth::user();

        $pengajuan_cuti = PengajuanCuti::with([
            'user',
            'jenisCuti'
        ])
            ->whereIn('status', [
                'pending_hrd',
                'pending_head',
                'disetujui'
            ])

            ->whereHas('user', function ($query) use ($user) {
                $query->where('divisi_id', $user->divisi_id);
            })
            ->when($request->get('status') === 'sedang_cuti', function ($query) {

                $query->where('status', 'disetujui')
                    ->whereDate('tanggal_mulai', '<=', today())
                    ->whereDate('tanggal_selesai', '>=', today());
            })

            ->when($request->filled('search'), function ($query) use ($request) {

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
            'lead.approval_cuti.disetujui',
            compact('pengajuan_cuti')
        );
    }

    public function setuju(PengajuanCuti $pengajuanCuti)
    {
        if ($pengajuanCuti->status !== 'pending_lead') {
            return redirect()->back()
                ->with('error', 'Pengajuan sudah diproses.');
        }

        $hrd = User::role('hrd')->first();

        if (!$hrd) {
            return redirect()->back()
                ->with('error', 'User HRD tidak ditemukan.');
        }

        ApprovalCuti::create([
            'pengajuan_cuti_id' => $pengajuanCuti->id,
            'approver_id'       => Auth::id(),
            'status'            => 'disetujui',
            'catatan'           => null,
            'created_at'        => now(),
        ]);

        $pengajuanCuti->update([
            'status'              => 'pending_hrd',
            'current_approver_id' => $hrd->id,
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan berhasil disetujui dan diteruskan ke HRD.');
    }

    public function tolak(Request $request, PengajuanCuti $pengajuanCuti)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        if ($pengajuanCuti->status !== 'pending_lead') {
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
            'status'             => 'ditolak',
            'ditolak_oleh'       => Auth::id(),
            'alasan_penolakan'   => $request->alasan_penolakan,
            'current_approver_id' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan berhasil ditolak.');
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
            'lead.approval_cuti.detail',
            compact(
                'pengajuanCuti',
                'riwayatApproval'
            )
        );
    }

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
