<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class CertificatesController extends Controller
{
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
		$items = auth()->user()->certificates()
			->where('is_issued', true)
			->orderBy('created_at', 'desc')
			->get();

		$footer_pages = $this->footer_pages;
		return view('certificates', compact('items', 'footer_pages'));
	}
}
