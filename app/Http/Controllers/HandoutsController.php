<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HandoutsController extends PageController
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
		$items = auth()->user()->purchasedCourseParts()->with('course')
			->orderBy('purchased_course_part.created_at', 'desc')->get();

		$show_details = "";
		$course_title_id = 0;
		$author_name = '';
		$author_photo = '';
		if ($request->has('show_details')) {
			$show_details = $request->show_details;
			$course_title_id = $request->course_title_id;
			$author_name = $request->author_name;
			$author_photo = $request->author_photo;
			$file_1 = $request->file_1;
		}

		$additional_files = [];
		$real_names = [];
		if (empty($show_details)) {
			foreach ($items as &$item) {

			}
		} else {
			$course_parts = DB::select('select additional_files, file, real_names from course_parts where id = ?', [ $show_details ]);
			foreach ($course_parts as $part) {
				$additional_files = $part->additional_files;
				$file = $part->file;
				$real_names = $part->real_names;
			}

			if ($additional_files != "")
				$additional_files = unserialize($additional_files);
			else
				$additional_files = [];
			if ($real_names != "")
				$real_names = unserialize($real_names);
			else
				$real_names = [];
		}

		$footer_pages = $this->footer_pages;
		return view('handouts', compact('footer_pages', 'show_details', 'items',
			'course_title_id', 'author_name', 'author_photo', 'additional_files', 'real_names'));
	}
}
