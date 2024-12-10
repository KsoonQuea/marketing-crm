<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPermissionGroups extends Migration
{
    public function up()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
    }

    public function down()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            //
        });
    }
}
