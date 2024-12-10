<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_dsrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('ebitda', 15, 2)->nullable();
            $table->decimal('ccris_commitment', 15, 2)->nullable();
            $table->decimal('bank_statement_commitment', 15, 2)->nullable();
            $table->decimal('new_financing_commitment', 15, 2)->nullable();
            $table->float('dsr', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
