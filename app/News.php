<?php namespace App;

use App\Util\Traits\HasUploads;
use App\Util\UploadsDir\PublicUploadsDir;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasUploads;

    const FILES = [ 'miniature' ];
    const UPLOADS_DIR_NAME = 'news';

    private static $uploadsDir;

    protected $fillable = [ 'name', 'text', 'name_kz', 'text_kz' ];

    public static function getUploadsDir() : PublicUploadsDir
    {
        if (!self::$uploadsDir) {
            self::$uploadsDir = new PublicUploadsDir('news');
        }
        return self::$uploadsDir;
    }

    public function deleteDocument()
    {
        if (!$this->miniature) {
            return;
        }
        self::getUploadsDir()->deleteFile($this->miniature);
        $this->miniature = null;
    }

    public function views()
    {
        return $this->hasMany(NewsView::class, 'news_id', 'id');
    }
}
