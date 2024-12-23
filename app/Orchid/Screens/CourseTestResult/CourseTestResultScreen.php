<?php

namespace App\Orchid\Screens\CourseTestResult;

use Orchid\Screen\Screen;
use App\Orchid\Layouts\CourseTestResult\CourseTestResultScreenListTable;
use App\Models\CourseTestResult;
use App\Models\User;

class CourseTestResultScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'course_test_result_list' => CourseTestResult::get()->map(function($result){
                $result->user = $result->user->full_name;
                $result->speciality = $result->coursePart->course->speciality->title;
                $result->course = $result->coursePart->course->title;
                $result->test = $result->coursePart->courseTest[0]->title;
                $result->date = $result->created_at;
                $result->result = $result->total_correct_question . '/' . $result->total_question;
                return $result;
            })
            
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Результаты';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CourseTestResultScreenListTable::class
        ];
    }
}
