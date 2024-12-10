<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRevenueToMasterCallListsTable extends Migration
{
    public function up()
    {
        Schema::table('master_call_lists', function (Blueprint $table) {
            $table->string('revenue')->nullable();
        });
    }

    public function down()
    {
        Schema::table('master_call_lists', function (Blueprint $table) {
            //
        });
    }
}
