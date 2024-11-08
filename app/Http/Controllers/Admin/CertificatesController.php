<?php namespace App\Http\Controllers\Admin;

use App\Models\Contest;
use App\Certificate;
use App\Models\ContestCategory;
use App\Models\ContestCertificate;
use App\Http\Controllers\PageController;
use App\Util\Traits\HasPagination;
use App\Util\ValidationUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Util\UploadsDir\PublicUploadsDir;

class CertificatesController extends PageController
{
	use HasPagination;

	public function index()
	{
		$items = Certificate::paginate(self::DEFAULT_PAGE_SIZE);
		return view('admin.certificates', compact('items'));
	}

	public function updateCertificate(Request $request, Contest $contest)
	{

	}

//	public function certificate(Request $request, Contest $contest)
//	{
//		$certificates = $contest->certificate();
//		return view('admin.certificateContest', [
//			'contest' => $contest,
//			'certificates' => $certificates,
//			'formAction' => route('admin.updateCertificateContest', ['contest' => $contest])
//		]);
//	}

	public function destroy($id)
	{
		$item = Certificate::findOrFail($id);
		$item->deleteWithFiles();
		return back();
	}

//	public function update(Request $request, Contest $contest)
//	{
//		$uploads = ContestCertificate::getUploadsDir();
//		foreach ($request['id'] as $key => $id) {
//			if ($certificates = ContestCertificate::find($id)) {
//				$file = $request->file('picture' . $id);
//				if ($file) {
//					$certificates->deleteUploaded($uploads, $fieldName);
//					$certificates->file = $uploads->saveUploadedFile($file);
//				}
//				$certificates->name = $request['list'][$key];
//				$certificates->text = $request['tab'][$key];
//				$certificates->id_contest = $contest->id;
//				$certificates->save();
//			} else {
//				$certificates = new ContestCertificate();
//				$file = $request->file('picture' . $id);
//				if ($file) {
//					$certificates->file = $uploads->saveUploadedFile($file);
//				}
//				$certificates->name = $request['list'][$key];
//				$certificates->text = $request['tab'][$key];
//				$certificates->id_contest = $contest->id;
//				$certificates->save();
//			}
//		}
//		return redirect()->route('admin.contestsCertificate', compact('contest'));
//	}
}
