<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Http\Controllers\Controller;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisi = Divisi::withCount('users')
            ->latest()
            ->paginate(10);

        return view('hrd.divisi.index', compact('divisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrd.divisi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisi,nama_divisi',
        ]);

        Divisi::create($validated);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Divisi $divisi)
    {
        return view('hrd.divisi.edit', compact('divisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Divisi $divisi)
    {
        $validated = $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisi,nama_divisi,' . $divisi->id,
        ]);

        $divisi->update($validated);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisi $divisi)
    {
        $divisi->delete();

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil dihapus');
    }
}
