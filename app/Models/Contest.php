<?php namespace App\Models;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
	use HasUploads;

	const UPLOADS_DIR_NAME = 'contests';
	const FILES = [ 'picture' ];
	protected $fillable = [
		'category_id', 'title', 'title_kz', 'desc_text', 'desc_text_kz',
		'picture_background', 'text_on_picture', 'text_on_picture_kz'
	];

	public function category()
	{
		return $this->belongsTo('App\Models\ContestCategory');
	}

	public function parts()
	{
		return $this->hasMany('App\Models\ContestPart');
	}

	public function testimonials()
	{
		return $this->hasMany('App\Models\ContestTestimonial');
	}

	public function certificates()
	{
		return $this->hasMany('App\Models\ContestCertificate');
	}

	public function awards()
	{
		return $this->hasMany('App\Models\ContestAward');
	}

	public function files()
	{
		return $this->hasMany('App\Models\ContestFile');
	}
}
