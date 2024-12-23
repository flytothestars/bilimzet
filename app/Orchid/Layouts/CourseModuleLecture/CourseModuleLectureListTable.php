<?php

namespace App\Orchid\Layouts\CourseModuleLecture;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;

class CourseModuleLectureListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_module_lecture_list';

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
            TD::make('title', 'Заголовок RU'),
            TD::make('title_kz', 'Заголовок KZ'),
            TD::make('action', 'Действие')->render(function ($courseModuleLecture) {
                return Group::make([
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCourseModuleLecture')
                        ->method('createOrUpdateCourseModuleLecture')
                        ->modalTitle('Редактирование лекцию ' . $courseModuleLecture->title)
                        ->asyncParameters([
                            'courseModuleLecture' => $courseModuleLecture->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить лекцию?')
                        ->parameters([
                            'courseModuleLecture' => $courseModuleLecture->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}