<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OlympicSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olympic_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('access_for_members');
        });

        DB::table('olympic_subjects')->insert(
            [
                [
                    'name' => 'Казахский язык и казахская литература',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Русский язык и русская литература',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Английский язык',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'История',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'География',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Биология',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Химия',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Математика',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Физика',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Информатика',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Начальные классы',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Художественный труд(ИЗО)',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'НВТП',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Физическая культура',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Музыка',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Самопознание',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Графика и дизайн',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Религиоведение',
                    'access_for_members' => 'member_id:1,member_id:2',
                ],
                [
                    'name' => 'Психология',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'Логопедия',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'Дефектология',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'Тифлопедагогика',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'Сурдопедагогика',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'ЛФК',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'Хореография',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'Библиотека',
                    'access_for_members' => 'member_id:1',
                ],
                [
                    'name' => 'История мира',
                    'access_for_members' => 'member_id:2',
                ],
                [
                    'name' => 'История Казахстана',
                    'access_for_members' => 'member_id:2',
                ],
                [
                    'name' => 'Монтессори',
                    'access_for_members' => 'member_id:3',
                ],
                [
                    'name' => '«Методист»',
                    'access_for_members' => 'member_id:3',
                ],
                [
                    'name' => 'Логопедия',
                    'access_for_members' => 'member_id:3',
                ],
                [
                    'name' => 'Психология',
                    'access_for_members' => 'member_id:3',
                ],
                [
                    'name' => 'Музыка',
                    'access_for_members' => 'member_id:3',
                ],
                [
                    'name' => '«Воспитатель»',
                    'access_for_members' => 'member_id:3',
                ],
                [
                    'name' => 'Физическое воспитание',
                    'access_for_members' => 'member_id:3',
                ],
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
        Schema::dropIfExists('olympic_subjects');
    }
}
