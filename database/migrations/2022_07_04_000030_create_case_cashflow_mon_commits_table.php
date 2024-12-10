<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_cashflow_mon_commits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('avg_mon_end_bank_balances', 15, 2)->nullable();
            $table->decimal('avg_mon_credit_transactions', 15, 2)->nullable();
            $table->decimal('mon_commitment', 15, 2)->nullable();
            $table->decimal('tot_mon_commitment_for_directors', 15, 2)->nullable();
            $table->decimal('tot_mon_commitment_of_directors_and_company', 15, 2)->nullable();
            $table->decimal('annualized_revenue', 15, 2)->nullable();
            $table->float('income_factor', 15, 2)->nullable();
            $table->float('dsr', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
