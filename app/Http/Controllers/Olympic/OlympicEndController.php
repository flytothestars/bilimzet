<?php

namespace App\Http\Controllers\Olympic;

use App\Data\Diploma;
use App\Data\DiplomaData;
use App\Data\Letter;
use App\Interactors\DiplomaGradeImageMaker;
use App\Interactors\DiplomaImageMaker;
use App\Interactors\LetterImageMaker;
use App\Interactors\LetterNewImageMaker;
use App\Models\Olympic\OlympicAnswer;
use App\Models\Olympic\OlympicQuestion;
use App\Models\Olympic\OlympicSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Illuminate\Support\Facades\Log;

class OlympicEndController extends Controller
{
    private $correctAnswerCount = 0;
    private $classification;

    public function index()
    {
        $token = request()->token;
        $user = Auth::user();

        $currentSession = OlympicSession::where('user_id', $user->id)->where('token', '=', $token)->first();

        if (!$currentSession) {
            return abort(404);
        }

        if (empty($currentSession->finished_at)) {
            $currentSession->update([
                'finished_at' => Carbon::now()
            ]);
        }

        $this->classification = $currentSession->course->classification;

        $duration = $currentSession->started_at->diff($currentSession->finished_at);
        $durationText = '00:' . ($duration->i < 10 ? '0' . $duration->i : $duration->i) . ':' . ($duration->s < 10 ? '0' . $duration->s : $duration->s);

        // Compare answers
        $results = [];

        if ($currentSession->results) {
            foreach ($currentSession->results as $answer) {
                $isCorrectAnswer = OlympicAnswer::isCorrectAnswer($answer['question_id'], $answer['answer_id']);
                $questionText = OlympicQuestion::where('id', $answer['question_id'])->first();
                $correctAnswerText = OlympicAnswer::where('question_id', $answer['question_id'])->where('is_right', 1)->first();
                $incorrectAnswerText = OlympicAnswer::where('id', $answer['answer_id'])->where('question_id', $answer['question_id'])->first();

                if ($isCorrectAnswer) {
                    $this->correctAnswerCount++;
                }

                $results[] = [
                    'isCorrectAnswer' => $isCorrectAnswer,
                    'questionText' => $questionText->question,
                    'correctAnswerText' => $correctAnswerText->answer,
                    'userAnswer' => $incorrectAnswerText->answer,
                ];
            }
        }

        $certificateImage = $this->makeDiploma($currentSession);
        $letterImage = $this->makeLetter($currentSession);

        $currentSession->update([
            'certificate_image' => $certificateImage ?: null,
            'letter_image' => $letterImage,
        ]);

        return response()->json([
            'letter_image' => $letterImage ? '/uploads/courses/letter/' . $letterImage : false,
            'certificate_image' => $certificateImage ? '/uploads/courses/diploma/' . $certificateImage : false,
            'results' => $results,
            'duration' => $durationText,
        ]);
    }

    private function makeDiploma(OlympicSession $currentSession)
    {
        if (!$this->getDiplomaFilename()) {
            return false;
        }

        $fullName = $currentSession->lastname . ' ' . $currentSession->name;
        $surname = $currentSession->surname ?? '';
        $courseTitle = $currentSession->course->title;
        $day = Carbon::now()->format('d') . '.';
        $month = Carbon::now()->format('m') . '.';
        $year = Carbon::now()->year;
        $regNum = rand(100000, 999999);

        $data = new DiplomaData(
            $fullName,
            $surname,
            $courseTitle,
            $day,
            $month,
            $year,
            $regNum,
            $this->correctAnswerCount
        );

        $uploads = Diploma::getPublicUploadsDir();
        $name = $uploads->generateName('png');
        $path = $uploads->getPathFor($name);
        $imageMaker = new DiplomaGradeImageMaker('diploma', $this->getDiplomaFilename());
        $imageMaker->makeImage($data, $path);
        $imageMaker->close();

        // Set number
        $currentSession->update([
            'certificate_number' => $regNum,
        ]);

        return $name;
    }

    private function makeLetter(OlympicSession $currentSession)
    {
        $fullName = $currentSession->lastname . ' ' . $currentSession->name;
        $surname = $currentSession->mentor_surname ?? '';
        $courseTitle = $currentSession->course->title;
        $day = Carbon::now()->format('d') . '.';
        $month = Carbon::now()->format('m') . '.';
        $year = Carbon::now()->year;
        $regNum = rand(100000, 999999);

        $data = new DiplomaData(
            $fullName,
            $surname,
            $courseTitle,
            $day,
            $month,
            $year,
            $regNum,
            $this->correctAnswerCount
        );



        if ($this->classification->name == 'Республиканская') {
            $letterFilename = 'new_letter.png';
        } elseif ($this->classification->name == 'Областная') {
            $letterFilename = 'new_letter_obl.png';
        }

        $uploads = Letter::getPublicUploadsDir();
        $name = $uploads->generateName('png');
        $path = $uploads->getPathFor($name);
        $imageMaker = new LetterNewImageMaker('diploma', $letterFilename);
        $imageMaker->makeImage($data, $path);
        $imageMaker->close();

        // Set number
        $currentSession->update([
            'letter_number' => $regNum,
        ]);

        return $name;
    }

    private function getDiplomaFilename()
    {
        if ($this->classification->name == 'Республиканская') {
            $firstGrade = '1_grade.png';
            $secondGrade = '2_grade.png';
            $thirdGrade = '3_grade.png';
        } elseif ($this->classification->name == 'Областная') {
            $firstGrade = '1_grade_obl.png';
            $secondGrade = '2_grade_obl.png';
            $thirdGrade = '3_grade_obl.png';
        }

        if ($this->classification->name == 'Областная') {
            if ($this->correctAnswerCount >= 22) {
                return $firstGrade;
            } elseif ($this->correctAnswerCount >= 18 && $this->correctAnswerCount <= 21) {
                return $secondGrade;
            } elseif ($this->correctAnswerCount >= 15 && $this->correctAnswerCount <= 17) {
                return $thirdGrade;
            } else {
                return false;
            }
        }

        if ($this->classification->name == 'Межрегиональная') {
            if ($this->correctAnswerCount >= 26) {
                return $firstGrade;
            } elseif ($this->correctAnswerCount >= 22 && $this->correctAnswerCount <= 25) {
                return $secondGrade;
            } elseif ($this->correctAnswerCount >= 18 && $this->correctAnswerCount <= 21) {
                return $thirdGrade;
            } else {
                return false;
            }
        }

        if ($this->classification->name == 'Республиканская') {
            if ($this->correctAnswerCount >= 34) {
                return $firstGrade;
            } elseif ($this->correctAnswerCount >= 29 && $this->correctAnswerCount <= 33) {
                return $secondGrade;
            } elseif ($this->correctAnswerCount >= 24 && $this->correctAnswerCount <= 28) {
                return $thirdGrade;
            } else {
                return false;
            }
        }
    }
}
