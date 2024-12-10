<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToMasterCallUserTasksTable extends Migration
{
    public function up()
    {
        Schema::table('master_call_user_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('master_call_batch_id')->nullable();
            $table->foreign('master_call_batch_id', 'master_call_batches_fk_10097211')->references('id')->on('master_call_batches');
            $table->unsignedBigInteger('master_call_list_id')->nullable();
            $table->foreign('master_call_list_id', 'master_call_lists_fk_10097212')->references('id')->on('master_call_lists');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'users_fk_10097213')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('master_call_user_tasks', function (Blueprint $table) {
            //
        });
    }
}
