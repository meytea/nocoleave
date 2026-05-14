<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisi = Divisi::first();

        $user = User::firstOrCreate(
            ['email' => 'admin@nocoleave.com'],
            [
                'name' => 'Admin HRD',
                'password' => Hash::make('password'),
                'nik' => '2001',
                'jenis_kelamin' => 'laki-laki',
                'is_active' => true,
                'divisi_id' => $divisi?->id,
            ]
        );

        if (! $user->hasRole('hrd')) {
            $user->assignRole('hrd');
        }
    }
}
