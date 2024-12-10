<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('financing_instruments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('loan_product')->nullable();
            $table->float('interest_rate', 15, 3)->nullable();
            $table->string('tenor')->nullable();
            $table->float('tenor_number')->nullable();
            $table->integer('tenor_month')->nullable();
            $table->integer('type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
