<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DirekturSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'email' => 'direktur@nocoleave.com'
            ],
            [
                'name' => 'Direktur',
                'password' => Hash::make('password'),
                'nik' => '1001',
                'jenis_kelamin' => 'laki-laki',
                'is_active' => true,
                'divisi_id' => null,
            ]
        );

        if (! $user->hasRole('direktur')) {
            $user->assignRole('direktur');
        }
    }
}