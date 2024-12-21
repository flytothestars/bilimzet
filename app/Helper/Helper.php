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

    public static function getExtension($item, $group = null)
    {
        $pictures = $item->attachment($group)->get();
        $extension = $pictures->first()?->extension;
        return $extension ? $extension : null;
    } 
}