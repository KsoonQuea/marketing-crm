<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColToCaseRequests extends Migration
{
    public function up()
    {
        Schema::table('case_requests', function (Blueprint $table) {
            $table->string('amount')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('case_requests', function (Blueprint $table) {
            //
        });
    }
}
