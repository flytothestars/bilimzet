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
                        ->get()->map(function($module){
                            $module->lesson = Lesson::where('course_module_id',$module->id)->get()
                                ->map(function($lesson){
                                    $lesson->lecture = CourseModuleLecture::where('lesson_id', $lesson->id)->get()
                                        ->map(function($lecture){
                                            $lecture->plain_text = strip_tags($lecture->content);
                                            $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                            $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                            return $lecture;
                                        });

                                    $lesson->video = Helper::getUrls($lesson, 'lessonVideo');
                                    $lesson->present = Helper::getUrls($lesson, 'lessonPresent');
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
                    ->map(function($lesson){
                        $lesson->lecture = CourseModuleLecture::where('lesson_id', $lesson->id)->get()
                            ->map(function($lecture){
                                $lecture->plain_text = strip_tags($lecture->content);
                                $lecture->plain_text_kz = strip_tags($lecture->content_kz);
                                $lecture->file = Helper::getUrls($lecture, 'courseModuleLecture');
                                return $lecture;
                            });

                        $lesson->video = Helper::getUrls($lesson, 'lessonVideo');
                        $lesson->present = Helper::getUrls($lesson, 'lessonPresent');
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
        ModulePassed::create([
            'user_id' => auth()->user()->id,
            'course_module_id' => $request->module_id,
            'type' => $request->type
        ]);
        return ApiResponseHelper::success();
    }

    public function courseProcess($part_id)
    {
        $userId = auth()->id(); // Сразу получаем ID пользователя
        $modules = CourseModule::where('course_part_id', $part_id)->get();

        $counter = 0;
        $passedCount = 0;

        foreach ($modules as $module) {
            // Список типов, которые нужно проверить
            $types = ['basic'];

            if ($module->is_video) {
                $types[] = 'video';
            }
            if ($module->is_present) {
                $types[] = 'present';
            }
            if ($module->is_lecture) {
                $types[] = 'lecture';
            }

            $counter += count($types);

            // Проверяем, какие модули пользователь прошел
            $passed = ModulePassed::where('user_id', $userId)
                ->where('course_module_id', $module->id)
                ->whereIn('type', $types)
                ->pluck('type')
                ->toArray();

            $passedCount += count($passed);
        }

        $data = [
            'total_procent' => '100%',
            'total_step' => $counter,
            'passed_procent' => ($counter > 0 ? round(($passedCount / $counter) * 100, 2) : 0) . '%',
            'passed_step' => $passedCount,
        ];

        return ApiResponseHelper::success($data);
    }


    public function courseModuleProcess($module_id)
    {
        $user = auth()->user()->id;
        $module = CourseModule::where('id',$module_id)->first();
        $counter = 1;
        $passed_count = 0;
        if($module->is_video){
            $counter++;
            $passed = ModulePassed::where('user_id', $user)->where('course_module_id', $module_id)->where('type', 'video')->first();
            if($passed){
                $passed_count++;
            }
        }
        if($module->is_present){
            $counter++;
            $passed = ModulePassed::where('user_id', $user)->where('course_module_id', $module_id)->where('type', 'present')->first();
            if($passed){
                $passed_count++;
            }
        }
        if($module->is_lecture){
            $counter++;
            $passed = ModulePassed::where('user_id', $user)->where('course_module_id', $module_id)->where('type', 'lecture')->first();
            if($passed){
                $passed_count++;
            }
        }

        $passed = ModulePassed::where('user_id', $user)->where('course_module_id', $module_id)->where('type', 'basic')->first();
        if($passed){
            $passed_count++;
        }

        $data = [
            'total_procent' => '100%',
            'total_step' => $counter,
            'passed_procent' => (($passed_count * 1) / $counter) * 100 . '%',
            'passed_step' => $passed_count
        ];
        return ApiResponseHelper::success($data);
    }
}
