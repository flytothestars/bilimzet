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
use App\Models\ModulePassed;
use App\Models\Lesson;
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
                $part->document_plan = Helper::getUrls($part, 'coursePartPlan');

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
                    $part->document_plan = Helper::getUrls($part, 'coursePartPlan');
                    $part->modules = CourseModule::where('course_part_id', $part->id)
                        ->get()->map(function($module) use ($part){
                            $modulePassed = ModulePassed::where('part_id', $part->id)->where('course_module_id', $module->id)->first();
                            if($modulePassed) {
                                $module->passed = true;
                            } else {
                                $module->passed = false;
                            }
                            $module->lesson = Lesson::where('course_module_id',$module->id)->get()
                                ->map(function($lesson) use ($module){
                                    $modulePassed = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->first();
                                    if($modulePassed) {
                                        $lesson->passed = true;
                                    } else {
                                        $lesson->passed = false;
                                    }
                                    $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','basic')->first();
                                    if($modulePassed) {
                                        $lesson->passed_basic = true;
                                    } else {
                                        $lesson->passed_basic = false;
                                    }
                                    $lesson->lecture = CourseModuleLecture::where('lesson_id', $lesson->id)->get()
                                        ->map(function($lecture) use ($lesson){
                                            $modulePassed = ModulePassed::where('lesson_id', $lesson->id)->where('lecture_id', $lecture->id)->where('type', 'lecture')->first();
                                            if($modulePassed) {
                                                $lecture->passed = true;
                                            } else {
                                                $lecture->passed = false;
                                            }
                                            $lecture->plain_text = strip_tags($lecture->content);
                                            $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                            $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                            return $lecture;
                                        });

                                    $lesson->video = Helper::getUrls($lesson, 'lessonVideo');
                                    $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','video')->first();
                                    if($modulePassed) {
                                        $lesson->passed_video = true;
                                    } else {
                                        $lesson->passed_video = false;
                                    }
                                    $lesson->present = Helper::getUrls($lesson, 'lessonPresent');
                                    $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','present')->first();
                                    if($modulePassed) {
                                        $lesson->passed_present = true;
                                    } else {
                                        $lesson->passed_present = false;
                                    }
                                    return $lesson;
                                });            
                            return $module;
                        });
                    return $part;
                });
            return $course;
        });
        return ApiResponseHelper::success($item);

    }

    public function coursePartModule($module_id, $lesson_id)
    {
        $item = CourseModule::where('id', $module_id)
            ->get()->map(function($module) use ($lesson_id){
                $module->lesson = Lesson::where('course_module_id',$module->id)->where('id', $lesson_id)->get()
                    ->map(function($lesson) use ($module){
                        $modulePassed = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->first();
                        if($modulePassed) {
                            $lesson->passed = true;
                        } else {
                            $lesson->passed = false;
                        }
                        $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','basic')->first();
                        if($modulePassed) {
                            $lesson->passed_basic = true;
                        } else {
                            $lesson->passed_basic = false;
                        }
                        $lesson->lecture = CourseModuleLecture::where('lesson_id', $lesson->id)->get()
                            ->map(function($lecture) use ($lesson){
                                $modulePassed = ModulePassed::where('lesson_id', $lesson->id)->where('lecture_id', $lecture->id)->where('type', 'lecture')->first();
                                if($modulePassed) {
                                    $lecture->passed = true;
                                } else {
                                    $lecture->passed = false;
                                }
                                $lecture->plain_text = strip_tags($lecture->content);
                                $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                return $lecture;
                            });

                        $lesson->video = Helper::getUrls($lesson, 'lessonVideo');
                        $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','video')->first();
                        if($modulePassed) {
                            $lesson->passed_video = true;
                        } else {
                            $lesson->passed_video = false;
                        }
                        $lesson->present = Helper::getUrls($lesson, 'lessonPresent');
                        $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','present')->first();
                        if($modulePassed) {
                            $lesson->passed_present = true;
                        } else {
                            $lesson->passed_present = false;
                        }
                        return $lesson;
                    });      
                return $module;
            });
        return ApiResponseHelper::success($item);
    }

    public function coursePartModuleLectureList($lesson_id)
    {
        $lecture = CourseModuleLecture::where('lesson_id', $lesson_id)->get()
        ->map(function($lecture){
            $lecture->plain_text = strip_tags($lecture->content);
            $lecture->plain_text_kz = strip_tags($lecture->content_kz);
            $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
            return $lecture;
        });
        return ApiResponseHelper::success($lecture);
    }

    public function moduleLecture($lesson_id, $lecture_id)
    {
        $lecture = CourseModuleLecture::where('id', $lecture_id)->get()
        ->map(function($lecture){
            $lecture->plain_text = strip_tags($lecture->content);
            $lecture->plain_text_kz = strip_tags($lecture->content_kz);
            $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
            return $lecture;
        });
        return ApiResponseHelper::success($lecture);
    }

    public function moduleVideo($lesson_id)
    {
        $modules = Lesson::where('id', $lesson_id)
        ->get()->map(function($module){
            $module->video = Helper::getUrls($module, 'lessonVideo');
            $module->present = Helper::getUrls($module, 'lessonPresent');

            return $module;
        });
        return ApiResponseHelper::success($modules);
    }

    public function modulePresent($lesson_id)
    {
        $modules = Lesson::where('id', $lesson_id)
        ->get()->map(function($module){
            $module->video = Helper::getUrls($module, 'lessonVideo');
            $module->present = Helper::getUrls($module, 'lessonPresent');

            return $module;
        });
        return ApiResponseHelper::success($modules);
    }

    public function process(Request $request)
    {
        ModulePassed::firstOrCreate([
            'user_id' => auth()->user()->id,
            'course_id' => $request->course_id,
            'part_id' => $request->part_id,
            'course_module_id' => $request->module_id,
            'lesson_id' => $request->lesson_id,
            'type' => $request->type,
            'lecture_id' => $request->lecture_id,
        ]);
        return ApiResponseHelper::success();
    }

    public function courseProcess($part_id, $course_id)
    {
        $userId = auth()->id();
        
        $part = CoursePart::where('id', $part_id)->get();
        
        $count = 0;
        foreach ($part as $key => $value) 
        {
            $modules = $value->courseModule()->get();
            foreach($modules as $module)
            {
                $lessons = $module->courseLessons()->get();
                $count++;
                foreach ($lessons as $lesson) {
                    if($lesson->is_lecture)
                    {
                        $count += $lesson->courseModuleLecture()->count();
                    }
                    if($lesson->is_video)
                    {
                        $count++;
                    }
                    if($lesson->is_present)
                    {
                        $count++;
                    }
                }
            }
        }
        $count_passed = 0;
        $passed = ModulePassed::where('course_id', $course_id)->where('part_id', $part_id)->get();
        if($passed){
            $count_passed = $passed->count();
        }
        
        if($count > 0){
            $data = [
                'total' => round(($count_passed/$count)*100, 2),
            ];    
        } else {
            $data = [
                'total' => 0,
            ]; 
        }
        return ApiResponseHelper::success($data);
    }


    public function courseModuleLessonProcess($module_id, $lesson_id)
    {
        $user = auth()->user()->id;
        $count = 1;
        $count_lecture = 0;
        $lesson = Lesson::where('id', $lesson_id)->first();
        if($lesson->is_lecture)
        {
            $count += $lesson->courseModuleLecture()->count();
        }
        if($lesson->is_video)
        {
            $count++;
        }
        if($lesson->is_present)
        {
            $count++;
        }

        // dd($count);
        $count_passed = 0;
        $passed = ModulePassed::where('lesson_id', $lesson_id)->where('course_module_id', $module_id)->where('user_id', $user)->get();
        $lectures = $lesson->courseModuleLecture()->get();
        foreach ($passed as $key => $value) {
            if($value->type == 'lecture'){
                foreach ($lectures as $key => $lecture) {
                    if($value->lecture_id == $lecture->id){
                        $count_passed++;
                    }
                }
            }
            if($value->type == 'basic'){
                $count_passed++;
            }
            if($value->type == 'video'){
                $count_passed++;
            }
            if($value->type == 'present'){
                $count_passed++;
            }
        }

        if($count > 0){
            $data = [
                'total' => round(($count_passed/$count)*100, 2),
            ];    
        } else {
            $data = [
                'total' => 0,
            ]; 
        }
        return ApiResponseHelper::success($data);
    }
}
