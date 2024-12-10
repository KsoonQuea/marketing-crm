<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignDateToCaseListsTable extends Migration
{
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->date("agreement_sign_date")->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            //
        });
    }
}
