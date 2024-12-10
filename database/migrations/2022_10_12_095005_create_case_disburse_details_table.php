<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseDisburseDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('case_disburse_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('bfe_name')->nullable();
            $table->double('bfe_commission_rate', 8 ,2)->default(0);
            $table->double('bfe_commission', 8 ,2)->nullable();
            $table->date('bfe_commission_pay_day')->nullable();

            $table->string('banker_name')->nullable();
            $table->double('banker_commission_rate', 8 ,2)->default(0);
            $table->double('banker_commission', 8 ,2)->nullable();
            $table->date('banker_commission_pay_day')->nullable();

            $table->integer('account_stage')->default(0);
            $table->integer('payments_status')->default(0);

            $table->unsignedBigInteger('case_disburse_id')->nullable();
            $table->foreign('case_disburse_id', 'case_fk_771282694')->references('id')->on('case_disburses');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('case_disburse_details');
    }
}
