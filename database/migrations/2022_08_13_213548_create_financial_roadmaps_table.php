<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialRoadmapsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_roadmaps', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('company_name')->nullable();
            $table->integer('business_industry')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();

            $table->double('turnover_percent', 15, 2)->default(0);
            $table->double('cogs_percent', 15, 2)->default(0);
            $table->double('gross_profit_percent', 15, 2)->default(0);
            $table->double('administration_expenses_percent', 15, 2)->default(0);
            $table->double('inventories_percent', 15, 2)->default(0);
            $table->double('trade_receivables_percent', 15, 2)->default(0);
            $table->double('trade_payables_percent', 15, 2)->default(0);
            $table->double('eligibility_percent', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_roadmaps');
    }
}
