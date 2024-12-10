<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToCaseDirectorCommitments extends Migration
{
    public function up()
    {
        Schema::table('case_director_commitments', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->integer('primary_type')->default(0);
        });
    }

    public function down()
    {
        Schema::table('case_director_commitments', function (Blueprint $table) {
            //
        });
    }
}
