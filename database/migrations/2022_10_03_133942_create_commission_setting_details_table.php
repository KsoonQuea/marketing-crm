<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionSettingDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('commission_setting_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('range');
            $table->double('range_fee');
            $table->double('rate');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commission_setting_details');
    }
}
