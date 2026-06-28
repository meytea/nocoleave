@extends('layouts.app')

@section('content')

<div class="space-y-6">

<div class="flex items-center justify-between">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Karyawan
        </h1>

        <p class="mt-1 text-gray-500">
            Informasi lengkap data karyawan.
        </p>
    </div>

    
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <div class="flex flex-col md:flex-row gap-8">

        {{-- Foto --}}
        <div class="flex-shrink-0">

            <div class="w-40 h-40 rounded-2xl overflow-hidden border border-gray-200">

                @if($karyawan->foto)

                <img
                    src="{{ str_starts_with($karyawan->foto, 'images/')
                            ? asset($karyawan->foto)
                            : asset('storage/' . $karyawan->foto) }}"
                    alt="{{ $karyawan->name }}"
                    class="w-full h-full object-cover">

                @else

                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-500 text-5xl font-bold">
                    {{ strtoupper(substr($karyawan->name, 0, 1)) }}
                </div>

                @endif

            </div>

        </div>

        {{-- Data --}}
        <div class="flex-1">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-gray-500">
                        Nama Lengkap
                    </p>

                    <p class="font-semibold text-gray-900 mt-1">
                        {{ $karyawan->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        NIK
                    </p>

                    <p class="font-semibold text-gray-900 mt-1">
                        {{ $karyawan->nik }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Email
                    </p>

                    <p class="font-semibold text-gray-900 mt-1">
                        {{ $karyawan->email }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Jenis Kelamin
                    </p>

                    <p class="font-semibold text-gray-900 mt-1">
                        {{ ucfirst($karyawan->jenis_kelamin) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Divisi
                    </p>

                    <p class="font-semibold text-gray-900 mt-1">
                        {{ $karyawan->divisi?->nama_divisi ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Jabatan
                    </p>

                    <span class="inline-flex px-3 py-1 rounded-full bg-cyan-100 text-cyan-700 text-sm font-semibold mt-1">
                        {{ $karyawan->getRoleNames()->first() }}
                    </span>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Status Akun
                    </p>

                    @if($karyawan->is_active)
                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold mt-1">
                        Aktif
                    </span>
                    @else
                    <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold mt-1">
                        Nonaktif
                    </span>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Bergabung Sejak
                    </p>

                    <p class="font-semibold text-gray-900 mt-1">
                        {{ $karyawan->created_at->format('d F Y') }}
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="flex justify-end">
    <a href="{{ route('head.karyawan.index') }}"
        class="inline-block mt-4 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
        Kembali
    </a>
</div>

</div>

@endsection
