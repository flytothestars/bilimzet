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
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('speciality_id')->nullable();
			$table->string('title');
            $table->string('title_kz');
			$table->string('author_fio');
			$table->string('author_fio_kz');
			$table->string('author_position');
            $table->string('author_position_kz');
			$table->string('author_photo')->nullable();
			$table->text('desc_text');
            $table->text('desc_text_kz');
			$table->text('listeners_category_text');
            $table->text('listeners_category_text_kz');
			$table->text('goals_text');
            $table->text('goals_text_kz');
			$table->text('tasks_text');
            $table->text('tasks_text_kz');
			$table->text('organization_text');
            $table->text('organization_text_kz');
			$table->boolean('is_demo')->default(false);
			$table->timestamps();
			$table->foreign('speciality_id')
				->references('id')->on('course_specialities')
				->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
