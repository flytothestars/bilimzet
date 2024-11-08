<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class NotificationsController extends PageController
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
		$items = auth()->user()->notifications()->orderBy('created_at', 'desc')->limit(20)->get();
		$footer_pages = $this->footer_pages;
		return view('notifications', compact('items', 'footer_pages'));
	}
}
