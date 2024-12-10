<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponseStatusToMasterCallUserTasksTable extends Migration
{
    public function up()
    {
        Schema::table('master_call_user_tasks', function (Blueprint $table) {
            $table->integer('response_status')->default('0');
        });
    }

    public function down()
    {
        Schema::table('master_call_user_tasks', function (Blueprint $table) {
            //
        });
    }
}
