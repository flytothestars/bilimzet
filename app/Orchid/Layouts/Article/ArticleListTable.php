<?php

namespace App\Orchid\Layouts\Article;

use App\Models\LibraryItem;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use App\Models\Category;
use App\Models\User;
use Orchid\Support\Color;

class ArticleListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'article_list';

    protected $styleButtonRadius = 'border-radius: 7px;';

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
            TD::make('author_id', 'Автор')->render(function(LibraryItem $article){
                $user = User::find($article->author_id);
                if($user){
                    return $user->full_name;
                }
            }),
            TD::make('category', 'Категория')->render(function(LibraryItem $article){
                $category = Category::find($article->category);
                if($category){
                    return $category->full;
                }
            }),
            TD::make('is_published', 'Публикация')->render(function(LibraryItem $article){
                return $article->is_published === 1 ? 'Да' : 'Нет';
            }),
            TD::make('action', 'Действие')->render(function ($article) {
                return Group::make([
                    Button::make('')
                        ->icon('bs.check')
                        ->method('published')
                        ->parameters([
                            'article' => $article->id,
                        ])
                        ->type(Color::SUCCESS)
                        ->style($this->styleButtonRadius),
                    Button::make('')
                        ->icon('bs.x')
                        ->method('noPublished')
                        ->parameters([
                            'article' => $article->id,
                        ])
                        ->type(Color::DANGER)
                        ->style($this->styleButtonRadius),
                    ModalToggle::make('')
                        ->icon('bs.pencil')
                        ->modal('editArticle')
                        ->method('createOrUpdateArticle')
                        ->modalTitle('Редактирование статью ' . $article->name)
                        ->asyncParameters([
                            'article' => $article->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                    Button::make('')
                        ->icon('trash')
                        ->method('delete')
                        ->confirm('Вы уверены, что хотите удалить статью?')
                        ->parameters([
                            'article' => $article->id,
                        ])
                        ->class('btn btn-danger text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            })->width('200px'),
        ];
    }
}