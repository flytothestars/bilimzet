<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTestQuestion extends Model
{
    protected $fillable = [
        'title', 'correct_answer', 'incorrect_answers',
	    'title_kz', 'correct_answer_kz', 'incorrect_answers_kz'
    ];

    protected $casts = [
        'incorrect_answers' => 'array',
	    'incorrect_answers_kz' => 'array',
    ];

    public function test()
    {
        return $this->belongsTo('App\CourseTest', 'course_test_id');
    }
}
