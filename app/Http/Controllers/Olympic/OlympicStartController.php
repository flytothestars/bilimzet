<?php

namespace App\Http\Controllers\Olympic;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Olympic\{
    OlympicCourse,
    OlympicSession
};
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OlympicStartController extends Controller
{
    const COURSE_DURATION = 60; // in minutes

    private $footer_pages = [];

    public function __construct()
    {
        $pages = DB::select('select content from pages where page_filt = ?', ['footer']);
        foreach ($pages as $page) {
            $this->footer_pages[] = base64_decode($page->content);
        }
    }

    public function start()
    {
        $footer_pages = $this->footer_pages;
        $token = request()->token;
        $user = Auth::user();

        $currentSession = OlympicSession::where('user_id', $user->id)->where('token', '=', $token)->first();

        if (!$currentSession) {
            return abort(404);
        }

        $courseTitle = $currentSession->course->title;
        $token = request()->token;

        $finishedAt = $currentSession->started_at->addMinutes(self::COURSE_DURATION)->subSecond()->format('Y-m-d H:i:s');
        $diff = Carbon::now()->diff(Carbon::parse($finishedAt));
        $remainingMinutes = $diff->i;
        $remainingSeconds = $diff->s;

        return view('olympics.question', compact(
            'courseTitle',
            'footer_pages',
            'remainingMinutes',
            'remainingSeconds',
            'finishedAt',
            'token'
        ));
    }

    public function generateSessionToken(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        // Generate course hash for olympic session
        $token = Str::random(32);
        $user = Auth::user();

        $course = OlympicCourse::where('id', $request->course_id)->first();
        $exist = OlympicSession::where('user_id', $user->id)->where('token', '!=', '')->whereNull('finished_at')->first();

        if (!$course || $exist) {
            return response()->json([], 204);
        }

        /*if ($user->money_amount_kzt < $course->price) {
            return response()->json([
                'not_enough_money' => true
            ]);
        }*/

        $startedAt = Carbon::now();

        $session = OlympicSession::create([
            'course_id' => $request->course_id,
            'user_id' => $user->id,
            'token' => $token,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'surname' => $request->surname,
            'mentor_name' => $request->mentor_name,
            'mentor_lastname' => $request->mentor_lastname,
            'mentor_surname' => $request->mentor_surname,
            'started_at' => $startedAt,
        ]);

        /*DB::transaction(function () use ($user, $course) {
            $user->money_amount_kzt -= $course->price;
            $user->save();
        });*/

        return response()->json([
            'url' => route('olympic.start') . '?token=' . $session->token,
        ]);
    }
}
