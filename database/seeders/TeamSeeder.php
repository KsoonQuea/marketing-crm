<?php

namespace Database\Seeders;

use App\Models\Team;
use FontLib\Table\Type\name;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $seeders = [
            [
                'name'                  => "Belinda's Team",
                'commission_rate'       => 3,
                'commission_percent'    => 3,
                'team_lead_id'          => 4,
            ],
        ];

        Team::insert($seeders);
    }
}
