<?php namespace App\Util\Traits;

use App\Util\UploadsDir\PrivateUploadsDir;
use App\Util\UploadsDir\PublicUploadsDir;
use App\Util\UploadsDir\UploadsDir;
use Symfony\Component\HttpFoundation\FileBag;

trait HasUploads
{
    private static $publicUploadsDir;
    private static $privateUploadsDir;

    public function saveDeclaredFiles(FileBag $fileBag)
    {
        foreach (self::getPublicFileFields() as $name) {
            $file = $fileBag->get($name);
            if ($file) {
                $this->saveUploaded(self::getPublicUploadsDir(), $name, $file);
            }
        }

        foreach (self::getPrivateFileFields() as $name) {
            $file = $fileBag->get($name);
            if ($file) {
                $this->saveUploaded(self::getPrivateUploadsDir(), $name, $file);
            }
        }
    }

    private static function getPublicFileFields(): array
    {
        return defined(self::class . "::FILES") ? self::FILES : [];
    }

    private static function getPrivateFileFields(): array
    {
        return defined(self::class . "::PRIVATE_FILES") ? self::PRIVATE_FILES : [];
    }

    public function saveUploaded(UploadsDir $uploadsDir, $fieldName, $uploadedDocument)
    {
        $this->deleteUploaded($uploadsDir, $fieldName);
        $this->$fieldName = $uploadsDir->saveUploadedFile($uploadedDocument);
    }

    public function deleteUploaded(UploadsDir $uploadsDir, $fieldName)
    {
        if (!$this->$fieldName) {
            return;
        }
        $uploadsDir->deleteFile($this->$fieldName);
        $this->$fieldName = null;
    }

    public static function getPublicUploadsDir(): PublicUploadsDir
    {
        if (!self::$publicUploadsDir) {
            self::$publicUploadsDir = new PublicUploadsDir(self::getUploadsDirName());
        }
        return self::$publicUploadsDir;
    }

    public static function getPrivateUploadsDir(): PrivateUploadsDir
    {
        if (!self::$privateUploadsDir) {
            self::$privateUploadsDir = new PrivateUploadsDir(self::getUploadsDirName());
        }
        return self::$privateUploadsDir;
    }

    private static function getUploadsDirName(): string
    {
        return self::UPLOADS_DIR_NAME ?? 'etc';
    }

    public function getUploadedUrl($fieldName)
    {
        if (!$this->$fieldName) {
            return '#no_url';
        }
        return self::getPublicUploadsDir()->getUrlFor($this->$fieldName);
    }

    public function getPrivateUploadedPath($fieldName)
    {
        if (!$this->$fieldName) {
            return '';
        }
        return self::getPrivateUploadsDir()->getPathFor($this->$fieldName);
    }

    public function deleteDeclaredFiles()
    {
        foreach (self::getPublicFileFields() as $name) {
            $this->deleteUploaded(self::getPublicUploadsDir(), $name);
        }

        foreach (self::getPrivateFileFields() as $name) {
            $this->deleteUploaded(self::getPrivateUploadsDir(), $name);
        }
    }

    public function deleteWithFiles()
    {
        $this->deleteDeclaredFiles();
        $this->delete();
    }
}
