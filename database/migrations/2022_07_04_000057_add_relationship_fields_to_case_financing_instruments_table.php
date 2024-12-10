<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('case_financing_instruments', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_6905316')->references('id')->on('case_lists');
            $table->unsignedBigInteger('financing_instrument_id')->nullable();
            $table->foreign('financing_instrument_id', 'financing_instrument_fk_6905317')->references('id')->on('financing_instruments');
        });
    }
};
