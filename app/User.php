<?php namespace App;

use App\Util\UploadsDir\PublicUploadsDir;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use Notifiable;

	const ADMIN_TYPE = 'admin';
	const DEFAULT_TYPE = 'default';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'full_name', 'address',
		'company_name', 'phone', 'position'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	private static $uploadsDir;

	public static function getUploadsDir(): PublicUploadsDir
	{
		if (!self::$uploadsDir) {
			self::$uploadsDir = new PublicUploadsDir('profile');
		}
		return self::$uploadsDir;
	}

	public static function generatePassword()
	{
		return substr(str_shuffle(MD5(microtime())), 0, 12);
	}

	public function getPhotoUrlAttribute()
	{
		if (!$this->photo) {
			return url('images/no_avatar.png');
		}
		return self::getUploadsDir()->getUrlFor($this->photo);
	}

	public function getDiplomaUrlAttribute()
	{
		if (!$this->diploma) {
			return "#no_diploma";
		}
		return self::getUploadsDir()->getUrlFor($this->diploma);
	}

	public function isAdmin()
	{
		return $this->type === self::ADMIN_TYPE;
	}

	public function isDefault()
	{
		return $this->type === self::DEFAULT_TYPE;
	}

	public function libraryItems()
	{
		return $this->hasMany('App\LibraryItem', 'author_id');
	}
	
	public function lecturesItems()
	{
		return $this->hasMany('App\LecturesItem', 'author_id');
	}

	public function purchasedCourseParts()
	{
		return $this->belongsToMany('App\CoursePart', 'purchased_course_part')
			->withTimestamps();
	}

	public function purchasedContestParts()
	{
		return $this->belongsToMany('App\Models\ContestPart', 'purchased_contest_part')
			->withTimestamps();
	}

	public function hasPurchasedCoursePart($partId)
	{
		return $this->purchasedCourseParts()
			->where('course_parts.id', $partId)
			->exists();
	}

	public function hasPurchasedContestPart($partId)
	{
		return $this->purchasedContestParts()
			->where('contest_parts.id', $partId)
			->exists();
	}

	public function getPurchasedCourses()
	{
		return $this->_getPurchasedCourses();
	}

	public function getPurchasedCoursesWithTests()
	{
		return $this->_getPurchasedCourses('course.tests');
	}

	private function _getPurchasedCourses($with = 'course')
	{
		return $this->purchasedCourseParts()
			->with($with)
			->get()
			->pluck('course')
			->unique();
	}

	public function getPurchasedContests()
	{
		return $this->_getPurchasedContests();
	}

	private function _getPurchasedContests($with = 'contest')
	{
		return $this->purchasedContestParts()
			->with($with)
			->get()
			->pluck('contest')
			->unique();
	}

	public function certificates()
	{
		return $this->hasMany('App\Certificate', 'user_id');
	}

	public function awards()
	{
		return $this->hasMany('App\Models\ContestAward', 'user_id');
	}

	public function notifications()
	{
		return $this->hasMany('App\Models\Notification');
	}
}
