<?php namespace App;

use App\Util\Traits\HasUploads;
use App\Util\UploadsDir\PublicUploadsDir;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class LibraryItem extends Model
{
	use HasUploads;

    const FILES = [ 'document' ];
    const UPLOADS_DIR_NAME = 'library_items';

    protected $fillable = [ 'title', 'title_kz', 'document', 'category', 'text', 'text_kz' ];

    private static $uploadsDir;

    public static function getUploadsDir() : PublicUploadsDir
    {
        if (!self::$uploadsDir) {
            self::$uploadsDir = new PublicUploadsDir('library');
        }
        return self::$uploadsDir;
    }

    public function saveUploadedDocument($uploadedDocument)
    {
        $this->deleteDocument();
        $this->document = self::getUploadsDir()->saveUploadedFile($uploadedDocument);
    }

    public function getDocumentUrlAttribute()
    {
        if (!$this->document) {
            return '#no_url';
        }
        return self::getUploadsDir()->getUrlFor($this->document);
    }

    public function deleteDocument()
    {
        if (!$this->document) {
            return;
        }
        self::getUploadsDir()->deleteFile($this->document);
        $this->document = null;
    }

    public function isCustomCategory() {
        return !in_array($this->category, Lang::get('library.categories'), true);
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}
