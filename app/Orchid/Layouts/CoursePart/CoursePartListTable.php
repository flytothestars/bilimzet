<?php

namespace App\Orchid\Layouts\CoursePart;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Link;

class CoursePartListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_part_list';

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
            TD::make('duration_hours', 'Длительность (академических часов)'),
            TD::make('price_kzt', 'Стоимость (тенге)'),
            TD::make('action', 'Действие')->render(function ($coursePart) {
                return Group::make([
                    Link::make('Модуль')->href(route('platform.course_module.list', [
                        'courseSpeciality' => $coursePart->course->speciality_id,
                        'course' => $coursePart->course_id,
                        'coursePart' => $coursePart->id
                    ])),
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCoursePart')
                        ->method('createOrUpdateCoursePart')
                        ->modalTitle('Редактирование части курса - ' . $coursePart->name)
                        ->asyncParameters([
                            'coursePart' => $coursePart->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить категорию?')
                        ->parameters([
                            'coursePart' => $coursePart->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}