<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_call_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('details')->nullable();
            $table->datetime('datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
