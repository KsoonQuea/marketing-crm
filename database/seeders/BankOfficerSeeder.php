<?php

namespace Database\Seeders;

use App\Models\BankOfficer;
use Illuminate\Database\Seeder;

class BankOfficerSeeder extends Seeder
{
    public function run()
    {
        $seeder = [
            [
                'name'          => 'Makau',
                'bank_id'       => '1',
                'commission'    => '2',
            ],[
                'name'          => 'Misa',
                'bank_id'       => '1',
                'commission'    => '2.5',
            ],[
                'name'          => 'Monash',
                'bank_id'       => '1',
                'commission'    => '3',
            ],[
                'name'          => 'Bill',
                'bank_id'       => '2',
                'commission'    => '4',
            ],[
                'name'          => 'Ben',
                'bank_id'       => '2',
                'commission'    => '2.5',
            ],[
                'name'          => 'Kura',
                'bank_id'       => '3',
                'commission'    => '2',
            ],[
                'name'          => 'Kiya',
                'bank_id'       => '3',
                'commission'    => '3',
            ],[
                'name'          => 'John',
                'bank_id'       => '4',
                'commission'    => '2',
            ],[
                'name'          => 'Jim',
                'bank_id'       => '4',
                'commission'    => '3.5',
            ],
        ];

        BankOfficer::insert($seeder);
    }
}
