@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-8 py-6 border-b border-gray-100">
            <h1 class="text-3xl font-bold text-gray-800">
                Edit Data Karyawan
            </h1>

            <p class="mt-2 text-gray-500">
                Update informasi data karyawan.
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('karyawan.update', $karyawan->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-8 space-y-8">

            @csrf
            @method('PUT')

            {{-- Foto Profile --}}
            <div class="flex items-center gap-6">

                <div class="w-28 h-28 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200">

                    @if ($karyawan->foto)

                    <img src="{{ asset('storage/' . $karyawan->foto) }}"
                        alt="Foto Profile"
                        class="w-full h-full object-cover">

                    @else

                    <div class="w-full h-full flex items-center justify-center text-3xl font-bold text-gray-400">
                        {{ strtoupper(substr($karyawan->name, 0, 1)) }}
                    </div>

                    @endif

                </div>

                <div class="flex-1">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Foto Profile
                    </label>

                    <input type="file"
                        name="foto"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    <p class="mt-2 text-xs text-gray-500">
                        Format: JPG, PNG, JPEG. Maksimal 2MB.
                    </p>

                    @error('foto')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>

            {{-- Form Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>

                    <input type="text"
                        name="name"
                        value="{{ old('name', $karyawan->name) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    @error('name')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email"
                        name="email"
                        value="{{ old('email', $karyawan->email) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    @error('email')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        NIK
                    </label>

                    <input type="text"
                        name="nik"
                        value="{{ old('nik', $karyawan->nik) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    @error('nik')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>

                    <select name="jenis_kelamin"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        <option value="laki-laki"
                            {{ $karyawan->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                            Laki-Laki
                        </option>

                        <option value="perempuan"
                            {{ $karyawan->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>

                    @error('jenis_kelamin')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Divisi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Divisi
                    </label>

                    <select name="divisi_id"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        <option value="">Pilih Divisi</option>

                        @foreach ($divisi as $item)

                        <option value="{{ $item->id }}"
                            {{ $karyawan->divisi_id == $item->id ? 'selected' : '' }}>

                            {{ $item->nama_divisi }}

                        </option>

                        @endforeach

                    </select>

                    @error('divisi_id')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Role
                    </label>

                    <select name="role"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        @foreach ($roles as $role)

                        <option value="{{ $role->name }}"
                            {{ $karyawan->hasRole($role->name) ? 'selected' : '' }}>

                            {{ ucfirst($role->name) }}

                        </option>

                        @endforeach

                    </select>

                    @error('role')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

            </div>

            {{-- Button --}}
            <div class="flex items-center gap-4 pt-4">

                <button type="submit"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">

                    Update Data

                </button>

                <a href="{{ route('karyawan.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection