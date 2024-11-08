<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use App\Util\TextHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends PageController
{
	public function index()
	{
		$gallery = [];
		$galleryItems = DB::select('select file_url, id from gallery');
		foreach ($galleryItems as $item) {
			$gallery[] = [
				'file_url' => $item->file_url,
				'id' => $item->id,
			];
		}

		return view('admin.gallery', compact('gallery'));
	}

	public function store()
	{
		$uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/courses/";

		if (isset($_FILES["gallery_photo"])) {
			if ($_FILES["gallery_photo"]['tmp_name'] != "") {

				$bn = basename($_FILES["gallery_photo"]['name']);
				$tms = time();
				$rc = TextHelper::russain_clear($tms . "_" . $bn);

				$uploadfile1 = $uploaddir . $rc;

				if ((move_uploaded_file($_FILES["gallery_photo"]['tmp_name'], $uploadfile1))) {
					$real_file = "/uploads/courses/" . $rc;
					DB::insert('insert into gallery(file_url) values(?)', [ $real_file ]);
				}
			}
		}

		return redirect()->route('admin.gallery');
	}

	public function deletePhoto()
	{
		if (isset($_REQUEST["photo_to_delete"])) {
			DB::delete('delete from gallery where id = ?', [ $_REQUEST["photo_to_delete"] ]);
		}

		return redirect()->route('admin.gallery');
	}
}
