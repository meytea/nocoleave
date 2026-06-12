<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Head;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;

class HeadController extends Controller
{
    public function index()
    {
        $heads = Head::with([
            'user',
            'divisi'
        ])
        ->latest()
        ->paginate(10);

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
            'user_id'   => 'required|exists:users,id',
            'divisi_id' => 'required|exists:divisi,id',
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
            'user_id'   => 'required|exists:users,id',
            'divisi_id' => 'required|exists:divisi,id',
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