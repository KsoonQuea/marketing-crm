<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('case_criteria', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_6897513')->references('id')->on('case_lists');
            $table->unsignedBigInteger('criteria_id')->nullable();
            $table->foreign('criteria_id', 'criteria_fk_6897514')->references('id')->on('criteria');
        });
    }
};
