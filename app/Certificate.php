<?php namespace App;

use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
	use HasUploads;

	const UPLOADS_DIR_NAME = 'courses';

	const FILES = ['file'];

	protected $fillable = [
		'title', 'title_kz', 'fio', 'fio_kz', 'course_title', 'course_title_kz',
		'duration', 'duration_kz', 'day', 'month', 'month_kz', 'year'
	];

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function testResult()
	{
		return $this->belongsTo('App\CourseTestResult', 'result_id');
	}
}
