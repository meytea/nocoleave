<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Models\HakCuti;
use App\Http\Controllers\Controller;

class HakCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hak_cuti = HakCuti::with(['user', 'jenisCuti'])
            ->latest()
            ->paginate(10);

        return view('hrd.hak_cuti.index', compact('hak_cuti'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrd.hak_cuti.create');
    }

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HakCuti $hak_cuti)
    {;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HakCuti $hak_cuti) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HakCuti $hak_cuti)
    {
        $hak_cuti->delete();

        return redirect()
            ->route('hak_cuti.index')
            ->with('success', 'Hak Cuti berhasil dihapus');
    }
}
