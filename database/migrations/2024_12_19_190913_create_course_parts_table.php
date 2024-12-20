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
        Schema::create('course_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('title_kz');
            $table->timestamps();
            $table->unsignedBigInteger('course_id');
            $table->integer('duration_hours');
            $table->integer('price_kzt');
            $table->string('plan')->nullable();
            $table->string('file')->nullable();

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_parts');
    }
};
