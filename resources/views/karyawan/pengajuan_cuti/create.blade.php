@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Ajukan Cuti
        </h1>

        @php
        $cutiTahunan = $hakCuti->first(function ($hak) {
        return $hak->jenisCuti?->is_tahunan;
        });
        @endphp

        <div
            id="info-cuti-tahunan"
            data-sisa="{{ $cutiTahunan?->sisa ?? 0 }}"
            class="hidden mb-6 bg-cyan-50 border border-cyan-200 rounded-xl p-4">



            <p class="text-cyan-700 font-medium">
                Sisa Cuti Tahunan Anda:
                <span class="font-bold">
                    {{ $cutiTahunan?->sisa ?? 0 }} Hari
                </span>
            </p>

        </div>

        @if ($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('error'))
        <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
        @endif



        <form action="{{ route('karyawan.pengajuan_cuti.store') }}"
            method="POST"
            class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Cuti
                    </label>

                    <select
                        id="kategori_cuti"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        <option value="">
                            Pilih Kategori
                        </option>

                        <option value="tahunan">
                            Tahunan
                        </option>

                        <option value="non_tahunan">
                            Non Tahunan
                        </option>

                    </select>
                </div>
                <!-- <div
                    id="info-cuti-tahunan"
                    class="hidden bg-cyan-50 border border-cyan-200 rounded-xl p-4">

                    @php
                    $cutiTahunan = $hakCuti->first(function ($hak) {
                    return $hak->jenisCuti?->is_tahunan;
                    });
                    @endphp

                    <p class="text-cyan-700 font-medium">
                        Sisa Cuti Tahunan Anda:
                        <span class="font-bold">
                            {{ $cutiTahunan?->sisa ?? 0 }} Hari
                        </span>
                    </p>

                </div> -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Cuti
                    </label>

                    <select
                        name="jenis_cuti_id"
                        id="jenis_cuti_id"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        <option value="">
                            Pilih Jenis Cuti
                        </option>

                        @foreach($jenisCuti as $item)

                        <option
                            value="{{ $item->id }}"
                            data-tahunan="{{ $item->is_tahunan ? '1' : '0' }}"
                            data-kuota="{{ $item->kuota }}">

                            {{ $item->nama_cuti }}

                        </option>

                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input type="date"
                        name="tanggal_mulai"
                        min="{{ now()->subDays(3)->format('Y-m-d') }}"
                        value="{{ old('tanggal_mulai') }}"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>

                    <input type="date"
                        name="tanggal_selesai"
                        min="{{ now()->subDays(3)->format('Y-m-d') }}"
                        value="{{ old('tanggal_selesai') }}"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Hari Cuti
                </label>

                <input
                    type="text"
                    id="jumlah_hari_preview"
                    readonly
                    value="-"
                    class="w-full rounded-xl bg-gray-100 border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Masuk
                </label>

                <input
                    type="text"
                    id="tanggal_masuk_preview"
                    readonly
                    value="-"
                    class="w-full rounded-xl bg-gray-100 border-gray-300">
            </div>

            <!-- Hidden input untuk menyimpan tanggal_masuk -->
            <input type="hidden" name="tanggal_masuk" id="tanggal_masuk_hidden" value="">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Cuti
                </label>

                <textarea name="alasan"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">{{ old('alasan') }}</textarea>
            </div>

            <div class="flex items-center gap-4 pt-4">

                <button type="submit"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">
                    Ajukan Cuti
                </button>

                <a href="{{ route('karyawan.pengajuan_cuti.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

