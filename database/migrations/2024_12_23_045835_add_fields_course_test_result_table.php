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
        Schema::table('course_test_results', function (Blueprint $table) {
            $table->string('finish_time');
            $table->string('total_question');
            $table->string('total_correct_question');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('course_part_id');
            $table->foreign('course_part_id')
                ->references('id')->on('course_parts')
                ->onUpdate('cascade')
                ->onDelete('cascade');        
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_test_results', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['course_part_id']);

            $table->dropColumn([
                'finish_time',
                'total_question',
                'total_correct_question',
                'user_id',
                'course_part_id'
            ]);
        });
    }
};
