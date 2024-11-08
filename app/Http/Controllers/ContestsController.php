<?php namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\ContestPart;
use App\Models\ContestTestimonial;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class ContestsController extends PageController
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
		$locale = Lang::getLocale();

		$footer_pages = $this->footer_pages;
		$categories = ContestCategory::where('training', 1)->get();
		foreach ($categories as &$category) {
			$category->name = $locale == 'kz' ? $category->name_kz : $category->name;
			foreach ($category->contests as &$contest) {
				$contest->title = $locale == 'kz' ? (empty($contest->title_kz) ? $contest->title : $contest->title_kz) : $contest->title;
			}
		}

		return view('contests', compact('categories', 'footer_pages'));
	}

	public function show(Request $request, $id)
	{
		$locale = Lang::getLocale();
		$user = auth()->user();
		$item = Contest::find($id);
		$item->title = $locale == 'kz' ? (empty($item->title_kz) ? $item->title : $item->title_kz) : $item->title;
		$item->desc_text = $locale == 'kz' ? (empty($item->desc_text_kz) ? $item->desc_text : $item->desc_text_kz) : $item->desc_text;

		$purchasedIds = collect([]);
		if ($user) {
			$purchasedIds = $user->purchasedCourseParts->pluck('id');
		}

     $testimonials = $item->testimonials()
         ->with('user')
         ->orderBy('created_at', 'desc')
         ->get();

		$footer_pages = $this->footer_pages;

		return view('contest', compact('item', 'purchasedIds', 'footer_pages', 'testimonials'));
	}

	public function buyPart(Request $request, $contestId, $partId)
	{
		$user = auth()->user();
		if ($user->hasPurchasedCoursePart($partId)) {
			return redirect()
				->route('contests', [ 'id' => $contestId ])
				->with('errorMessage', 'Выбранная вами часть курса уже куплена');
		}

		$item = ContestPart::with('contest')->findOrFail($partId);
		$availableMoneyKZT = $user->money_amount_kzt;
		$footer_pages = $this->footer_pages;

		return view('buyContestPart', compact('item', 'availableMoneyKZT', 'footer_pages'));
	}

	public function doBuyPart(Request $request, $contestId, $partId)
	{
		$user = auth()->user();
		if ($user->hasPurchasedContestPart($partId)) {
			return redirect()
				->route('contests', [ 'id' => $contestId ])
				->with('errorMessage', 'Выбранная вами часть конкурса уже куплена');
		}

		$part = ContestPart::findOrFail($partId);

		if ($user->money_amount_kzt < $part->price_kzt) {
			return redirect()
				->route('buyContestPart', ['contestId' => $contestId, 'partId' => $partId])
				->with('errorMessage', 'Не удалось купить часть конкурса - недостаточно денег');
		}

		DB::transaction(function () use ($user, $part) {
			$user->money_amount_kzt -= $part->price_kzt;
			$user->save();
			$user->purchasedContestParts()->attach($part);

			Notification::createForContestPart($part, $user);
		});

		return redirect()->route('buyContestPartThanks', compact('contestId', 'partId'));
	}

	public function buyPartThanks(Request $request, $contestId, $partId)
	{
		$user = auth()->user();

		if (!$user->hasPurchasedCoursePart($partId)) {
			return redirect()
				->route('buyContestPart', ['contestId' => $contestId, 'partId' => $partId])
				->with('errorMessage', 'Вы ещё не приобрели эту часть курса');
		}

		$item = ContestPart::with('contest')
			->findOrFail($partId);
		$footer_pages = $this->footer_pages;
		return view('buyContestPartThanks', compact('item', 'footer_pages'));
	}

	public function downloadPartFile(Request $request, $contestId, $partId)
	{
		$user = auth()->user();

		if (!$user->hasPurchasedCoursePart($partId)) {
			return redirect()
				->route('buyContestPart', ['contestId' => $contestId, 'partId' => $partId])
				->with('errorMessage', 'Вы ещё не приобрели эту часть конкурса');
		}

		$part = ContestPart::findOrFail($partId);
		return response()->file($part->getPrivateUploadedPath('file'), [
			'Content-Disposition' => "attachment; filename=\"$part->file\""
		]);
	}

	public function storeContestTestimonial(Request $request, $contestId)
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

		if(auth()->user()) {
		$user = auth()->user();
		} else {
		$user->id = 305;
		};
		$contest = Contest::findOrFail($contestId);
		$testimonial = new ContestTestimonial();
		$testimonial->text = $request->get('text');
		$testimonial->contest_id = $contest->id;
		$testimonial->user_id = $user->id;
		$testimonial->save();
		return redirect($url);
	}
}
