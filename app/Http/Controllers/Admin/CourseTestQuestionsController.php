<?php namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseSpeciality;
use App\CourseTest;
use App\CourseTestQuestion;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;

class CourseTestQuestionsController extends PageController
{
	const STORE_RULES = [
		'title' => 'required',
		'correct_answer' => 'required',
	];

	public function create(CourseSpeciality $speciality, Course $course, CourseTest $test)
	{
		$formAction = route('admin.storeCourseTestQuestion', compact('speciality', 'course', 'test'));
		$course = $test->course;
		$item = null;

		return view('admin.courseTestQuestion', compact('speciality', 'course',
			'test', 'item', 'formAction'));
	}

	public function store(Request $request, CourseSpeciality $speciality, Course $course, CourseTest $test)
	{
		$this->validate($request, self::STORE_RULES);

		$item = new CourseTestQuestion($request->all());
		$test->questions()->save($item);

		return $this->onSave($request, $speciality, $course, $test, $item);
	}

	private function onSave(Request $request, CourseSpeciality $speciality, Course $course, CourseTest $test,
	                        CourseTestQuestion $question)
	{
		return redirect()->route('admin.editCourseTest',
			compact('speciality', 'course', 'test'));
	}

	public function edit(Request $request, CourseSpeciality $speciality, Course $course, CourseTest $test,
	                     CourseTestQuestion $question)
	{
		$formAction = route('admin.updateCourseTestQuestion',
			compact('speciality', 'course', 'test', 'question'));

		return view('admin.courseTestQuestion', [
			'speciality' => $speciality,
			'course' => $course,
			'test' => $test,
			'item' => $question,
			'formAction' => $formAction,
		]);
	}

	public function update(Request $request, CourseSpeciality $speciality, Course $course, CourseTest $test,
	                       CourseTestQuestion $question)
	{
		$this->validate($request, self::STORE_RULES);

		$question->fill($request->all());
		$question->save();

		return $this->onSave($request, $speciality, $course, $test, $question);
	}

	public function destroy(CourseSpeciality $speciality, Course $course, CourseTest $test, CourseTestQuestion $question)
	{
		$question->delete();
		return back();
	}
}
