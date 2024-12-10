<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToPermissionGroups extends Migration
{
    public function up()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('title_id')->nullable();
            $table->foreign('title_id', 'titles_fk_6362412')->references('id')->on('permission_group_titles');
        });
    }

    public function down()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            //
        });
    }
}
