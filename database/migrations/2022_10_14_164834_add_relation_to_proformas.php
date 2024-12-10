<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationToProformas extends Migration
{
    public function up()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->unsignedBigInteger('case_disburse_detail_id')->nullable();
            $table->foreign('case_disburse_detail_id', 'case_disburse_detail_fk_772819324')->references('id')->on('case_disburse_details');
        });
    }

    public function down()
    {
        Schema::table('proformas', function (Blueprint $table) {
            //
        });
    }
}
