<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestTestimonial extends Model
{
	protected $fillable = [ 'user_id', 'contest_id', 'text', 'is_demo', 'viewed' ];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function contest()
	{
		return $this->belongsTo('App\Models\Contest');
	}
}
