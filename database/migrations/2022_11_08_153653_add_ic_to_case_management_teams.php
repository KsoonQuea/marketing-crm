<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIcToCaseManagementTeams extends Migration
{
    public function up()
    {
        Schema::table('case_management_teams', function (Blueprint $table) {
            $table->string('ic')->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_management_teams', function (Blueprint $table) {
            //
        });
    }
}
