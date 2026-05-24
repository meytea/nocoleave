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
                'kuota' => 12,
                'is_tahunan' => true,
            ],
            [
                'nama_cuti' => 'Cuti Menikah',
                'kuota' => 3,
                'is_tahunan' => false,
            ],
            [
                'nama_cuti' => 'Cuti Melahirkan',
                'kuota' => 90,
                'is_tahunan' => false,
            ],
            [
                'nama_cuti' => 'Cuti Menemani Istri Melahirkan',
                'kuota' => 2,
                'is_tahunan' => false,
            ],
            [
                'nama_cuti' => 'Cuti Menikahkan Anak',
                'kuota' => 2,
                'is_tahunan' => false,
            ],
            [
                'nama_cuti' => 'Cuti Keguguran',
                'kuota' => null,
                'is_tahunan' => false,
            ],
            [
                'nama_cuti' => 'Cuti Keluarga Inti Meninggal',
                'kuota' => 2,
                'is_tahunan' => false,
            ],
            [
                'nama_cuti' => 'Cuti Umroh',
                'kuota' => 15,
                'is_tahunan' => false,
            ],
            [
                'nama_cuti' => 'Cuti Haji',
                'kuota' => 40,
                'is_tahunan' => false,
            ],
        ];

        foreach ($jenisCuti as $item) {
            JenisCuti::firstOrCreate(
                [
                    'nama_cuti' => $item['nama_cuti']
                ],
                $item
            );
        }
    }
}