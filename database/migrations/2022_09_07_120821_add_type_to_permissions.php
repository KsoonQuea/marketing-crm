<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToPermissions extends Migration
{
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->integer('type')->default(0);
        });
    }

    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
}
