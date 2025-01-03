<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IndustryType;

class IndustryTypeTableSeeder extends Seeder
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
                'name' => 'WHOLESALE / RETAIL',
            ],
            [
                'name' => 'MANUFACTURING',
            ],
            [
                'name' => 'SERVICES SECTOR',
            ],
            [
                'name' => 'CONSTRUCTION',
            ],
        ];
        

        IndustryType::insert($permissions);
    }
}
