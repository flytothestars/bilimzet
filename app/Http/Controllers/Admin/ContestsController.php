<?php namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\Data\CertificateData;
use App\Data\KazMonths;
use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestCategory;
use App\Models\ContestCertificate;
use App\Models\ContestFile;
use App\Models\ContestPart;
//use App\CourseSpeciality;
use App\Interactors\CertificateImageMaker;
use App\Http\Controllers\PageController;
use App\Models\Notification;
use App\Util\TextHelper;
use App\Util\Traits\HasPagination;
use App\Util\ValidationUtils;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContestsController extends PageController
{
	use HasPagination;

	const STORE_RULES = [
		'title' => 'required|string',
		'picture' => 'image|dimensions:max_height=1000,max_width=1000|max:2048',
		'desc_text' => 'required|string|min:7',
		'text_on_picture' => 'string|min:7',
	];

	const STORE_PARTS_RULES = [
		'duration_hours' => 'required|integer|min:1',
		'price_kzt' => 'required|integer|min:1',
		'plan' => 'required|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240'
	];

	public function index(Request $request)
	{
		$this->onPaginationIndex();
		$items = Contest::orderBy('updated_at', 'DESC')->paginate(self::DEFAULT_PAGE_SIZE);
		return view('admin.contests', compact('items'));
	}

	public function showItem(Request $request)
	{
		$this->onPaginationIndex();
		$items = Contest::orderBy('title')->paginate(self::DEFAULT_PAGE_SIZE);
		return view('admin.contest', compact('items'));
	}

	public function store(Request $request)
	{
		$this->validate($request, self::STORE_RULES);

		$item = new Contest($request->all());
		$item->saveDeclaredFiles($request->files);
		$item->save();

		return $this->_onSave($request, $item);
	}

	private function _onSave(Request $request, Contest $contest): RedirectResponse
	{
		$saveOpt = $request->get('_save_opt');

		if ($saveOpt === 'save_part') {
			return redirect()->route('admin.contests');
		}
		if ($saveOpt === 'add_part') {
			return redirect()->route('admin.editContest', compact('contest'));
		}

		throw new \LogicException("Unknown saveOpt: $saveOpt");
	}

	public function create()
	{
		return view('admin.contest', [
			'item' => null,
			'categories' => ContestCategory::all(),
			'formAction' => route('admin.storeContest')
		]);
	}

	public function edit(Request $request, Contest $contest)
	{
		$formAction = route('admin.updateContest', [ 'contest' => $contest ] );
		$partsRoute = route('admin.contestParts', [ 'contest' => $contest ] );
		$categories = ContestCategory::all();
		$item = TextHelper::esc( $contest, [ 'desc_text', 'text_on_picture' ] );

		$data = compact('formAction', 'partsRoute', 'categories', 'contest', 'item');

		return view('admin.contest', $data);
	}

	public function update(Request $request, Contest $contest)
	{
		$rules = self::STORE_RULES;
		$this->validate($request, $rules);

		$contest->fill($request->all());
		$contest->saveDeclaredFiles($request->files);
		$contest = TextHelper::unesc( $contest, [ 'desc_text', 'text_on_picture' ] );
		$contest->save();

		return $this->_onSave($request, $contest);
	}

	public function destroy(Contest $contest)
	{
		$contest->deleteWithFiles();
		return back();
	}



	public function parts(Contest $contest)
	{
		$this->onPaginationIndex();
		$items = $contest->parts;
		return view('admin.contestParts', compact('contest','items' ));
	}

	public function createPart(Contest $contest)
	{
		$formAction = route('admin.storeContestPart', compact('contest'));
		$additional_files_orig = [];
		$item = null;

		return view('admin.contestPart', compact('contest', 'formAction', 'item', 'additional_files_orig'));
	}

	public function storePart(Request $request, Contest $contest)
	{
		$this->validate($request, self::STORE_PARTS_RULES);
		////обновляем список файлов
		//$course_id = $_REQUEST["course_id"];
		//$item_id = $_REQUEST["item_id"];

		//require($_SERVER["DOCUMENT_ROOT"] . "/classes/classes2.php");
		//require($_SERVER["DOCUMENT_ROOT"] . "/functions/functions.php");

		$uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/contests/";

		////echo $_SERVER["DOCUMENT_ROOT"]."<br>";

		unset($additional_files);
		$additional_files = [];

		//$real_names[] = array();

		//$string_arr = "file";
		/*
		if($_FILES[$string_arr]['tmp_name']!="") {

							$tms=time();
							$uploadfile1 = $uploaddir.$this->russain_clear($tms."_".basename($_FILES[$string_arr]['name']));

							if ((move_uploaded_file($_FILES[$string_arr]['tmp_name'], $uploadfile1))) {
								$real_file="/uploads/courses/".$this->russain_clear($tms."_".basename($_FILES[$string_arr]['name']));
								$main_file=$real_file;
							}
		   }
		*/
		$main_file = "";
		for ($i = 1; $i <= 80; $i++) {

			$p = $i + 1;

			$string_arr = "file$p";

			if (isset($_FILES[$string_arr]) && $_FILES[$string_arr]['tmp_name'] != "") {

				$tms = time();
				$uploadfile1 = $uploaddir . TextHelper::russain_clear($tms . "_" . basename($_FILES[$string_arr]['name']));

				if ((move_uploaded_file($_FILES[$string_arr]['tmp_name'], $uploadfile1))) {
					$real_file = "/uploads/courses/" . TextHelper::russain_clear($tms . "_" . basename($_FILES[$string_arr]['name']));
					$additional_files[] = $real_file;
					$real_names[$real_file] = basename($_FILES[$string_arr]['name']);
					$main_file = $real_file;
				}
			}
		}

		///обновляем эту часть -

//		$db = new connect_db();
//		$sql = "SET SESSION sql_mode = 'ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
//		$db->dbo->exec($sql);

		$item = new ContestPart($request->all());
		$item->saveDeclaredFiles($request->files);
		$contest->parts()->save($item);

		$plan_real_name = $_FILES["plan"]["name"];
		$real_names["plan"] = $plan_real_name;

		$count_files = count($additional_files);
		$additional_files = serialize($additional_files);
		$real_names = serialize($real_names);
		$additional_files = "'" . addslashes($additional_files) . "'";
		$real_names = "'" . addslashes($real_names) . "'";
		///var_dump($additional_files);
		//if ($item_id != "") {

		$additional_files_orig = $item->additional_files;
		$old_file = $item->file;
//			///это обновление части курса, проверяем, изменились ли файлы по сравнению с текущим набором
//			$sql = "SELECT additional_files,file from contest_parts where id='$item_id'";
//			foreach ($db->dbo->query($sql) as $row) {
//				$additional_files_orig = $row[0];
//				$old_file = $row[1];
//			}

			if ($additional_files_orig != "") $additional_files_orig = unserialize($additional_files_orig); else $additional_files_orig = array();

			$additional_files_orig = serialize($additional_files_orig);
			$additional_files_orig = "'" . addslashes($additional_files_orig) . "'";

			if ($additional_files_orig != $additional_files and $count_files > 0) {
				$item->additional_files = $additional_files;
				$item->save();
//				$sql = "UPDATE contest_parts set additional_files=$additional_files where id='$id_item'";
//				$db->dbo->exec($sql);
			}

			if ($old_file != $main_file and $main_file != "") {
				$item->file = $main_file;
				$item->save();
//				$sql = "UPDATE contest_parts set file='$main_file' where id='$id_item'";
//				$db->dbo->exec($sql);
			}

//		} else {
//
//			///это вставка новой записи, ищем
//			$sql = "SELECT max(id) from contest_parts where course_id='$course_id'";
//			foreach ($db->dbo->query($sql) as $row) {
//				$max_id = $row[0];
//			}
//
//			$sql = "UPDATE contest_parts set additional_files=$additional_files,file='$main_file' where id='$max_id'";
//			$db->dbo->exec($sql);
//
//			/////обновление реальных имен
//			$sql = "UPDATE contest_parts set real_names=$real_names where id='$max_id'";
//
//			$db->dbo->exec($sql);
//
//		}

		////	echo $sql;

		return redirect()->route('admin.contestParts', compact('contest'));
	}

	public function editPart(Request $request, Contest $contest, ContestPart $part)
	{
		$formAction = route('admin.updateContestPart', compact('contest', 'part'));

		$item = $part;
		$additional_files_orig = [];
		$real_names = [];

		if (isset($item->id)) {
			$course_parts = DB::select('select additional_files, real_names from course_parts where id = ?', [ $item->id ]);
			foreach ($course_parts as $course_part) {
				$additional_files_orig = unserialize($course_part->additional_files);
				$real_names = unserialize($course_part->real_names);
			}
		}

		return view('admin.contestPart', compact('contest', 'formAction', 'item',
			'additional_files_orig', 'real_names'));
	}

	public function updatePart(Request $request, Contest $contest, ContestPart $part)
	{
		$rules = self::STORE_PARTS_RULES;
		ValidationUtils::makeNullable($rules, ['plan']);
		$this->validate($request, $rules);

		$part->update($request->all());
		$part->saveDeclaredFiles($request->files);
		$part->save();

		//require($_SERVER["DOCUMENT_ROOT"] . "/classes/classes2.php");
		//require($_SERVER["DOCUMENT_ROOT"] . "/functions/functions.php");

		$uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/contests/";


		//$db = new connect_db();
		//$sql = "SET SQL_MODE = '';";
		//$db->dbo->exec($sql);


		////обновляем список файлов
		//$course_id = $_REQUEST["course_id"];
		//$item_id = $_REQUEST["item_id"];


		////echo $_SERVER["DOCUMENT_ROOT"]."<br>";

		unset($additional_files);
		$additional_files = [];
		//$real_names[] = array();

		$real_names = unserialize($part->real_names);

		////подгружаем реальные имена из базы данных
//		$sql = "SELECT real_names from contest_parts where id='$item_id'";
//		foreach ($db->dbo->query($sql) as $row) {
//			$real_names = $row[0];
//		}

		//$real_names = unserialize($real_names);

		$plan_real_name = $_FILES["plan"]["name"];
		if ($plan_real_name != "") $real_names["plan"] = $plan_real_name;

		for ($i = 1; $i <= 80; $i++) {

			$p = $i + 1;

			$string_arr = "file$p";

			if (isset($_FILES[$string_arr]) && $_FILES[$string_arr]['tmp_name'] != "") {

				$tms = time();
				$uploadfile1 = $uploaddir . TextHelper::russain_clear($tms . "_" . basename($_FILES[$string_arr]['name']));

				if ((move_uploaded_file($_FILES[$string_arr]['tmp_name'], $uploadfile1))) {
					$real_file = "/uploads/contests/" . TextHelper::russain_clear($tms . "_" . basename($_FILES[$string_arr]['name']));
					$additional_files[] = $real_file;
					$real_names[$real_file] = basename($_FILES[$string_arr]['name']);
				}
			}
		}

		$count_arr = count($additional_files);
		$additional_files = serialize($additional_files);
		$real_names = serialize($real_names);
		$additional_files = "'" . addslashes($additional_files) . "'";
		$real_names = "'" . addslashes($real_names) . "'";
		///var_dump($additional_files);
		//if ($item_id != "") {


		$additional_files_orig = $part->additional_files;
//			///это обновление части курса, проверяем, изменились ли файлы по сравнению с текущим набором
//			$sql = "SELECT additional_files from contest_parts where id='$item_id'";
//			foreach ($db->dbo->query($sql) as $row) {
//				$additional_files_orig = $row[0];
//			}

			if ($additional_files_orig != "") $additional_files_orig = unserialize($additional_files_orig); else $additional_files_orig = array();

			$additional_files_orig = serialize($additional_files_orig);
			$additional_files_orig = "'" . addslashes($additional_files_orig) . "'";

			if ($additional_files_orig != $additional_files and $count_arr > 0) {
				$part->additional_files = $additional_files;
				$part->real_names = $real_names;
				$part->save();
//				$sql = "UPDATE contest_parts set additional_files=$additional_files,real_names=$real_names where id='$item_id'";
//				$db->dbo->exec($sql);
			}

			if ($plan_real_name != "") {
				$part->real_names = $real_names;
				$part->save();
//				$sql = "UPDATE contest_parts set real_names=$real_names where id='$item_id'";
//				$db->dbo->exec($sql);
			}

//		} else {

//			///это вставка новой записи, ищем
//			$sql = "SELECT max(id) from course_parts";
//			foreach ($db->dbo->query($sql) as $row) {
//				$max_id = $row[0];
//			}
//
//			$sql = "UPDATE contest_parts set additional_files=$additional_files where id='$max_id'";
//			$db->dbo->exec($sql);
//		}

		///echo $sql;

		return redirect()->route('admin.contestParts', compact('contest'));
	}

	public function destroyPart(Contest $contest, ContestPart $part)
	{
		$part->deleteWithFiles();
		return back();
	}

	public function downloadFilePart(Contest $contest, ContestPart $part)
	{
		$contentDisposition = 'Content-Disposition: attachment; filename="' . $part->file . '"';
		return response()->file($part->getPrivateUploadedPath('file'), [ $contentDisposition ]);
	}

	public function files(Request $request)
	{
		$this->onPaginationIndex();
		$items = ContestFile::orderBy('updated_at', 'DESC')->paginate(self::DEFAULT_PAGE_SIZE);
		foreach ($items as &$item) {
			$award = ContestAward::where('user_id', $item->user_id)->where('contest_id', $item->contest_id)->get();
			$item->award = count($award) ? $award[0] : null;
		}
		return view('admin.contestFiles', compact('items'));
	}

	public function destroyFile(ContestFile $contestFile)
	{
		$contestFile->deleteWithFiles();
		return back();
	}


	public function certificates(Request $request, Contest $contest)
	{
		$this->onPaginationIndex();
		$items = ContestFile::orderBy('updated_at', 'DESC')->paginate(self::DEFAULT_PAGE_SIZE);
		$certificates = $contest->certificates;
		$formAction = route('admin.updateCertificateContest', ['contest' => $contest]);

		return view('admin.certificateContest', compact('contest', 'certificates', 'formAction', 'items'));
	}

	public function destroyCertificate($id)
	{
		$item = ContestCertificate::findOrFail($id);
		$item->deleteWithFiles();
		return back();
	}

	public function updateCertificates(Request $request, Contest $contest)
	{
		$uploads = ContestCertificate::getPublicUploadsDir();
		foreach ($request['id'] as $key => $id) {
			if ($certificates = ContestCertificate::find($id)) {
				$file = $request->file('picture' . $id);
				if ($file) {
					$certificates->deleteUploaded($uploads, $certificates->file);
					$certificates->file = $uploads->saveUploadedFile($file);
				}
				$certificates->title = $request['list'][$key];
				$certificates->text = $request['tab'][$key];
				$certificates->contest_id = $contest->id;
				$certificates->save();
			} else {
				$certificates = new ContestCertificate();
				$file = $request->file('picture' . $id);
				if ($file) {
					$certificates->file = $uploads->saveUploadedFile($file);
				}
				$certificates->title = $request['list'][$key];
				$certificates->text = $request['tab'][$key];
				$certificates->contest_id = $contest->id;
				$certificates->save();
			}
		}
		return back();
	}

	public function createAward(Request $request, ContestFile $contestFile)
	{
		$certificates = ContestCertificate::where('contest_id', $contestFile->contest->id)->get();

		return view('admin.createAward', compact('contestFile', 'certificates' ));
	}

	public function storeAward(Request $request, ContestFile $contestFile)
	{
		$contest = $contestFile->contest;

		$awards = ContestAward::where('contest_id', $contest->id)->get();
		if (count($awards)) $awards->delete();

		$award = new ContestAward();
		$award->user_id = $contestFile->user_id;
		$award->contest_id = $contest->id;
		$award->certificate_id = $request->certificate_id;
		$award->save();

		return redirect()->route('admin.previewAward', compact('contestFile', 'award'));
	}

	public function previewAward(Request $request, ContestFile $contestFile, ContestAward $award)
	{
		return view('admin.previewAward', compact('contestFile', 'award'));
	}

	public function deleteAward(Request $request, ContestFile $contestFile, ContestAward $award)
	{
		$award->delete();
		return redirect()->route('admin.contestFiles')->with([ 'message' => 'Награда удалена' ]);
	}

}
