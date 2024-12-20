<?php

namespace App\Orchid\Layouts\News;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;

class NewsListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'news_list';

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
            TD::make('name', 'Заголовка'),
            TD::make('created_at', 'Дата'),
            TD::make('action', 'Действие')->render(function ($news) {
                return Group::make([
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editNews')
                        ->method('createOrUpdateNews')
                        ->modalTitle('Редактирование новости ' . $news->name)
                        ->asyncParameters([
                            'news' => $news->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить филиал?')
                        ->parameters([
                            'news' => $news->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}