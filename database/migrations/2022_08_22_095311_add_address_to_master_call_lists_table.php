<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToMasterCallListsTable extends Migration
{
    public function up()
    {
        Schema::table('master_call_lists', function (Blueprint $table) {
            $table->text('company_address')->nullable();
        });
    }

    public function down()
    {
        Schema::table('master_call_lists', function (Blueprint $table) {
            //
        });
    }
}
