<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OlympicSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olympic_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('token', 255);
            $table->text('results')->nullable();
            $table->string('certificate_image')->nullable();
            $table->string('letter_image')->nullable();
            $table->integer('certificate_number')->nullable();
            $table->integer('letter_number')->nullable();
            $table->string('name');
            $table->string('lastname');
            $table->string('surname')->nullable();
            $table->string('mentor_name')->nullable();
            $table->string('mentor_lastname')->nullable();
            $table->string('mentor_surname')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();

            $table->foreign('course_id')
                ->references('id')->on('olympic_courses')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('olympic_sessions');
    }
}
