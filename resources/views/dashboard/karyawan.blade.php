@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Dashboard Karyawan</h1>
        <p class="text-gray-600 mt-2">Selamat Datang</p>
    </div>

    {{-- STATISTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Sisa Cuti Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <a href="{{ route('karyawan.pengajuan_cuti.create') }}"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Sisa Cuti Tahunan</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $sisaCutiTahunan }}
                        </p>
                        <p class="text-gray-500 text-xs mt-2">
                            Hari tersisa
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-cyan-50 rounded-2xl flex items-center justify-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-cyan-50 rounded-2xl flex items-center justify-center">
                            <x-heroicon-o-user class="w-8 h-8 text-cyan-600" />
                        </div>
                    </div>
                </div>
            </a>
        </div>



        {{-- Disetujui Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <a href="{{ route('karyawan.pengajuan_cuti.disetujui') }}"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pengajuan Disetujui</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $pengajuanDisetujui }}
                        </p>
                        <p class="text-gray-500 text-xs mt-2">
                            Pengajuan Disetujui
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center">
                            <x-heroicon-o-check-circle class="w-8 h-8 text-green-600" />
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Ditolak Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <a href="{{ route('karyawan.pengajuan_cuti.ditolak') }}"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium"> Pengajuan Ditolak</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $pengajuanDitolak }}
                        </p>
                        <p class="text-gray-500 text-xs mt-2">
                            Pengajuan Ditolak
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center">
                            <x-heroicon-o-x-circle class="w-8 h-8 text-red-600" />
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- PENDING APPROVAL TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Pengajuan Cuti</h2>
            <p class="text-sm text-gray-600 mt-1">{{ now()->format('d F Y') }}</p>
        </div>

        @if($pengajuanTerbaru->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Mulai</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Selesai</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Masuk</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Hari</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                @endif
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengajuanTerbaru as $index => $item)

                    <tr class="hover:bg-gray-50 transition-colors">

                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                                {{ $item->jenisCuti->nama_cuti }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_mulai->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_selesai->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->jumlah_hari }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            @php
                            $statusConfig = [
                            'pending_lead' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending Lead'],
                            'pending_hrd' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending HRD'],
                            'pending_head' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending Head'],
                            'pending_direktur' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending Direktur'],
                            'disetujui' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'label' => 'Disetujui'],
                            'ditolak' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'label' => 'Ditolak'],
                            ];

                            $config = $statusConfig[$item->status] ?? [
                            'bg' => 'bg-gray-50',
                            'text' => 'text-gray-700',
                            'label' => ucfirst($item->status)
                            ];
                            @endphp

                            <span class="px-3 py-1 rounded-full {{ $config['bg'] }} {{ $config['text'] }} text-xs font-semibold">
                                {{ $config['label'] }}
                            </span>

                        </td>

                        <td class="px-6 py-4 text-center">

                            <a href="{{ route('karyawan.pengajuan_cuti.show', $item->id) }}"
                                class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                Detail
                            </a>

                        </td>

                    </tr>


                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p class="text-gray-600 font-medium">Belum ada pengajuan cuti</p>
                                    <p class="text-sm text-gray-500 mt-1">Mulai buat pengajuan cuti pertama Anda</p>
                                </div>
                                <a href="{{ route('karyawan.pengajuan_cuti.create') }}"
                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-cyan-600 text-white text-sm font-semibold hover:bg-cyan-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Ajukan Cuti
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($pengajuanCuti->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
                <p class="text-sm text-gray-600">
                    Menampilkan
                    <span class="font-semibold">{{ $pengajuanCuti->firstItem() }}</span>
                    hingga
                    <span class="font-semibold">{{ $pengajuanCuti->lastItem() }}</span>
                    dari
                    <span class="font-semibold">{{ $pengajuanCuti->total() }}</span>
                </p>
                <div class="flex gap-1">
                    {{-- Previous Link --}}
                    @if ($pengajuanCuti->onFirstPage())
                    <span class="px-3 py-2 rounded-lg text-gray-400 bg-gray-100 text-sm font-medium cursor-not-allowed">← Sebelumnya</span>
                    @else
                    <a href="{{ $pengajuanCuti->previousPageUrl() }}"
                        class="px-3 py-2 rounded-lg text-gray-700 bg-white border border-gray-300 text-sm font-medium hover:bg-gray-50 transition-colors">
                        ← Sebelumnya
                    </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($pengajuanCuti->getUrlRange(1, $pengajuanCuti->lastPage()) as $page => $url)
                    @if ($page == $pengajuanCuti->currentPage())
                    <span class="px-3 py-2 rounded-lg bg-cyan-600 text-white text-sm font-medium">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}"
                        class="px-3 py-2 rounded-lg text-gray-700 bg-white border border-gray-300 text-sm font-medium hover:bg-gray-50 transition-colors">
                        {{ $page }}
                    </a>
                    @endif
                    @endforeach

                    {{-- Next Link --}}
                    @if ($pengajuanCuti->hasMorePages())
                    <a href="{{ $pengajuanCuti->nextPageUrl() }}"
                        class="px-3 py-2 rounded-lg text-gray-700 bg-white border border-gray-300 text-sm font-medium hover:bg-gray-50 transition-colors">
                        Selanjutnya →
                    </a>
                    @else
                    <span class="px-3 py-2 rounded-lg text-gray-400 bg-gray-100 text-sm font-medium cursor-not-allowed">Selanjutnya →</span>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- {{-- WORKFLOW SUMMARY & LEAVE STATISTICS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Workflow Summary --}}
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Workflow Approval</h3>

            <div class="space-y-4">

                {{-- Pending Lead --}}
                <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Pending Lead</p>
                        <p class="text-xs text-gray-600 mt-1">Menunggu Lead</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-yellow-700 bg-yellow-100">
                        8
                    </span>
                </div>

                {{-- Pending HRD --}}
                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl border border-purple-100">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Pending HRD</p>
                        <p class="text-xs text-gray-600 mt-1">Menunggu HRD</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-purple-700 bg-purple-100">
                        5
                    </span>
                </div>

                {{-- Pending Head --}}
                <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Pending Head</p>
                        <p class="text-xs text-gray-600 mt-1">Menunggu Head</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-indigo-700 bg-indigo-100">
                        3
                    </span>
                </div>

                {{-- Pending Direktur --}}
                <div class="flex items-center justify-between p-4 bg-pink-50 rounded-xl border border-pink-100">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Pending Direktur</p>
                        <p class="text-xs text-gray-600 mt-1">Menunggu Direktur</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-pink-700 bg-pink-100">
                        2
                    </span>
                </div>

            </div>
        </div>

        {{-- Leave Statistics --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Statistik Jenis Cuti</h3>

            <div class="space-y-6">

                {{-- Cuti Tahunan --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-gray-700">Cuti Tahunan</p>
                        <span class="text-sm font-bold text-gray-900">42 / 60 digunakan</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-3 rounded-full" style="width: 70%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">70% - 18 hari tersisa</p>
                </div>

                {{-- Cuti Sakit --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-gray-700">Cuti Sakit</p>
                        <span class="text-sm font-bold text-gray-900">8 / 12 digunakan</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-red-500 to-orange-500 h-3 rounded-full" style="width: 67%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">67% - 4 hari tersisa</p>
                </div>

                {{-- Cuti Besar --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-gray-700">Cuti Besar</p>
                        <span class="text-sm font-bold text-gray-900">15 / 30 digunakan</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-3 rounded-full" style="width: 50%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">50% - 15 hari tersisa</p>
                </div>

                {{-- Cuti Melahirkan --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-gray-700">Cuti Melahirkan</p>
                        <span class="text-sm font-bold text-gray-900">3 / 90 digunakan</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3 rounded-full" style="width: 3%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">3% - 87 hari tersisa</p>
                </div>

            </div>
        </div>

    </div> -->

</div>

@endsection