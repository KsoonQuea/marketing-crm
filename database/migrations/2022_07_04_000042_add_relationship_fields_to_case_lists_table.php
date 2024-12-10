<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('salesman_id')->nullable();
            $table->foreign('salesman_id', 'salesman_fk_6889324')->references('id')->on('users');
            $table->unsignedBigInteger('industry_type_id')->nullable();
            $table->foreign('industry_type_id', 'industry_type_fk_6888886')->references('id')->on('industry_types');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_6888908')->references('id')->on('cities');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id', 'state_fk_6888895')->references('id')->on('states');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id', 'country_fk_6888710')->references('id')->on('countries');
        });
    }
};
