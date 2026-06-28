<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\HakCuti;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanCutiTahunanExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    // Menyimpan tahun laporan yang dipilih pengguna
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        // Mengambil data hak cuti tahunan seluruh karyawan pada tahun yang dipilih
        $hakCuti = HakCuti::with([
            'user.roles',
            'user.divisi',
            'jenisCuti'
        ])
            ->where('tahun', $this->tahun)
            ->whereHas('jenisCuti', function ($query) {
                $query->where('is_tahunan', true);
            })
            ->get();

        // Mengambil seluruh pengajuan cuti tahunan yang telah disetujui
        $pengajuanCuti = PengajuanCuti::where('status', 'disetujui')
            ->whereYear('tanggal_mulai', $this->tahun)
            ->whereHas('jenisCuti', function ($query) {
                $query->where('is_tahunan', true);
            })
            ->get();

        // Menyimpan rekap jumlah hari cuti setiap bulan berdasarkan user
        $rekap = [];

        foreach ($pengajuanCuti as $cuti) {

            // Membuat array bulan (1-12) jika user belum memiliki data rekap
            if (!isset($rekap[$cuti->user_id])) {

                $rekap[$cuti->user_id] = array_fill(1, 12, 0);
            }

            // Menghitung jumlah hari cuti pada masing-masing bulan
            $hasil = $this->hitungPerBulan(
                $cuti->tanggal_mulai,
                $cuti->tanggal_selesai
            );

            // Menambahkan jumlah hari ke bulan yang sesuai
            foreach ($hasil as $bulan => $jumlahHari) {

                $rekap[$cuti->user_id][$bulan] += $jumlahHari;
            }
        }

        // Menyusun data yang akan ditampilkan pada file Excel
        return $hakCuti->map(function ($item) use ($rekap) {

            // Mengambil data rekap bulanan berdasarkan user,
            // jika tidak ada maka seluruh bulan bernilai 0
            $bulan = $rekap[$item->user_id] ?? array_fill(1, 12, 0);

            return [

                $item->user->name,

                $item->user->nik,

                $item->user->roles->first()?->name ?? '-',

                $item->user->divisi?->nama_divisi ?? '-',

                $item->jenisCuti->kuota,

                // Rekap penggunaan cuti setiap bulan                
                $bulan[1],
                $bulan[2],
                $bulan[3],
                $bulan[4],
                $bulan[5],
                $bulan[6],
                $bulan[7],
                $bulan[8],
                $bulan[9],
                $bulan[10],
                $bulan[11],
                $bulan[12],

                // Rekap total penggunaan dan sisa hak cuti
                $item->terpakai,

                $item->sisa,

            ];
        });
    }

    // Membuat header pada file Excel
    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Jabatan',
            'Divisi',
            'Kuota Cuti',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
            'Terpakai',
            'Sisa Cuti',
        ];
    }

    // Menghitung jumlah hari cuti pada setiap bulan
    // dengan mengabaikan hari Minggu
    private function hitungPerBulan($tanggalMulai, $tanggalSelesai): array
    {
        $bulan = array_fill(1, 12, 0);

        $periode = CarbonPeriod::create(
            Carbon::parse($tanggalMulai),
            Carbon::parse($tanggalSelesai)
        );

        foreach ($periode as $tanggal) {

            // Hari Minggu tidak dihitung sebagai hari cuti
            if ($tanggal->dayOfWeek == Carbon::SUNDAY) {
                continue;
            }

            // Menambahkan jumlah hari pada bulan yang sesuai
            $bulan[$tanggal->month]++;
        }

        return $bulan;
    }

    // Menambahkan jumlah hari pada bulan yang sesuai
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}
