<?php namespace App\Data;

use Illuminate\Support\Facades\Lang;

class CourseSpecialityTabs
{
    public static function getTabNumberForCategory($fullCategory)
    {
        $parentCategory = CourseSpecialityCategories::getParentCategory($fullCategory);
        $categories = array_keys( Lang::get('courses.categories') );
        $index = array_search($parentCategory, $categories);
        if ($index === false) {
            return -1000;
        }
        return $index + 1;
    }
}
