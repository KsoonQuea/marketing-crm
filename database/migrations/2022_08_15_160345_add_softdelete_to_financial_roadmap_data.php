<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeleteToFinancialRoadmapData extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            $table->softDeletes()->nullable();
        });
    }

    public function down()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            //
        });
    }
}
