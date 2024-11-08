<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OlympicMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olympic_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        DB::table('olympic_members')->insert(
            [
                [
                    'name' => 'Учитель',
                ],
                [
                    'name' => 'Ученик'
                ],
                [
                    'name' => 'Воспитатель',
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
        Schema::dropIfExists('olympic_members');
    }
}
