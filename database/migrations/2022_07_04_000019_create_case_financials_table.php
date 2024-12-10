<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_financials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('current_asset', 15, 2)->nullable();
            $table->decimal('non_current_asset', 15, 2)->nullable();
            $table->decimal('director_asset', 15, 2)->nullable();
            $table->decimal('related_customer_asset', 15, 2)->nullable();
            $table->decimal('customer_asset', 15, 2)->nullable();
            $table->decimal('current_liabilities', 15, 2)->nullable();
            $table->decimal('non_current_liabilities', 15, 2)->nullable();
            $table->decimal('director_liabilities', 15, 2)->nullable();
            $table->decimal('related_customer_liabilities', 15, 2)->nullable();
            $table->decimal('customer_liabilities', 15, 2)->nullable();
            $table->decimal('loan_n_hp', 15, 2)->nullable();
            $table->decimal('share_capital', 15, 2)->nullable();
            $table->decimal('revenue', 15, 2)->nullable();
            $table->decimal('sales_cost', 15, 2)->nullable();
            $table->decimal('finance_cost', 15, 2)->nullable();
            $table->decimal('depreciation', 15, 2)->nullable();
            $table->decimal('profit', 15, 2)->nullable();
            $table->decimal('tax', 15, 2)->nullable();
            $table->date('financial_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
