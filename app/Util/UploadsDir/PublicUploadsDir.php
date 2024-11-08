<?php namespace App\Util\UploadsDir;

class PublicUploadsDir extends UploadsDir
{
    public function getUrlFor($name): string
    {
        return url("/uploads/{$this->dirName}/$name");
    }

    protected function makeDirPath($dirName): string
    {
        return public_path('uploads') . DIRECTORY_SEPARATOR . $dirName;
    }
}
