<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_director_commitments', function (Blueprint $table) {
            $table->unsignedBigInteger('director_id')->nullable();
            $table->foreign('director_id', 'director_fk_2198108372')->references('id')->on('directors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_director_commitment', function (Blueprint $table) {
            //
        });
    }
};
