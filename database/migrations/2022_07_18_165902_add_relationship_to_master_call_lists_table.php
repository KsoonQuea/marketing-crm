<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToMasterCallListsTable extends Migration
{
    public function up()
    {
        Schema::table('master_call_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('master_call_batch_id')->nullable();
            $table->foreign('master_call_batch_id', 'master_call_batches_fk_10097201')->references('id')->on('master_call_batches');
        });
    }

    public function down()
    {
        Schema::table('master_call_lists', function (Blueprint $table) {
            //
        });
    }
}
