@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Karyawan Lead
            </h1>

            <p class="mt-1 text-gray-500">
                Kelola data karyawan perusahaan.
            </p>
        </div>

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
                        <th class="px-6 py-4 text-left">Foto</th>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">NIK</th>
                        <th class="px-6 py-4 text-left">Divisi</th>
                        <th class="px-6 py-4 text-left">Jabatan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($karyawan as $item)

                    <tr class="border-t border-gray-100">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->foto }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->email }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->nik }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->divisi?->nama_divisi ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-700 text-xs uppercase font-semibold">
                                {{ $item->getRoleNames()->first() }}
                            </span>
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex items-center justify-center gap-3">

                                <a href="{{ route('karyawan.edit', $item->id) }}"
                                    class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                    Detail
                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7"
                            class="px-6 py-8 text-center text-gray-500">
                            Data karyawan belum tersedia.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-6">
        {{ $karyawan->links() }}
    </div>

</div>

@endsection