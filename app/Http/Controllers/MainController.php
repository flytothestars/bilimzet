<?php namespace App\Http\Controllers;

use App\Data\Diploma;
use App\Data\DiplomaData;
use App\Interactors\DiplomaGradeImageMaker;
use App\Interactors\SeminarImageMaker;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
	private $footer_pages = [];
	private $locale;

	public function __construct()
	{
		$this->locale = Lang::getLocale();

		$pages = DB::select('select content,content_kz from pages where page_filt = ?', ['footer']);
		foreach ($pages as $page) {
			$this->footer_pages[] = base64_decode($this->locale == 'kz' ? $page->content_kz : $page->content);
		}
	}

	public function index()
	{
		$news = DB::select('select * from news order by created_at desc limit 3');
		foreach ($news as &$new) {
			$time = new \DateTime($new->created_at);
			$new->name = $this->locale == 'kz' ? (empty($new->name_kz) ? $new->name : $new->name_kz) : $new->name;
			$new->date = $time->format('d-m-Y');
		}

		$about_pages = [];
		$pages = DB::select('select content,content_kz from pages where page_filt = ?', [ 'about_text_main' ]);
		foreach ($pages as $page) {
			$about_pages[] = base64_decode($this->locale == 'kz' ? $page->content_kz : $page->content);
		}

		$footer_pages = $this->footer_pages;
		return view('index', compact('news', 'footer_pages', 'about_pages'));
	}

	public function about()
	{
		$about_pages = [];
		$pages = DB::select('select content,content_kz from pages where page_filt = ?', [ 'about_text' ]);
		foreach ($pages as $page) {
			$about_pages[] = base64_decode($this->locale == 'kz' ? $page->content_kz : $page->content);
		}

		$file_urls = [];
		$files = DB::select('select file_url from gallery');
		foreach ($files as $file) {
			$file_urls[] = $file->file_url;
		}
		$footer_pages = $this->footer_pages;
		$letters = DB::select('select image from letters');

		return view('about', compact('about_pages', 'file_urls', 'footer_pages', 'letters'));
	}

	public function contacts()
	{
		$contact_pages = [];
		$pages = DB::select('select content,content_kz from pages where page_filt = ?', ['contacts']);
		foreach ($pages as $page) {
			$contact_pages[] = base64_decode($this->locale == 'kz' ? $page->content_kz : $page->content);
		}

		$contact_stuff_pages = [];
		$pages = DB::select('select content,content_kz from pages where page_filt = ?', ['contacts_stuff']);
		foreach ($pages as $page) {
			$contact_stuff_pages[] = base64_decode($this->locale == 'kz' ? $page->content_kz : $page->content);
		}

		$guides = DB::select('select * from gids');
		foreach ($guides as &$guide) {
			$guide->title = $this->locale == 'kz' ? (empty($guide->title_kz) ? $guide->title : $guide->title_kz) : $guide->title;
			$guide->text = $this->locale == 'kz' ? (empty($guide->text_kz) ? $guide->text : $guide->text_kz) : $guide->text;
			if (substr($guide->video, 0, 7) !== '<iframe') {
				$src = str_replace([ 'www.youtube.com/watch?v=', 'youtu.be/' ], 'www.youtube.com/embed/', $guide->video);
				$guide->video = $src;
			} else {
				$guide->video = preg_replace('/src=\"(\w+)\"/i', '${1}', $guide->video);
			}
		}

		$footer_pages = $this->footer_pages;
		return view('contacts', compact('guides', 'footer_pages', 'contact_pages', 'contact_stuff_pages'));
	}

	public function seminar(Request $request)
	{
		if ($request->filled('start')) {
			if (auth()->guest()) {
				return redirect(route('seminar'))->with('error', 'Войдите или зарегистрируйтесь чтобы продолжить.');
			} else if (auth()->user()->money_amount_kzt < 1000) {
				return redirect(route('seminar'))->with('error', 'Недостаточно средств, стоимость семинара 1000тг, пожалуйста пополните счет в личном кабинете.');
			}

			$fullName = auth()->user()->full_name;
			$day = Carbon::now()->format('d') . '.';
			$month = Carbon::now()->format('m') . '.';
			$year = Carbon::now()->year;
			$regNum = '№ ' . rand(100000, 999999);

			$data = new DiplomaData(
				$fullName,
				null,
				null,
				$day,
				$month,
				$year,
				$regNum,
				null
			);

			$uploads = Diploma::getPublicUploadsDir();
			$name = $uploads->generateName('png');
			$path = $uploads->getPathFor($name);
			$imageMaker = new SeminarImageMaker('diploma', 'seminar.png');
			$imageMaker->makeImage($data, $path);
			$imageMaker->close();

			DB::transaction(function () {
				User::where('id', auth()->user()->id)->update([
					'seminar' => true,
				]);

				auth()->user()->seminar = 1;
			});

			if ($request->filled('download') && auth()->user()->seminar) {
				\Response::download(public_path() . '/uploads/courses/diploma/' . $name)->send();
			}
		}


		$footer_pages = $this->footer_pages;

		return view('seminar', compact('footer_pages'));
	}
}
