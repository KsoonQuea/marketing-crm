<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeTextToMemoTable extends Migration
{
    public function up()
    {
        Schema::table('memo', function (Blueprint $table) {
            $table->text('remark')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('memo', function (Blueprint $table) {
            //
        });
    }
}
