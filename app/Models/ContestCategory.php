<?php namespace App\Models;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class ContestCategory extends Model
{
	use HasUploads;
	const UPLOADS_DIR_NAME = 'contests_category';

	const FILES = [ 'picture' ];
	protected $fillable = [ 'training', 'name', 'name_kz' ];

	public function contests()
	{
		return $this->hasMany('App\Models\Contest', 'category_id');
	}
}
