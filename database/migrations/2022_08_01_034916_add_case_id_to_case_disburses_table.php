<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaseIdToCaseDisbursesTable extends Migration
{
    public function up()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            $table->unsignedBigInteger('case_list_id')->nullable();
            $table->foreign('case_list_id', 'case_lists_fk_1090182')->references('id')->on('case_lists');
        });
    }

    public function down()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            //
        });
    }
}
