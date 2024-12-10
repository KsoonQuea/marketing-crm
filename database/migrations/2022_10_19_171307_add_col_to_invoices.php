<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToInvoices extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('company_address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();

            $table->double('service_fee', 8, 2)->nullable();
            $table->integer('sst_status')->default(1);
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
}
