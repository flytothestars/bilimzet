<?php

namespace App\Orchid\Layouts\CourseTestResult;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Fields\Group;

class CourseTestResultScreenListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_test_result_list';

    protected $styleButton = '
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100%;';
    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),
            TD::make('user', 'Пользователь'),
            TD::make('speciality', 'Специализация'),
            TD::make('course', 'Курс'),
            TD::make('test', 'Тест'),
            TD::make('date', 'Дата прохождения'),
            TD::make('result', 'Результат'),
            TD::make('action', 'Действие')->render(function ($courseTest) {
                return Group::make([
                    ]);
            })->width('200px'),
        ];
    }
}