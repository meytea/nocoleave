@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">
            Selamat Datang, {{ Auth::user()->name }}
        </h1>

        <p class="text-gray-600 mt-2">
            Selamat datang di Dashboard Lead.
        </p>
    </div>

    {{-- STATISTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Karyawan Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <a href="{{ route('lead.karyawan.index') }}"
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
            <a href="{{ route('lead.approval_cuti.disetujui', ['status' => 'sedang_cuti']) }}"
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
            <a href="{{ route('lead.approval_cuti.index') }}"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">
                            Menunggu Persetujuan Lead
                        </p>

                        <p class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $pendingLead }}
                        </p>

                        <p class="text-gray-500 text-xs mt-2">
                            Pengajuan pending Lead
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
    <div  class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Daftar Pengajuan Cuti</h2>
            </div>

            <form method="GET" id="searchForm">

                <div class="relative w-full max-w-md">

                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <x-heroicon-o-magnifying-glass
                            class="w-5 h-5 text-gray-400" />
                    </div>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Cari..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                </div>

            </form>

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

                        <!-- <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th> -->
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
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
                        <!-- <td class="px-6 py-4 text-sm text-center">
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
                        </td> -->
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-center gap-3">

                                <form action="{{ route('lead.approval_cuti.setuju', $item->id) }}"
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
                                <a href="{{ route('lead.approval_cuti.show', $item->id) }}"
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

</div>
<script>
    let timer;

    document.getElementById('search').addEventListener('keyup', function() {

        clearTimeout(timer);

        timer = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);

    });
  
    function openRejectModal(id) {
        const form = document.getElementById('rejectForm');

        form.action =
            "{{ url('/lead/approval_cuti') }}/" + id + "/tolak";

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