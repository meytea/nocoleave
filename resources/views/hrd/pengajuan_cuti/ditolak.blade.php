@extends('layouts.app')

@section('content')

<div class="space-y-8">
    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Pengajuan Cuti Ditolak</h1>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
    <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-start gap-3">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p class="text-sm font-semibold text-green-700">Berhasil!</p>
            <p class="text-sm text-green-600 mt-1">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Daftar Pengajuan Cuti Ditolak</h2>
                <p class="text-sm text-gray-600 mt-1">Total: {{ $pengajuanCuti->total() }} pengajuan</p>
            </div>

            {{-- Form Filter Jenis Cuti --}}
            <form action="{{ route('hrd.pengajuan_cuti.ditolak') }}" method="GET" class="flex items-center gap-2">
                <select name="jenis_cuti_id" onchange="this.form.submit()"
                    class="rounded-xl border-gray-200 text-sm focus:border-cyan-500 focus:ring-cyan-500 py-2 pl-3 pr-10 text-gray-700">
                    <option value="">Semua Jenis Cuti</option>
                    @foreach($jenisCutiList as $jenis)
                    <option value="{{ $jenis->id }}" {{ request('jenis_cuti_id') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_cuti }}
                    </option>
                    @endforeach
                </select>
                @if(request()->filled('jenis_cuti_id'))
                <a href="{{ route('hrd.pengajuan_cuti.ditolak') }}"
                    class="inline-flex items-center justify-center p-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors"
                    title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
                @endif
            </form>

        </div>

        {{-- Table --}}
        @if($pengajuanCuti->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Mulai</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Selesai</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah Hari</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
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
                                </form>
                                <a href="#"
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
                                    <p class="text-gray-600 font-medium">Belum ada pengajuan cuti yang ditolak</p>
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
                    <p class="text-gray-900 font-bold text-lg">Belum ada pengajuan cuti yang ditolak</p>
                </div>

            </div>
        </div>
        @endif

    </div>

</div>

@endsection