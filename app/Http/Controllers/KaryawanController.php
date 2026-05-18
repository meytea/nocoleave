<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = User::with('divisi')
            ->latest()
            ->paginate(10);

        return view('hrd.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisi = Divisi::all();
        $roles = Role::all();

        return view('hrd.karyawan.create', compact('divisi', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nik' => 'required|unique:users,nik',
            'jenis_kelamin' => 'required',
            'divisi_id' => 'nullable|exists:divisi,id',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'divisi_id' => $validated['divisi_id'],
            'is_active' => true,
        ]);

        $user->assignRole($validated['role']);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
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
    public function edit(string $id)
    {
        $karyawan = User::findOrFail($id);
        $divisi = Divisi::all();
        $roles = Role::all();

        return view('hrd.karyawan.edit', compact('karyawan', 'divisi', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $karyawan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
            'nik' => 'required|unique:users,nik,' . $karyawan->id,
            'jenis_kelamin' => 'required',
            'divisi_id' => 'nullable|exists:divisi,id',
            'role' => 'required',
        ]);

        $karyawan->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'divisi_id' => $validated['divisi_id'],
        ]);

        $karyawan->syncRoles([$validated['role']]);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $karyawan)
    {
        $karyawan->delete();

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus');
    }
}
