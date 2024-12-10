<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_gearings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('borrow_item')->nullable();
            $table->decimal('borrow_price', 15, 2)->nullable();
            $table->decimal('financing_amount', 15, 2)->nullable();
            $table->decimal('bank_redemtion', 15, 2)->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
