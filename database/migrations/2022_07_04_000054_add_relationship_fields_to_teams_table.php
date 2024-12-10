<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->unsignedBigInteger('team_lead_id')->nullable();
            $table->foreign('team_lead_id', 'team_lead_fk_6899005')->references('id')->on('users');
        });
    }
};
