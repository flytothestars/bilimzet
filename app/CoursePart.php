<?php

namespace App;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class CoursePart extends Model
{
    use HasUploads;

    const FILES = [
        'plan'
    ];

    const PRIVATE_FILES = [
        'file'
    ];

    const UPLOADS_DIR_NAME = 'courses';

    protected $fillable = [
        'duration_hours', 'price_kzt'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function usersWhoBought()
    {
        return $this->belongsToMany('App\User', 'purchased_course_part')
            ->withTimestamps();
    }
}
