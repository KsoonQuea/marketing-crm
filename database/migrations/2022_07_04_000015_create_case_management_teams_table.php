<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_management_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->float('shareholding', 15, 2)->nullable();
            $table->string('responsible_area')->nullable();
            $table->integer('experience_year')->nullable();
            $table->integer('case_year')->nullable();
            $table->string('director_relationship')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
