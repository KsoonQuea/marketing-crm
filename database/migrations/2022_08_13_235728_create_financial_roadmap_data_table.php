<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialRoadmapDataTable extends Migration
{
    public function up()
    {
        Schema::create('financial_roadmap_data', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('financial_year')->nullable();

            $table->double('turnover', 15, 2)->default(0);
            $table->double('cogs', 15, 2)->default(0);
            $table->double('gross_profit', 15, 2)->default(0);
            $table->double('depreciation_expenses', 15, 2)->default(0);
            $table->double('finance_cost', 15, 2)->default(0);
            $table->double('profit_bfr_tax', 15, 2)->default(0);
            $table->double('tax', 15, 2)->default(0);
            $table->double('profit_aft_tax', 15, 2)->default(0);

            $table->double('inventories', 15, 2)->default(0);
            $table->double('trade_receivables', 15, 2)->default(0);
            $table->double('trade_payables', 15, 2)->default(0);
            $table->double('share_capital', 15, 2)->default(0);
            $table->double('retained_earnings', 15, 2)->default(0);
            $table->double('net_worth', 15, 2)->default(0);
            $table->double('annual_debts', 15, 2)->default(0);

            $table->double('net_cash', 15, 2)->default(0);

            $table->integer('group_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_roadmap_data');
    }
}
