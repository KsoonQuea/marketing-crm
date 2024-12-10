<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToCaseFinancials extends Migration
{
    public function up()
    {
        Schema::table('case_financials', function (Blueprint $table) {
            $table->float('equity', 15, 2)->default('0');
            $table->string('auditor')->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_financials', function (Blueprint $table) {
            //
        });
    }
}
