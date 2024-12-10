<?php

namespace Database\Seeders;

use App\Models\CaseCreditCheckType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditCheckTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credit = [
            [
                'name'           => 'CCRIS',
            ],
            [
                'name'           => 'CTOS',
            ],
        ];

        CaseCreditCheckType::insert($credit);
    }
}
