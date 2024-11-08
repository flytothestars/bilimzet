<?php


namespace App\Util\UploadsDir;


class PrivateUploadsDir extends UploadsDir
{
    protected function makeDirPath($dirName): string
    {
        return storage_path('uploads') . DIRECTORY_SEPARATOR . $dirName;
    }
}
