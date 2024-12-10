<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCol3ToFinancialRoadmapData extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            $table->integer('edit_status')->default(0);
        });
    }

    public function down()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            //
        });
    }
}