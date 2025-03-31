<?php

namespace App\Orchid\Layouts\CourseSpeciality;

use App\Models\CourseSpeciality;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use App\Models\Category;
use Orchid\Screen\Actions\Link;

class CourseSpecialityListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_speciality_list';

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
            TD::make('title', 'Заголовок'),
            TD::make('description', 'Описание'),
            TD::make('category', 'Категория')->render(function(CourseSpeciality $courseSpeciality){
                $category = Category::find($courseSpeciality->category);
                if($category){
                    return $category->full;
                }
            }),
            TD::make('action', 'Действие')->render(function ($courseSpeciality) {
                return Group::make([
                    Link::make('Курсы')->href(route('platform.course.list', [
                        'courseSpeciality' => $courseSpeciality->id,
                    ])),
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCourseSpeciality')
                        ->method('createOrUpdateCourseSpeciality')
                        ->modalTitle('Редактирование cпециализации ' . $courseSpeciality->title)
                        ->asyncParameters([
                            'courseSpeciality' => $courseSpeciality->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить cпециализации?')
                        ->parameters([
                            'courseSpeciality' => $courseSpeciality->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}