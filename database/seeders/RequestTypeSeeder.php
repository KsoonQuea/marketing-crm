<?php

namespace Database\Seeders;

use App\Models\RequestType as ModelsRequestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $request =[
            [
                'name'           => 'Bank',
            ],
            [
                'name'           => 'CapBoost',
            ],
            [
                'name'           => 'Inv F.',
            ],
            [
                'name'           => 'Others',
            ],
        ];

        ModelsRequestType::insert($request);
    }
}
