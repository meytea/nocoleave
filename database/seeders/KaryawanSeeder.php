<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawans = [
            [
                'email' => 'karyawan.backend1@nocoleave.com',
                'name' => 'Fajar Nugroho',
                'nik' => '4001001',
                'jenis_kelamin' => 'laki-laki',
                'divisi' => 'Web Developer Backend',
            ],
            [
                'email' => 'karyawan.mobile1@nocoleave.com',
                'name' => 'Rina Kurnia',
                'nik' => '4001002',
                'jenis_kelamin' => 'perempuan',
                'divisi' => 'Mobile Developer',
            ],
            [
                'email' => 'karyawan.support1@nocoleave.com',
                'name' => 'Anton Setiawan',
                'nik' => '4001003',
                'jenis_kelamin' => 'laki-laki',
                'divisi' => 'Support Operasional',
            ],
            [
                'email' => 'karyawan.hrd1@nocoleave.com',
                'name' => 'Maya Putri',
                'nik' => '4001004',
                'jenis_kelamin' => 'perempuan',
                'divisi' => 'Human Resource Development',
            ],
        ];

        foreach ($karyawans as $userData) {
            $divisi = Divisi::where('nama_divisi', $userData['divisi'])->first();

            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'nik' => $userData['nik'],
                    'jenis_kelamin' => $userData['jenis_kelamin'],
                    'is_active' => true,
                    'divisi_id' => $divisi?->id,
                ]
            )->assignRole('karyawan');
        }
    }
}
