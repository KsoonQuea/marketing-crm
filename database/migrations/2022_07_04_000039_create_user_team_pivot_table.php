<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_teams', function (Blueprint $table) {
            $table->unsignedBigInteger('user_team_id');
            $table->foreign('user_team_id', 'user_team_id_fk_6899006')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_6899006')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
