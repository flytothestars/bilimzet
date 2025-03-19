<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->longText('goal')->nullable()->change();
            $table->longText('goal_kz')->nullable()->change();
            $table->longText('task')->nullable()->change();
            $table->longText('task_kz')->nullable()->change();
            $table->longText('result')->nullable()->change();
            $table->longText('result_kz')->nullable()->change();
            $table->longText('content')->nullable()->change();
            $table->longText('content_kz')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('goal')->nullable()->change();
            $table->string('goal_kz')->nullable()->change();
            $table->string('task')->nullable()->change();
            $table->string('task_kz')->nullable()->change();
            $table->string('result')->nullable()->change();
            $table->string('result_kz')->nullable()->change();
            $table->string('content')->nullable()->change();
            $table->string('content_kz')->nullable()->change();
        });
    }
};
