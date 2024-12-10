<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('case_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_6889767')->references('id')->on('case_lists');
            $table->unsignedBigInteger('request_type_id')->nullable();
            $table->foreign('request_type_id', 'request_type_fk_6889781')->references('id')->on('request_types');
        });
    }
};
