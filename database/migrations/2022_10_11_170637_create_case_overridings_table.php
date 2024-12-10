<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseOverridingsTable extends Migration
{
    public function up()
    {
        Schema::create('case_overridings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();
            $table->double('commission_rate', 8, 2)->default(0);
            $table->double('commission', 8, 2)->nullable();
            $table->date('commission_pay_day')->nullable();
            $table->integer('type')->default(0);

            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_4677328994')->references('id')->on('case_lists');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('case_overridings');
    }
}
