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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('title_kz');
            $table->boolean('is_lecture')->default(false);
            $table->boolean('is_video')->default(false);
            $table->boolean('is_present')->default(false);
            $table->unsignedBigInteger('course_module_id');
            $table->foreign('course_module_id')
                ->references('id')->on('course_modules')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
