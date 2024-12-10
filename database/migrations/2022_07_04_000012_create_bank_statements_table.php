<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bank_statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_owner')->nullable();
            $table->string('bank_account')->nullable();
            $table->float('credit', 15, 2)->nullable();
            $table->float('debit', 15, 2)->nullable();
            $table->float('month_end_balance', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
