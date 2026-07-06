@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Pengajuan Cuti
        </h1>

        <p class="mt-1 text-gray-500">
            Menampilkan detail pengajuan cuti serta riwayat proses persetujuan hingga status pengajuan saat ini.
        </p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
    @endif


    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

        <!-- <h2 class="text-xl font-bold text-gray-800 mb-4">
            Detail Pengajuan Cuti
        </h2> -->

        <!-- Stepper -->
        <div class="mb-6">

            <div class="flex items-start justify-between relative">
                

                @foreach($workflow as $index => $step)

                <div class="flex-1 flex flex-col items-center relative">

                    <!-- Garis -->
                    @if(!$loop->last)
                    <div class="absolute top-5 left-1/2 w-full h-1 z-0">

                        <div class="h-full
                        @if($rejectedStep !== null)
                            {{ $index < $rejectedStep ? 'bg-green-500' : 'bg-gray-200' }}
                        @else
                            {{ $index < $currentStep ? 'bg-green-500' : 'bg-gray-200' }}
                        @endif">
                        </div>

                    </div>
                    @endif

                    <!-- Bulatnya -->
                    <div class="relative z-10 w-12 h-12 rounded-full flex items-center justify-center shadow-sm border-2
                        @if($rejectedStep !== null)

                            @if($index < $rejectedStep)
                                bg-green-500 border-green-500 text-white
                            @elseif($index == $rejectedStep)
                                bg-red-500 border-red-500 text-white
                            @else
                                bg-white border-gray-300 text-gray-400
                            @endif
                        @else

                        @if($index < $currentStep)
                                bg-green-500 border-green-500 text-white
                            @elseif($index == $currentStep)
                                bg-cyan-500 border-cyan-500 text-white
                            @else
                                bg-white border-gray-300 text-gray-400
                            @endif
                        @endif">

                        <!-- Icon Stepper -->
                        @if($rejectedStep !== null && $index == $rejectedStep)
                            <x-heroicon-s-x-mark class="w-5 h-5" />
                        @elseif($index < $rejectedStep)
                            <x-heroicon-s-check class="w-5 h-5" />
                        @elseif($index < $currentStep)
                            <x-heroicon-s-check class="w-5 h-5" />
                        @elseif($index == $currentStep)
                            <x-heroicon-s-clock class="w-5 h-5" />
                        @else
                            <x-heroicon-o-minus class="w-5 h-5" />
                        @endif  
                    </div>

                    <span class="mt-3 text-sm font-medium text-gray-700">
                        {{ $step }}
                    </span>
                </div>

                @endforeach

            </div>

        </div>

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
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Karyawan</th>
                        <th class="px-6 py-4 text-left">Jenis Cuti</th>
                        <th class="px-6 py-4 text-left">Approver</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-left">Catatan</th>
                        <th class="px-6 py-4 text-center">Tanggal</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($riwayatApproval as $item)

                    <tr class="border-t border-gray-100">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->pengajuanCuti->user->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->pengajuanCuti->jenisCuti->nama_cuti ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->approver->name ?? '-' }}
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

                        <td class="px-6 py-4">
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