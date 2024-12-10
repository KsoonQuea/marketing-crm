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
        Schema::table('case_manager_section', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6889723324')->references('id')->on('users');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id', 'case_fk_68897231202')->references('id')->on('case_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_manager_section', function (Blueprint $table) {
            //
        });
    }
};
