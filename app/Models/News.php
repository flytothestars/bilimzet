<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [ 'id','name', 'text', 'name_kz', 'text_kz' ];
}
