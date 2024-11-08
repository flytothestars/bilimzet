<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestAward extends Model
{
	protected $fillable = [ 'user_id', 'contest_id', 'certificate_id' ];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function contest()
	{
		return $this->belongsTo('App\Models\Contest');
	}

	public function certificate()
	{
		return $this->belongsTo('App\Models\ContestCertificate', 'certificate_id');
	}
}
