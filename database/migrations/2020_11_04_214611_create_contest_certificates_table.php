<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestCertificatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest_certificates', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('contest_id');
			$table->string('name', 255);
			$table->string('name_kz', 255);
			$table->text('text');
			$table->text('text_kz');
			$table->string('file', 255);
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
		Schema::dropIfExists('contest_certificates');
	}
}
