<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditController extends PageController
{
	public function index()
	{
		$page_filt = "footer";
		if (isset($_REQUEST["page_filt"])) {
			$page_filt = $_REQUEST["page_filt"];
		}

		$content = "";
		$content_kz = "";
		$contentItems = DB::select('select content,content_kz from pages where page_filt = ?', [ $page_filt ]);
		foreach ($contentItems as $item) {
			$content = base64_decode($item->content);
			$content_kz = base64_decode($item->content_kz);
		}

		return view('admin.edit', compact('content', 'content_kz', 'page_filt'));
	}

	public function store()
	{
		if (isset($_REQUEST["pages_text"])) {
			$page_filt = $_REQUEST["page_filt"];
			$pages_text = base64_encode($_REQUEST["pages_text"]);
			$pages_text_kz = base64_encode($_REQUEST["pages_text_kz"]);

			DB::update('update pages set content = ?, content_kz = ? where page_filt = ?', [ $pages_text, $pages_text_kz, $page_filt ]);
		}

		return redirect()->route('admin.edit')->with('message', 'Данные страницы обновлены!');;
	}
}
