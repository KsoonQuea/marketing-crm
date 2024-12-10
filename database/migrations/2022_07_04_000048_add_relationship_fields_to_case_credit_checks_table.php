<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('case_credit_checks', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_6895467')->references('id')->on('case_lists');
            $table->unsignedBigInteger('credit_check_id')->nullable();
            $table->foreign('credit_check_id', 'credit_check_fk_6895468')->references('id')->on('case_credit_check_types');
        });
    }
};
