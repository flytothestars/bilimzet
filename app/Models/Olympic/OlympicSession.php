<?php

namespace App\Models\Olympic;

use Illuminate\Database\Eloquent\Model;

class OlympicSession extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'token',
        'results',
        'certificate_image',
        'letter_image',
        'certificate_number',
        'letter_number',
        'name',
        'lastname',
        'surname',
        'mentor_name',
        'mentor_lastname',
        'mentor_surname',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'results' => 'json',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public $timestamps = false;

    public function course()
    {
        return $this->hasOne(OlympicCourse::class, 'id', 'course_id');
    }
}
