@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">
            Selamat Datang, {{ Auth::user()->name }}
        </h1>

        <p class="text-gray-600 mt-2">
            Selamat datang di Dashboard Direktur.
        </p>
    </div>

    {{-- STATISTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Sisa Cuti Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
             <a href="{{ route('direktur.karyawan.index') }}"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Karyawan Aktif</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">
                        {{ $totalKaryawan }}
                    </p>
                    <p class="text-gray-500 text-xs mt-2">
                        Karyawan
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-cyan-50 rounded-2xl flex items-center justify-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-cyan-50 rounded-2xl flex items-center justify-center">
                        <x-heroicon-o-users class="w-8 h-8 text-cyan-600" />
                    </div>
                </div>
            </div>
             </a>
        </div>



        {{--Sedang Cuti Hari Ini Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
             <a href="{{ route('direktur.riwayat_cuti.index') }}"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">
                        Sedang Cuti Hari Ini
                    </p>

                    <p class="text-4xl font-bold text-gray-900 mt-2">
                        {{ $sedangCutiHariIni }}
                    </p>

                    <p class="text-gray-500 text-xs mt-2">
                        Karyawan sedang cuti
                    </p>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center">
                    <x-heroicon-o-calendar-days class="w-8 h-8 text-green-600" />
                </div>
            </div>
             </a>
        </div>

        {{-- Pending Approval --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
             <a href="#"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">
                        Menunggu Persetujuan Direktur
                    </p>

                    <p class="text-4xl font-bold text-gray-900 mt-2">
                        {{ $pendingDirektur }}
                    </p>

                    <p class="text-gray-500 text-xs mt-2">
                        Pengajuan pending Direktur
                    </p>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-2xl flex items-center justify-center">
                    <x-heroicon-o-clock class="w-8 h-8 text-yellow-600" />
                </div>
            </div>
             </a>
        </div>
    </div>
    {{-- TABLE CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Daftar Pengajuan Cuti</h2>
                
            </div>
        </div>

        {{-- Table --}}
        @if($pengajuanCuti->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nama
                        </th>

                        <!-- <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Jabatan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Divisi
                        </th> -->

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Jenis Cuti
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal Mulai
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal Selesai
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal Masuk
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Jumlah Hari
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi
                        </th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengajuanCuti as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $pengajuanCuti->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $item->user->name }}
                        </td>
                        <!-- <td class="px-6 py-4 text-sm text-gray-600">
                            {{ ucfirst($item->user->roles->first()?->name ?? '-') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $item->user->divisi->nama_divisi ?? '-' }}
                        </td> -->
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
                            {{ $item->tanggal_masuk->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold text-center">
                            {{ $item->jumlah_hari }} hari
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @php
                            $statusConfig = [
                            'pending_lead' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending Lead'],
                            'pending_hrd' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending HRD'],
                            'pending_head' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending Head'],
                            'pending_direktur' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'label' => 'Pending Direktur'],
                            'disetujui' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'label' => 'Disetujui'],
                            'ditolak' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'label' => 'Ditolak'],
                            ];
                            $config = $statusConfig[$item->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'label' => ucfirst($item->status)];
                            @endphp
                            <span class="px-3 py-1 rounded-full {{ $config['bg'] }} {{ $config['text'] }} text-xs font-semibold">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-center gap-3">

                                <form action="{{ route('direktur.approval_cuti.setuju', $item->id) }}"
                                    method="POST">
                                    @csrf

                                    <button type="submit"
                                        onclick="return confirm('Setujui pengajuan cuti ini?')"
                                        class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                        Setujui
                                    </button>
                                </form>
                                <button type="button"
                                    onclick="openRejectModal({{ $item->id }})"
                                    class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-xs font-semibold">

                                    Tolak

                                </button>
                                <a href="{{ route('direktur.approval_cuti.show', $item->id) }}"
                                    class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-xs font-semibold">
                                    Detail
                                </a>



                            </div>

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
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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



        @else
        {{-- Empty State --}}
        <div class="p-12 text-center">
            <div class="flex flex-col items-center gap-3">
                <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div>
                    <p class="text-gray-900 font-bold text-lg">Belum ada pengajuan cuti</p>
                </div>
                
            </div>
        </div>
        @endif

    </div>
    <div id="rejectModal"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white rounded-xl p-6 w-full max-w-md">

        <h3 class="text-lg font-semibold mb-4">
            Alasan Penolakan
        </h3>

        <form id="rejectForm" method="POST">

            @csrf

            <textarea
                name="alasan_penolakan"
                rows="4"
                required
                class="w-full rounded-lg border border-gray-300 p-3"></textarea>

            <div class="flex justify-end gap-2 mt-4">

                <button type="button"
                    onclick="closeRejectModal()"
                    class="bg-gray-200 px-4 py-2 rounded-lg">

                    Batal

                </button>

                <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg">

                    Simpan

                </button>

            </div>

        </form>

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
<script>
    function openRejectModal(id) {
        const form = document.getElementById('rejectForm');

        form.action =
            "{{ url('/direktur/approval_cuti') }}/" + id + "/tolak";

        document
            .getElementById('rejectModal')
            .classList.remove('hidden');
    }

    function closeRejectModal() {
        document
            .getElementById('rejectModal')
            .classList.add('hidden');
    }
</script>

@endsection