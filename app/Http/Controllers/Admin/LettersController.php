<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use App\Util\TextHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LettersController extends PageController
{
	public function index()
	{
		$letters = DB::select('select id, image from letters');
		return view('admin.letters', compact('letters'));
	}

	public function store()
	{
		$uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/letters/";

		if (isset($_FILES["letter_photo"])) {
			if ($_FILES["letter_photo"]['tmp_name'] != "") {

				$bn = basename($_FILES["letter_photo"]['name']);
				$tms = time();
				$rc = TextHelper::russain_clear($tms . "_" . $bn);

				$uploadfile1 = $uploaddir . $rc;

				if ((move_uploaded_file($_FILES["letter_photo"]['tmp_name'], $uploadfile1))) {
					$real_file = "/uploads/letters/" . $rc;
					DB::insert('insert into letters(image) values(?)', [ $real_file ]);
				}
			}
		}

		return redirect()->route('admin.letters');
	}

	public function deletePhoto()
	{
		if (isset($_REQUEST["photo_to_delete"])) {
			DB::delete('delete from letters where id = ?', [ $_REQUEST["photo_to_delete"] ]);
		}

		return redirect()->route('admin.letters');
	}
}
