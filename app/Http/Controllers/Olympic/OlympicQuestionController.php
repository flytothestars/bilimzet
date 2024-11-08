<?php

namespace App\Http\Controllers\Olympic;

use App\Certificate;
use App\Data\CertificateData;
use App\Interactors\CertificateImageMaker;
use App\Models\Olympic\OlympicSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Routing\Controller;
use Auth;
use Illuminate\Support\Collection;

class OlympicQuestionController extends Controller
{
    public function getQuestion(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $session = OlympicSession::where('user_id', Auth::user()->id)->where('token', $request->token)->first();
        $course = $session->course;

        if (!$course || !$session) {
            return abort(404);
        }

        $questionsCourse = $course->questions;

        // If we already have answered items set next question
        if (!empty($session->results) && !isset($request->question_id)) {
            $minQuestionId = $this->getMinQuestionId($session, $questionsCourse);

            if (!$minQuestionId) {
                return response()->json([
                    'last_question' => true,
                    'token' => $session->token,
                ]);
            }

            $request['question_id'] = $minQuestionId;
        }

        if (!empty($session->finished_at)) {
            return response()->json([
                'last_question' => true,
                'token' => $session->token,
            ]);
        }

        $question = $request->filled('question_id')
            ? $course->questions()->where('id', $request->question_id)->with('answers')->first()
            : $course->questions()->with('answers')->first();

        $data = [
            'questions' => $questionsCourse,
            'currentQuestion' => $question,
            'token' => $session->token,
        ];

        return response()->json($data);
    }

    public function setAnswer(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $session = OlympicSession::where('user_id', Auth::user()->id)->where('token', $request->token)->first();
        $course = $session->course;

        if (!$course || !$session) {
            return abort(404);
        }


        $session->update([
            'results' => $request->answered
        ]);

        // Check if last question
        $sessionAfterUpdate = OlympicSession::where('user_id', Auth::user()->id)->where('token', $request->token)->first();
        $questions = $sessionAfterUpdate->course->questions;

        if (!$this->getMinQuestionId($session, $questions)) {
            $sessionAfterUpdate->update([
                'finished_at' => Carbon::now()
            ]);

            return response()->json([
                'last_question' => true,
                'token' => $sessionAfterUpdate->token,
            ]);
        }
    }

    public function getResults(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $session = OlympicSession::where('user_id', Auth::user()->id)->where('token', $request->token)->first();
        $course = $session->course;

        if (!$course || !$session) {
            return abort(404);
        }

        return response()->json($session->results);
    }

    private function getMinQuestionId(OlympicSession $session, Collection $questions)
    {
        $questionsList = array_column($session->results, 'question_id');
        $questionsListCourse = $questions->pluck('id')->toArray();

        if (count($questionsList) === count($questionsListCourse)) {
            return false;
        }

        return min(array_diff($questionsListCourse, $questionsList));
    }
}
