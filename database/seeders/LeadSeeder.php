<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leads = [
            [
                'email' => 'lead.backend@nocoleave.com',
                'name' => 'Rian Prasetyo',
                'nik' => '3001001',
                'jenis_kelamin' => 'laki-laki',
                'divisi' => 'Web Developer Backend',
            ],
            [
                'email' => 'lead.mobile@nocoleave.com',
                'name' => 'Dewi Lestari',
                'nik' => '3001002',
                'jenis_kelamin' => 'perempuan',
                'divisi' => 'Mobile Developer',
            ],
        ];

        foreach ($leads as $leadData) {
            $divisi = Divisi::where('nama_divisi', $leadData['divisi'])->first();

            User::firstOrCreate(
                ['email' => $leadData['email']],
                [
                    'name' => $leadData['name'],
                    'password' => Hash::make('password'),
                    'nik' => $leadData['nik'],
                    'jenis_kelamin' => $leadData['jenis_kelamin'],
                    'is_active' => true,
                    'divisi_id' => $divisi?->id,
                ]
            )->assignRole('lead');
        }
    }
}
