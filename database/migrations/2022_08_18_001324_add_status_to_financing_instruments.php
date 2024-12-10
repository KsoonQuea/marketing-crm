<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToFinancingInstruments extends Migration
{
    public function up()
    {
        Schema::table('financing_instruments', function (Blueprint $table) {
            $table->integer('financial_roadmap_status')->default(0);
        });
    }

    public function down()
    {
        Schema::table('financing_instruments', function (Blueprint $table) {
            //
        });
    }
}
