<?php

namespace App;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
       'id_user', 'massage', 'date'
    ];


    const UPLOADS_DIR_NAME = 'comment';
    protected $table = 'comment';

}
