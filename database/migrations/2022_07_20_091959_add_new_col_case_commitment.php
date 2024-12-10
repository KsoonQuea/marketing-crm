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
        Schema::table('case_commitments', function (Blueprint $table) {
            $table->decimal('total_hl', 15, 2)->nullable();
            $table->decimal('total_tl', 15, 2)->nullable();
            $table->decimal('total_hp', 15, 2)->nullable();
            $table->decimal('total_cc', 15, 2)->nullable();
            $table->decimal('total_trade_line', 15, 2)->nullable();
            $table->decimal('cc_charge', 15, 2)->nullable();
            $table->decimal('tl_charge', 15, 2)->nullable();
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
