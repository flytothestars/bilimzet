<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class CourseModuleLecture extends BaseModel
{
    use HasFactory, Attachable, AsSource;

    protected $fillable = [
        'title', 'title_kz', 'content', 'content_kz', 'lesson_id'
    ];
    protected $hidden = ['title_kz','content_kz'];

    public function lesson()
    {
        return $this->belongsTo('App\Models\CourseModule', 'lesson_id');
    }

    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

    public function getContentAttribute()
    {
        return $this->getLocalizedField('content');
    }

}
