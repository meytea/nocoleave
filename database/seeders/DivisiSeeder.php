<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisi = [
            'Support Operasional',
            'HSE',

            'Web Developer Frontend',
            'Web Developer Backend',
            'Mobile Developer',
            'Project Management Officer',
            'IoT Development',

            'Human Resource Development',

            'Regional Business Development',
            'Digital Marketing',
        ];

        foreach ($divisi as $item) {
            Divisi::firstOrCreate([
                'nama_divisi' => $item
            ]);
        }
    }
}
