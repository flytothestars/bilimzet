<?php

namespace App\Models\Olympic;

use Illuminate\Database\Eloquent\Model;

class OlympicCourse extends Model
{
    protected $fillable = [
        'classification_id',
        'member_id',
        'subject_id',
        'title',
        'price',
        'locale',
    ];

    public function classification()
    {
        return $this->hasOne(OlympicClassification::class, 'id', 'classification_id');
    }

    public function member()
    {
        return $this->belongsTo(OlympicMember::class);
    }

    public function subject()
    {
        return $this->hasOne(OlympicSubject::class, 'id', 'subject_id');
    }

    public function questions()
    {
        return $this->hasMany(OlympicQuestion::class, 'course_id');
    }
}
