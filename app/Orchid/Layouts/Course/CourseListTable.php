<?php

namespace App\Orchid\Layouts\Course;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Link;

class CourseListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_list';

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
            TD::make('title', 'Наименование RU'),
            TD::make('title_kz', 'Наименование KZ'),
            TD::make('action', 'Действие')->render(function ($course) {
                return Group::make([
                    Link::make('Части курса')->href(route('platform.course_part.list', [
                        'courseSpeciality' => $course->speciality_id,
                        'course' => $course->id,
                    ])),
                    Link::make('Тест')->href(route('platform.course_test.list', [
                        'courseSpeciality' => $course->speciality_id,
                        'course' => $course->id,
                    ])),
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCourse')
                        ->method('createOrUpdateCourse')
                        ->modalTitle('Редактирование категорию ' . $course->name)
                        ->asyncParameters([
                            'course' => $course->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить категорию?')
                        ->parameters([
                            'course' => $course->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}