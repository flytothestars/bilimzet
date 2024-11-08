<?php

namespace App\Models\Olympic;

use Illuminate\Database\Eloquent\Model;

class OlympicAnswer extends Model
{
    protected $fillable = [
        'question_id',
        'answer',
        'is_right',
    ];

    protected $hidden = [
        'is_right'
    ];

    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(OlympicQuestion::class);
    }

    public static function isCorrectAnswer($questionId, $answerId)
    {
        $correctAnswer = self::where('question_id', $questionId)->where('is_right', 1)->first();

        return optional($correctAnswer)->id === $answerId;
    }
}
