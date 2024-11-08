<?php namespace App\Http\Controllers;

use App\CourseTest;
use App\CourseTestResult;
use App\Data\RunningTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseTestsController extends PageController
{
	const RUNNING_TEST_KEY = 'running_test';

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
		$courses = $user->getPurchasedCoursesWithTests();
		$footer_pages = $this->footer_pages;

		foreach ($courses as $course) {
			foreach ($course->tests as &$test) {
				// получение ифнормации о тесте
				$test->correct_answers = 0;
				$test->total_answers = 0;
				$result_id = 0;
				$test->is_test = false;
				$course_test_results = DB::select('select correct_answers,total_answers,id from course_test_results where course_test_id = ? and user_id = ?', [ $test->id, $user->id ]);
				foreach ($course_test_results as $result) {
					$test->correct_answers = $result->correct_answers;
					$test->total_answers = $result->total_answers;
					if ($test->total_answers > 0) $test->is_test = true;
					$result_id = $result->id;
				}

				// получен ли сертификат
				$test->certificateId = "";
				$test->no_cert = false;
				$certificates = DB::select('select id from certificates where result_id = ? and user_id = ?', [ $result_id, $user->id ]);
				foreach ($certificates as $certificate){
					$test->certificateId = $certificate->id;
					if ($test->certificateId == 0) $test->no_cert = true;
				}
				if ($test->total_answers == 0) $test->no_cert = true;
			}
		}

		return view('myTests', compact('courses', 'footer_pages'));
	}

	private function getRunningTest()
	{
		$runningTestData = session(self::RUNNING_TEST_KEY);
		return new RunningTest($runningTestData);
	}

	private function setRunningTest(RunningTest $runningTest)
	{
		session([ self::RUNNING_TEST_KEY => $runningTest->getData() ]);
	}

	private function removeRunningTest()
	{
		session([ self::RUNNING_TEST_KEY => null ]);
	}

	public function view(Request $request, $id)
	{
		$id = intval($id);
		///$this->removeRunningTest();
		$runningTest = $this->getRunningTest();
		$test = $this->verifyAndGetTest($id);

		if ($runningTest->getId() !== $id || $runningTest->isExpired()) {
			$this->removeRunningTest();
			$runningTest = RunningTest::create($test);
		}

		if ($runningTest->isDone()) {
			return redirect()->route('doneTest', compact('id'));
		}

		if ($runningTest->isExpired()) {
			return $this->timeoutResponse($id);
		}

		$questionN = $runningTest->getQuestionN();
		$progressPercent = intval($runningTest->getProgressInPercents());
		$question = $test->questions[$questionN];
		$questionNumberPretty = $runningTest->getPrettyQuestionNumber();
		$questionTextPretty = ($questionN + 1) . '. ' . $question->title;

		$this->setRunningTest($runningTest);
		$footer_pages = $this->footer_pages;
		return view('test', [
			'endTime' => $runningTest->getEndTime()->getTimestamp() * 1000,
			'test' => $test,
			'progressPercent' => $progressPercent,
			'question' => $question,
			'questionNumberPretty' => $questionNumberPretty,
			'questionTextPretty' => $questionTextPretty,
			'answers' => $this->makeAnswers($question),
			'footer_pages' => $footer_pages
		]);
	}

	private function verifyAndGetTest($id): CourseTest
	{
		$user = auth()->user();
		$courses = $user->getPurchasedCoursesWithTests();
		$test = $this->findTest($courses, $id);
		if (!$test) {
			abort(404);
		}
		return $test;
	}

	private function findTest($courses, $testId): ?CourseTest
	{
		foreach ($courses as $course) {
			foreach ($course->tests as $test) {
				if ($test->id === intval($testId)) {
					return $test;
				}
			}
		}
		return null;
	}

	private function makeAnswers($question)
	{
		$answers = $question->incorrect_answers;
		$answers[] = $question->correct_answer;
		shuffle($answers);

		$res = [];
		foreach (['a', 'b', 'c', 'd'] as $key => $letter) {
			$item = new \stdClass();
			$item->className = $letter;
			$item->letter = mb_strtoupper($letter);
			$item->title = $answers[$key];
			$res[] = $item;
		}
		return $res;
	}

	public function step(Request $request, $id)
	{
		$id = intval($id);
		$runningTest = $this->getRunningTest();
		if ($runningTest->getId() !== $id) {
			return redirect()->route('viewTest', ['id' => $id]);
		}
		$test = $this->verifyAndGetTest($id);

		if ($runningTest->isExpired()) {
			return $this->timeoutResponse($id);
		}

		$question = $test->questions[$runningTest->getQuestionN()];
		$answerIsCorrect = $request->get('answer') === $question->correct_answer;
		$runningTest->addAnswer($answerIsCorrect);

		$this->setRunningTest($runningTest);

		if ($runningTest->isDone()) {
			return redirect()->route('doneTest', compact('id'));
		}

		return redirect()->route('viewTest', compact('id'));
	}

	public function done(Request $request, $id)
	{
		$id = intval($id);
		$runningTest = $this->getRunningTest();
		$test = $this->verifyAndGetTest($id);

		if ($runningTest->getId() !== $id || $runningTest->isExpired()) {
			$this->removeRunningTest();
			$runningTest = RunningTest::create($test);
		}

		if (!$runningTest->isDone()) {
			return redirect()->route('viewTest', compact('id'));
		}

		CourseTestResult::createFrom($runningTest);

		$this->removeRunningTest();
		$footer_pages = $this->footer_pages;
		return view('testDoneThanks', [
			'item' => $test,
			'correctAnswers' => $runningTest->getCorrectAnswers(),
			'totalAnswers' => $runningTest->getQuestionsTotal(),
			'footer_pages' => $footer_pages
		]);
	}

	public function timeout(Request $request, $id)
	{
		$id = intval($id);
		$runningTest = $this->getRunningTest();
		if ($runningTest->getId() !== $id) {
			return redirect()->route('viewTest', ['id' => $id]);
		}
		$this->verifyAndGetTest($id);
		$this->removeRunningTest();

		return $this->timeoutResponse($id);
	}

	private function timeoutResponse($id)
	{
		return redirect()
			->route('viewTest', compact('id'))
			->with('errorMessage', 'Время вышло. Начинайте сначала.');
	}
}
