@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Edit Jenis Cuti
        </h1>

        <form action="{{ route('jenis_cuti.update', $jenis_cuti->id) }}"
            method="POST"
            class="space-y-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Jenis Cuti
                </label>

                <input type="text"
                    name="nama_cuti"
                    value="{{ old('nama_cuti', $jenis_cuti->nama_cuti) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                @error('nama_cuti')
                <p class="mt-2 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kuota Cuti (Hari)
                </label>

                <input type="number"
                    name="kuota"
                    value="{{ old('kuota', $jenis_cuti->kuota) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                @error('kuota')
                <p class="mt-2 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="flex items-center gap-3">

                <input type="checkbox"
                    name="is_tahunan"
                    value="{{ old('is_tahunan', $jenis_cuti->is_tahunan) ? 'checked' : '' }}"
                    class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">

                <label class="text-sm font-medium text-gray-700">
                    Termasuk Cuti Tahunan
                </label>

                @error('is_tahunan')
                <p class="mt-2 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>



            <div class="flex items-center gap-4">

                <button type="submit"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">
                    Update
                </button>

                <a href="{{ route('jenis_cuti.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection