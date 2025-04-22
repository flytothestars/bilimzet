<?php

namespace App\Orchid\Layouts\CourseComment;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Link;
use App\Models\Course;
use App\Models\CoursePart;
use App\Models\User;
use App\Models\CommentCourse;
use Orchid\Support\Color;

class CourseCommentListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'course_comment_list';

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
            TD::make('comment', 'Коммент'),
            // TD::make('course_id', 'Курс')->render(function(CommentCourse $сommentCourse){
            //     $course = Course::find($сommentCourse->course_id);
            //     if($course){
            //         return $course->title;
            //     }
            // }),
            // TD::make('part_id', 'Часть')->render(function(CommentCourse $сommentCourse){
            //     $part = CoursePart::find($сommentCourse->part_id);
            //     if($part){
            //         return $part->title;
            //     }
            // }),
            TD::make('user_id', 'Пользователь')->render(function(CommentCourse $сommentCourse){
                $user = User::find($сommentCourse->user_id);
                if($user){
                    return $user->full_name;
                }
            }),
            
            TD::make('action', 'Действие')->render(function ($сommentCourse) {
                return Group::make([
                    // Button::make('Скрыть')
                    //     ->method('hideComment')
                    //     ->parameters([
                    //         'сommentCourse' => $сommentCourse->id,
                    //     ])
                    //     ->type(Color::SUCCESS)
                    //     ->style($this->styleButton),
                    // Button::make('Показать')
                    //     ->method('showComment')
                    //     ->parameters([
                    //         'сommentCourse' => $сommentCourse->id,
                    //     ])
                    //     ->type(Color::DANGER)
                    //     ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить модуля?')
                        ->parameters([
                            'сommentCourse' => $сommentCourse->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}