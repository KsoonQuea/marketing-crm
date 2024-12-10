<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToFinancialRoadmaps extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
    }

    public function down()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            //
        });
    }
}
