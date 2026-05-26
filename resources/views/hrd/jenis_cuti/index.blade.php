@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Jenis Cuti
            </h1>

            <p class="mt-1 text-gray-500">
                Kelola data jenis cuti perusahaan.
            </p>
        </div>

        <a href="{{ route('jenis_cuti.create') }}"
            class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-3 rounded-xl font-medium transition">
            + Tambah Jenis Cuti
        </a>

    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 uppercase text-xs text-gray-500 tracking-wide">
                    <tr>
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Nama Jenis Cuti</th>
                        <th class="px-6 py-4 text-center">Kuota</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($jenis_cuti as $item)

                    <tr class="border-t border-gray-100">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->nama_cuti }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->kuota }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex items-center justify-center gap-3">

                                <a href="{{ route('jenis_cuti.edit', $item->id) }}"
                                    class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                    Edit
                                </a>
                                

                                <form action="{{ route('jenis_cuti.destroy', $item->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                        class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4"
                            class="px-6 py-8 text-center text-gray-500">
                            Jenis Cuti belum tersedia.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

    <div class="mt-6">
        {{ $jenis_cuti->links() }}
    </div>

   


    @endsection