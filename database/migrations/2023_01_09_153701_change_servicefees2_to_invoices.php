<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('service_fee');
            $table->dropColumn('invoices');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->double('service_fee');
            $table->decimal('invoices');
        });
    }
};