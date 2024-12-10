<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_bank_status', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_688972312')->references('id')->on('case_lists');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id', 'bank_fk_68897232')->references('id')->on('banks');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_68897233')->references('id')->on('users');
            $table->unsignedBigInteger('bank_status_id')->nullable();
            $table->foreign('bank_status_id', 'bank_status_fk_68897234')->references('id')->on('bank_status');
            $table->unsignedBigInteger('memo_id')->nullable();
            $table->foreign('memo_id', 'memo_fk_6889723488')->references('id')->on('memo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_bank_status', function (Blueprint $table) {
            //
        });
    }
};
