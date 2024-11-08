<?php namespace App\Data;

use App\Util\Traits\HasUploads;

class Letter
{
	use HasUploads;

	const UPLOADS_DIR_NAME = 'courses/letter';

	const FILES = ['file'];
}
