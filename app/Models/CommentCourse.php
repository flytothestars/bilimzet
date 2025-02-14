<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'course_id', 'part_id', 'comment'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }
}
