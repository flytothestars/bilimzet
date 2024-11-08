<?php namespace App\Http\Controllers\Admin;

use App\CourseTestimonial;
use App\Models\ContestTestimonial;
use App\Http\Controllers\PageController;
use App\Util\Traits\HasPagination;

class TestimonialsController extends PageController
{
	use HasPagination;

	public function index()
	{
		$this->onPaginationIndex();

		$items = CourseTestimonial::with(['user','course'])
			->orderBy('created_at', 'desc')
			->paginate(self::DEFAULT_PAGE_SIZE);
		$items_new = 0;
		foreach ($items as $item) {
			$items_new += $item->viewed ? 0 : 1;
		}

		$contests = ContestTestimonial::with(['user'])
			->orderBy('created_at', 'desc')
			->paginate(self::DEFAULT_PAGE_SIZE);
		$contests_new = 0;
		foreach ($contests as $contest) {
			$contests_new += $contest->viewed ? 0 : 1;
		}
		return view('admin.testimonials', compact('items', 'items_new', 'contests', 'contests_new'));
	}

	public function viewed($id)
	{
		$item = CourseTestimonial::findOrFail($id);
		$item->viewed = true;
		$item->save();
		return back();
	}

	public function viewedContest($id)
	{
		$item = ContestTestimonial::findOrFail($id);
		$item->viewed = true;
		$item->save();
		return back();
	}

	public function destroy($id)
	{
		$item = CourseTestimonial::findOrFail($id);
		$item->delete();
		return back();
	}

	public function destroyContest($id)
	{
		$item = ContestTestimonial::findOrFail($id);
		$item->delete();
		return back();
	}
}
