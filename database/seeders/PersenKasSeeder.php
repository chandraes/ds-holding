<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PersenKas;

class PersenKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'kas-besar',
                'persen' => 50,
            ],
            [
                'nama' => 'kas-gaji-komisaris',
                'persen' => 50,
            ],
        ];

        foreach ($data as $key => $value) {
            PersenKas::create($value);
        }
    }
}
