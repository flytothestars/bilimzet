<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class CommentArticle extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'id', 'user_id', 'article_id', 'comment'
    ];

    public function article()
    {
        return $this->belongsTo('App\Models\LibraryItem', 'article_id');
    }
}
