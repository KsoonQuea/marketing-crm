<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToCaseDisbursesTable extends Migration
{
    public function up()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id', 'banks_fk_4103261')->references('id')->on('banks');
        });
    }

    public function down()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            //
        });
    }
}
