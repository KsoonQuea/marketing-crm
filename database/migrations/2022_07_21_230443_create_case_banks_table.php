<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseBanksTable extends Migration
{
    public function up()
    {
        Schema::create('case_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('current_stage')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('case_banks');
    }
}
