<?php namespace App\Models;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class ContestPart extends Model
{
	use HasUploads;

	const FILES = [ 'plan' ];
	const PRIVATE_FILES = [ 'file' ];
	const UPLOADS_DIR_NAME = 'contents';
	protected $fillable = [
		'contest_id', 'duration_hours', 'price_kzt', 'plan', 'plan_kz', 'file',
		'additional_files', 'real_names'
	];

	public function contest()
	{
		return $this->belongsTo('App\Models\Contest');
	}

	public function usersWhoBought()
	{
		return $this->belongsToMany('App\User', 'purchased_contest_part', 'contest_part_id')
			->withTimestamps();
	}
}
