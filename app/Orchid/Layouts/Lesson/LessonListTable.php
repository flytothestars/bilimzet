<?php

namespace App\Orchid\Layouts\Lesson;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Link;
use App\Models\CourseModuleLecture;

class LessonListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'lesson_list';

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
            TD::make('is_lecture', 'Лекция')->render(function($item){
                $courseModuleLecture = CourseModuleLecture::where('lesson_id', $item->id)->count();
                if($courseModuleLecture > 0){
                    $item->update(['is_lecture' => 1]);
                } else {
                    $item->update(['is_lecture' => 0]);
                }
                return $courseModuleLecture > 0 ? 'Есть' : 'Нет';
            }),
            TD::make('is_video', 'Видеоуроки')->render(function($item){
                return $item->is_video === 1 ? 'Есть' : 'Нет';
            }),
            TD::make('is_present', 'Презентация')->render(function($item){
                return $item->is_present === 1 ? 'Есть' : 'Нет';
            }),

            TD::make('action', 'Действие')->render(function ($lesson) {
                return Group::make([
                    Link::make('Лекция')->href(route('platform.course_module_lecture.list', [
                        'courseSpeciality' => $lesson->courseModule->coursePart->course->speciality_id,
                        'course' => $lesson->courseModule->coursePart->course_id,
                        'coursePart' => $lesson->courseModule->course_part_id,
                        'courseModule' => $lesson->courseModule->id,
                        'lesson' => $lesson->id,
                    ])),
                    ModalToggle::make('Презентация')
                        ->modal('createOrEditPresent')
                        ->method('createOrEditLessonPresent')
                        ->modalTitle('Презентация - ' . $lesson->title)
                        ->asyncParameters([
                            'lesson' => $lesson->id
                        ])
                        ->class('btn text-center rounded-2')
                        ->style($this->styleButton),
                    
                    ModalToggle::make('Видеоуроки')
                        ->modal('createOrEditVideo')
                        ->method('createOrEditLessonVideo')
                        ->modalTitle('Видеоуроки - ' . $lesson->title)
                        ->asyncParameters([
                            'lesson' => $lesson->id
                        ])
                        ->class('btn text-center rounded-2')
                        ->style($this->styleButton),
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCourseLesson')
                        ->method('createOrUpdateLesson')
                        ->modalTitle('Редактирование урока ' . $lesson->title)
                        ->asyncParameters([
                            'lesson' => $lesson->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить категорию?')
                        ->parameters([
                            'lesson' => $lesson->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}