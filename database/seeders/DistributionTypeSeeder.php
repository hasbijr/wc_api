<?php

namespace Database\Seeders;

use App\Models\DistributionType;
use Illuminate\Database\Seeder;

class DistributionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
            ['nama' => 'Warteg'],
            ['nama' => 'Mesjid'],
            ['nama' => 'Distribusi Langsung'],
            ['nama' => 'Lain-lain'],
        ];

        DistributionType::insert($type);
    }
}
