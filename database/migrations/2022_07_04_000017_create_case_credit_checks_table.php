<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_credit_checks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('director_n_company')->nullable();
            $table->string('finding')->nullable();
            $table->string('migration')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
