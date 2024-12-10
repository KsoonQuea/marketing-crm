<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaseDisburseDetailIdToCaseOverridings extends Migration
{
    public function up()
    {
        Schema::table('case_overridings', function (Blueprint $table) {
            $table->unsignedBigInteger('case_disburse_detail_id')->nullable();
            $table->foreign('case_disburse_detail_id', 'case_disburse_detail_fk_663278324')->references('id')->on('case_disburse_details');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'case_disburse_detail_fk_99180124')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('case_overridings', function (Blueprint $table) {
            //
        });
    }
}
