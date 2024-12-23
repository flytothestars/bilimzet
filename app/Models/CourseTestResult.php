<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class CourseTestResult extends Model
{
    use HasFactory,AsSource,Attachable;

    protected $fillable = [ 'user_id', 'finish_time', 'total_question', 'total_correct_question', 'course_part_id', 'status_certificate', 'rand' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coursePart()
    {
        return $this->belongsTo(CoursePart::class, 'course_part_id');
    }

}
