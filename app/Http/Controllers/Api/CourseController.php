<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CourseSpeciality;
use App\Helper\ApiResponseHelper;
use App\Helper\Helper;
use App\Models\Course;

class CourseController extends Controller
{
    public function category()
    {
        $course_categories = Category::where('training', 1)
            ->get()->map(function ($item) {
                $item->picture = Helper::getUrl($item, 'categoryIcon');
                return $item;
            });

        $result = $course_categories->map(function ($category) {
            $category->specialities = CourseSpeciality::where('category', $category->id)->get()->map(function ($item) {
                $item->picture = Helper::getUrl($item);
                return $item;
            });
            return $category;
        });
        return ApiResponseHelper::success($result);
    }

    public function courseList($id)
    {
        $item = Course::where('speciality_id', $id)->get()->map(function($item){
            $item->author_photo = Helper::getUrl($item, 'courseAuthorPhoto');
            return $item;
        });
        return ApiResponseHelper::success($item);
    }

    public function coursePartList($id)
    {
        $user = auth()->user();
        $item = Course::with('parts')->find($id);

        return ApiResponseHelper::success($item);    
    }

    public function getCategory()
    {
        $categories = Category::where('training', 1)->get();
        return ApiResponseHelper::success($categories);
    }

    public function coursePartModuleList($course_id, $part_id)
    {

    }

    public function coursePartModule($course_id, $part_id, $module_id)
    {

    }
}
