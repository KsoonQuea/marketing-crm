<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToFinancialRoadmapData extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            $table->double('general_expenses')->default(0);

            $table->double('working_capital_eligibility')->default(0);
            $table->double('existing_loan')->default(0);
            $table->double('financing_term_loan')->default(0);
            $table->double('financing_overdraft')->default(0);
            $table->double('financing_trade_line')->default(0);
            $table->double('financing_property_loan')->default(0);
            $table->double('total_loan_amount')->default(0);
            $table->double('repayment_term_property_loan')->default(0);
            $table->double('repayment_od_trade')->default(0);
            $table->double('repayment_term_loan')->default(0);
            $table->double('repayment_overdraft')->default(0);
            $table->double('repayment_trade_line')->default(0);
            $table->double('repayment_property_loan')->default(0);
            $table->double('annual_repayment')->default(0);
            $table->double('ebitda')->default(0);
            $table->double('total_outstanding_loan_amount')->default(0);
            $table->double('dscr')->default(0);
            $table->double('gearing_ratio')->default(0);
        });
    }

    public function down()
    {
        Schema::table('financial_roadmap_data', function (Blueprint $table) {
            //
        });
    }
}
