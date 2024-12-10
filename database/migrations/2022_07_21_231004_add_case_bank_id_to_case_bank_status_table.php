<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaseBankIdToCaseBankStatusTable extends Migration
{
    public function up()
    {
        Schema::table('case_bank_status', function (Blueprint $table) {
            $table->unsignedBigInteger('case_bank_id')->nullable();
            $table->foreign('case_bank_id', 'case_banks_fk_1288403')->references('id')->on('case_banks');
        });
    }

    public function down()
    {
        Schema::table('case_bank_status', function (Blueprint $table) {
            //
        });
    }
}
