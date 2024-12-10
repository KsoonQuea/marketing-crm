<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_director_commitments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('director_name')->nullable();
            $table->decimal('house_loan', 15, 2)->nullable();
            $table->decimal('personal_loan', 15, 2)->nullable();
            $table->decimal('hire_purchase', 15, 2)->nullable();
            $table->decimal('credit_card_limit', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
