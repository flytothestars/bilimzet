<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    protected $fillable = [
        'news_id',
        'ip'
    ];

    public $timestamps = false;
}
