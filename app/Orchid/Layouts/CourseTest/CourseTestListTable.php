<?php

namespace App\Orchid\Layouts\CourseTest;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use App\Models\CoursePart;
use App\Models\CourseTest;
use Orchid\Screen\Actions\Link;

class CourseTestListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_test_list';

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
            TD::make('title', 'Название RU'),
            TD::make('title_kz', 'Название KZ'),
            TD::make('duration_minutes', 'Время выполнения (минут)'),
            TD::make('course_part_id', 'Курс часть')->render(function(CourseTest $coursePart){
                $category = CoursePart::find($coursePart->course_part_id);
                if($category){
                    return $category->title;
                }
            }),
            TD::make('action', 'Действие')->render(function ($courseTest) {
                return Group::make([
                    Link::make('Вопросы')->href(route('platform.course_question.list', [
                        'courseSpeciality' => $courseTest->course->speciality_id,
                        'course' => $courseTest->course_id,
                        'courseTest' => $courseTest->id
                    ])),
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCourseTest')
                        ->method('createOrUpdateCourseTest')
                        ->modalTitle('Редактирование категорию ' . $courseTest->name)
                        ->asyncParameters([
                            'courseTest' => $courseTest->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить категорию?')
                        ->parameters([
                            'courseTest' => $courseTest->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}