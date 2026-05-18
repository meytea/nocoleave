@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Dashboard Monitoring</h1>
        <p class="text-gray-600 mt-2">Kelola dan pantau semua pengajuan cuti karyawan</p>
    </div>

    {{-- STATISTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Total Karyawan Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Karyawan</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">120</p>
                    <p class="text-green-600 text-xs mt-2">↑ 5 bulan ini</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-cyan-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 19H9a6 6 0 016-6v0a6 6 0 016 6v1.25M12 4.354a4 4 0 110 5.292M15 19H9a6 6 0 016-6v0a6 6 0 016 6v1.25" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Pengajuan Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Pengajuan</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">156</p>
                    <p class="text-blue-600 text-xs mt-2">Tahun ini</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Disetujui Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Disetujui</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">98</p>
                    <p class="text-green-600 text-xs mt-2">62.8%</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Ditolak Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Ditolak</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">24</p>
                    <p class="text-red-600 text-xs mt-2">15.4%</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2-2l2 2" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- PENDING APPROVAL TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Pengajuan Menunggu Persetujuan</h2>
            <p class="text-sm text-gray-600 mt-1">{{ now()->format('d F Y') }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Karyawan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hari</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Approver</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    {{-- Row 1 --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Budi Santoso</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                Cuti Tahunan
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">19 Mei - 24 Mei 2026</td>
                        <td class="px-6 py-4 text-sm text-gray-600">6 hari</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                Pending Lead
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Rina Wijaya</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                Detail
                            </button>
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-cyan-600 hover:bg-cyan-700 text-white transition">
                                Setujui
                            </button>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Siti Nurhaliza</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                Cuti Sakit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">18 Mei - 19 Mei 2026</td>
                        <td class="px-6 py-4 text-sm text-gray-600">2 hari</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                                Pending HRD
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Hendra Kusuma</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                Detail
                            </button>
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-cyan-600 hover:bg-cyan-700 text-white transition">
                                Setujui
                            </button>
                        </td>
                    </tr>

                    {{-- Row 3 --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Ahmad Rizki</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700">
                                Cuti Besar
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">01 Juni - 30 Juni 2026</td>
                        <td class="px-6 py-4 text-sm text-gray-600">30 hari</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                Pending Head
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Bambang Sutrisno</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                Detail
                            </button>
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-cyan-600 hover:bg-cyan-700 text-white transition">
                                Setujui
                            </button>
                        </td>
                    </tr>

                    {{-- Row 4 --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Dwi Handoko</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                Cuti Tahunan
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">22 Mei - 23 Mei 2026</td>
                        <td class="px-6 py-4 text-sm text-gray-600">2 hari</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pink-50 text-pink-700">
                                Pending Direktur
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Direktur</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                Detail
                            </button>
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-cyan-600 hover:bg-cyan-700 text-white transition">
                                Setujui
                            </button>
                        </td>
                    </tr>

                    {{-- Row 5 --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Yuni Wijaya</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                                Cuti Melahirkan
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">01 Juli - 31 Agustus 2026</td>
                        <td class="px-6 py-4 text-sm text-gray-600">60 hari</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                Pending Lead
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Rina Wijaya</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                Detail
                            </button>
                            <button class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-cyan-600 hover:bg-cyan-700 text-white transition">
                                Setujui
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    {{-- WORKFLOW SUMMARY & LEAVE STATISTICS --}}
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

    </div>

</div>

@endsection