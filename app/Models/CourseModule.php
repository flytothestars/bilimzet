<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class CourseModule extends Model
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'title', 'title_kz', 'course_part_id',
        'is_lecture','is_video','is_present',
        'goal','goal_kz','task','task_kz','result','result_kz','content','content_kz',
    ];

    public function coursePart()
    {
        return $this->belongsTo('App\Models\CoursePart', 'course_part_id');
    }

    public function courseLessons()
    {
        return $this->hasMany('App\Models\Lesson', 'course_module_id');
    }

}
