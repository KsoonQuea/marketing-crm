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
        Schema::table('bank_statements', function (Blueprint $table) {
            $table->float('total_avg_credit', 15, 2)->nullable();
            $table->float('total_avg_debit', 15, 2)->nullable();
            $table->float('total_avg_month_end_balance', 15, 2)->nullable();
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
