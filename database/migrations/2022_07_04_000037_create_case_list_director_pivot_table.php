<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_list_director', function (Blueprint $table) {
            $table->unsignedBigInteger('case_list_id');
            $table->foreign('case_list_id', 'case_list_id_fk_6895509')->references('id')->on('case_lists')->onDelete('cascade');
            $table->unsignedBigInteger('director_id');
            $table->foreign('director_id', 'director_id_fk_6895509')->references('id')->on('directors')->onDelete('cascade');
        });
    }
};
