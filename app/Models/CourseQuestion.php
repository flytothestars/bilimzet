<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class CourseQuestion extends BaseModel
{
    use HasFactory, AsSource;

    protected $fillable = [
        'title', 'correct_answer',
	    'title_kz', 'correct_answer_kz',
        'incorrect_answer_1',
        'incorrect_answer_1_kz',
        'incorrect_answer_2',
        'incorrect_answer_2_kz',
        'incorrect_answer_3',
        'incorrect_answer_3_kz',
        'course_test_id'
    ];
    protected $hidden = ['title_kz', 'correct_answer_kz','incorrect_answer_1_kz','incorrect_answer_2_kz','incorrect_answer_3_kz'];

    public function test()
    {
        return $this->belongsTo('App\Models\CourseTest', 'course_test_id');
    }

    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

    public function getCorrectAnswerAttribute()
    {
        return $this->getLocalizedField('correct_answer');
    }

    public function getIncorrectAnswer1Attribute()
    {
        return $this->getLocalizedField('incorrect_answer_1');
    }

    public function getIncorrectAnswer2Attribute()
    {
        return $this->getLocalizedField('incorrect_answer_2');
    }

    public function getIncorrectAnswer3Attribute()
    {
        return $this->getLocalizedField('incorrect_answer_3');
    }

}
