<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToCaseLists extends Migration
{
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->integer('draft_status')->default('0');
        });
    }

    public function down()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            //
        });
    }
}