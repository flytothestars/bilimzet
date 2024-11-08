<?php namespace App\Models;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class ContestCertificate extends Model
{
	use HasUploads;

	const UPLOADS_DIR_NAME = 'contests';

	protected $fillable = [ 'contest_id', 'name', 'name_kz', 'text', 'text_kz', 'file' ];

	public function contest()
	{
		return $this->belongsTo('App\Models\Contest');
	}

	public function awards()
	{
		return $this->hasMany('App\Models\ContestAward', 'certificate_id');
	}
}
