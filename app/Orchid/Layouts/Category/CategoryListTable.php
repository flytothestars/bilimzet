<?php

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use App\Models\Category;

class CategoryListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'category_list';

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
            TD::make('name', 'Наименование RU'),
            TD::make('name_kz', 'Наименование KZ'),
            TD::make('training', 'Обучение')->render(function(Category $category){
                return $category->training === 1 ? 'Повышение квалификации' : 'Переподготовка';
            }),
            TD::make('action', 'Действие')->render(function ($category) {
                return Group::make([
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editCategory')
                        ->method('createOrUpdateCategory')
                        ->modalTitle('Редактирование категорию ' . $category->name)
                        ->asyncParameters([
                            'category' => $category->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить категорию?')
                        ->parameters([
                            'category' => $category->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}