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

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">

            {{-- Judul --}}
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Daftar Pengajuan Cuti
                </h2>

                
            </div>

            {{-- Search & Filter --}}
            <form
                method="GET"
                id="filterForm"
                class="flex items-center gap-4">

                @php
                $statusList = [
                'disetujui' => 'Disetujui',
                'ditolak' => 'Ditolak',
                ];
                @endphp

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="w-44 rounded-xl border-gray-300 text-sm">

                    <option value="">Semua Status</option>

                    @foreach($statusList as $value => $label)

                    <option
                        value="{{ $value }}"
                        {{ request('status') == $value ? 'selected' : '' }}>

                        {{ $label }}

                    </option>

                    @endforeach

                </select>

                {{-- Filter Jenis Cuti --}}
                <select
                    name="jenis_cuti"
                    onchange="this.form.submit()"
                    class="w-60 rounded-xl border-gray-300 text-sm">

                    <option value="">Semua Jenis Cuti</option>

                    @foreach($jenisCuti as $item)

                    <option
                        value="{{ $item->id }}"
                        {{ request('jenis_cuti') == $item->id ? 'selected' : '' }}>

                        {{ $item->nama_cuti }}

                    </option>

                    @endforeach

                </select>

                {{-- Search --}}
                <div class="relative w-72">

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
                            <div class="font-medium">
                                {{ $item->approver->name ?? '-' }}
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ $item->approver->roles->first()->name ?? '-' }}
                            </div>
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

        {{-- Pagination --}}
@if($riwayatApproval->hasPages())
<div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">

    <p class="text-sm text-gray-600">
        Menampilkan
        <span class="font-semibold">{{ $riwayatApproval->firstItem() }}</span>
        hingga
        <span class="font-semibold">{{ $riwayatApproval->lastItem() }}</span>
        dari
        <span class="font-semibold">{{ $riwayatApproval->total() }}</span>
    </p>

    <div class="flex gap-1">

        {{-- Previous --}}
        @if ($riwayatApproval->onFirstPage())

            <span class="px-3 py-2 rounded-lg text-gray-400 bg-gray-100 text-sm font-medium cursor-not-allowed">
                ← Sebelumnya
            </span>

        @else

            <a href="{{ $riwayatApproval->previousPageUrl() }}"
                class="px-3 py-2 rounded-lg text-gray-700 bg-white border border-gray-300 text-sm font-medium hover:bg-gray-50 transition-colors">
                ← Sebelumnya
            </a>

        @endif

        {{-- Nomor Halaman --}}
        @foreach ($riwayatApproval->getUrlRange(1, $riwayatApproval->lastPage()) as $page => $url)

            @if ($page == $riwayatApproval->currentPage())

                <span class="px-3 py-2 rounded-lg bg-cyan-600 text-white text-sm font-medium">
                    {{ $page }}
                </span>

            @else

                <a href="{{ $url }}"
                    class="px-3 py-2 rounded-lg text-gray-700 bg-white border border-gray-300 text-sm font-medium hover:bg-gray-50 transition-colors">
                    {{ $page }}
                </a>

            @endif

        @endforeach

        {{-- Next --}}
        @if ($riwayatApproval->hasMorePages())

            <a href="{{ $riwayatApproval->nextPageUrl() }}"
                class="px-3 py-2 rounded-lg text-gray-700 bg-white border border-gray-300 text-sm font-medium hover:bg-gray-50 transition-colors">
                Selanjutnya →
            </a>

        @else

            <span class="px-3 py-2 rounded-lg text-gray-400 bg-gray-100 text-sm font-medium cursor-not-allowed">
                Selanjutnya →
            </span>

        @endif

    </div>

</div>
@endif


    </div>

    <!-- <div>
        {{ $riwayatApproval->links() }}
    </div> -->

</div>

<script>
    let timer;

    document.getElementById('search').addEventListener('keyup', function() {

        clearTimeout(timer);

        timer = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);

    });
</script>

@endsection