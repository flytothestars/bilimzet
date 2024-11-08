<?php namespace App\Data;

use App\CourseTest;
use Carbon\Carbon;

class RunningTest
{
	private $data;

	public function __construct($data)
	{
		$this->data = $data;
	}

	public static function create(CourseTest $courseTest)
	{
		$endTime = Carbon::now()
			->addMinutes($courseTest->duration_minutes - 6.20)->toIso8601String();;

		///$endTime=$endTime-380;
		///$endTime=time()+$courseTest->duration_in_minutes*60;

		////	throw new \LogicException(var_dump( $courseTest->duration_minutes));

		$data = [
			'_runningTestData' => true,
			'id' => $courseTest->id,
			'questionsTotal' => $courseTest->questions->count(),
			'endTime' => $endTime,
			'questionN' => 0,
			'correctAnswers' => 0,
			'incorrectAnswers' => 0,
		];

		if ($data['questionN'] >= $data['questionsTotal']) {
			$data['finishedTime'] = Carbon::now()->toIso8601String();
		}

///var_dump($data);
		return new RunningTest($data);
	}

	public function addAnswer($isCorrect)
	{
		if (!$this->data)
			return;

		$this->data['questionN']++;
		if ($isCorrect) {
			$this->data['correctAnswers']++;
		} else {
			$this->data['incorrectAnswers']++;
		}
		if ($this->isDone()) {
			$this->data['finishedTime'] = Carbon::now()->toIso8601String();
		}
	}

	public function getProgressInPercents()
	{
		return ($this->getQuestionN() + 1) / $this->getQuestionsTotal() * 100;
	}

	public function getQuestionN()
	{
		return $this->data['questionN'] ?? null;
	}

	public function getQuestionsTotal()
	{
		return $this->data['questionsTotal'] ?? null;
	}

	public function getPrettyQuestionNumber()
	{
		return sprintf('%02d / %02d',
			$this->getQuestionN() + 1, $this->getQuestionsTotal());
	}

	public function isDone()
	{
		if (!$this->data)
			return false;
		return $this->data['questionN'] >= $this->data['questionsTotal'];
	}

	public function isPresent()
	{
		return ($this->data['_runningTestData'] ?? false) === true;
	}

	public function getId()
	{
		if (!$this->data)
			return null;
		return $this->data['id'] ?? null;
	}

	public function getEndTime()
	{
		//if (empty($this->data['endTime'])) {
		//  throw new \LogicException("endTime is empty");
		// }

		// throw new \LogicException("endTime is ".($this->data['endTime']*1-time()));

		return Carbon::parse($this->data['endTime']);
	}

	public function getFinishedTime()
	{
		if (empty($this->data['finishedTime'])) {
			throw new \LogicException("finishedTime is empty");
		}

		return Carbon::parse($this->data['finishedTime']);
	}

	public function isExpired()
	{
		return false;
		return Carbon::now()
			->greaterThanOrEqualTo($this->getEndTime());
	}

	public function getCorrectAnswers()
	{
		return $this->data['correctAnswers'] ?? null;
	}

	public function getIncorrectAnswers()
	{
		return $this->data['incorrectAnswers'] ?? null;
	}

	public function getData()
	{
		return $this->data;
	}
}
