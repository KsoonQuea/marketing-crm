<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColToCaseManagementTeams extends Migration
{
    public function up()
    {
        Schema::table('case_management_teams', function (Blueprint $table) {
            $table->string('experience_year')->nullable()->change();
            $table->string('case_year')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('case_management_teams', function (Blueprint $table) {
            //
        });
    }
}
