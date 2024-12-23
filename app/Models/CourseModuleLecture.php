<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class CourseModuleLecture extends Model
{
    use HasFactory, Attachable, AsSource;

    protected $fillable = [
        'title', 'title_kz', 'content', 'content_kz', 'course_module_id'
    ];

    public function courseModule()
    {
        return $this->belongsTo('App\Models\CourseModule', 'course_module_id');
    }
}
