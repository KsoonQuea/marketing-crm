<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformasTable extends Migration
{
    public function up()
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date')->nullable();
            $table->string('file_num')->nullable();
            $table->string('description')->nullable();

            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_234782994')->references('id')->on('case_lists');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proformas');
    }
}
