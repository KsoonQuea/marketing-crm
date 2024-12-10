<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttributeToMemoTable extends Migration
{
    public function up()
    {
        Schema::table('memo', function (Blueprint $table) {
            $table->string('remark')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('memo', function (Blueprint $table) {
            //
        });
    }
}
