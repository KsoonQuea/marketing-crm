<?php

namespace Database\Seeders;

use App\Models\ApplicationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'BANK LOAN',
            ],
            [
                'name' => 'FACTORING',
            ],
            [
                'name' => 'CAPBOOST',
            ],
            [
                'name' => 'FUNDAZTIC',
            ],
        ];

        ApplicationType::insert($permissions);
    }
}
