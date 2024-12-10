<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankOfficerIdToCaseDisburses extends Migration
{
    public function up()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_officer_id')->nullable();
            $table->foreign('bank_officer_id', 'bank_officer_fk_7772199324')->references('id')->on('bank_officers');
        });
    }

    public function down()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            //
        });
    }
}
