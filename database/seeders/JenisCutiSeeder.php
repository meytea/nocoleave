<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisCuti;

class JenisCutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisCuti = [
            [
                'nama_cuti' => 'Cuti Tahunan',
                'kode_cuti' => 'CT',
                'durasi_default' => 12,
                'is_tahunan' => true,
                'keterangan' => 'Cuti tahunan karyawan maksimal 12 hari',
            ],
            [
                'nama_cuti' => 'Cuti Menikah',
                'kode_cuti' => 'CMN',
                'durasi_default' => 3,
                'is_tahunan' => false,
                'keterangan' => 'Cuti menikah maksimal 3 hari',
            ],
            [
                'nama_cuti' => 'Cuti Melahirkan',
                'kode_cuti' => 'CML',
                'durasi_default' => 90,
                'is_tahunan' => false,
                'keterangan' => 'Cuti melahirkan 45 hari sebelum dan 45 hari setelah melahirkan',
            ],
            [
                'nama_cuti' => 'Cuti Menemani Istri Melahirkan',
                'kode_cuti' => 'CIM',
                'durasi_default' => 2,
                'is_tahunan' => false,
                'keterangan' => 'Cuti untuk menemani istri melahirkan maksimal 2 hari',
            ],
            [
                'nama_cuti' => 'Cuti Menikahkan Anak',
                'kode_cuti' => 'CMA',
                'durasi_default' => 2,
                'is_tahunan' => false,
                'keterangan' => 'Cuti menikahkan anak maksimal 2 hari',
            ],
            [
                'nama_cuti' => 'Cuti Keguguran',
                'kode_cuti' => 'CKG',
                'durasi_default' => null,
                'is_tahunan' => false,
                'keterangan' => 'Durasi cuti berdasarkan rekomendasi manajemen',
            ],
            [
                'nama_cuti' => 'Cuti Keluarga Inti Meninggal',
                'kode_cuti' => 'CKM',
                'durasi_default' => 2,
                'is_tahunan' => false,
                'keterangan' => 'Cuti karena keluarga inti meninggal maksimal 2 hari',
            ],
            [
                'nama_cuti' => 'Cuti Umroh',
                'kode_cuti' => 'CU',
                'durasi_default' => 15,
                'is_tahunan' => false,
                'keterangan' => 'Cuti umroh maksimal 15 hari',
            ],
            [
                'nama_cuti' => 'Cuti Haji',
                'kode_cuti' => 'CH',
                'durasi_default' => 40,
                'is_tahunan' => false,
                'keterangan' => 'Cuti haji maksimal 40 hari',
            ],
        ];

        foreach ($jenisCuti as $item) {
            JenisCuti::firstOrCreate(
                [
                    'kode_cuti' => $item['kode_cuti']
                ],
                $item
            );
        }
    }
}