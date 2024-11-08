<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OlympicClassification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olympic_classifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        DB::table('olympic_classifications')->insert(
            [
                [
                    'name' => 'Республиканская',
                ],
                [
                    'name' => 'Международная'
                ],
                [
                    'name' => 'Областная',
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('olympic_classifications');
    }
}
