<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_financing_instruments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('proposed_limit', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
