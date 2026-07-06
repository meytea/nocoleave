@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Riwayat Approval Cuti
        </h1>

        <p class="mt-1 text-gray-500">
            Riwayat persetujuan dan penolakan pengajuan cuti.
        </p>


    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
    @endif


    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Detail Pengajuan Cuti
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-500">Jenis Cuti</p>
                <p class="font-semibold">
                    {{ $pengajuanCuti->jenisCuti->nama_cuti }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-semibold">
                    {{ $pengajuanCuti->status }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Mulai</p>
                <p class="font-semibold">
                    {{ $pengajuanCuti->tanggal_mulai?->format('d M Y') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Selesai</p>
                <p class="font-semibold">
                    {{ $pengajuanCuti->tanggal_selesai?->format('d M Y') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Jumlah Hari</p>
                <p class="font-semibold">
                    {{ $pengajuanCuti->jumlah_hari }} Hari
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Masuk</p>
                <p class="font-semibold">
                    {{ $pengajuanCuti->tanggal_masuk?->format('d M Y') ?? '-' }}
                </p>
            </div>

        </div>

        <div class="mt-4">

            <p class="text-sm text-gray-500">
                Alasan
            </p>

            <p class="font-medium">
                {{ $pengajuanCuti->alasan }}
            </p>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">



        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 uppercase text-xs text-gray-500 tracking-wide">

                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4 text-center">Karyawan</th>
                        <th class="px-6 py-4 text-center">Jenis Cuti</th>
                        <th class="px-6 py-4 text-center">Approver</th>
                        <th class="px-6 py-4 text-center">Jabatan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Catatan</th>
                        <th class="px-6 py-4 text-center">Tanggal</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($riwayatApproval as $item)

                    <tr class="border-t border-gray-100 text-center">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800 text-center">
                            {{ $item->pengajuanCuti->user->name ?? '-' }}
                            
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->pengajuanCuti->jenisCuti->nama_cuti ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->approver->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center text-gray-600">
                            {{ ucfirst($item->approver->getRoleNames()->first() ?? '-') }}
                        </td>
                        

                        <td class="px-6 py-4 text-center">

                            @if($item->status == 'disetujui')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                Disetujui
                            </span>

                            @else

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                Ditolak
                            </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->catatan ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->created_at?->format('d M Y H:i') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7"
                            class="px-6 py-8 text-center text-gray-500">

                            Belum ada riwayat approval.

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
    <div class="flex justify-end">
        <a href="{{ url()->previous() }}"
            class="inline-block mt-4 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
            Kembali
        </a>
    </div>



</div>

@endsection