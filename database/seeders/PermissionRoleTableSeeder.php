<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $master_permissions = Permission::all()->where('type', '!=', '5')->except([326, 328, 330, 332, 334, 336, 338]);
        Role::findOrFail(1)->syncPermissions($master_permissions->pluck('id'));

        $admin_permissions = Permission::all()->where('type', '!=', '5')->except([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 264, 265, 266, 267, 268, 326, 328, 330, 332, 334, 336, 338]);
        Role::findOrFail(2)->syncPermissions($admin_permissions->pluck('id'));

        $salesman_permissions = Permission::whereIn('id', [
            192, 193, 195, 198, 201, 203, 204, 206, 207, 209, 210, 211, 212, 213, 216, 217, 218, 220, 225, 226,236, 237, 239, 240, 241,242, 243, 244, 245, 246, 247, 291, 293, 296, 298, 301,303, 306, 308, 311,313, 316, 318, 321, 323, 327, 329, 331, 333, 339, 340, 342
            ,200, 205 // credit part permission
        ]);

        Role::findOrFail(3)->syncPermissions($salesman_permissions->pluck('id'));

        $manger_permissions = Permission::whereIn('id', [
            185, 186, 187, 188, 191, 195, 198, 199, 200, 201, 203, 204, 205, 206, 207, 209, 210, 211, 212, 213, 215, 219, 221, 222, 223, 224, 227, 228, 229, 241, 242, 243, 244, 245, 246, 247, 290, 292, 295, 297, 300, 302, 305, 307, 310, 312, 315, 317, 320, 322, 325, 328, 330, 332, 334, 336, 340, 366
        ]);

        Role::findOrFail(4)->syncPermissions($manger_permissions->pluck('id'));

        $credit_permissions = Permission::whereIn('id', [
            185, 186, 187, 188, 191, 195, 198, 199, 200, 201, 203, 204, 205, 206, 207, 209, 210, 211, 212, 213, 215, 219, 221, 222, 223, 224, 227, 228, 229, 241, 242, 243, 244, 245, 246, 247, 290, 292, 295, 297, 300, 302, 305, 307, 310, 312, 315, 317, 320, 322, 325, 328, 330, 332, 334, 336, 340
        ]);

        Role::findOrFail(5)->syncPermissions($credit_permissions->pluck('id'));

        $account_permissions = Permission::whereIn('id', [
            191, 195, 215, 340, 341, 342, 343,348, 349, 350, 351, 352, 353, 354, 355, 356, 357, 358, 359, 360, 361, 362, 363, 364, 365, 371
        ]);

        Role::findOrFail(6)->syncPermissions($account_permissions->pluck('id'));
    }
}
