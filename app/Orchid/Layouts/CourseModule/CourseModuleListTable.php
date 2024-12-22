<?php

namespace App\Orchid\Layouts\CourseModule;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Link;

class CourseModuleListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_module_list';

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
            TD::make('title', 'Заголовок вопроса RU'),
            TD::make('title_kz', 'Заголовок вопроса KZ'),
            TD::make('is_lecture', 'Лекция')->render(function($item){
                return $item->is_lecture === 1 ? 'Есть' : 'Нет';
            }),
            TD::make('is_video', 'Видеоуроки')->render(function($item){
                return $item->is_video === 1 ? 'Есть' : 'Нет';
            }),
            TD::make('is_present', 'Презентация')->render(function($item){
                return $item->is_present === 1 ? 'Есть' : 'Нет';
            }),

            TD::make('action', 'Действие')->render(function ($courseModule) {
                return Group::make([
                    Link::make('Лекция')->href(route('platform.course_part.list', [
                        'courseSpeciality' => $courseModule->speciality_id,
                        'courseModule' => $courseModule->id,
                    ])),
                    ModalToggle::make('Презентация')
                        ->modal('createOrEditPresent')
                        ->method('createOrEditCourseModulePresent')
                        ->modalTitle('Презентация - ' . $courseModule->title)
                        ->asyncParameters([
                            'courseModule' => $courseModule->id
                        ])
                        ->class('btn text-center rounded-2')
                        ->style($this->styleButton),
                    
                    ModalToggle::make('Видеоуроки')
                        ->modal('createOrEditVideo')
                        ->method('createOrEditCourseModuleVideo')
                        ->modalTitle('Видеоуроки - ' . $courseModule->title)
                        ->asyncParameters([
                            'courseModule' => $courseModule->id
                        ])
                        ->class('btn text-center rounded-2')
                        ->style($this->styleButton),
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCourseModule')
                        ->method('createOrUpdateCourseModule')
                        ->modalTitle('Редактирование категорию ' . $courseModule->title)
                        ->asyncParameters([
                            'courseModule' => $courseModule->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить категорию?')
                        ->parameters([
                            'courseModule' => $courseModule->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}