<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCol2ToFinancialRoadmaps extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            $table->integer('edit_status')->default(0);
        });
    }

    public function down()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            //
        });
    }
}
