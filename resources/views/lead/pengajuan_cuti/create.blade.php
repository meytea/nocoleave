@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Ajukan Cuti
        </h1>

        @if ($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Informasi Hak Cuti --}}
        <div class="mb-8 bg-cyan-50 border border-cyan-100 rounded-xl p-4">

            <h3 class="font-semibold text-cyan-700 mb-3">
                Hak Cuti Anda
            </h3>

            <table class="w-full text-sm">

                <thead>
                    <tr>
                        <th class="text-left py-2">Jenis Cuti</th>
                        <th class="text-center py-2">Sisa</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($hakCuti as $hak)

                    <tr>
                        <td class="py-2">
                            {{ $hak->jenisCuti->nama_cuti }}
                        </td>

                        <td class="text-center py-2">
                            {{ $hak->sisa }} Hari
                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <form action="{{ route('lead.pengajuan_cuti.store') }}"
            method="POST"
            class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Cuti
                    </label>

                    <select name="jenis_cuti_id"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        <option value="">
                            Pilih Jenis Cuti
                        </option>

                        @foreach($jenisCuti as $item)

                        <option value="{{ $item->id }}">
                            {{ $item->nama_cuti }}
                        </option>

                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input type="date"
                        name="tanggal_mulai"
                        value="{{ old('tanggal_mulai') }}"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>

                    <input type="date"
                        name="tanggal_selesai"
                        value="{{ old('tanggal_selesai') }}"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Cuti
                </label>

                <textarea name="alasan"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">{{ old('alasan') }}</textarea>
            </div>

            <div class="flex items-center gap-4 pt-4">

                <button type="submit"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">
                    Ajukan Cuti
                </button>

                <a href="{{ route('lead.pengajuan_cuti.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection