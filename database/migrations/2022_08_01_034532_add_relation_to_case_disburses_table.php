<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationToCaseDisbursesTable extends Migration
{
    public function up()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'users_fk_1090181')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            //
        });
    }
}
