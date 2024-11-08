<?php namespace App\Data;

class DiplomaData
{
	private $fullName;
	private $surname;
	private $courseName;
	private $day;
	private $month;
	private $year;
    private $correctAnswers;

	private $reg_number;


	public function __construct(
	    string $fullName,
        ?string $surname,
        ?string $courseName,
        string $day,
        string $month,
        string $year,
        string $reg_number,
        ?int $correctAnswers
    ) {

		$this->fullName = $fullName;
        $this->surname = $surname;
		$this->courseName = $courseName;
		$this->day = $day;
		$this->month = $month;
		$this->year = $year;
		$this->reg_number = $reg_number;
		$this->correctAnswers = $correctAnswers;
	}

	public function getFullName(): string
	{
		return $this->fullName;
	}

    public function getSurname(): string
    {
        return $this->surname;
    }

	public function get_reg_number(): string
	{
		return $this->reg_number;
	}

	public function getCourseName(): string
	{
		return $this->courseName;
	}

	public function getDay(): string
	{
		return $this->day;
	}

	public function getMonth(): string
	{
		return $this->month;
	}

	public function getYear(): string
	{
		return $this->year;
	}

    public function getCorrectAnswers(): int
    {
        return $this->correctAnswers;
    }
}
