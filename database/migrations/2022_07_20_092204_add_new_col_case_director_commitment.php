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
            $table->string('director_ic')->nullable();
            $table->decimal('total_hl', 15, 2)->nullable();
            $table->decimal('total_pl', 15, 2)->nullable();
            $table->decimal('total_hp', 15, 2)->nullable();
            $table->decimal('total_cc', 15, 2)->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('final_total', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
