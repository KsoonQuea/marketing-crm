<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\PermissionGroupTitle;
use Illuminate\Database\Seeder;

class PermissionGroupTitleSeeder extends Seeder
{
    public function run()
    {
        $permissionGroupTitles = [
            [
                'name' => 'Dashboard Management',           // 1
            ],
            [
                'name' => 'Case Management',                // 2
            ],
            [
                'name' => 'Call List Management',           // 3
            ],
            [
                'name' => 'Account Management',             // 8
            ],
            [
                'name' => 'Report Management',             // 9
            ],
            [
                'name' => 'Financial Roadmaps Management',  // 4
            ],
            [
                'name' => 'Users Management',               // 5
            ],
            [
                'name' => 'Directors Management',           // 6
            ],
            [
                'name' => 'Settings',                       // 7
            ]
        ];

        PermissionGroupTitle::insert($permissionGroupTitles);
    }
}
