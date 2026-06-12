<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JenisCuti;
use App\Models\HakCuti;

class HakCutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisCutiList = JenisCuti::all();
        $karyawanUsers = User::role('hrd')->get();
        $tahun = now()->year;

        foreach ($karyawanUsers as $user) {
            foreach ($jenisCutiList as $jenisCuti) {
                HakCuti::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'jenis_cuti_id' => $jenisCuti->id,
                        'tahun' => $tahun,
                    ],
                    [
                        'sisa' => $jenisCuti->kuota ?? 0,
                        'terpakai' => 0,
                    ]
                );
            }
        }
    }
}
