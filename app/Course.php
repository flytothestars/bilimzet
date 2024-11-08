<?php

namespace App;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasUploads;

    const FILES = [
        'picture', 'author_photo'
    ];

    const UPLOADS_DIR_NAME = 'courses';

    protected $fillable = [
       'title', 'title_kz', 'author_fio', 'author_fio_kz', 'author_position', 'author_position_kz',
	    'desc_text', 'desc_text_kz', 'listeners_category_text', 'listeners_category_text_kz',
	    'goals_text', 'goals_text_kz', 'tasks_text', 'tasks_text_kz', 'organization_text', 'organization_text_kz',
    ];

    public function speciality()
    {
        return $this->belongsTo('App\CourseSpeciality', 'speciality_id');
    }

    public function parts()
    {
        return $this->hasMany('App\CoursePart');
    }

    public function tests()
    {
        return $this->hasMany('App\CourseTest');
    }

    public function testimonials()
    {
        return $this->hasMany('App\CourseTestimonial');
    }
}
