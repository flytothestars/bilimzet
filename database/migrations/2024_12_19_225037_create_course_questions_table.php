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
        Schema::create('course_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title');
            $table->string('correct_answer');
            $table->string('title_kz');
            $table->string('correct_answer_kz');
            $table->text('incorrect_answer_1');
            $table->text('incorrect_answer_1_kz');
            $table->text('incorrect_answer_2');
            $table->text('incorrect_answer_2_kz');
            $table->text('incorrect_answer_3');
            $table->text('incorrect_answer_3_kz');

            $table->unsignedBigInteger('course_test_id');
            $table->foreign('course_test_id')
                ->references('id')->on('course_tests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_questions');
    }
};
