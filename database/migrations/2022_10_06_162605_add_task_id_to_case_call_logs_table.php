<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaskIdToCaseCallLogsTable extends Migration
{
    public function up()
    {
        Schema::table('case_call_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('master_call_list_id')->nullable();
            $table->foreign('master_call_list_id', 'master_call_list_fk_1598090')->references('id')->on('master_call_lists');
        });
    }

    public function down()
    {
        Schema::table('case_call_logs', function (Blueprint $table) {
            //
        });
    }
}
