<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToFinancialRoadmaps extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            $table->unsignedBigInteger('business_industry')->nullable()->change();
            $table->foreign('business_industry', 'industry_types_fk_27632712')->references('id')->on('industry_types');
        });
    }

    public function down()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            //
        });
    }
}
