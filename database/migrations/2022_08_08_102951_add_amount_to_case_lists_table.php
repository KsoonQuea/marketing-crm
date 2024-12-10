<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountToCaseListsTable extends Migration
{
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->decimal('approved_amount',15,2)->default('0');
            $table->decimal('service_fee_percentage',15,2)->default('0');
            $table->decimal('service_fee_amount',15,2)->default('0');
        });
    }

    public function down()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            //
        });
    }
}
