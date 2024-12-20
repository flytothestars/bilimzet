<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibraryItem extends Model
{
	use HasFactory, AsSource, Attachable;

    protected $fillable = [ 
        'title', 'title_kz', 'document', 
        'document_extension', 'category', 'text', 'text_kz',
        'is_published', 'author_id'
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }
}

