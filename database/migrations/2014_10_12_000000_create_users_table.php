<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->string('full_name')->default('');
			$table->string('address')->default('');
			$table->string('company_name')->nullable();
			$table->string('phone')->nullable();
			$table->string('position')->nullable();
			$table->string('photo')->nullable();
			$table->string('diploma')->nullable();
			$table->boolean('receive_news_accept')->default(false);
			$table->string('type')->default(User::DEFAULT_TYPE);
			$table->decimal('money_amount_kzt', 10, 2)->default(0);
			$table->boolean('is_demo')->default(false);
			$table->rememberToken();
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
		Schema::dropIfExists('users');
	}
}
