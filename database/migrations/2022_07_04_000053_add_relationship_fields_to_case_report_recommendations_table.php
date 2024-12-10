<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('case_report_recommendations', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_6897744')->references('id')->on('case_lists');
        });
    }
};
