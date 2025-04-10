<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Promotion extends BaseModel
{
    use HasFactory, AsSource, Attachable;
    
    protected $fillable = [ 'id','title', 'title_kz', 'description', 'description_kz'];
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
