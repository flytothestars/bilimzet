<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Support\Color;
use App\Models\Promotion;

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
            TD::make('banner', 'Баннер')->render(function(Promotion $promotion){
                return $promotion->banner === 1 ? 'Да' : 'Нет';
            }),
            TD::make('is_active', 'Активен?')->render(function(Promotion $promotion){
                return $promotion->is_active === 1 ? 'Да' : 'Нет';
            }),
            TD::make('action', 'Действие')->render(function ($promotion) {
                return Group::make([
                    Button::make('Активен')
                        ->method('actived')
                        ->parameters([
                            'promotion' => $promotion->id,
                        ])
                        ->type(Color::SUCCESS)
                        ->style($this->styleButton),
                    Button::make('Не активен')
                        ->method('noActived')
                        ->parameters([
                            'promotion' => $promotion->id,
                        ])
                        ->type(Color::DANGER)
                        ->style($this->styleButton),
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