<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToCaseBanksTable extends Migration
{
    public function up()
    {
        Schema::table('case_banks', function (Blueprint $table) {
            $table->unsignedBigInteger('current_bank_id')->nullable();
            $table->foreign('current_bank_id', 'banks_fk_1288401')->references('id')->on('banks');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_lists_fk_1288402')->references('id')->on('case_lists');
        });
    }

    public function down()
    {
        Schema::table('case_banks', function (Blueprint $table) {
            //
        });
    }
}
