<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalDateToCaseDisburses extends Migration
{
    public function up()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            $table->date('approval_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('case_disburses', function (Blueprint $table) {
            //
        });
    }
}
