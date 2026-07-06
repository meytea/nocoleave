<?php

namespace Database\Seeders;

use App\Models\HakCuti;
use App\Models\JenisCuti;
use App\Models\User;
use Illuminate\Database\Seeder;

class HakCutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahun = now()->year;

        // Ambil hanya jenis cuti tahunan
        $jenisCutiTahunan = JenisCuti::where('is_tahunan', true)->get();

        // User yang berhak memiliki hak cuti
        $users = User::role([
            'karyawan',
            'lead',
            'head',
            'hrd',
        ])->get();

        foreach ($users as $user) {

            foreach ($jenisCutiTahunan as $jenisCuti) {

                HakCuti::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'jenis_cuti_id' => $jenisCuti->id,
                        'tahun' => $tahun,
                    ],
                    [
                        'terpakai' => 0,
                        'sisa' => $jenisCuti->kuota,
                    ]
                );
            }
        }
    }
}