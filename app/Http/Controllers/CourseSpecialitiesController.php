<?php namespace App\Http\Controllers;

use App\CourseSpeciality;
use App\Data\CourseSpecialityCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class CourseSpecialitiesController extends PageController
{
	private $footer_pages = [];

	public function __construct()
	{
		$pages = DB::select('select content from pages where page_filt = ?', ['footer']);
		foreach ($pages as $page) {
			$this->footer_pages[] = base64_decode($page->content);
		}
	}

	public function index(Request $request)
	{
		$tab = intval($request->get('tab', 1));
		$categories = Lang::get('courses.categories');
		$categoryNames = array_keys($categories);
		$categoryName = $tab === 1 ? $categoryNames[0] : $categoryNames[1];
		//$subcategoryNames = $categories[$categoryName];
		$locale = Lang::getLocale();
		$name = 'name' . ($locale == 'kz' ? '_kz' : '');
		$course_categories = DB::select('select id,training,' . $name . ' from course_categories where training = ?', [ $tab === 1 ? 1 : 0]);
		$subcategoryNames = [];
		$ids = [];
		foreach ($course_categories as $course_category) {
			$subcategoryNames[] = $locale == 'kz' ? $course_category->name_kz : $course_category->name;
			$ids[] = $course_category->id;
		}

		$specialities = CourseSpeciality::whereIn('category', $ids)->get();
		$subcategoriesData = [];
		foreach ($course_categories as $course_category) {
			$name = $locale == 'kz' ? $course_category->name_kz : $course_category->name;
			$subcategoriesData[$name] = [];
			foreach ($specialities as &$speciality) {
				$speciality->title = $locale == 'kz' ? (empty($speciality->title_kz) ? $speciality->title : $speciality->title_kz) : $speciality->title;
				if ($speciality->category == $course_category->id) {
					$subcategoriesData[$name][] = $speciality;
				}
			}
		}

		$footer_pages = $this->footer_pages;

		return view('specialities', compact('tab', 'categoryName', 'categoryNames',
			'subcategoryNames', 'subcategoriesData', 'footer_pages'));
	}

	public function show(Request $request, $id)
	{
		$locale = Lang::getLocale();
		$item = CourseSpeciality::with('courses')->findOrFail($id);
		$item->title = $locale == 'kz' ? (empty($item->title_kz) ? $item->title : $item->title_kz) : $item->title;
		$footer_pages = $this->footer_pages;

		return view('speciality', compact('item', 'footer_pages'));
	}
}
