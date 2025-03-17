<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class CourseModule extends BaseModel
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'title', 'title_kz', 'course_part_id', 'duration_hours'
    ];

    protected $hidden = [
        'title_kz'
    ];

    public function coursePart()
    {
        return $this->belongsTo('App\Models\CoursePart', 'course_part_id');
    }

    public function courseLessons()
    {
        return $this->hasMany('App\Models\Lesson', 'course_module_id');
    }

    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

}
