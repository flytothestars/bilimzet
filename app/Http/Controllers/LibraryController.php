<?php namespace App\Http\Controllers;

use App\Data\AcceptFiles;
use App\LibraryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use App\Util\UploadsDir\PublicUploadsDir;
use App\Util\ValidationUtils;
use Illuminate\Support\Facades\Auth;

class LibraryController extends PageController
{
	const STORE_RULES = [
		'title' => 'required|string',
		'picture' => 'file|mimes:pdf,doc,docx|max:10240',
		'text' => 'required|string',
	];

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
		$name = 'name' . ($locale == 'kz' ? '_kz' : '');
		$course_categories = DB::select('select id,training,' . $name . ' from course_categories where training = ?', [ 1 ]);
		$categories = [];
		foreach ($course_categories as $course_category) {
			$categories[] = [
				'id' => $course_category->id,
				'name' => $locale == 'kz' ? $course_category->name_kz : $course_category->name
			];
		}
		$currentCategory = $request->category ?? $course_categories[0]->id;

		$items = LibraryItem::with('author')
			->where('is_published', true)
			->where('category', $currentCategory)
			->orderBy('created_at', 'DESC')
			->get();

		$footer_pages = $this->footer_pages;
		return view('library', compact('items', 'categories', 'currentCategory', 'footer_pages'));
	}

	public function show($id)
	{
		$item = LibraryItem::findOrFail($id);
		$footer_pages = $this->footer_pages;
		$similars = LibraryItem::where('is_published', true)
			->where('category', $item->category)
			->orderBy('created_at', 'DESC')
			->get();
		return view('libraryItem', compact('item', 'similars', 'footer_pages'));
	}

	public function applyItem(Request $request)
	{
		$items = LibraryItem::where('author_id', Auth::id())->get();
		$accept = AcceptFiles::get();
		$footer_pages = $this->footer_pages;
		$categories = Lang::get('courses.categories');
		$categoryNames = array_keys($categories);
		$locale = Lang::getLocale();
		$name = 'name' . ($locale == 'kz' ? '_kz' : '');
		$categories = DB::select('select id,training,' . $name . ' from course_categories');
		foreach ($categories as &$category) {
			$category->name = ($category->training ? $categoryNames[0] : $categoryNames[1]) .
				' ' . ($locale == 'kz' ? $category->name_kz : $category->name);
		}

		return view('applyDoc', compact('items', 'categories', 'accept', 'footer_pages'));
	}

	public function doApplyItem(Request $request)
	{
		$uploads = LibraryItem::getUploadsDir();
		$file = $request->file('document');

		$this->validate($request, self::STORE_RULES);
		$file = $request->file('document');
		if (!$file) {
			throw ValidationException::withMessages([
				'error' => 'Выберите хотя бы один файл'
			]);
		}

//        if(count($file) > 5) {
//            throw ValidationException::withMessages([
//                'error' => 'Файлов должно быть не больше 5'
//            ]);
//        }
//
		$item = new LibraryItem();
		$item->title = $request['title'];
		$item->title_kz = $request['title_kz'];
		$item->document_extension = '';
		$item->category = $request['category'];
		$item->text = $request['text'];
		$item->text_kz = $request['text_kz'];
		$item->document_extension = $file->getClientOriginalExtension();
		$item->document = $uploads->saveUploadedFile($file);
		auth()->user()->libraryItems()->save($item);

		return back()->with('message', 'Файлы были загружены. Они появятся в библиотеке после прохождения модерации.');
	}
}
