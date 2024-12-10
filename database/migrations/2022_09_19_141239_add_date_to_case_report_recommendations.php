<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToCaseReportRecommendations extends Migration
{
    public function up()
    {
        Schema::table('case_report_recommendations', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_report_recommendations', function (Blueprint $table) {
            //
        });
    }
}
