<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date')->nullable();
            $table->string('file_num')->nullable();
            $table->string('company_name')->nullable();
            $table->longText('description')->nullable();
            $table->integer('generate_type')->default(0);
            $table->integer('disbursement_type')->default(0);

            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_8821782694')->references('id')->on('case_lists');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
