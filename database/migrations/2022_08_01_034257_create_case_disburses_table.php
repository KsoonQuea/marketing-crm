<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseDisbursesTable extends Migration
{
    public function up()
    {
        Schema::create('case_disburses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('agreement_sign_date')->nullable();
            $table->decimal('service_fee_percent',15,2)->default('0');
            $table->date('loan_disbursement_date')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('case_disburses');
    }
}
