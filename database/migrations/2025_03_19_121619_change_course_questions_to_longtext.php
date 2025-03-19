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
        Schema::table('course_questions', function (Blueprint $table) {
            $table->longText('title')->change();
            $table->longText('correct_answer')->change();
            $table->longText('title_kz')->change();
            $table->longText('correct_answer_kz')->change();
            $table->longText('incorrect_answer_1')->change();
            $table->longText('incorrect_answer_1_kz')->change();
            $table->longText('incorrect_answer_2')->change();
            $table->longText('incorrect_answer_2_kz')->change();
            $table->longText('incorrect_answer_3')->change();
            $table->longText('incorrect_answer_3_kz')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_questions', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('correct_answer')->change();
            $table->string('title_kz')->change();
            $table->string('correct_answer_kz')->change();
            $table->text('incorrect_answer_1')->change();
            $table->text('incorrect_answer_1_kz')->change();
            $table->text('incorrect_answer_2')->change();
            $table->text('incorrect_answer_2_kz')->change();
            $table->text('incorrect_answer_3')->change();
            $table->text('incorrect_answer_3_kz')->change();
        });
    }
};
