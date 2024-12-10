<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_case_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_role')->nullable()->comment('0:admin, 1: salesmen, 2: team leader, 3: manager, 4: credit, 5: accountant');
            $table->integer('action')->nullable()->comment('0:none, 1: pending, 2: pass, 3: return');
            $table->date('date')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
