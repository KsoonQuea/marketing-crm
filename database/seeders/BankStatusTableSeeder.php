<?php

namespace Database\Seeders;

use App\Models\BankStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bankstatus = [
            [
                'name'  => 'Assessment',
            ],
            [
                'name'  => 'Agreement',
            ],
            [
                'name'  => 'Site Visit',
            ],
            [
                'name'  => 'Case Submission',
            ],
            [
                'name'  => 'Approval',
            ],
            [
                'name'  => 'Acceptance',
            ],
            [
                'name'  => 'Disbursement',
            ],
        ];

        DB::table('bank_status')->insert($bankstatus);
    }
}
