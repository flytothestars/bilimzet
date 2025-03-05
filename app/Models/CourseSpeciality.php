<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class CourseSpeciality extends BaseModel
{
    use HasFactory, Attachable, AsSource;

    protected $fillable = [ 'title', 'title_kz', 'category', 'picture_background', 'description', 'description_kz'];
    protected $hidden = ['title_kz', 'description_kz'];


    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

    public function getDescriptionAttribute()
    {
        return $this->getLocalizedField('description');
    }
}
