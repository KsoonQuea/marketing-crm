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
        Schema::create('case_manager_section', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('agreement_signing_date')->nullable();
            $table->string('agreement_signing_date_remark')->nullable();
            $table->float('service_fee', 2)->nullable();
            $table->string('service_fee_remark')->nullable();
            $table->date('loan_disbursement_date')->nullable();
            $table->string('loan_disbursement_date_remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
