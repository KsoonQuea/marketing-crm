<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_report_recommendations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('recommendation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
