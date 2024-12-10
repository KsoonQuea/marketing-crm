<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('bank_officers', function (Blueprint $table) {
            $table->string('ic')->nullable()->after('name');
            $table->string('bank_account')->nullable()->after('bank_id');
        });
    }

    public function down()
    {
        Schema::table('bank_officers', function (Blueprint $table) {
            //
        });
    }
};
