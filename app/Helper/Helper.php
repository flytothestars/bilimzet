<?php 

namespace App\Helper;

class Helper 
{
    public static function getUrl($item, $group = null)
    {
        $pictures = $item->attachment($group)->get();
        $relativeUrl = $pictures->first()?->relativeUrl;
        return $relativeUrl ? url($relativeUrl) : null;
    }

    public static function getUrls($item, $group = null)
    {
        $pictures = $item->attachment($group)->get();
        $relativeUrls = $pictures->map(function ($picture) {
            return url($picture->relativeUrl);
        })->toArray();

        return $relativeUrls ?: null; 
    }

    public static function getExtension($item, $group = null)
    {
        $pictures = $item->attachment($group)->get();
        $extension = $pictures->first()?->extension;
        return $extension ? $extension : null;
    } 

    public static function getSize($item, $group = null)
    {
        $file = $item->attachment($group)->get();
        $sizeFile = $file->map(function ($file) {
            return self::formatFileSize($file->size);
        });

        return $sizeFile ?: null; 
    }

    private static function formatFileSize($size)
    {
        if ($size >= 1048576) {
            return round($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        }
        return $size . ' B';
    }
}