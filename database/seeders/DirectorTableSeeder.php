<?php

namespace Database\Seeders;

use App\Models\Director;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directors = [
            [
                'created_at' => '2022-07-01 12:00:00',
                'name'  => 'Regend Sia',
                'ic'    => '901211019874',
                'phone'    => '60168876651',
            ],
            [
                'created_at' => '2022-07-01 12:00:00',
                'name' => 'Yong Wei Sia',
                'ic'   => '950202019975',
                'phone' => '60121123418',
            ],
            [
                'created_at' => '2022-07-01 12:00:00',
                'name' => 'Mike Sia',
                'ic'   => '890231012021',
                'phone' => '60124409921',
            ],
            [
                'created_at' => '2022-07-01 12:00:00',
                'name' => 'Chia',
                'ic'   => '870324013902',
                'phone' => '60148895571',
            ],
        ];

        Director::insert($directors);
    }
}
