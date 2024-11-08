<?php namespace App\Data;

use App\Util\Traits\HasUploads;

class Diploma
{
	use HasUploads;

	const UPLOADS_DIR_NAME = 'courses/diploma';

	const FILES = ['file'];
}
