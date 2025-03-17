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
        Schema::table('course_modules', function (Blueprint $table) {
            $table->dropColumn([
                'is_lecture', 'is_video', 'is_present',
                'goal', 'goal_kz', 'task', 'task_kz', 
                'result', 'result_kz', 'content', 'content_kz'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_modules', function (Blueprint $table) {
            $table->boolean('is_lecture')->default(false);
            $table->boolean('is_video')->default(false);
            $table->boolean('is_present')->default(false);
            $table->text('goal')->nullable();
            $table->text('goal_kz')->nullable();
            $table->text('task')->nullable();
            $table->text('task_kz')->nullable();
            $table->text('result')->nullable();
            $table->text('result_kz')->nullable();
            $table->text('content')->nullable();
            $table->text('content_kz')->nullable();
        });
    }
};
