<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class CourseSpeciality extends Model
{
    use HasFactory, Attachable, AsSource;

    protected $fillable = [ 'title', 'title_kz', 'category', 'picture_background' ];

}
