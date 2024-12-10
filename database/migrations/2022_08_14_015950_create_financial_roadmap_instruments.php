<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialRoadmapInstruments extends Migration
{
    public function up()
    {
        Schema::create('financial_roadmap_instruments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('proposed_limit', 15, 2)->nullable();
            $table->decimal('interest_rate', 15, 3)->nullable();
            $table->decimal('tenor', 15, 2)->nullable();
            $table->decimal('commitments', 15, 2)->nullable();
            $table->decimal('new_commitments', 15, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_roadmap_instruments');
    }
}
