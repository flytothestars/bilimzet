<?php namespace App\Data;

class ContestsSpecialityCategories
{
    public static function makeCategory($parent, $child) {
        return "$parent^$child";
    }

    public static function parseCategory($category) {
        return explode('^', $category, 2);
    }

    public static function getParentCategory($category)
    {
        return self::parseCategory($category)[0];
    }

    public static function getChildCategory($category)
    {
        return self::parseCategory($category)[1];
    }
}
