<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToFinancialRoadmapInstruments extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmap_instruments', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_roadmap_id')->nullable();
            $table->foreign('financial_roadmap_id', 'financial_roadmaps_fk_3243572')->references('id')->on('financial_roadmaps');
        });
    }

    public function down()
    {
        Schema::table('financial_roadmap_instruments', function (Blueprint $table) {
            //
        });
    }
}
