<?php 

namespace App\Helper;

class Helper 
{
    public static function getUrl($item)
    {
        $pictures = $item->attachments()->get();
        $relativeUrl = $pictures->first()?->relativeUrl;
        return $relativeUrl ? url($relativeUrl) : null;
    }

    public static function getExtension($item)
    {
        $pictures = $item->attachments()->get();
        $extension = $pictures->first()?->extension;
        return $extension ? $extension : null;
    } 
}