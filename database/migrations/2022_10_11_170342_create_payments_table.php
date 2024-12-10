<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('or')->nullable();
            $table->string('sst_paid_date')->nullable();

            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_66712294')->references('id')->on('case_lists');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
