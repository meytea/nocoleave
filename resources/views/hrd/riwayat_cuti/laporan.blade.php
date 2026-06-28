@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Laporan Cuti
        </h1>

        <p class="mt-1 text-gray-500">
            Export laporan cuti karyawan dalam format Excel.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <form action="{{ route('hrd.riwayat_cuti.export') }}"
            method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Jenis Laporan --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Laporan
                    </label>

                    <select
                        name="jenis_laporan"
                        id="jenis_laporan"
                        onchange="toggleJenisCuti()"
                        class="w-full rounded-xl border-gray-300">

                        <option value="tahunan">
                            Cuti Tahunan
                        </option>

                        <option value="non_tahunan">
                            Cuti Non Tahunan
                        </option>

                    </select>

                </div>

                {{-- Tahun --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun
                    </label>

                    <select name="tahun"
                        class="w-full rounded-xl border-gray-300">

                        @for($tahun = now()->year; $tahun >= 2023; $tahun--)

                        <option value="{{ $tahun }}">
                            {{ $tahun }}
                        </option>

                        @endfor

                    </select>

                </div>

                {{-- Jenis Cuti --}}
                <div
                    id="jenis_cuti_container"
                    class="hidden md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Cuti
                    </label>

                    <select name="jenis_cuti_id"
                        class="w-full rounded-xl border-gray-300">

                        <option value="">
                            -- Pilih Jenis Cuti --
                        </option>

                        @foreach($jenisCuti as $item)

                        <option value="{{ $item->id }}">
                            {{ $item->nama_cuti }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <a
                    href="{{ route('hrd.riwayat_cuti.disetujui') }}"
                    class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300">

                    Kembali

                </a>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white">

                    Export Excel

                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function toggleJenisCuti() {

        let jenis = document.getElementById('jenis_laporan').value;

        let container = document.getElementById('jenis_cuti_container');

        if (jenis === 'non_tahunan') {

            container.classList.remove('hidden');

        } else {

            container.classList.add('hidden');

        }

    }
</script>

@endsection