<?php namespace App\Util\UploadsDir;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

abstract class UploadsDir
{
    protected $dirName;
    protected $dirPath;

    public function __construct($dirName)
    {
        $this->dirName = $dirName;
        $this->dirPath = $this->makeDirPath($dirName);

        if (!is_dir($this->dirPath)) {
            mkdir($this->dirPath, 0777, true);
        }
    }

    protected abstract function makeDirPath($dirName): string;

    public function saveUploadedFile($uploadedFile, $name = null)
    {
        if (empty($uploadedFile)) {
            return '';
        }

        if (empty($name)) {
            $name = $this->generateName($uploadedFile->getClientOriginalExtension());
        }
        $uploadedFile->move($this->dirPath, $name);

        return $name;
    }

    public function generateName($ext): string
    {
        return (string) Str::uuid() . '.' . $ext;
    }

    public function deleteFile($name): void
    {
        File::delete($this->getPathFor($name));
    }

    public function getPathFor($name): string
    {
        return $this->dirPath . DIRECTORY_SEPARATOR . $name;
    }

    public function copyFiles($pathList)
    {
        $fileNames = [];
        foreach ($pathList as $filePath) {
            $fileName = basename($filePath);
            $fileNames[] = $fileName;
            $targetPath = $this->getPathFor($fileName);
            copy($filePath, $targetPath);
        }
        return $fileNames;
    }
}
