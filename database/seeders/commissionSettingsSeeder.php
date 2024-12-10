<?php

namespace Database\Seeders;

use App\Models\commissionSettings;
use Illuminate\Database\Seeder;

class commissionSettingsSeeder extends Seeder
{
    public function run()
    {
        $commissionSetting = [
            [
                'class'             => 'A',
                'monthly_target'    => '60000',
                'quarterly_target'  => '180000',
            ],
            [
                'class'             => 'B',
                'monthly_target'    => '40000',
                'quarterly_target'  => '120000',
            ],
            [
                'class'             => 'C',
                'monthly_target'    => '28000',
                'quarterly_target'  => '840000',
            ],
        ];

        commissionSettings::insert($commissionSetting);
    }
}
