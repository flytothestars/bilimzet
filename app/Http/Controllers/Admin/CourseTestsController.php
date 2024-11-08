<?php namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseSpeciality;
use App\CourseTest;
use App\Http\Controllers\PageController;
use App\Util\Traits\HasPagination;
use Illuminate\Http\Request;

class CourseTestsController extends PageController
{
	use HasPagination;

	const STORE_RULES = [
		'title' => 'required',
		'duration_minutes' => 'required|integer|min:1',
	];

	public function index(CourseSpeciality $speciality, Course $course)
	{
		//$this->onPaginationIndex();
		$items = $course->tests;

		return view('admin.courseTests', compact('speciality', 'course', 'items'));
	}

	public function create(CourseSpeciality $speciality, Course $course)
	{
		$formAction = route('admin.storeCourseTest', compact('speciality', 'course'));
		return view('admin.courseTest', [
			'speciality' => $speciality,
			'course' => $course,
			'formAction' => $formAction,
			'item' => null
		]);
	}

	public function store(Request $request, CourseSpeciality $speciality, Course $course)
	{
		$this->validate($request, self::STORE_RULES);

		$item = new CourseTest($request->all());

		$course->tests()->save($item);
		////echo "fdfsd";
		return $this->onSave($request, $speciality, $course, $item);
	}

	private function onSave(Request $request, CourseSpeciality $speciality, Course $course, CourseTest $test)
	{
		$addQuestion = $request->get('_save_opt') === 'add_question';
		if ($addQuestion) {
			$route = route('admin.createCourseTestQuestion', compact('speciality', 'course', 'test'));
		} else {
			$route = route('admin.courseTests', compact('speciality', 'course'));
		}
		return redirect()->to($route);
	}

	public function edit(Request $request, CourseSpeciality $speciality, Course $course, CourseTest $test)
	{
		$formAction = route('admin.updateCourseTest', compact('speciality', 'course', 'test'));

		return view('admin.courseTest', [
			'speciality' => $speciality,
			'course' => $course,
			'item' => $test,
			'questions' => $test->questions,
			'formAction' => $formAction,
		]);
	}

	public function update(Request $request, CourseSpeciality $speciality, Course $course, CourseTest $test)
	{
		$this->validate($request, self::STORE_RULES);

		$test->fill($request->all());
		$test->save();

		return $this->onSave($request, $speciality, $course, $test);
	}

	public function destroy(CourseSpeciality $speciality, Course $course, CourseTest $test)
	{
		$test->delete();
		return back();
	}
}
