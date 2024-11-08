<?php namespace App\Http\Controllers;

use App\Data\AcceptFiles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contest;
use App\Models\ContestFile;
use Illuminate\Validation\ValidationException;

class ProfileContestsController extends PageController
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
		$user = auth()->user();
		$contests = $user->getPurchasedContests();
		foreach ($contests as &$contest) {
			$contestFiles = ContestFile::where('user_id', $user->id)->where('contest_id', $contest->id)->get();
			if ($contestFiles->count() > 0) {
				$contest->workplace = $contestFiles[0]->workplace;
				$contest->files = explode(';', $contestFiles[0]->file);
				$contest->videos = explode(';', $contestFiles[0]->video);
			}
		}

		$footer_pages = $this->footer_pages;
		$accept = AcceptFiles::get();

		return view('myContests', compact('contests', 'accept', 'footer_pages'));
	}

	public function store(Request $request, $id)
	{
		$user = auth()->user();
		$contestFiles = ContestFile::where('user_id', $user->id)->where('contest_id', $id)->get();

		$file = $request->file('file');
		if (!$file) {
			throw ValidationException::withMessages([
				'error' => 'Выберите хотя бы один файл'
			]);
		}

		$uploads = ContestFile::getUploadsDir();

		$file = $uploads->saveUploadedFile($file);;
		$video = $request->video;
		if ($contestFiles->count() > 0) {
			$file .= (empty($file) ? '' : ';') . $contestFiles[0]->file;
			$video .= (empty($video) ? '' : ';') . $contestFiles[0]->video;
		}

		$data = [
			'user_id' => $user->id,
			'contest_id' => $id,
			'workplace' => $request->workplace,
			'file' => $file,
			'video' => $video,
			'updated_at' => Carbon::now(),
		];
		if ($contestFiles->count() > 0) {
			$contestFiles[0]->update($data);
		} else {
			ContestFile::create($data);
		}

		return redirect()->route('myContests');
	}

	public function deleteFile(Request $request, $id)
	{
		$user = auth()->user();
		$contestFiles = ContestFile::where('user_id', $user->id)->where('contest_id', $id)->get();
		if ($contestFiles->count() > 0) {
			$files = explode(';', $contestFiles[0]->file);
			$key = array_search($request->file, $files);
			if ($key !== false) {
				$uploads = ContestFile::getUploadsDir();
				$uploads->deleteFile($request->file);
				array_splice($files, $key, 1);
				$contestFiles[0]->update([ 'file' => implode(';', $files) ]);
				return back();
			}
		}

		return back();
	}

	public function deleteVideo(Request $request, $id)
	{
		$user = auth()->user();
		$contestFiles = ContestFile::where('user_id', $user->id)->where('contest_id', $id)->get();
		if ($contestFiles->count() > 0) {
			$videos = explode(';', $contestFiles[0]->video);
			$key = array_search($request->video, $videos);
			if ($key !== false) {
				array_splice($videos, $key, 1);
				$contestFiles[0]->update([ 'video' => implode(';', $videos) ]);
				return back();
			}
		}

		return back();
	}
}
