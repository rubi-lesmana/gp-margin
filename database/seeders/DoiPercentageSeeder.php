<?php

namespace Database\Seeders;

use App\Models\DoiPercentage;
use Illuminate\Database\Seeder;

class DoiPercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'min_days'   => 0,
                'max_days'   => 60,
                'percentage' => 0.00,
                'label'      => '0 - 60 Hari',
            ],
            [
                'min_days'   => 61,
                'max_days'   => 120,
                'percentage' => 2.00,
                'label'      => '61 - 120 Hari',
            ],
            [
                'min_days'   => 121,
                'max_days'   => null,   // NULL = lebih dari 120 hari
                'percentage' => 3.00,
                'label'      => '> 120 Hari',
            ],
        ];

        foreach ($data as $item) {
            DoiPercentage::create($item);
        }
    }
}