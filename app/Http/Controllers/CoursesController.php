<?php namespace App\Http\Controllers;

use App\Course;
use App\CoursePart;
use App\CourseTestimonial;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;

class CoursesController extends PageController
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
		$subcategoryNames = $categories[$categoryName];
		//$subcategoryNames = array_keys($categories);

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
			foreach ($specialities as $speciality) {
				if ($speciality->category == $course_category->id) {
					$subcategoriesData[$name][] = $speciality;
				}
			}
		}

		$footer_pages = $this->footer_pages;

		return view('courses', compact('tab','categoryName', 'categoryNames',
			'categories', 'subcategoryNames', 'subcategoriesData', 'footer_pages'));
	}

	public function show(Request $request, $id)
	{
		$locale = Lang::getLocale();
		$item = Course::with('parts')->find($id);
		$item->title = $locale == 'kz' ? (empty($item->title_kz) ? $item->title : $item->title_kz) : $item->title;
		$item->author_fio = $locale == 'kz' ? (empty($item->author_fio_kz) ? $item->author_fio : $item->author_fio_kz) : $item->author_fio;
		$item->author_position = $locale == 'kz' ? (empty($item->author_position_kz) ? $item->author_position : $item->author_position_kz) : $item->author_position;
		$item->desc_text = $locale == 'kz' ? (empty($item->desc_text_kz) ? $item->desc_text : $item->desc_text_kz) : $item->desc_text;
		$item->listeners_category_text = $locale == 'kz' ? (empty($item->listeners_category_text_kz) ? $item->listeners_category_text : $item->listeners_category_text_kz) : $item->listeners_category_text;
		$item->goals_text = $locale == 'kz' ? (empty($item->goals_text_kz) ? $item->goals_text : $item->goals_text_kz) : $item->goals_text;
		$item->tasks_text = $locale == 'kz' ? (empty($item->tasks_text_kz) ? $item->tasks_text : $item->tasks_text_kz) : $item->tasks_text;
		$item->organization_text = $locale == 'kz' ? (empty($item->organization_text_kz) ? $item->organization_text : $item->organization_text_kz) : $item->organization_text;
		
		$purchasedIds = collect([]);
		$user = auth()->user();
		if ($user) {
			$purchasedIds = $user->purchasedCourseParts->pluck('id');
		}
				

				
		$testimonials = $item->testimonials()
			->with('user')
			->orderBy('created_at', 'desc')
			->get();

		foreach ($item->parts as &$part) {
			$course_parts = DB::select('select additional_files, real_names, plan from course_parts where id = ?', [ $part->id ]);
			foreach ($course_parts as $pt) {
				$additional_files_orig = $pt->additional_files;
				$real_names = $pt->real_names;
				$plan = $pt->plan;
			}
			if ($additional_files_orig != "")
				$additional_files_orig = unserialize($additional_files_orig);
			else
				$additional_files_orig = [];
			if ($real_names != "")
				$real_names = unserialize($real_names);
			else
				$real_names = [];
			$part->additional_files_orig = $additional_files_orig;
			$part->real_plan_name = $real_names["plan"];
		}
		$footer_pages = $this->footer_pages;

		return view('course', compact('item', 'purchasedIds', 'testimonials', 'footer_pages'));
	}

	public function buyPart(Request $request, $courseId, $partId)
	{
		$user = auth()->user();
		if ($user->hasPurchasedCoursePart($partId)) {
			return redirect()
				->route('course', ['id' => $courseId])
				->with('errorMessage', 'Выбранная вами часть курса уже куплена');
		}

		$item = CoursePart::with('course')
			->findOrFail($partId);

		$availableMoneyKZT = $user->money_amount_kzt;
		$footer_pages = $this->footer_pages;

		return view('buyCoursePart', compact('item','availableMoneyKZT', 'footer_pages'));
	}

	public function doBuyPart(Request $request, $courseId, $partId)
	{
		$user = auth()->user();
		if ($user->hasPurchasedCoursePart($partId)) {
			return redirect()
				->route('course', ['id' => $courseId])
				->with('errorMessage', 'Выбранная вами часть курса уже куплена');
		}

		$part = CoursePart::findOrFail($partId);

		if ($user->money_amount_kzt < $part->price_kzt) {
			return redirect()
				->route('buyCoursePart', ['courseId' => $courseId, 'partId' => $partId])
				->with('errorMessage', 'Не удалось купить часть курса - недостаточно денег');
		}

		DB::transaction(function () use ($user, $part) {
			$user->money_amount_kzt -= $part->price_kzt;
			$user->save();
			$user->purchasedCourseParts()->attach($part);

			Notification::createForCoursePart($part, $user);
		});

		return redirect()
			->route('buyCoursePartThanks', ['courseId' => $courseId, 'partId' => $partId]);
	}

	public function buyPartThanks(Request $request, $courseId, $partId)
	{
		$user = auth()->user();

		if (!$user->hasPurchasedCoursePart($partId)) {
			return redirect()
				->route('buyCoursePart', ['courseId' => $courseId, 'partId' => $partId])
				->with('errorMessage', 'Вы ещё не приобрели эту часть курса');
		}

		$item = CoursePart::with('course')
			->findOrFail($partId);

		$footer_pages = $this->footer_pages;
		return view('buyCoursePartThanks', compact('item', 'footer_pages'));
	}

	public function downloadPartFile(Request $request, $courseId, $partId)
	{
		$user = auth()->user();

		if (!$user->hasPurchasedCoursePart($partId)) {
			return redirect()
				->route('buyCoursePart', ['courseId' => $courseId, 'partId' => $partId])
				->with('errorMessage', 'Вы ещё не приобрели эту часть курса');
		}

		$part = CoursePart::findOrFail($partId);
		return response()->file($part->getPrivateUploadedPath('file'), [
			'Content-Disposition' => "attachment; filename=\"$part->file\""
		]);
	}

	public function storeCourseTestimonial(Request $request, $courseId)
	{
		$url = url()->previous() . '#testimonials';
		$validator = Validator::make($request->all(), [
			'text' => 'required|max:1000'
		]);
		if ($validator->fails()) {
			return redirect($url)
				->withErrors($validator)
				->withInput();
		}

		$course = Course::findOrFail($courseId);

		$testimonial = new CourseTestimonial();
		$testimonial->text = $request->get('text');
		$testimonial->course_id = $course->id;
		if(auth()->user()) {
		$user = auth()->user();
		$testimonial->user_id = $user->id;
		} else {
		$testimonial->user_id = 305;
		};
		$testimonial->save();

		return redirect($url);
	}
}
