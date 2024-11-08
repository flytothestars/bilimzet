<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OlympicCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olympic_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('classification_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->string('title', 255);
            $table->integer('price');
            $table->timestamps();

            $table->foreign('classification_id')
                ->references('id')->on('olympic_classifications')
                ->onDelete('cascade');

            $table->foreign('member_id')
                ->references('id')->on('olympic_members')
                ->onDelete('cascade');

            $table->foreign('subject_id')
                ->references('id')->on('olympic_subjects')
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
        Schema::dropIfExists('olympic_courses');
    }
}
