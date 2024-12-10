<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToFinancialRoadmaps extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            $table->double('default_turnover_percent')->nullable();
            $table->double('default_cogs_percent')->nullable();
            $table->double('default_gross_profit_percent')->nullable();
            $table->double('default_finance_cost_percent')->nullable();
            $table->double('default_inventories_percent')->nullable();
            $table->double('default_trade_receivables_percent')->nullable();
            $table->double('default_trade_payables_percent')->nullable();
            $table->double('default_eligibility_percent')->nullable();
        });
    }

    public function down()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            //
        });
    }
}
