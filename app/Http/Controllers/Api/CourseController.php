<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CourseSpeciality;
use App\Helper\ApiResponseHelper;
use App\Helper\Helper;
use App\Models\Course;
use App\Models\CoursePart;
use App\Models\CourseBuy;
use App\Models\CourseModule;
use App\Models\CourseModuleLecture;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function category()
    {
        $course_categories = Category::where('training', 1)
            ->get()->map(function ($item) {
                $item->picture = Helper::getUrls($item, 'categoryIcon');
                return $item;
            });

        $result = $course_categories->map(function ($category) {
            $category->specialities = CourseSpeciality::where('category', $category->id)->get()->map(function ($item) {
                $item->picture = Helper::getUrls($item);
                return $item;
            });
            return $category;
        });
        return ApiResponseHelper::success($result);
    }

    public function courseList($id)
    {
        $item = Course::where('speciality_id', $id)->get()->map(function($item){
            $item->author_photo = Helper::getUrls($item, 'courseAuthorPhoto');
            return $item;
        });
        return ApiResponseHelper::success($item);
    }

    public function coursePartList(Request $request, $id)
    {
        $item = Course::where('id',$id)->get()->map(function($course){
            $course->parts = CoursePart::where('course_id', $course->id)->get()->map(function($part){
                $user = auth('sanctum')->user();
                if($user){
                    $courseBuy = CourseBuy::where('user_id', $user->id)
                        ->where('course_part_id', $part->id)
                        ->where('course_id', $part->course_id)->first();
                    if($courseBuy){
                        $part->is_purchased_user = true;
                        $part->purchased = $courseBuy;
                        $part->purchased->link = url('/api/course/'.$part->course_id.'/part/'.$part->id.'/module');

                    }else {
                        $part->is_purchased_user = false;
                        $part->purchased = [];
                    }
                    return $part;
                } else {
                    $part->is_purchased_user = false;
                    $part->purchased = [];
                    return $part;
                }
            });
            return $course;
        });

        return ApiResponseHelper::success($item);    
    }

    public function getCategory()
    {
        $categories = Category::where('training', 1)->get();
        return ApiResponseHelper::success($categories);
    }

    public function coursePartModuleList($course_id, $part_id)
    {
        $item = Course::where('id', $course_id)->get()->map(function($course) use ($part_id){
            $course->parts = CoursePart::where('id', $part_id)
                ->where('course_id', $course->id)
                ->get()->map(function($part){
                    $part->modules = CourseModule::where('course_part_id', $part->id)
                        ->get()->map(function($module){
                            $module->lecture = CourseModuleLecture::where('course_module_id', $module->id)->get()
                                ->map(function($lecture){
                                    $lecture->plain_text = strip_tags($lecture->content);
                                    $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                    $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                    return $lecture;
                                });
                            $module->video = Helper::getUrls($module, 'courseModuleVideo');
                            $module->present = Helper::getUrls($module, 'courseModulePresent');

                            return $module;
                        });
                    return $part;
                });
            return $course;
        });
        return ApiResponseHelper::success($item);

    }

    public function coursePartModule($course_id, $part_id, $module_id)
    {
        $item = Course::where('id', $course_id)->get()->map(function($course) use ($part_id, $module_id){
            $course->parts = CoursePart::where('id', $part_id)
                ->where('course_id', $course->id)
                ->get()->map(function($part) use ($module_id){
                    $part->modules = CourseModule::where('id', $module_id)->where('course_part_id', $part->id)
                        ->get()->map(function($module){
                            $module->lecture = CourseModuleLecture::where('course_module_id', $module->id)->get()
                                ->map(function($lecture){
                                    $lecture->plain_text = strip_tags($lecture->content);
                                    $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                    $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                    return $lecture;
                                });
                            $module->video = Helper::getUrls($module, 'courseModuleVideo');
                            $module->present = Helper::getUrls($module, 'courseModulePresent');

                            return $module;
                        });
                    return $part;
                });
            return $course;
        });
        return ApiResponseHelper::success($item);
    }

    public function courseModuleLectureList($module_id){
        $lecture = CourseModuleLecture::where('course_module_id', $module_id)->get()
                                ->map(function($lecture){
                                    $lecture->plain_text = strip_tags($lecture->content);
                                    $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                    $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                    return $lecture;
                                });
                                return ApiResponseHelper::success($lecture);

    }

    public function moduleLecture($module_id, $lecture_id){
        $lecture = CourseModuleLecture::where('id', $lecture_id)->get()
                                ->map(function($lecture){
                                    $lecture->plain_text = strip_tags($lecture->content);
                                    $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                    $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                    return $lecture;
                                });
                                return ApiResponseHelper::success($lecture);

    }

    public function moduleVideo($module_id){
        $modules = CourseModule::where('id', $module_id)
        ->get()->map(function($module){
            $module->video = Helper::getUrls($module, 'courseModuleVideo');
            $module->present = Helper::getUrls($module, 'courseModulePresent');

            return $module;
        });
        return ApiResponseHelper::success($modules);
    }

    public function modulePresent($module_id){
        $modules = CourseModule::where('id', $module_id)
        ->get()->map(function($module){
            $module->video = Helper::getUrls($module, 'courseModuleVideo');
            $module->present = Helper::getUrls($module, 'courseModulePresent');

            return $module;
        });
        return ApiResponseHelper::success($modules);
    }
}
