<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('case_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request')->nullable();
            $table->string('facility_type')->nullable();
            $table->float('amount', 15, 2)->nullable();
            $table->string('specific_concern')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
