<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToCaseCallLogsTable extends Migration
{
    public function up()
    {
        Schema::table('case_call_logs', function (Blueprint $table) {
            $table->string('phone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_call_logs', function (Blueprint $table) {
            //
        });
    }
}
