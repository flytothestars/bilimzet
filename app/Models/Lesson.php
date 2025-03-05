<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Lesson extends BaseModel
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'title', 'title_kz', 'course_module_id',
        'is_lecture','is_video','is_present',
        'goal','goal_kz','task','task_kz',
        'result','result_kz','content','content_kz',
    ];
    protected $hidden = ['title_kz', 'text_kz', 'goal_kz','task_kz','result_kz','content_kz'];

    public function courseModule()
    {
        return $this->belongsTo('App\Models\CourseModule', 'course_module_id');
    }

    public function courseModuleLecture()
    {
        return $this->hasMany('App\Models\CourseModuleLecture', 'lesson_id');
    }

    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

    public function getTextAttribute()
    {
        return $this->getLocalizedField('text');
    }

    public function getGoalAttribute()
    {
        return $this->getLocalizedField('goal');
    }

    public function getTaskAttribute()
    {
        return $this->getLocalizedField('task');
    }

    public function getResultAttribute()
    {
        return $this->getLocalizedField('result');
    }

    public function getContentAttribute()
    {
        return $this->getLocalizedField('content');
    }
}
