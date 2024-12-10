<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinPart2ToCaseLists extends Migration
{
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->date('gearing_date')->nullable()->change();
            $table->double('dsr_bankStt_commitment')->nullable();
            $table->double('cash_flow_factor')->nullable();
            $table->double('gearing_borrow')->nullable();
            $table->double('gearing_redemtion')->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            //
        });
    }
}