<script>
    // Menjalankan seluruh script setelah halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {

        // Fungsi untuk menghitung jumlah hari cuti dan menentukan tanggal masuk kerja secara otomatis
        function hitungJumlahHari() {

            // Jika tanggal belum lengkap maka preview dikosongkan
            if (!tanggalMulai.value || !tanggalSelesai.value) {
                jumlahHariPreview.value = '0 Hari';
                tanggalMasukPreview.value = '-';
                return;
            }

            let mulai = new Date(tanggalMulai.value);
            let selesai = new Date(tanggalSelesai.value);

            let jumlahHari = 0;

            // Menghitung jumlah hari cuti dengan mengabaikan hari Minggu
            while (mulai <= selesai) {

                if (mulai.getDay() !== 0) {
                    jumlahHari++;
                }

                mulai.setDate(mulai.getDate() + 1);
            }

            // Menampilkan jumlah hari cuti pada form
            jumlahHariPreview.value = jumlahHari + ' Hari';

            // Menghitung tanggal masuk kerja setelah cuti selesai
            let tanggalMasuk = new Date(tanggalSelesai.value);

            tanggalMasuk.setDate(
                tanggalMasuk.getDate() + 1
            );

            // Jika tanggal masuk jatuh pada hari Minggu,
            // maka otomatis dipindahkan ke hari Senin
            if (tanggalMasuk.getDay() === 0) {
                tanggalMasuk.setDate(
                    tanggalMasuk.getDate() + 1
                );
            }

            // Menampilkan tanggal masuk kerja
            tanggalMasukPreview.value =
                tanggalMasuk.toLocaleDateString('id-ID');

            // Menyimpan tanggal masuk ke hidden input
            // agar dapat dikirim ke controller
            const year = tanggalMasuk.getFullYear();
            const month = String(tanggalMasuk.getMonth() + 1).padStart(2, '0');
            const day = String(tanggalMasuk.getDate()).padStart(2, '0');
            document.getElementById('tanggal_masuk_hidden').value = `${year}-${month}-${day}`;
        }

        // Mengambil elemen-elemen form yang diperlukan
        const kategoriSelect = document.getElementById('kategori_cuti');
        const jenisCutiSelect = document.getElementById('jenis_cuti_id');
        const tanggalMulai = document.querySelector('[name="tanggal_mulai"]');
        const tanggalSelesai = document.querySelector('[name="tanggal_selesai"]');
        const jumlahHariPreview = document.getElementById('jumlah_hari_preview');
        const tanggalMasukPreview = document.getElementById('tanggal_masuk_preview');

        // Informasi sisa cuti tahunan
        const infoTahunan =
            document.getElementById('info-cuti-tahunan');

        // Event ketika kategori cuti dipilih
        kategoriSelect.addEventListener('change', function() {

            const kategori = this.value;

            const sisa = parseInt(infoTahunan.dataset.sisa);

            if (kategori === 'tahunan' && sisa <= 0) {

                alert('Sisa cuti tahunan Anda telah habis.');

                tanggalMulai.disabled = true;
                tanggalSelesai.disabled = true;

            } else {

                tanggalMulai.disabled = false;
                tanggalSelesai.disabled = false;
            }

            // Menampilkan atau menyembunyikan informasi sisa cuti tahunan
            if (kategori === 'tahunan') {
                infoTahunan.classList.remove('hidden');
            } else {
                infoTahunan.classList.add('hidden');
            }

            // Memfilter jenis cuti sesuai kategori yang dipilih
            const options = jenisCutiSelect.querySelectorAll('option');

            options.forEach(option => {

                if (option.value === '') {
                    option.hidden = false;
                    return;
                }

                const isTahunan = option.dataset.tahunan === '1';

                if (kategori === 'tahunan') {
                    option.hidden = !isTahunan;
                } else if (kategori === 'non_tahunan') {
                    option.hidden = isTahunan;
                } else {
                    option.hidden = false;
                }


            });

            hitungBatasCutiTahunan();

            // Mengosongkan pilihan jenis cuti ketika kategori berubah
            jenisCutiSelect.value = '';
        });

        // Event ketika jenis cuti dipilih
        jenisCutiSelect.addEventListener('change', function() {

            if (!tanggalMulai.value) {
                return;
            }

            // Menghitung batas maksimal cuti non tahunan berdasarkan kuota jenis cuti
            if (kategoriSelect.value === 'non_tahunan') {

                hitungBatasCutiNonTahunan();

            }

        });

        // Event ketika tanggal mulai dipilih
        tanggalMulai.addEventListener('change', function() {

            cekHariMinggu(this);

            if (!this.value) return;

            // Tanggal selesai tidak boleh lebih kecil dari tanggal mulai
            tanggalSelesai.min = this.value;

            // Menentukan batas maksimal tanggal selesai berdasarkan kategori cuti
            if (kategoriSelect.value === 'tahunan') {

                hitungBatasCutiTahunan();

            } else if (kategoriSelect.value === 'non_tahunan') {

                hitungBatasCutiNonTahunan();

            }

            if (
                tanggalSelesai.value &&
                tanggalSelesai.value < this.value
            ) {
                tanggalSelesai.value = '';
            }

            hitungJumlahHari();
        });

        // Event ketika tanggal selesai dipilih
        tanggalSelesai.addEventListener('change', function() {

            cekHariMinggu(this);

            if (!this.value) return;

            hitungJumlahHari();
        });

        // Validasi agar pengguna tidak dapat memilih hari Minggu
        function cekHariMinggu(input) {

            const tanggal = new Date(input.value);

            if (tanggal.getDay() === 0) {

                alert('Hari Minggu tidak dapat dipilih.');

                input.value = '';

                jumlahHariPreview.value = '0 Hari';
            }
        }

        // Menghitung batas maksimal tanggal selesai
        // berdasarkan sisa hak cuti tahunan yang dimiliki
        function hitungBatasCutiTahunan() {

            if (
                kategoriSelect.value !== 'tahunan' ||
                !tanggalMulai.value
            ) {
                tanggalSelesai.removeAttribute('max');
                return;
            }

            const sisa = parseInt(
                infoTahunan.dataset.sisa
            );

            console.log('Sisa cuti:', sisa);
            console.log('Kategori:', kategoriSelect.value);

            if (sisa <= 0) {
                tanggalSelesai.removeAttribute('max');
                return;
            }

            let batas = new Date(tanggalMulai.value);

            let hariKerja = 1;

            while (hariKerja < sisa) {

                batas.setDate(
                    batas.getDate() + 1
                );

                if (batas.getDay() !== 0) {
                    hariKerja++;
                }
            }

            tanggalSelesai.max =
                batas.toISOString().split('T')[0];

            console.log('Max tanggal selesai:', tanggalSelesai.max);
        }

         // Menghitung batas maksimal tanggal selesai
        // berdasarkan kuota pada jenis cuti non tahunan
        function hitungBatasCutiNonTahunan() {

            const selectedOption =
                jenisCutiSelect.options[
                    jenisCutiSelect.selectedIndex
                ];

            if (!selectedOption || !tanggalMulai.value) {
                tanggalSelesai.removeAttribute('max');
                return;
            }

            const kuota =
                parseInt(
                    selectedOption.dataset.kuota || 0
                );

            if (kuota <= 0) {
                tanggalSelesai.removeAttribute('max');
                return;
            }

            let batas = new Date(
                tanggalMulai.value
            );

            let hariKerja = 1;

            while (hariKerja < kuota) {

                batas.setDate(
                    batas.getDate() + 1
                );

                if (batas.getDay() !== 0) {
                    hariKerja++;
                }
            }

            tanggalSelesai.max =
                batas.toISOString().split('T')[0];
        }

    });
</script>

@endsection