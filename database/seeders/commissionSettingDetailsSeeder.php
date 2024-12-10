<?php

namespace Database\Seeders;

use App\Models\commissionSettingDetails;
use Illuminate\Database\Seeder;

class commissionSettingDetailsSeeder extends Seeder
{
    public function run()
    {
        $commissionSettingDetails = [
            [
                'range'                     => '60k & Above',
                'range_fee'                 => '60000',
                'rate'                      => '22.5',
                'commission_settings_id'    => '1',
            ], [
                'range'                     => '40k & Above',
                'range_fee'                 => '40000',
                'rate'                      => '18',
                'commission_settings_id'    => '1',
            ],[
                'range'                     => '15k & Above',
                'range_fee'                 => '15000',
                'rate'                      => '13.5',
                'commission_settings_id'    => '1',
            ],

            [
                'range'                     => '40k & Above',
                'range_fee'                 => '40000',
                'rate'                      => '18',
                'commission_settings_id'    => '2',
            ], [
                'range'                     => '15k & Above',
                'range_fee'                 => '15000',
                'rate'                      => '13.5',
                'commission_settings_id'    => '2',
            ],[
                'range'                     => '10k & Above',
                'range_fee'                 => '10000',
                'rate'                      => '10',
                'commission_settings_id'    => '2',
            ],

            [
                'range'                     => '28k & Above',
                'range_fee'                 => '28000',
                'rate'                      => '15',
                'commission_settings_id'    => '3',
            ], [
                'range'                     => '10k & Above',
                'range_fee'                 => '10000',
                'rate'                      => '12',
                'commission_settings_id'    => '3',
            ],[
                'range'                     => '6k & Above',
                'range_fee'                 => '6000',
                'rate'                      => '8',
                'commission_settings_id'    => '3',
            ],
        ];

        commissionSettingDetails::insert($commissionSettingDetails);
    }
}
