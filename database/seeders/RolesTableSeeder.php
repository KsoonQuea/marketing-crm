<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Master Account',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'BFE',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Sales Manager',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Credit',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Account',
                'guard_name' => 'admin'
            ],
        ];

        Role::insert($roles);
    }
}
