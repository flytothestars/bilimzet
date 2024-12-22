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
            $table->dropColumn(['text', 'text_kz', 'lecture', 'lecture_kz']);

            $table->string('goal');
            $table->string('goal_kz');
            $table->string('task');
            $table->string('task_kz');
            $table->string('result');
            $table->string('result_kz');
            $table->string('content');
            $table->string('content_kz');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_modules', function (Blueprint $table) {
            $table->string('text');
            $table->string('text_kz');
            $table->string('lecture');
            $table->string('lecture_kz');
            
            $table->dropColumn(['goal', 'goal_kz', 'task', 'task_kz', 'result', 'result_kz', 'content', 'content_kz']);
       
        });
    }
};
