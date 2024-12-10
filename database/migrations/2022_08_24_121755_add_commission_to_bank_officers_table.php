<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionToBankOfficersTable extends Migration
{
    public function up()
    {
        Schema::table('bank_officers', function (Blueprint $table) {
            $table->decimal('commission',15,2)->default('0');
        });
    }

    public function down()
    {
        Schema::table('bank_officers', function (Blueprint $table) {
            //
        });
    }
}
