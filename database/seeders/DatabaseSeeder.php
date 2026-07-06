<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan role sudah tersedia sebelum assign role ke admin HRD.
        $this->call([
            RoleSeeder::class,
            DivisiSeeder::class,
            UserSeeder::class,
            // AdminSeeder::class,
            // DirekturSeeder::class,
           
            JenisCutiSeeder::class,
            HeadSeeder::class,
            // LeadSeeder::class,
            // KaryawanSeeder::class,
            HakCutiSeeder::class,
            
        ]);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
