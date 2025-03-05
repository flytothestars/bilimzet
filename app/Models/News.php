<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;

class News extends BaseModel
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [ 'id','name', 'text', 'name_kz', 'text_kz', 'view_count'];

    protected $hidden = ['name_kz', 'text_kz'];
    protected $appends = ['plain_text'];
    
    public function getNameAttribute()
    {
        return $this->getLocalizedField('name');
    }

    public function getTextAttribute()
    {
        return $this->getLocalizedField('text');
    }

    public function getPlainTextAttribute()
    {
        return strip_tags($this->getLocalizedField('text'));
    }
}
