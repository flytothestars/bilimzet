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
            $table->string('goal')->nullable();
            $table->string('goal_kz')->nullable();
            $table->string('task')->nullable();
            $table->string('task_kz')->nullable();
            $table->string('result')->nullable();
            $table->string('result_kz')->nullable();
            $table->string('content')->nullable();
            $table->string('content_kz')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'goal','goal_kz',
                'task','task_kz',
                'result','result_kz',
                'content','content_kz'
            ]);
        });
    }
};
