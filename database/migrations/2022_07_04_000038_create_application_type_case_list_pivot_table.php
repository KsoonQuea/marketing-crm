<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('application_type_case_list', function (Blueprint $table) {
            $table->unsignedBigInteger('case_list_id');
            $table->foreign('case_list_id', 'case_list_id_fk_6920903')->references('id')->on('case_lists')->onDelete('cascade');
            $table->unsignedBigInteger('application_type_id');
            $table->foreign('application_type_id', 'application_type_id_fk_6920903')->references('id')->on('application_types')->onDelete('cascade');
        });
    }
};
