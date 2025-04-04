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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

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
                $item->count_course = Course::where('speciality_id', $item->id)->count();
                return $item;
            });
            return $category;
        });
        return ApiResponseHelper::success($result);
    }

    public function courseList($lang, $id)
    {
        $item = Course::where('speciality_id', $id)->get()->map(function($item){
            $item->author_photo = Helper::getUrls($item, 'courseAuthorPhoto');
            return $item;
        });
        return ApiResponseHelper::success($item);
    }

    public function coursePartList(Request $request, $lang, $id)
    {
        $item = Course::where('id',$id)->get()->map(function($course){
            $course->parts = CoursePart::where('course_id', $course->id)->get()->map(function($part){
                $locale = App::getLocale();
                if($locale === 'kz'){
                    $groupCoursePartPlan = 'coursePartPlanKz';
                } else {
                    $groupCoursePartPlan = 'coursePartPlanRu';
                }
                $part->document_plan = Helper::getUrls($part, $groupCoursePartPlan);

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
        $categories = Category::where('training', 1)->get()->map(function ($item) {
            $item->picture = Helper::getUrls($item, 'categoryIcon');
            return $item;
        });
        return ApiResponseHelper::success($categories);
    }

    public function coursePartModuleList($lang, $course_id, $part_id)
    {
        $user = auth()->user()->id;
        $item = Course::where('id', $course_id)->get()->map(function($course) use ($part_id, $user){
            $course->parts = CoursePart::where('id', $part_id)
                ->where('course_id', $course->id)
                ->get()->map(function($part) use ($user){
                    $locale = App::getLocale();
                    if($locale === 'kz'){
                        $groupCoursePartPlan = 'coursePartPlanKz';
                    } else {
                        $groupCoursePartPlan = 'coursePartPlanRu';
                    }
                    $part->document_plan = Helper::getUrls($part, $groupCoursePartPlan);
                    $part->modules = CourseModule::where('course_part_id', $part->id)
                        ->get()->map(function($module) use ($part, $user){
                            $modulePassed = ModulePassed::where('part_id', $part->id)->where('course_module_id', $module->id)->where('user_id', $user)->first();
                            if($modulePassed) {
                                $module->passed = true;
                            } else {
                                $module->passed = false;
                            }
                            $module->lesson = Lesson::where('course_module_id',$module->id)->get()
                                ->map(function($lesson) use ($module, $user){
                                    $modulePassed = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('user_id', $user)->first();
                                    if($modulePassed) {
                                        $lesson->passed = true;
                                    } else {
                                        $lesson->passed = false;
                                    }
                                    $modulePassedBasic = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','basic')->where('user_id', $user)->first();
                                    if($modulePassedBasic) {
                                        $lesson->passed_basic = true;
                                    } else {
                                        $lesson->passed_basic = false;
                                    }
                                    $lesson->lecture = CourseModuleLecture::where('lesson_id', $lesson->id)->get()
                                        ->map(function($lecture) use ($lesson, $user){
                                            $modulePassedLecture = ModulePassed::where('lesson_id', $lesson->id)->where('lecture_id', $lecture->id)->where('type', 'lecture')->where('user_id', $user)->first();
                                            if($modulePassedLecture) {
                                                $lecture->passed = true;
                                            } else {
                                                $lecture->passed = false;
                                            }
                                            $lecture->plain_text = strip_tags($lecture->content);
                                            $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                            $locale = App::getLocale();
                                            if($locale === 'kz'){
                                                $groupCourseModuleLecture = 'courseModuleLectureKz';
                                            } else {
                                                $groupCourseModuleLecture = 'courseModuleLectureRu';
                                            }
                                            $lecture->file = Helper::getUrls($lecture, $groupCourseModuleLecture);
                                            return $lecture;
                                        });
                                    
                                    $locale = App::getLocale();
                                    if($locale === 'kz'){
                                        $groupLessonVideo = 'lessonVideoKz';
                                        $groupLessonPresent = 'lessonPresentKz';
                                    } else {
                                        $groupLessonVideo = 'lessonVideoRu';
                                        $groupLessonPresent = 'lessonPresentRu';
                                    }
                                    $lesson->video = Helper::getUrls($lesson, $groupLessonVideo);
                                    $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','video')->where('user_id', $user)->first();
                                    if($modulePassedVideo) {
                                        $lesson->passed_video = true;
                                    } else {
                                        $lesson->passed_video = false;
                                    }
                                    $lesson->present = Helper::getUrls($lesson, $groupLessonPresent);
                                    $modulePassedPresent = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','present')->where('user_id', $user)->first();
                                    if($modulePassedPresent) {
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

    public function coursePartModule($lang, $module_id, $lesson_id)
    {
        $user = auth()->user()->id;

        $item = CourseModule::where('id', $module_id)
            ->get()->map(function($module) use ($lesson_id, $user){
                $module->lesson = Lesson::where('course_module_id',$module->id)->where('id', $lesson_id)->get()
                    ->map(function($lesson) use ($module, $user){
                        $modulePassed = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('user_id', $user)->first();
                        if($modulePassed) {
                            $lesson->passed = true;
                        } else {
                            $lesson->passed = false;
                        }
                        $modulePassedBasic = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','basic')->where('user_id', $user)->first();
                        if($modulePassedBasic) {
                            $lesson->passed_basic = true;
                        } else {
                            $lesson->passed_basic = false;
                        }
                        $lesson->lecture = CourseModuleLecture::where('lesson_id', $lesson->id)->get()
                            ->map(function($lecture) use ($lesson, $user){
                                $modulePassedLecture = ModulePassed::where('lesson_id', $lesson->id)->where('lecture_id', $lecture->id)->where('type', 'lecture')->where('user_id', $user)->first();
                                if($modulePassedLecture) {
                                    $lecture->passed = true;
                                } else {
                                    $lecture->passed = false;
                                }
                                $lecture->plain_text = strip_tags($lecture->content);
                                $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                $locale = App::getLocale();
                                if($locale === 'kz'){
                                    $groupCourseModuleLecture = 'courseModuleLectureKz';
                                } else {
                                    $groupCourseModuleLecture = 'courseModuleLectureRu';
                                }
                                $lecture->file = Helper::getUrls($lecture, $groupCourseModuleLecture);
                                return $lecture;
                            });
                        $locale = App::getLocale();
                        if($locale === 'kz'){
                            $groupLessonVideo = 'lessonVideoKz';
                            $groupLessonPresent = 'lessonPresentKz';
                        } else {
                            $groupLessonVideo = 'lessonVideoRu';
                            $groupLessonPresent = 'lessonPresentRu';
                        }
                        $lesson->video = Helper::getUrls($lesson, $groupLessonVideo);
                        $modulePassedVideo = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','video')->where('user_id', $user)->first();
                        if($modulePassedVideo) {
                            $lesson->passed_video = true;
                        } else {
                            $lesson->passed_video = false;
                        }
                        $lesson->present = Helper::getUrls($lesson, $groupLessonPresent);
                        $modulePassedPresent = ModulePassed::where('lesson_id', $lesson->id)->where('course_module_id', $module->id)->where('type','present')->where('user_id', $user)->first();
                        if($modulePassedPresent) {
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

    public function coursePartModuleLectureList($lang, $lesson_id)
    {
        $lecture = CourseModuleLecture::where('lesson_id', $lesson_id)->get()
        ->map(function($lecture){
            $lecture->plain_text = strip_tags($lecture->content);
            $lecture->plain_text_kz = strip_tags($lecture->content_kz);
            $locale = App::getLocale();
            if($locale === 'kz'){
                $groupCourseModuleLecture = 'courseModuleLectureKz';
            } else {
                $groupCourseModuleLecture = 'courseModuleLectureRu';
            }
            $lecture->file = Helper::getUrls($lecture, $groupCourseModuleLecture);
            return $lecture;
        });
        return ApiResponseHelper::success($lecture);
    }

    public function moduleLecture($lang, $lesson_id, $lecture_id)
    {
        $locale = App::getLocale();
        $lecture = CourseModuleLecture::where('id', $lecture_id)->get()
        ->map(function($lecture) use ($locale){
            $lecture->plain_text = strip_tags($lecture->content);
            $lecture->plain_text_kz = strip_tags($lecture->content_kz);
            if($locale === 'kz'){
                $groupCourseModuleLecture = 'courseModuleLectureKz';
            } else {
                $groupCourseModuleLecture = 'courseModuleLectureRu';
            }
            $lecture->file = Helper::getUrls($lecture, $groupCourseModuleLecture);
            return $lecture;
        });
        return ApiResponseHelper::success($lecture);
    }

    public function moduleVideo($lang, $lesson_id)
    {
        $modules = Lesson::where('id', $lesson_id)
        ->get()->map(function($module){
            $locale = App::getLocale();
            if($locale === 'kz'){
                $groupLessonVideo = 'lessonVideoKz';
                $groupLessonPresent = 'lessonPresentKz';
            } else {
                $groupLessonVideo = 'lessonVideoRu';
                $groupLessonPresent = 'lessonPresentRu';
            }
            $module->video = Helper::getUrls($module, $groupLessonVideo);
            $module->present = Helper::getUrls($module, $groupLessonPresent);

            return $module;
        });
        return ApiResponseHelper::success($modules);
    }

    public function modulePresent($lang, $lesson_id)
    {
        $modules = Lesson::where('id', $lesson_id)
        ->get()->map(function($module){
            $locale = App::getLocale();
            if($locale === 'kz'){
                $groupLessonVideo = 'lessonVideoKz';
                $groupLessonPresent = 'lessonPresentKz';
            } else {
                $groupLessonVideo = 'lessonVideoRu';
                $groupLessonPresent = 'lessonPresentRu';
            }
            $module->video = Helper::getUrls($module, $groupLessonVideo);
            $module->present = Helper::getUrls($module, $groupLessonPresent);

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
            'lecture_id' => empty($request->lecture_id) ? 'null' : $request->lecture_id,
        ]);
        return ApiResponseHelper::success();
    }

    public function courseProcess($lang, $course_id, $part_id)
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
                Log::debug("basic " . $count);
                foreach ($lessons as $lesson) {
                    $count++;
                    if($lesson->is_lecture)
                    {
                        $count += $lesson->courseModuleLecture()->count();
                        Log::debug("lecture " . $lesson->courseModuleLecture()->count());
                    }
                    if($lesson->is_video)
                    {
                        $count++;
                        Log::debug("video " . $count);
                    }
                    if($lesson->is_present)
                    {
                        $count++;
                        Log::debug("present " . $count);
                    }
                }
            }
        }
        $count_passed = 0;
        $passed = ModulePassed::where('course_id', $course_id)->where('part_id', $part_id)->where('user_id', $userId)->get();
        if($passed){
            $count_passed = $passed->count();
        }
        Log::debug("first " . $count_passed);
        Log::debug("second " . $count);
        Log::debug("====================");

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


    public function courseModuleLessonProcess($lang, $module_id, $lesson_id)
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

    public function coursePopular($lang) {
        $courseBuy = CourseBuy::select('course_id', 'course_part_id', DB::raw('COUNT(*) as count'))
            ->groupBy('course_id', 'course_part_id')
            ->orderByDesc('count')
            ->get()->map(function ($item) {
                $item->course = Course::where('id', $item->course_id)->first();
                $item->part = CoursePart::where('id', $item->course_part_id)->first();
                
                return $item;
            });
        return ApiResponseHelper::success($courseBuy);
 
    }
}
