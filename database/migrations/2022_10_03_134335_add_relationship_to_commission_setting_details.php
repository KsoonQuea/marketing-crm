<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToCommissionSettingDetails extends Migration
{
    public function up()
    {
        Schema::table('commission_setting_details', function (Blueprint $table) {
            $table->unsignedBigInteger('commission_settings_id')->nullable();
            $table->foreign('commission_settings_id', 'commission_settings_fk_636281910')->references('id')->on('commission_settings');
        });
    }

    public function down()
    {
        Schema::table('commission_setting_details', function (Blueprint $table) {
            //
        });
    }
}
