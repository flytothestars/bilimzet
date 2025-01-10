<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\CourseQuestion;
use App\Models\CourseTest;
use App\Models\CourseTestResult;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getTest($part_id, $course_id){
        $test = CourseTest::where('course_part_id', $part_id)->where('course_id', $course_id)->get()->map(function($test){
            $test->questions = CourseQuestion::where('course_test_id', $test->id)->get();
            $test->count_question = $test->questions->count();
            return $test;
        });
        return ApiResponseHelper::success($test);
    }

    public function sendResultTest(Request $request)
    {
        $user = auth()->user()->id;
        $test = CourseTestResult::create([
            'finish_time' => $request->finish_time,
            'user_id' => $user,
            'total_question' => $request->total_question,
            'total_correct_question' => $request->total_correct_question,
            'course_part_id' => $request->course_part_id
        ]);
        return ApiResponseHelper::success($test);
    }
}
