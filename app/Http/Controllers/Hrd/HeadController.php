<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Head;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;

class HeadController extends Controller
{
    public function index(Request $request)
    {
        $heads = Head::with([
            'user',
            'divisi'
        ])
            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Nama Departemen
                    $q->where(
                        'nama_departemen',
                        'like',
                        "%{$search}%"
                    )

                        // Nama Head
                        ->orWhereHas('user', function ($user) use ($search) {

                            $user->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        })

                        // Nama Divisi
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

        return view('hrd.head.index', compact('heads'));
    }

    public function create()
    {
        $users = User::role('head')->get();

        $divisi = Divisi::orderBy('nama_divisi')
            ->get();

        return view(
            'hrd.head.create',
            compact(
                'users',
                'divisi'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'nama_departemen'   => 'required|string|max:255',
            'divisi_id'         => 'required|exists:divisi,id',
        ]);

        Head::create($validated);

        return redirect()
            ->route('head.index')
            ->with(
                'success',
                'Data Head berhasil ditambahkan'
            );
    }

    public function edit(Head $head)
    {
        $users = User::role('head')->get();

        $divisi = Divisi::orderBy('nama_divisi')
            ->get();

        return view(
            'hrd.head.edit',
            compact(
                'head',
                'users',
                'divisi'
            )
        );
    }

    public function update(
        Request $request,
        Head $head
    ) {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'nama_departemen'   => 'required|string|max:255',
            'divisi_id'         => 'required|exists:divisi,id',
        ]);

        $head->update($validated);

        return redirect()
            ->route('head.index')
            ->with(
                'success',
                'Data Head berhasil diperbarui'
            );
    }

    public function destroy(Head $head)
    {
        $head->delete();

        return redirect()
            ->route('head.index')
            ->with(
                'success',
                'Data Head berhasil dihapus'
            );
    }
}
