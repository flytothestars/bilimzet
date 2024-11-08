<?php

namespace App\Models\Olympic;

use Illuminate\Database\Eloquent\Model;

class OlympicQuestion extends Model
{
    protected $fillable = [
        'course_id',
        'question',
    ];

    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo(OlympicCourse::class);
    }

    public function answers()
    {
        return $this->hasMany(OlympicAnswer::class, 'question_id', 'id');
    }
}
