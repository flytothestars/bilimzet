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
        Schema::table('module_passeds', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('part_id');
            $table->foreign('part_id')
                ->references('id')->on('course_parts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id')
                ->references('id')->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('lecture_id')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('module_passeds', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['part_id']);
            $table->dropForeign(['lesson_id']);

            $table->dropColumn([
                'course_id',
                'part_id',
                'lesson_id',
                'lecture_id'
            ]);
        });
    }
};
