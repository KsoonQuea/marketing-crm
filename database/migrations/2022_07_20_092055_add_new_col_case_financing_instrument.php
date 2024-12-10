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
        Schema::table('case_financing_instruments', function (Blueprint $table) {
            $table->decimal('interest_rate', 15, 3)->nullable();
            $table->string('tenor')->nullable();
            $table->decimal('total_proposed_limit', 15, 2)->nullable();
            $table->decimal('total_commitments', 15, 2)->nullable();
            $table->decimal('commitments', 15, 2)->nullable();
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
