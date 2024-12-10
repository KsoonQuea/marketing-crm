<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSstPaidDateToDisburseDetails extends Migration
{
    public function up()
    {
        Schema::table('case_disburse_details', function (Blueprint $table) {
            $table->date('sst_paid_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_disburse_details', function (Blueprint $table) {
            //
        });
    }
}
