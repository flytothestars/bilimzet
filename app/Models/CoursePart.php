<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePart extends BaseModel
{
	use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'title', 'title_kz', 'duration_hours', 'price_kzt', 'course_id'
    ];
    protected $hidden = ['title_kz'];


    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function courseModule()
    {
        return $this->hasMany('App\Models\CourseModule', 'course_part_id');
    }

    public function courseTest()
    {
        return $this->hasMany('App\Models\CourseTest', 'course_part_id');
    }

    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

}
