<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToCaseBankStatusTable extends Migration
{
    public function up()
    {
        Schema::table('case_bank_status', function (Blueprint $table) {
            $table->decimal('amount',15,2)->default('0');
        });
    }

    public function down()
    {
        Schema::table('case_bank_status', function (Blueprint $table) {
            //
        });
    }
}
