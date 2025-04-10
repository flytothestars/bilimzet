<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;

class PromotionListTable extends Table
{
    
    protected $target = 'promotion_list';

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
            TD::make('title', 'Заголовка'),
            TD::make('description', 'Описание'),
            TD::make('action', 'Действие')->render(function ($promotion) {
                return Group::make([
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editPromotion')
                        ->method('createOrUpdatePromotion')
                        ->modalTitle('Редактирование ' . $promotion->title)
                        ->asyncParameters([
                            'promotion' => $promotion->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить?')
                        ->parameters([
                            'promotion' => $promotion->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}