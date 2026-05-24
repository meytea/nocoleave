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
            'kode_cuti' => 'required|string|max:50|unique:jenis_cuti,kode_cuti',
            'kuota' => 'required|integer|min:1',
            'is_tahunan' => 'nullable|boolean',
            'keterangan' => 'nullable|string',
        ]);

        JenisCuti::create([
            
            'nama_cuti' => $validated['nama_cuti'],
            'kode_cuti' => $validated['kode_cuti'],
            'kuota' => $validated['kuota'],
            'is_tahunan' => $request->has('is_tahunan'),
            'keterangan' => $validated['keterangan'] ?? null,
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
    public function edit(JenisCuti $JenisCuti)
    {;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisCuti $jenis_cuti) {}

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
