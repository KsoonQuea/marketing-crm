<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('case_cashflow_mon_commits', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_6905057')->references('id')->on('case_lists');
        });
    }
};
