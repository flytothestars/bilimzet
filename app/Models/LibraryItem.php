<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibraryItem extends BaseModel
{
	use HasFactory, AsSource, Attachable;

    protected $fillable = [ 
        'title', 'title_kz', 'document', 
        'document_extension', 'category', 'text', 'text_kz',
        'is_published', 'author_id'
    ];
    protected $hidden = ['title_kz', 'text_kz'];


    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Category', 'category');
    }

    public function comment()
    {
        return $this->hasMany('App\Models\CommentArticle', 'article_id');
    }

    public function getTitleAttribute()
    {
        return $this->getLocalizedField('title');
    }

    public function getTextAttribute()
    {
        return $this->getLocalizedField('text');
    }
}

