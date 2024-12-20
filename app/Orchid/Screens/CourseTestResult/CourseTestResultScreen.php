<?php

namespace App\Orchid\Screens\CourseTestResult;

use Orchid\Screen\Screen;
use App\Orchid\Layouts\CourseTestResult\CourseTestResultScreenListTable;
use App\Models\CourseTestResult;

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
            'course_test_result_list' => CourseTestResult::paginate(10)
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
