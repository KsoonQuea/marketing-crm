<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToCaseBanksTable extends Migration
{
    public function up()
    {
        Schema::table('case_banks', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_officer_id')->nullable();
            $table->foreign('bank_officer_id', 'bank_officers_fk_2090121')->references('id')->on('bank_officers');
        });
    }

    public function down()
    {
        Schema::table('case_banks', function (Blueprint $table) {
            //
        });
    }
}
