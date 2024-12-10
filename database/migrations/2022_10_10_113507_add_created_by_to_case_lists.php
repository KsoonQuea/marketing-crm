<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToCaseLists extends Migration
{
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by', 'created_by_fk_618723324')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            //
        });
    }
}
