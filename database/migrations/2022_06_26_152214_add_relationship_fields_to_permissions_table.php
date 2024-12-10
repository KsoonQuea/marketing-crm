<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table): void {
            $table->unsignedBigInteger('permission_group_id')->after('name')->nullable();
            $table->foreign('permission_group_id', 'permission_group_fk_6083190')->references('id')->on('permission_groups');
        });
    }
};
