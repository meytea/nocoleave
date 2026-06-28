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

    </div>

    <div>
        {{ $riwayatApproval->links() }}
    </div>

</div>

@endsection