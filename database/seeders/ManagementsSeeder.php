<?php

namespace Database\Seeders;

use App\Models\Managements;
use Illuminate\Database\Seeder;

class ManagementsSeeder extends Seeder
{
    public function run()
    {
        $seeders = [
            [
                'commission_rate'   => 3,
                'user_id'           => 2,
            ],
        ];

        Managements::insert($seeders);
    }
}
