@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Edit Hak Cuti
        </h1>

        <form action="{{ route('hak_cuti.update', $hakCuti->id) }}"
              method="POST"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Karyawan
                    </label>

                    <input type="text"
                           value="{{ $hakCuti->user->name }}"
                           readonly
                           class="w-full rounded-xl bg-gray-100 border-gray-300 text-gray-600">
                </div>

                {{-- NIK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        NIK
                    </label>

                    <input type="text"
                           value="{{ $hakCuti->user->nik }}"
                           readonly
                           class="w-full rounded-xl bg-gray-100 border-gray-300 text-gray-600">
                </div>

                {{-- Jabatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jabatan
                    </label>

                    <input type="text"
                           value="{{ $hakCuti->user->roles->first()?->name }}"
                           readonly
                           class="w-full rounded-xl bg-gray-100 border-gray-300 text-gray-600">
                </div>

                {{-- Divisi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Divisi
                    </label>

                    <input type="text"
                           value="{{ $hakCuti->user->divisi?->nama_divisi ?? '-' }}"
                           readonly
                           class="w-full rounded-xl bg-gray-100 border-gray-300 text-gray-600">
                </div>

                {{-- Jenis Cuti --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Cuti
                    </label>

                    <input type="text"
                           value="{{ $hakCuti->jenisCuti->nama_cuti }}"
                           readonly
                           class="w-full rounded-xl bg-gray-100 border-gray-300 text-gray-600">
                </div>

                {{-- Tahun --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun
                    </label>

                    <input type="text"
                           value="{{ $hakCuti->tahun }}"
                           readonly
                           class="w-full rounded-xl bg-gray-100 border-gray-300 text-gray-600">
                </div>

            </div>

            <hr class="my-2">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Terpakai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Terpakai
                    </label>

                    <input type="number"
                           name="terpakai"
                           min="0"
                           value="{{ old('terpakai', $hakCuti->terpakai) }}"
                           class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    @error('terpakai')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Sisa --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sisa Cuti
                    </label>

                    <input type="number"
                           name="sisa"
                           min="0"
                           value="{{ old('sisa', $hakCuti->sisa) }}"
                           class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    @error('sisa')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="flex items-center gap-4 pt-4">

                
                <button type="submit"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">

                    Update Data

                </button>

                <a href="{{ route('hak_cuti.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection