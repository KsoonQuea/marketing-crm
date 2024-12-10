<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCallListsTable extends Migration
{
    public function up()
    {
        Schema::create('master_call_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('ic')->nullable();
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_description')->nullable();
            $table->integer('status')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_call_lists');
    }
}
