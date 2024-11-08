<?php namespace App\Data;

class CertificateData
{
	private $fullName;
	private $courseName;
	private $duration;
	private $day;
	private $month;
	private $year;

	private $reg_number;
	private $sign1;
	private $sign2;

	public function __construct(string $fullName, string $courseName, string $duration,
	                            string $day, string $month, string $year, string $reg_number, string $sign1, string $sign2)
	{

		$this->fullName = $fullName;
		$this->courseName = $courseName;
		$this->duration = $duration;
		$this->day = $day;
		$this->month = $month;
		$this->year = $year;
		$this->reg_number = $reg_number;
		$this->sign1 = $sign1;
		$this->sign2 = $sign2;
	}

	public function getFullName(): string
	{
		return $this->fullName;
	}

	public function get_reg_number(): string
	{
		return $this->reg_number;
	}

	public function get_sign1(): string
	{
		return $this->sign1;
	}

	public function get_sign2(): string
	{
		return $this->sign2;
	}

	public function getCourseName(): string
	{
		return $this->courseName;
	}

	public function getDuration(): string
	{
		return $this->duration;
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
}
