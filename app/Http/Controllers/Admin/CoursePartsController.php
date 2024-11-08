<?php namespace App\Http\Controllers\Admin;

use App\Course;
use App\CoursePart;
use App\CourseSpeciality;
use App\Http\Controllers\PageController;
use App\Util\TextHelper;
use App\Util\Traits\HasPagination;
use App\Util\ValidationUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursePartsController extends PageController
{
	use HasPagination;

	const STORE_RULES = [
		'duration_hours' => 'required|integer|min:1',
		'price_kzt' => 'required|integer|min:1',
		'plan' => 'required|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240'
	];

	public function index(CourseSpeciality $speciality, Course $course)
	{
		$this->onPaginationIndex();

		return view('admin.courseParts', [
			'speciality' => $speciality,
			'course' => $course,
			'items' => $course->parts
		]);
	}

	public function create(CourseSpeciality $speciality, Course $course)
	{
		$formAction = route('admin.storeCoursePart', compact('speciality', 'course'));
		$additional_files_orig = [];
		$item = null;

		return view('admin.coursePart', compact('speciality', 'course',
			'formAction', 'item', 'additional_files_orig'));
	}

	public function store(Request $request, CourseSpeciality $speciality, Course $course)
	{
		$this->validate($request, self::STORE_RULES);
		////обновляем список файлов
		$course_id = $_REQUEST["course_id"];
		$item_id = $_REQUEST["item_id"];

		require($_SERVER["DOCUMENT_ROOT"] . "/classes/classes2.php");
		//require($_SERVER["DOCUMENT_ROOT"] . "/functions/functions.php");

		$uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/courses/";

		////echo $_SERVER["DOCUMENT_ROOT"]."<br>";

		unset($additional_files);
		$additional_files = array();

		$real_names[] = array();

		$string_arr = "file";
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
				}
			}
		}

		/*
		if($_FILES['file2']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.$this->russain_clear($tms."_".basename($_FILES['file2']['name']));

						if ((move_uploaded_file($_FILES['file2']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".$this->russain_clear($tms."_".basename($_FILES['file2']['name']));
							$additional_files[]=$real_file;
						}
	   }

		if($_FILES['file3']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.$this->russain_clear($tms."_".basename($_FILES['file3']['name']));

						if ((move_uploaded_file($_FILES['file3']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".$this->russain_clear($tms."_".basename($_FILES['file3']['name']));
							$additional_files[]=$real_file;
						}
	   }

	   if($_FILES['file4']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.russain_clear($tms."_".basename($_FILES['file4']['name']));

						if ((move_uploaded_file($_FILES['file4']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".russain_clear($tms."_".basename($_FILES['file4']['name']));
							$additional_files[]=$real_file;
						}
	   }

	    if($_FILES['file5']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.russain_clear($tms."_".basename($_FILES['file5']['name']));

						if ((move_uploaded_file($_FILES['file5']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".russain_clear($tms."_".basename($_FILES['file5']['name']));
							$additional_files[]=$real_file;
						}
	   }

	   if($_FILES['file6']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.russain_clear($tms."_".basename($_FILES['file6']['name']));

						if ((move_uploaded_file($_FILES['file6']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".russain_clear($tms."_".basename($_FILES['file6']['name']));
							$additional_files[]=$real_file;
						}
	   }

	   if($_FILES['file7']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.russain_clear($tms."_".basename($_FILES['file7']['name']));

						if ((move_uploaded_file($_FILES['file7']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".russain_clear($tms."_".basename($_FILES['file7']['name']));
							$additional_files[]=$real_file;
						}
	   }

	   if($_FILES['file8']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.russain_clear($tms."_".basename($_FILES['file8']['name']));

						if ((move_uploaded_file($_FILES['file8']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".russain_clear($tms."_".basename($_FILES['file8']['name']));
							$additional_files[]=$real_file;
						}
	   }

	   if($_FILES['file9']['tmp_name']!="") {

						$tms=time();
						$uploadfile1 = $uploaddir.russain_clear($tms."_".basename($_FILES['file9']['name']));

						if ((move_uploaded_file($_FILES['file9']['tmp_name'], $uploadfile1))) {
							$real_file="/uploads/courses/".russain_clear($tms."_".basename($_FILES['file9']['name']));
							$additional_files[]=$real_file;
						}
	   }
	   */
		///обновляем эту часть -

		$db = new connect_db();
		$sql = "SET SESSION sql_mode = 'ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
		$db->dbo->exec($sql);

		$item = new CoursePart($request->all());
		$item->saveDeclaredFiles($request->files);
		$course->parts()->save($item);

		$plan_real_name = $_FILES["plan"]["name"];
		$real_names["plan"] = $plan_real_name;

		$count_files = count($additional_files);
		$additional_files = serialize($additional_files);
		$real_names = serialize($real_names);
		$additional_files = $db->dbo->quote($additional_files);
		$real_names = $db->dbo->quote($real_names);
		///var_dump($additional_files);
		if ($item_id != "") {

			///это обновление части курса, проверяем, изменились ли файлы по сравнению с текущим набором
			$sql = "SELECT additional_files,file from course_parts where id='$item_id'";
			foreach ($db->dbo->query($sql) as $row) {
				$additional_files_orig = $row[0];
				$old_file = $row[1];
			}

			if ($additional_files_orig != "") $additional_files_orig = unserialize($additional_files_orig); else $additional_files_orig = array();

			$additional_files_orig = serialize($additional_files_orig);
			$additional_files_orig = $db->dbo->quote($additional_files_orig);

			if ($additional_files_orig != $additional_files and $count_files > 0) {
				$sql = "UPDATE course_parts set additional_files=$additional_files where id='$id_item'";
				$db->dbo->exec($sql);
			}

			if ($old_file != $main_file and $main_file != "") {

				$sql = "UPDATE course_parts set file='$main_file' where id='$id_item'";
				$db->dbo->exec($sql);
			}

		} else {

			///это вставка новой записи, ищем
			$sql = "SELECT max(id) from course_parts where course_id='$course_id'";
			foreach ($db->dbo->query($sql) as $row) {
				$max_id = $row[0];
			}

			$sql = "UPDATE course_parts set additional_files=$additional_files,file='$main_file' where id='$max_id'";
			$db->dbo->exec($sql);

			/////обновление реальных имен
			$sql = "UPDATE course_parts set real_names=$real_names where id='$max_id'";

			$db->dbo->exec($sql);

		}

		////	echo $sql;

		return redirect()->route('admin.courseParts', compact('speciality', 'course'));
	}

	public function edit(Request $request, CourseSpeciality $speciality, Course $course, CoursePart $part)
	{
		$formAction = route('admin.updateCoursePart', compact('speciality', 'course', 'part'));

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

		return view('admin.coursePart', compact('speciality', 'course', 'formAction', 'item',
			'additional_files_orig', 'real_names'));
	}

	public function update(Request $request, CourseSpeciality $speciality, Course $course, CoursePart $part)
	{
		$rules = self::STORE_RULES;
		ValidationUtils::makeNullable($rules, ['plan']);
		$this->validate($request, $rules);

		$part->update($request->all());
		$part->saveDeclaredFiles($request->files);
		$part->save();

		require($_SERVER["DOCUMENT_ROOT"] . "/classes/classes2.php");
		//require($_SERVER["DOCUMENT_ROOT"] . "/functions/functions.php");

		$uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/courses/";


		$db = new connect_db();
		$sql = "SET SQL_MODE = '';";
		$db->dbo->exec($sql);


		////обновляем список файлов
		$course_id = $_REQUEST["course_id"];
		$item_id = $_REQUEST["item_id"];


		////echo $_SERVER["DOCUMENT_ROOT"]."<br>";

		unset($additional_files);
		$additional_files = array();
		$real_names[] = array();

		////подгружаем реальные имена из базы данных
		$sql = "SELECT real_names from course_parts where id='$item_id'";
		foreach ($db->dbo->query($sql) as $row) {
			$real_names = $row[0];
		}

		$real_names = unserialize($real_names);

		$plan_real_name = $_FILES["plan"]["name"];
		if ($plan_real_name != "") $real_names["plan"] = $plan_real_name;

		for ($i = 1; $i <= 80; $i++) {

			$p = $i + 1;

			$string_arr = "file_$p";

			if ($_FILES[$string_arr]['tmp_name'] != "") {

				$tms = time();
				$uploadfile1 = $uploaddir . TextHelper::russain_clear($tms . "_" . basename($_FILES[$string_arr]['name']));

				if ((move_uploaded_file($_FILES[$string_arr]['tmp_name'], $uploadfile1))) {
					$real_file = "/uploads/courses/" . TextHelper::russain_clear($tms . "_" . basename($_FILES[$string_arr]['name']));
					$additional_files[] = $real_file;
					$real_names[$real_file] = basename($_FILES[$string_arr]['name']);
				}
			}
		}

		$f = $additional_files;
		$count_arr = count($additional_files);
		$additional_files = serialize($additional_files);
		$real_names = serialize($real_names);
		$additional_files = $db->dbo->quote($additional_files);
		$real_names = $db->dbo->quote($real_names);
		///var_dump($additional_files);
		if ($item_id != "") {


			///это обновление части курса, проверяем, изменились ли файлы по сравнению с текущим набором
			$sql = "SELECT additional_files from course_parts where id='$item_id'";
			foreach ($db->dbo->query($sql) as $row) {
				$additional_files_orig = $row[0];
			}

			if ($additional_files_orig != "") $additional_files_orig = unserialize($additional_files_orig); else $additional_files_orig = array();

			$additional_files = $db->dbo->quote(serialize(array_merge($f, $additional_files_orig)));

			$additional_files_orig = serialize($additional_files_orig);
			$additional_files_orig = $db->dbo->quote($additional_files_orig);

			if ($additional_files_orig != $additional_files and $count_arr > 0) {
				$sql = "UPDATE course_parts set additional_files=$additional_files,real_names=$real_names where id='$item_id'";
				$db->dbo->exec($sql);
			}

			if ($plan_real_name != "") {

				$sql = "UPDATE course_parts set real_names=$real_names where id='$item_id'";
				$db->dbo->exec($sql);
			}

		} else {

			///это вставка новой записи, ищем
			$sql = "SELECT max(id) from course_parts";
			foreach ($db->dbo->query($sql) as $row) {
				$max_id = $row[0];
			}

			$sql = "UPDATE course_parts set additional_files=$additional_files where id='$max_id'";
			$db->dbo->exec($sql);
		}

		///echo $sql;


		return redirect()->route('admin.courseParts', compact('speciality', 'course'));
	}

	public function destroy(CourseSpeciality $speciality, Course $course, CoursePart $part)
	{
		$part->deleteWithFiles();
		return back();
	}

	public function downloadFile(CourseSpeciality $speciality, Course $course, CoursePart $part)
	{
		return response()->file($part->getPrivateUploadedPath('file'), [
			"Content-Disposition: attachment; filename=\"$part->file\""
		]);
	}
}
