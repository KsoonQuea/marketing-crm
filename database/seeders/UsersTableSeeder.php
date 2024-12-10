<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'           => 'Kevin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'class_id'       => null,
                'remember_token' => null,
            ],
            [
                'name'           => 'Chloe',
                'email'          => 'normal_admin@admin.com',
                'password'       => bcrypt('normal_admin'),
                'class_id'       => null,
                'remember_token' => null,
            ],
            [
                'name'           => 'Bryan',
                'email'          => 'bfe@bfe.com',
                'password'       => bcrypt('bfebfe'),
                'class_id'       => 1,
                'remember_token' => null,
            ],
            [
                'name'           => 'Belinda',
                'email'          => 'manager@manager.com',
                'password'       => bcrypt('manager'),
                'class_id'       => null,
                'remember_token' => null,
            ],
            [
                'name'           => 'Jess',
                'email'          => 'credit@credit.com',
                'password'       => bcrypt('credit'),
                'class_id'       => null,
                'remember_token' => null,
            ],
            [
                'name'           => 'Boyce',
                'email'          => 'account@account.com',
                'password'       => bcrypt('account'),
                'class_id'       => null,
                'remember_token' => null,
            ],
            [
                'name'           => 'Adam',
                'email'          => 'adam@adam.com',
                'password'       => bcrypt('adamadam'),
                'class_id'       => 2,
                'remember_token' => null,
            ],
            [
                'name'           => 'Elsa',
                'email'          => 'elsa@elsa.com',
                'password'       => bcrypt('elsaelsa'),
                'class_id'       => 3,
                'remember_token' => null,
            ],

        ];

        User::insert($users);
    }
}
