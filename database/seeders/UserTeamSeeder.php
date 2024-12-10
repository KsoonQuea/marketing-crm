<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserTeam;
use Illuminate\Database\Seeder;

class UserTeamSeeder extends Seeder
{
    public function run()
    {
        $query = User::with(['roles'])->whereHas('roles', function ($query){
            $query->where('id', 3);
        })->get();

        $seeders = array();

        foreach ($query as $query_item){
            $arr = [
                'user_team_id'  => 1,
                'user_id'       => $query_item->id,
            ];

            array_push($seeders, $arr);
        }

        UserTeam::insert($seeders);
    }
}
