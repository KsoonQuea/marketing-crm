<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCallUserTasksTable extends Migration
{
    public function up()
    {
        Schema::create('master_call_user_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_call_user_tasks');
    }
}
