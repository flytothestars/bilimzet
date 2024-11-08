<?php namespace App;

use App\Util\Traits\HasUploads;
use App\Util\UploadsDir\PublicUploadsDir;
use Illuminate\Database\Eloquent\Model;

class Gid extends Model
{
    use HasUploads;

    const FILES = [ 'video' ];

    public $timestamps = false;

    const UPLOADS_DIR_NAME = 'gid';

    protected $fillable = [
        'title', 'text', 'title_kz', 'text_kz'
    ];

}
