<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class CourseTest extends BaseModel
{
    use HasFactory, AsSource;

    protected $fillable = [ 'title', 'title_kz', 'duration_minutes', 'course_id', 'course_part_id' ];
    protected $hidden = ['title_kz'];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function coursePart()
    {
        return $this->belongsTo('App\Models\CoursePart', 'course_part_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\CourseQuestion', 'course_test_id');
    }

    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

}
