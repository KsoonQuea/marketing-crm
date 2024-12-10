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
        Schema::table('case_financials', function (Blueprint $table) {
            $table->decimal('other_asset', 15, 2)->nullable();
            $table->decimal('other_liabilities', 15, 2)->nullable();
            $table->decimal('current_maturity', 15, 2)->nullable();
            $table->decimal('retained_earnings', 15, 2)->nullable();
            $table->decimal('tnw', 15, 2)->nullable();
            $table->decimal('gross_profit', 15, 2)->nullable();
            $table->decimal('profit_bfr_tax', 15, 2)->nullable();
            $table->decimal('profit_aft_tax', 15, 2)->nullable();
            $table->decimal('ebitda', 15, 2)->nullable();
            $table->integer('group_id')->nullable();

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
