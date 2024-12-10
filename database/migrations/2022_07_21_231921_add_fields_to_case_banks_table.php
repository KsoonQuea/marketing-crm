<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCaseBanksTable extends Migration
{
    public function up()
    {
        Schema::table('case_banks', function (Blueprint $table) {
            $table->integer('current_status')->default('0');
        });
    }

    public function down()
    {
        Schema::table('case_banks', function (Blueprint $table) {
            //
        });
    }
}
