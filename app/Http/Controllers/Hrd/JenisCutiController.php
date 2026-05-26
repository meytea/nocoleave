<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Models\JenisCuti;
use App\Http\Controllers\Controller;

class JenisCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_cuti = JenisCuti::latest()->paginate(10);

        return view('hrd.jenis_cuti.index', compact('jenis_cuti'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrd.jenis_cuti.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_cuti' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
            'is_tahunan' => 'nullable|boolean',
        ]);

        JenisCuti::create([

            'nama_cuti' => $validated['nama_cuti'],
            'kuota' => $validated['kuota'],
            'is_tahunan' => $request->has('is_tahunan'),
        ]);

        return redirect()
            ->route('jenis_cuti.index')
            ->with('success', 'Jenis cuti berhasil ditambahkan');
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
    public function edit(JenisCuti $jenis_cuti)
    {
        return view('hrd.jenis_cuti.edit', compact('jenis_cuti'));
    }


    public function update(Request $request, JenisCuti $jenis_cuti)
    {
    $validated = $request->validate([
        'nama_cuti' => 'required|string|max:255|unique:jenis_cuti,nama_cuti,' . $jenis_cuti->id,
        'kuota' => 'required|integer|min:1',
        'is_tahunan' => 'nullable|boolean',
    ]);

    $jenis_cuti->update([
        'nama_cuti' => $validated['nama_cuti'],
        'kuota' => $validated['kuota'],
        'is_tahunan' => $request->has('is_tahunan'),
    ]);

    return redirect()
        ->route('jenis_cuti.index')
        ->with('success', 'Jenis cuti berhasil diperbarui');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisCuti $jenis_cuti)
    {
        $jenis_cuti->delete();

        return redirect()
            ->route('jenis_cuti.index')
            ->with('success', 'Jenis Cuti berhasil dihapus');
    }
}
