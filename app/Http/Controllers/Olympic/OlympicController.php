<?php

namespace App\Http\Controllers\Olympic;

use App\Models\Olympic\{
    OlympicAnswer, OlympicClassification, OlympicMember, OlympicQuestion, OlympicSubject, OlympicCourse, OlympicSession
};
use App\Traits\hasLang;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class OlympicController extends Controller
{
    use hasLang;

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
        $footer_pages = $this->footer_pages;
        $currentSession = OlympicSession::where('user_id', Auth::user()->id)->whereNull('finished_at')->first();

        return view('olympics.index', compact('footer_pages', 'currentSession'));
    }

    public function getClassificationsList(Request $request)
    {
        if ($request->ajax()) {
            $classifications = OlympicClassification::select($this->byLang('name') . ' as name', 'id')->whereNotNull($this->byLang('name'))->where('status', 1)->get();

            return response()->json($classifications);
        }
    }

    public function getMembersList(Request $request)
    {
        if ($request->ajax()) {
            $members = OlympicMember::select($this->byLang('name') . ' as name', 'id')->whereNotNull($this->byLang('name'))->where('status', 1)->get();

            return response()->json($members);
        }
    }

    public function getSubjectsList(Request $request)
    {
        if ($request->ajax()) {
            $subjects = OlympicSubject::select($this->byLang('name') . ' as name', 'id')->whereNotNull($this->byLang('name'))->where('access_for_members', 'like', '%member_id:' . $request->member_id . '%')->get();

            return response()->json($subjects);
        }
    }

    public function getCourseDetail(Request $request)
    {
        if ($request->ajax())
        {
            if (isset($request->classification_id) && isset($request->member_id) && isset($request->subject_id)) {
                try {
                    $course = isset($request->course_id) && $request->course_id > 0
                        ? OlympicCourse::withCount('questions')->where('locale', app()->getLocale())->where('id', $request->course_id)->first()
                        : OlympicCourse::withCount('questions')->where('locale', app()->getLocale())->where($request->except('course_id'))->get();

                    return response()->json($course);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'text' => 'Что-то пошло не так',
                    ]);
                }
            }

            return false;
        }
    }

    public function showResult($id)
    {
        $footer_pages = $this->footer_pages;

        $session = OlympicSession::findOrFail($id);
        $courseTitle = $session->course->title;
        $certificateImage = $session->certificate_image;
        $letterImage = $session->letter_image;

        $duration = $session->started_at->diff($session->finished_at);
        $durationText = '00:' . ($duration->i < 10 ? '0' . $duration->i : $duration->i) . ':' . ($duration->s < 10 ? '0' . $duration->s : $duration->s);

        // Compare answers
        $results = [];

        if ($session->results) {
            foreach ($session->results as $answer) {
                $isCorrectAnswer = OlympicAnswer::isCorrectAnswer($answer['question_id'], $answer['answer_id']);
                $questionText = OlympicQuestion::where('id', $answer['question_id'])->first();
                $correctAnswerText = OlympicAnswer::where('question_id', $answer['question_id'])->where('is_right', 1)->first();
                $incorrectAnswerText = OlympicAnswer::where('id', $answer['answer_id'])->where('question_id', $answer['question_id'])->first();

                $results[] = [
                    'isCorrectAnswer' => $isCorrectAnswer,
                    'questionText' => $questionText->question,
                    'correctAnswerText' => $correctAnswerText->answer,
                    'userAnswer' => $incorrectAnswerText->answer,
                ];
            }
        }

        return view('olympics.result', compact(
            'footer_pages',
            'results',
            'durationText',
            'courseTitle',
            'certificateImage',
            'letterImage',
            'id'
        ));
    }

    public function download($id)
    {
        $session = OlympicSession::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$session) {
            abort(404);
        }

        $type = request()->type ?? null;

        switch ($type) {
            case 'diploma':
                $file = public_path() . '/uploads/courses/diploma/' . $session->certificate_image;
                break;
            case 'letter':
                $file = !empty($session->letter_image) ? public_path() .'/uploads/courses/letter/' . $session->letter_image : '';
                break;
        }

        if (empty($file)) {
            abort(404);
        }

        return response()->download($file);
    }
}
