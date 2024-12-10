<?php

namespace Database\Seeders;

use App\Models\Managements;
use App\Models\PermissionGroupTitle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionGroupTitleSeeder::class,
            PermissionGroupSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            commissionSettingsSeeder::class,
            commissionSettingDetailsSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            ApplicationTypeTableSeeder::class,
            DirectorTableSeeder::class,
            IndustryTypeTableSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            BankSeeder::class,
            FinancingInstrumentTableSeeder::class,
            CreditCheckTypeSeeder::class,
            RequestTypeSeeder::class,
            BankStatusTableSeeder::class,
            TeamSeeder::class,
            UserTeamSeeder::class,
            ManagementsSeeder::class,
            BankOfficerSeeder::class,
        ]);
    }
}
