<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArrangeToCaseCriteriaTable extends Migration
{
    public function up()
    {
        Schema::table('case_criteria', function (Blueprint $table) {
            $table->integer('arrange')->default('0');
        });
    }

    public function down()
    {
        Schema::table('case_criteria', function (Blueprint $table) {
            //
        });
    }
}
