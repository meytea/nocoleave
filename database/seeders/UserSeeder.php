<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'meilita@nocoleave.com',
                'name' => 'Meilita Ayu Nur Khasanah',
                'nik' => '102405001',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'hrd',
                'divisi' => 'Human Resource Development',
            ],
            [
                'email' => 'muhammad@nocoleave.com',
                'name' => 'Muhammad Ardi',
                'nik' => '102405002',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'direktur',
                'divisi' => null,
            ],
            [
                'email' => 'budi@nocoleave.com',
                'name' => 'Budi Santoso',
                'nik' => '102405003',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'head',
                'divisi' => null,
            ],
            [
                'email' => 'siti@nocoleave.com',
                'name' => 'Siti Aminah',
                'nik' => '102405004',
                'jenis_kelamin' => 'perempuan',
                'role' => 'head',
                'divisi' => null,
            ],
            [
                'email' => 'rian@nocoleave.com',
                'name' => 'Rian Prasetyo',
                'nik' => '102405005',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'lead',
                'divisi' => 'Web Developer Backend',
            ],
            [
                'email' => 'dewi@nocoleave.com',
                'name' => 'Dewi Lestari',
                'nik' => '102405006',
                'jenis_kelamin' => 'perempuan',
                'role' => 'lead',
                'divisi' => 'Mobile Developer',
            ],
            [
                'email' => 'fajar@nocoleave.com',
                'name' => 'Fajar Nugroho',
                'nik' => '102405007',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'karyawan',
                'divisi' => 'Web Developer Backend',
            ],
            [
                'email' => 'rina@nocoleave.com',
                'name' => 'Rina Kurnia',
                'nik' => '102405008',
                'jenis_kelamin' => 'perempuan',
                'role' => 'karyawan',
                'divisi' => 'Mobile Developer',
            ],
            [
                'email' => 'anton@nocoleave.com',
                'name' => 'Anton Setiawan',
                'nik' => '102405009',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'karyawan',
                'divisi' => 'Support Operasional',
            ],
            [
                'email' => 'maya@nocoleave.com',
                'name' => 'Maya Putri',
                'nik' => '102405010',
                'jenis_kelamin' => 'perempuan',
                'role' => 'karyawan',
                'divisi' => 'Human Resource Development',
            ],
        ];

        foreach ($users as $userData) {
            $divisiId = null;

            if ($userData['divisi']) {
                $divisi = Divisi::where('nama_divisi', $userData['divisi'])->first();
                $divisiId = $divisi?->id;
            }

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'nik' => $userData['nik'],
                    'jenis_kelamin' => $userData['jenis_kelamin'],
                    'is_active' => true,
                    'divisi_id' => $divisiId,
                ]
            );

            if (! $user->hasRole($userData['role'])) {
                $user->assignRole($userData['role']);
            }
        }
    }
}
