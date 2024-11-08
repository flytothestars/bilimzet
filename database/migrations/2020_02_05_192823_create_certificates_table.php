<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('certificates', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('result_id')->nullable();
			$table->string('template');
			$table->string('title');
			$table->string('fio');
			$table->string('course_title');
			$table->string('file');
			$table->boolean('is_issued')->default(false);
			$table->string('duration');
			$table->string('day');
			$table->string('month');
			$table->string('year');
			$table->timestamps();
			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade');
			$table->foreign('result_id')
				->references('id')->on('course_test_results')
				->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('certificates');
	}
}
