<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'speciality_id', 'title', 'title_kz', 'author_fio', 'author_fio_kz', 'author_position', 'author_position_kz',
         'desc_text', 'desc_text_kz', 'listeners_category_text', 'listeners_category_text_kz',
         'goals_text', 'goals_text_kz', 'tasks_text', 'tasks_text_kz', 'organization_text', 'organization_text_kz',
         'form_training','form_training_kz','valid_period','valid_period_kz',
         'issuance_certificate','issuance_certificate_kz','certificate_text','certificate_text_kz',
     ];
 
    public function speciality()
    {
        return $this->belongsTo('App\Models\CourseSpeciality', 'speciality_id');
    }

    public function parts()
    {
        return $this->hasMany('App\Models\CoursePart');
    }

    public function comment()
    {
        return $this->hasMany('App\Models\CommentCourse');
    }

    public function tests()
    {
        return $this->hasMany('App\Models\CourseTest');
    }
}
