<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCol4ToFinancialRoadmaps extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            $table->decimal('default_general_expenses_percent')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            //
        });
    }
}
