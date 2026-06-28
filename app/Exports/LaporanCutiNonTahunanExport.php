<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LaporanCutiNonTahunanExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    protected $tahun;
    protected $jenisCutiId;

    public function __construct($tahun, $jenisCutiId)
    {
        $this->tahun = $tahun;
        $this->jenisCutiId = $jenisCutiId;
    }

    public function collection()
    {
        $pengajuanCuti = PengajuanCuti::with([
            'user.roles',
            'user.divisi',
            'jenisCuti'
        ])
            ->where('status', 'disetujui')
            ->where('jenis_cuti_id', $this->jenisCutiId)
            ->whereYear('tanggal_mulai', $this->tahun)
            ->get();

        $rekap = [];

        foreach ($pengajuanCuti as $cuti) {

            if (!isset($rekap[$cuti->user_id])) {

                $rekap[$cuti->user_id] = [
                    'nama' => $cuti->user->name,
                    'nik' => $cuti->user->nik,
                    'jabatan' => $cuti->user->roles->first()?->name ?? '-',
                    'divisi' => $cuti->user->divisi?->nama_divisi ?? '-',
                    'bulan' => array_fill(1, 12, 0),
                    'total' => 0,
                ];
            }

            $hasil = $this->hitungPerBulan(
                $cuti->tanggal_mulai,
                $cuti->tanggal_selesai
            );

            foreach ($hasil as $bulan => $jumlahHari) {

                $rekap[$cuti->user_id]['bulan'][$bulan] += $jumlahHari;
                $rekap[$cuti->user_id]['total'] += $jumlahHari;
            }
        }

        return collect($rekap)->map(function ($item) {

            return [

                $item['nama'],

                $item['nik'],

                $item['jabatan'],

                $item['divisi'],

                $item['bulan'][1],
                $item['bulan'][2],
                $item['bulan'][3],
                $item['bulan'][4],
                $item['bulan'][5],
                $item['bulan'][6],
                $item['bulan'][7],
                $item['bulan'][8],
                $item['bulan'][9],
                $item['bulan'][10],
                $item['bulan'][11],
                $item['bulan'][12],

                $item['total'],

            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Jabatan',
            'Divisi',
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
            'Total Hari',
        ];
    }

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

    private function hitungPerBulan($tanggalMulai, $tanggalSelesai): array
    {
        $bulan = array_fill(1, 12, 0);

        $periode = CarbonPeriod::create(
            Carbon::parse($tanggalMulai),
            Carbon::parse($tanggalSelesai)
        );

        foreach ($periode as $tanggal) {

            // Lewati hari Minggu
            if ($tanggal->dayOfWeek == Carbon::SUNDAY) {
                continue;
            }

            $bulan[$tanggal->month]++;
        }

        return $bulan;
    }
}
