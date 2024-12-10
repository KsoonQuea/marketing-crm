<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('edited_approved_amount_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('case_disburse_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('previous_amount')->nullable();
            $table->integer('current_amount')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('edited_approved_amount_logs');
    }
};
