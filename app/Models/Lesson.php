<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Lesson extends Model
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'title', 'title_kz', 'course_module_id',
        'is_lecture','is_video','is_present',
    ];

    public function courseModule()
    {
        return $this->belongsTo('App\Models\CourseModule', 'course_module_id');
    }

    public function courseModuleLecture()
    {
        return $this->hasMany('App\Models\CourseModuleLecture', 'lesson_id');
    }
}
