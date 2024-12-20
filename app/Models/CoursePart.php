<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePart extends Model
{
	use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'title', 'title_kz', 'duration_hours', 'price_kzt', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }
}
