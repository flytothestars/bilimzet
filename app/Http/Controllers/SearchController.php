<?php namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class SearchController extends PageController
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
		$searchText = $request->get('search', '');
		$courseType = $request->get('course_type', '*');
		$items = $this->getSearchResults($searchText, $courseType);
		$footer_pages = $this->footer_pages;
		$categories = Lang::get('courses.categories');

		return view('search', compact('items', 'categories', 'footer_pages'));
	}

	private function getSearchResults($searchText, $courseType)
	{
		$searchText = str_replace('%', '', $searchText);

		if (empty($searchText)) {
			return [];
		}

		$query = Course::query()
			->where('title', 'like', "%$searchText%");

		if ($courseType !== '*') {
			$query = $query->whereHas('speciality', function ($subQuery) use ($courseType) {
				$subQuery->where('category', 'like', "$courseType^%");
			});
		}

		return $query->limit(10)->get();
	}
}
