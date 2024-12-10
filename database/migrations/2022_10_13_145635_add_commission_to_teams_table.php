<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionToTeamsTable extends Migration
{
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->decimal('commission_percent',15,2)->default('0');
        });
    }

    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            //
        });
    }
}
