<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationship2ToFinancialRoadmaps extends Migration
{
    public function up()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'users_fk_277832712')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('financial_roadmaps', function (Blueprint $table) {
            //
        });
    }
}
