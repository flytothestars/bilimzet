<?php namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseSpeciality;
use App\Http\Controllers\PageController;
use App\Util\TextHelper;
use App\Util\Traits\HasPagination;
use App\Util\ValidationUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CoursesController extends PageController
{
	use HasPagination;

	const STORE_RULES = [
		'title' => 'required|string',
		'author_fio' => 'required|string',
		'author_position' => 'required|string',
		'author_photo' => 'required|image|dimensions:min_width=100,min_height=100,max_height=1000,max_width=1000|max:2048',
		'desc_text' => 'required|string',
		'listeners_category_text' => 'required|string',
		'goals_text' => 'required|string',
		'tasks_text' => 'required|string',
		'organization_text' => 'required|string',
	];

	public function index(CourseSpeciality $speciality)
	{
		$this->onPaginationIndex();

		$items = $speciality->courses()->paginate(self::DEFAULT_PAGE_SIZE);

		return view('admin.courses', compact('items', 'speciality'));
	}

	public function create(CourseSpeciality $speciality)
	{
		return view('admin.course', [
			'speciality' => $speciality,
			'formAction' => route('admin.storeCourse', compact('speciality')),
			'item' => null
		]);
	}

	public function store(Request $request, CourseSpeciality $speciality)
	{
		$this->validate($request, self::STORE_RULES);

		$item = new Course($request->all());
		$item->saveDeclaredFiles($request->files);
		$speciality->courses()->save($item);

		return $this->_onSave($request, $speciality, $item);
	}

	public function edit(CourseSpeciality $speciality, Course $course)
	{
		$specCourse = compact('speciality', 'course');
		$formAction = route('admin.updateCourse', $specCourse);
		$partsRoute = route('admin.courseParts', $specCourse);
		$testsRoute = route('admin.courseTests', $specCourse);
		$item = TextHelper::esc( $course, [
			'desc_text', 'listeners_category_text', 'goals_text',
			'tasks_text', 'organization_text'
		]);

		$data = compact('speciality', 'formAction', 'partsRoute', 'testsRoute', 'item');

		return view('admin.course', $data);
	}

	public function update(Request $request, CourseSpeciality $speciality, Course $course)
	{
		$rules = self::STORE_RULES;
		ValidationUtils::makeNullable($rules, ['author_photo']);
		$this->validate($request, $rules);

		$course->fill($request->all());
		$course->saveDeclaredFiles($request->files);
		$course = TextHelper::unesc( $course, [
			'desc_text', 'listeners_category_text', 'goals_text',
			'tasks_text', 'organization_text'
		]);
		$course->save();

		return $this->_onSave($request, $speciality, $course);
	}

	public function destroy(CourseSpeciality $speciality, Course $course)
	{
		$course->deleteWithFiles();
		return back();
	}

	private function _onSave(Request $request, CourseSpeciality $speciality, Course $course): RedirectResponse
	{
		$saveOpt = $request->get('_save_opt');

		if ($saveOpt === 'add_test') {
			return redirect()->route('admin.createCourseTest', compact('speciality', 'course'));
		}
		if ($saveOpt === 'add_part') {
			return redirect()->route('admin.createCoursePart', compact('speciality', 'course'));
		}

		return redirect()->route('admin.courses', compact('speciality'));
	}
}
