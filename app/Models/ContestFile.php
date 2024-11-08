<?php namespace App\Models;

use App\Util\Traits\HasUploads;
use App\Util\UploadsDir\PublicUploadsDir;
use Illuminate\Database\Eloquent\Model;

class ContestFile extends Model
{
	use HasUploads;

	const UPLOADS_DIR_NAME = 'contest_files';

	protected $table = 'contest_files';
	public $timestamps = false;

	protected $fillable = [	'user_id', 'contest_id', 'workplace', 'file', 'video' ];

	private static $uploadsDir;
	public static function getUploadsDir() : PublicUploadsDir
	{
		if (!self::$uploadsDir) {
			self::$uploadsDir = new PublicUploadsDir(self::UPLOADS_DIR_NAME);
		}
		return self::$uploadsDir;
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function contest()
	{
		return $this->belongsTo('App\Models\Contest');
	}
}
