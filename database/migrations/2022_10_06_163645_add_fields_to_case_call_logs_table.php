<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCaseCallLogsTable extends Migration
{
    public function up()
    {
        Schema::table('case_call_logs', function (Blueprint $table) {
            $table->integer('response_status')->default('0');
        });
    }

    public function down()
    {
        Schema::table('case_call_logs', function (Blueprint $table) {
            //
        });
    }
}
