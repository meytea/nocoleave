@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Tambah Jenis Cuti
        </h1>

        <form action="{{ route('jenis_cuti.store') }}"
            method="POST"
            class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 gap-6">


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Jenis Cuti
                    </label>

                    <input type="text"
                        name="nama_cuti"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kuota Cuti (Hari)
                    </label>

                    <input type="number"
                        name="durasi_default"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <div class="flex items-center gap-3">

                    <input type="checkbox"
                        name="is_tahunan"
                        value="1"
                        class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">

                    <label class="text-sm font-medium text-gray-700">
                        Termasuk Cuti Tahunan
                    </label>

                </div>


                <div class="flex items-center gap-4 pt-4">

                    <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">
                        Simpan
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