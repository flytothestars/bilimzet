<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTest extends Model
{
    protected $fillable = [ 'title', 'title_kz', 'duration_minutes' ];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function questions()
    {
        return $this->hasMany('App\CourseTestQuestion', 'course_test_id');
    }
}
