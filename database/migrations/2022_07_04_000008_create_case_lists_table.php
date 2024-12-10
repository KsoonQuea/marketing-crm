<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('case_code')->nullable();
            $table->string('company_name')->nullable();
            $table->date('incorporation_date')->nullable();
            $table->string('bfe')->nullable();
            $table->string('business_activity')->nullable();
            $table->date('applicaion_date')->nullable();
            $table->longText('business_bg')->nullable();
            $table->string('remark')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('postcode')->nullable();
            $table->integer('salesmen_status')->nullable()->comment('0:returned, 1: submitted');
            $table->integer('case_status')->nullable()->comment('0:pending, 1: completed, 2: rejected');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
