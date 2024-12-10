<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelatationToBankOfficersTable extends Migration
{
    public function up()
    {
        Schema::table('bank_officers', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id', 'banks_fk_1090091')->references('id')->on('banks');
        });
    }

    public function down()
    {
        Schema::table('bank_officers', function (Blueprint $table) {
            //
        });
    }
}
