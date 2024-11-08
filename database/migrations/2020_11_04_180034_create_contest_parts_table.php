<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestPartsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest_parts', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('contest_id');
			$table->integer('duration_hours');
			$table->integer('price_kzt');
			$table->string('plan');
			$table->string('plan_kz');
			$table->string('file');
			$table->text('additional_files');
			$table->text('real_names');
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
		Schema::dropIfExists('contest_parts');
	}
}
