<?php

namespace App\Orchid\Screens\Article;

use App\Orchid\Layouts\Article\ArticleListTable;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Upload;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Support\Facades\Toast;
use App\Models\LibraryItem;
use Orchid\Screen\Fields\Relation;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\ArticleRequest;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Modal;

class ArticleScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'article_list' =>LibraryItem::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Статья';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать cтатью')->modal('createArticle')->method('createOrUpdateArticle')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ArticleListTable::class,
            Layout::modal('createArticle', Layout::rows([
                Input::make('article.title')->title('Заголовка RU')->required(),
                Input::make('article.title_kz')->title('Заголовка KZ')->required(),
                Select::make('article.is_published')
                        ->options([
                            '0'   => 'Нет',
                            '1' => 'Да',
                        ])->title('Опубликовать статью'),
                Relation::make('article.category')->fromModel(Category::class, 'name')->displayAppend('full')->title('Категория')->required(),
                Relation::make('article.author_id')->fromModel(User::class, 'full_name')->title('Автор')->required(),
                Upload::make('article.attachments')
                    ->title('Документ')
                    ->groups('articleDocument')
                    ->required(),
                Quill::make('article.text')->title('Описание RU')->required(),
                Quill::make('article.text_kz')->title('Описание KZ')->required(),
            ]))->title('Создать статью')->applyButton('Создать')->size(Modal::SIZE_LG),
            
            Layout::modal('editArticle', Layout::rows([
                Input::make('article.id')->type('hidden'),
                Input::make('article.title')->title('Заголовка RU')->required(),
                Input::make('article.title_kz')->title('Заголовка KZ')->required(),
                Select::make('article.is_published')
                        ->options([
                            '0'   => 'Нет',
                            '1' => 'Да',
                        ])->title('Опубликовать статью'),
                Relation::make('article.category')->fromModel(Category::class, 'name')->displayAppend('full')->title('Категория')->required(),
                Relation::make('article.author_id')->fromModel(User::class, 'full_name')->title('Автор')->required(),
                Upload::make('article.attachments')
                    ->title('Документ')
                    ->groups('articleDocument')
                    ->required(),
                Quill::make('article.text')->title('Описание RU')->required(),
                Quill::make('article.text_kz')->title('Описание KZ')->required(),
            ]))->async('asyncGetArticle')->size(Modal::SIZE_LG)
        ];
    }

    public function createOrUpdateArticle(ArticleRequest $request )
    {
        $validated = $request->validated();
        
        $articleId = $request->input('article.id');
        $validated['article']['author_id'] = auth()->user()->id;  // Пример, если автор - текущий пользователь
        $article = LibraryItem::updateOrCreate([
            'id' => $articleId
        ], $validated['article']);
        $article->attachments()->syncWithoutDetaching(
            $request->input('article.attachments', [])
        );
        is_null($articleId) ? Toast::info('Статья успешно добавлено') : Toast::info('Статья успешно обновлено');

    }

    public function delete(LibraryItem $article)
    {
        $article->delete();
        Toast::info('Статья успешно удалено');
    }

    public function asyncGetArticle(LibraryItem $article): array
    {
        $article->load('attachments');
        return [
            'article' => $article
        ];
    }
}
