<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCol4ToFinancialRoadmapData extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            $table->double('turnover_percent')->default(0);
            $table->double('cogs_percent')->default(0);
            $table->double('gross_profit_percent')->default(0);
            $table->double('general_expenses_percent')->default(0);
            $table->double('profit_bfr_tax_percent')->default(0);
            $table->double('tax_percent')->default(0);
            $table->double('profit_aft_tax_percent')->default(0);
            $table->double('inventories_percent')->default(0);
            $table->double('trade_receivables_percent')->default(0);
            $table->double('trade_payables_percent')->default(0);

        });
    }

    public function down()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            //
        });
    }
}
