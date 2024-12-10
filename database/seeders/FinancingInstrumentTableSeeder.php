<?php

namespace Database\Seeders;

use App\Models\FinancingInstrument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancingInstrumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $financing_instruments = [
            [
                'loan_product'  => 'Term Loan',
                'interest_rate' => '3.825',
                'tenor'         => '7 years',
                'tenor_number'  => '7',
                'tenor_month'   => '84',
                'type'          => '0',
                'able_edit_type'=> '1',
            ],
            [
                'loan_product'  => 'TRRF / DRF',
                'interest_rate' => '1.84',
                'tenor'         => '7 years',
                'tenor_number'  => '7',
                'tenor_month'   => '84',
                'type'          => '0',
                'able_edit_type'=> '1',
            ],
            [
                'loan_product'  => 'AES',
                'interest_rate' => '2.645',
                'tenor'         => '5 years',
                'tenor_number'  => '5',
                'tenor_month'   => '60',
                'type'          => '0',
                'able_edit_type'=> '1',
            ],
            [
                'loan_product'  => 'Overdraft',
                'interest_rate' => '7',
                'tenor'         => 'On demand',
                'tenor_number'  => '0.8',
                'tenor_month'   => '12',
                'type'          => '0',
                'able_edit_type'=> '0',
            ],
            [
                'loan_product'  => 'Trade Line',
                'interest_rate' => '7',
                'tenor'         => 'On demand',
                'tenor_number'  => '0.8',
                'tenor_month'   => '12',
                'type'          => '0',
                'able_edit_type'=> '0',
            ],
            [
                'loan_product'  => 'Credit Card',
                'interest_rate' => '5',
                'tenor'         => 'On demand',
                'tenor_number'  => '0.8',
                'tenor_month'   => '12',
                'type'          => '0',
                'able_edit_type'=> '0',
            ],
            [
                'loan_product'  => 'CapBoost',
                'interest_rate' => '5.0',
                'tenor'         => '',
                'tenor_number'  => '6',
                'tenor_month'   => '6',
                'type'          => '1',
                'able_edit_type'=> '2',
            ],
        ];

        FinancingInstrument::insert($financing_instruments);
    }
}
