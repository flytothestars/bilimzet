<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\CourseTestQuestion::class, function (Faker $faker) {
    $a = mt_rand(0, 10);
    $b = mt_rand(0, 10);
    $answer = $a + $b;

    return [
        'title' => "Посчитайте $a + $b",
        'correct_answer' => $answer,
        'incorrect_answers' => [
            $answer + 1,
            $answer + 2,
            $answer + 3,
        ]
    ];
});
