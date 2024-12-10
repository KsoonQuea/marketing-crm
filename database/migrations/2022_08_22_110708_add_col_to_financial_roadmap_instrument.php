<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToFinancialRoadmapInstrument extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmap_instruments', function (Blueprint $table) {
            $table->integer('group_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('financial_roadmap_instrument', function (Blueprint $table) {
            //
        });
    }
}
