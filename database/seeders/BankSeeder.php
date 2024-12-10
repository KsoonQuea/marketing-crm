<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run()
    {
        $banks = [
            [
                'name'           => 'Public Bank',
            ],
            [
                'name'           => 'CIMB Bank',
            ],
            [
                'name'           => 'Hong Leong Bank',
            ],
            [
                'name'           => 'RHB Bank',
            ],
        ];

        Bank::insert($banks);
    }
}
