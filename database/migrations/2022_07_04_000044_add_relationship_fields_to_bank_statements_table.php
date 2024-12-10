<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('bank_statements', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id', 'bank_fk_6889722')->references('id')->on('banks');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_6889723')->references('id')->on('case_lists');
        });
    }
};
