<?php namespace App\Http\Controllers;

use App\News;
use App\NewsView;
use App\Util\Traits\HasPagination;
use App\Util\ValidationUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class NewsController extends PageController
{
	use HasPagination;

	private $footer_pages = [];

	public function __construct()
	{
		$pages = DB::select('select content from pages where page_filt = ?', ['footer']);
		foreach ($pages as $page) {
			$this->footer_pages[] = base64_decode($page->content);
		}
	}

	public function index()
	{
		$this->onPaginationIndex();

		$locale = Lang::getLocale();

		$items = News::orderBy('created_at', 'desc')->withCount('views')->paginate(self::DEFAULT_PAGE_SIZE);
		foreach ($items as &$item) {
			$time = new \DateTime($item->created_at);
			$item->date = $time->format('d-m-Y');
			$item->name = $locale == 'kz' ? (empty($item->name_kz) ? $item->name : $item->name_kz) : $item->name;
			$item->text = $locale == 'kz' ? (empty($item->text_kz) ? $item->text : $item->text_kz) : $item->text;
		}

		$footer_pages = $this->footer_pages;
		return view('news', compact('items', 'footer_pages'));
	}

	public function show($id)
	{
		$locale = Lang::getLocale();

		$item = News::find($id);
		$item->name = $locale == 'kz' ? (empty($item->name_kz) ? $item->name : $item->name_kz) : $item->name;
		$item->text = $locale == 'kz' ? (empty($item->text_kz) ? $item->text : $item->text_kz) : $item->text;

		$footer_pages = $this->footer_pages;

		// Add view
        NewsView::updateOrCreate([
            'news_id' => $id,
            'ip' => request()->getClientIp(),
        ]);

		return view('new', compact('item', 'footer_pages'));
	}
}
