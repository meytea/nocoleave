<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'karyawan']);
        Role::create(['name' => 'lead']);
        Role::create(['name' => 'head']);
        Role::create(['name' => 'hrd']);
        Role::create(['name' => 'direktur']);
    }
}
