<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\Head;
use App\Models\User;
use Illuminate\Database\Seeder;

class HeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heads = [

            [
                'email' => 'budi@nocoleave.com',
                'nama_departemen' => 'Project and Engineering',
                'divisi' => [
                    'Web Developer Frontend',
                    'Web Developer Backend',
                    'Mobile Developer',
                    'Project Management Officer',
                    'IoT Development',
                ],
            ],

            [
                'email' => 'siti@nocoleave.com',
                'nama_departemen' => 'Operational',
                'divisi' => [
                    'Support Operasional',
                    'HSE',
                ],
            ],

            // Contoh jika nanti ada Head Business Development
            /*
            [
                'email' => 'andi@nocoleave.com',
                'nama_departemen' => 'Business Development',
                'divisi' => [
                    'Regional Business Development',
                    'Digital Marketing',
                ],
            ],
            */

        ];

        foreach ($heads as $head) {

            $user = User::where('email', $head['email'])->first();

            if (!$user) {
                continue;
            }

            foreach ($head['divisi'] as $namaDivisi) {

                $divisi = Divisi::where(
                    'nama_divisi',
                    $namaDivisi
                )->first();

                if (!$divisi) {
                    continue;
                }

                Head::firstOrCreate(

                    [
                        'user_id'   => $user->id,
                        'divisi_id' => $divisi->id,
                    ],

                    [
                        'nama_departemen' => $head['nama_departemen'],
                    ]

                );
            }
        }
    }
}