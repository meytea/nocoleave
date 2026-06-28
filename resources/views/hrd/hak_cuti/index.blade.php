@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Hak Cuti
            </h1>

            <p class="mt-1 text-gray-500">
                Kelola Data Hak Cuti karyawan.
            </p>
        </div>

        <!-- <a href="{{ route('hak_cuti.create') }}"
            class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-3 rounded-xl font-medium transition">
            + Tambah Hak Cuti
        </a> -->

    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 p-6 border-b border-gray-100">

            <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                {{-- Filter Tahun --}}
                <form action="{{ route('hak_cuti.index') }}"
                    method="GET"
                    class="flex items-center gap-2">

                    <select
                        name="tahun"
                        onchange="this.form.submit()"
                        class="rounded-xl border-gray-200 text-sm focus:border-cyan-500 focus:ring-cyan-500 py-2 pl-3 pr-10 text-gray-700">

                        @foreach($daftarTahun as $item)

                        <option
                            value="{{ $item }}"
                            {{ request('tahun', $tahun) == $item ? 'selected' : '' }}>

                            {{ $item }}

                        </option>

                        @endforeach

                    </select>

                    @if(request()->filled('tahun'))

                    <a href="{{ route('hak_cuti.index') }}"
                        class="inline-flex items-center justify-center p-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors"
                        title="Reset Filter">

                        <svg class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />

                        </svg>

                    </a>

                    @endif

                </form>

                {{-- Search --}}
                <form method="GET" id="searchForm">

                    <input
                        type="hidden"
                        name="tahun"
                        value="{{ request('tahun', $tahun) }}">

                    <div class="relative w-full max-w-md">

                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                            <x-heroicon-o-magnifying-glass
                                class="w-5 h-5 text-gray-400" />

                        </div>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama karyawan..."
                            class="w-full pl-10 pr-4 py-2 rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    </div>

                </form>

            </div>

            {{-- Tombol Generate --}}
            <div>

                <form
                    action="{{ route('hak_cuti.generate') }}"
                    method="POST"
                    onsubmit="return confirm('Generate hak cuti untuk tahun berikutnya?')">

                    @csrf

                    <button
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-xl font-medium transition">

                        Generate Tahun Berikutnya

                    </button>

                </form>

            </div>

        </div>

        <div class="overflow-x-auto">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-50 uppercase text-xs text-gray-500 tracking-wide">
                            <tr>
                                <th class="px-6 py-4 text-left">No</th>
                                <th class="px-6 py-4 text-left">Nama Karyawan</th>

                                <th class="px-6 py-4 text-center">Jenis Cuti</th>
                                <th class="px-6 py-4 text-center">Tahun</th>
                                <th class="px-6 py-4 text-center">Kuota Cuti</th>
                                <th class="px-6 py-4 text-center">Terpakai</th>
                                <th class="px-6 py-4 text-center">Sisa Cuti</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($hak_cuti as $item)



                            <tr class="border-t border-gray-100">

                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $item->user?->name ?? 'USER HILANG' }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $item->jenisCuti->nama_cuti }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $item->tahun }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $item->jenisCuti->kuota }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $item->terpakai }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $item->sisa }}
                                </td>



                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-3">

                                        <a href="{{ route('hak_cuti.edit', $item->id) }}"
                                            class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                            Edit
                                        </a>



                                        <!-- <form action="{{ route('hak_cuti.destroy', $item->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                        class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                        Hapus
                                    </button>

                                </form> -->

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="4"
                                    class="px-6 py-8 text-center text-gray-500">
                                    Hak Cuti belum tersedia.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>
            <div>

            </div>

            <!-- <div class="mt-6">
        {{ $hak_cuti->links() }}
    </div> -->




            @endsection