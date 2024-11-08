<?php namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\CourseTestResult;
use App\Data\CertificateData;
use App\Data\KazMonths;
use App\Http\Controllers\PageController;
use App\Interactors\CertificateImageMaker;
use App\Models\Notification;
use App\Util\Traits\HasPagination;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseTestResultsController extends PageController
{
    use HasPagination;

    public function index()
    {
        $this->onPaginationIndex();

        $items = CourseTestResult::with(['test.course.speciality', 'certificate', 'user'])
            ->orderBy('finished_at', 'desc')
            ->paginate(self::DEFAULT_PAGE_SIZE);
        return view('admin.testResults', compact('items'));
    }

    public function destroy($id)
    {
        $item = CourseTestResult::findOrFail($id);
        $item->delete();
        return back();
    }

    public function createCertificate(Request $request, $id)
    {
        $result = CourseTestResult::with('test.course')
            ->findOrFail($id);

        $now = Carbon::now();
        $durationHours = $result->test->course->parts->sum('duration_hours');

        $item = new Certificate();
        $item->title = "Сертификат о прохождении теста \"{$result->test->title}\" " .
            "курса \"{$result->test->course->title}\"";
	    $item->title_kz = "Сертификат о прохождении теста \"{$result->test->title_kz}\" " .
		    "курса \"{$result->test->course->title_kz}\"";
        $item->fio = $result->user->full_name;
	    $item->template = storage_path('uploads') . DIRECTORY_SEPARATOR . 'res.png';
        $item->course_title = $result->test->course->title;
	    $item->course_title_kz = $result->test->course->title_kz;
        $item->duration = $durationHours . ' (академиялық сағат)';
	    $item->duration_kz = $durationHours . ' (академиялық сағат)';
        $item->day = $now->format('d');
        $item->month = KazMonths::getMonthName($now);
	    $item->month_kz = KazMonths::getMonthName($now);
        $item->year = $now->format('Y');
       /// $item->reg_number = $now->format('Y');
	    $certId = 0;

        return view('admin.certificate', compact('item', 'id', 'certId' ));
    }

    public function storeCertificate(Request $request, $id)
    {
        $certificate = new Certificate();

		$reg_number=$_REQUEST["reg_number"];
		$sign1=$_REQUEST["sign1"];
		$sign2=$_REQUEST["sign2"];

        $this->_saveCertificate($certificate, $request, $id,$reg_number,$sign1,$sign2);
        Notification::createForCertificate($certificate);

       return redirect()->route('admin.previewCertificate', [
            'id' => $id,
            'certId' => $certificate->id,
        ]);
    }

    private function _saveCertificate(Certificate $certificate, Request $request, $id,$reg_number,$sign1,$sign2)
    {
        $rules = [
            'title' => 'required',
            'fio' => 'required',
            'course_title' => 'required',
            'duration' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
        ];
        $this->validate($request, $rules);

        $data = new CertificateData($request->get('fio'), $request->get('course_title'),
            $request->get('duration'), $request->get('day'),
            $request->get('month'), $request->get('year'),$reg_number,$sign1,$sign2
        );
        $result = CourseTestResult::findOrFail($id);

        $certificate->fill($request->all());
        $certificate->result_id = $id;
        $certificate->user_id = $result->user_id;

        $certificate->deleteUploaded(Certificate::getPublicUploadsDir(), 'file');
        $certificate->file = $this->makeImage($data);

        $certificate->save();
    }

    private function makeImage(CertificateData $data): string
    {
        $uploads = Certificate::getPublicUploadsDir();
        $name = $uploads->generateName('png');
        $path = $uploads->getPathFor($name);
        $imageMaker = new CertificateImageMaker();
        $imageMaker->makeImage($data, $path);
        $imageMaker->close();
        return $name;
    }

    public function editCertificate(Request $request, $id, $certId)
    {
        $item = Certificate::findOrFail($certId);
        return view('admin.certificate', compact('item', 'id', 'certId' ));
    }

    public function updateCertificate(Request $request, $id, $certId)
    {
        $certificate = Certificate::findOrFail($certId);

		$reg_number=$_REQUEST["reg_number"];
		$sign1=$_REQUEST["sign1"];
		$sign2=$_REQUEST["sign2"];

        $this->_saveCertificate($certificate, $request, $id,$reg_number,$sign1,$sign2);

        return redirect()->route('admin.previewCertificate', [
            'id' => $id,
            'certId' => $certId,
        ]);
    }

    public function previewCertificate(Request $request, $id, $certId)
    {
        $item = Certificate::findOrFail($certId);
        $formAction = route('admin.processCertificate', [
            'id' => $id,
            'certId' => $certId,
        ]);
        return view('admin.certificatePreview', [
            'item' => $item,
            'formAction' => $formAction,
        ]);
    }

    public function processCertificate(Request $request, $id, $certId)
    {
        $item = Certificate::findOrFail($certId);
        $resultsRoute = route('admin.testResults');
        $saveOpt = $request->get('_save_opt');
        if ($saveOpt === 'issue') {
            $item->is_issued = true;
            $item->save();
            return redirect($resultsRoute)->with([
                'message' => 'Сертификат был выдан'
            ]);
        }
        if ($saveOpt === 'edit') {
            return redirect()->route('admin.editCertificate', [
                'id' => $id,
                'certId' => $certId,
            ]);
        }
        if ($saveOpt === 'delete') {
            $item->deleteWithFiles();
            return redirect($resultsRoute)->with([
                'message' => 'Сертификат удалён'
            ]);
        }
        throw new \LogicException("Unknown processCertificate saveOpt: \"$saveOpt\"");
    }

}
