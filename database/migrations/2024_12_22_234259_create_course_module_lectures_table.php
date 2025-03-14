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
        Schema::create('course_module_lectures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_kz');
            $table->string('content');
            $table->string('content_kz');
            $table->timestamps();

            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id')
                ->references('id')->on('lessons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_module_lectures');
    }
};
