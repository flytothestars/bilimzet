<?php

namespace App\Orchid\Layouts\Feedback;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use App\Models\Feedback;
use Orchid\Support\Color;

class FeedbackListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'feedback_list';

    protected $styleButton = 'border-radius: 5px;';
    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('phone', 'Телефон номер'),
            TD::make('name', 'Имя'),
            TD::make('email', 'Почта'),
            TD::make('is_feedbacked', 'Статус')->render(function(Feedback $feedback){
                return $feedback->is_feedbacked === 1 ? 'Опрошен' : 'Неопрошен';
            }),
            TD::make('action', 'Статус действии')->render(function ($feedback) {
                return Group::make([
                    Button::make('Опрошен')
                        ->method('interviewed')
                        ->parameters([
                            'feedback' => $feedback->id,
                        ])
                        ->type(Color::SUCCESS)
                        ->style($this->styleButton),
                    Button::make('Не опрошен')
                        ->method('noInterviewed')
                        ->parameters([
                            'feedback' => $feedback->id,
                        ])
                        ->type(Color::DANGER)
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}