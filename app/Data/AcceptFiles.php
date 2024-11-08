<?php namespace App\Data;

class AcceptFiles
{
	public static $accept = [
		'application/pdf',
		'application/rtf',
		'application/msword',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/vnd.ms-powerpoint',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation'
	];

	public static function get()
	{
		return implode(',', self::$accept);
	}
}
