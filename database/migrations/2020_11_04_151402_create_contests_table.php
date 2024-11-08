<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contests', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('category_id');
			$table->string('title');
			$table->string('title_kz');
			$table->text('desc_text');
			$table->text('desc_text_kz');
			$table->boolean('is_demo');
			$table->string('picture', 255);
			$table->text('text_on_picture');
			$table->text('text_on_picture_kz');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contests');
	}
}
