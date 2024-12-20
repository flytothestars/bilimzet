<?php

namespace App\Orchid\Screens\News;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Upload;
use App\Orchid\Layouts\News\NewsListTable;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Picture;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;

class NewsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'news_list' => News::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Новости';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать новости')->modal('createNews')->method('createOrUpdateNews')
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
            NewsListTable::class,
            Layout::modal('createNews', Layout::rows([
                Input::make('news.name')->title('Заголовка RU')->required(),
                Input::make('news.name_kz')->title('Заголовка KZ')->required(),
                Upload::make('news.attachments')
                    ->title('Миниатюра')
                    ->required(),
                Quill::make('news.text')->title('Описание RU')->required(),
                Quill::make('news.text_kz')->title('Описание KZ')->required(),
                
            ]))->title('Создать новости')->applyButton('Создать')->size(Modal::SIZE_LG),
            Layout::modal('editNews', Layout::rows([
                Input::make('news.id')->type('hidden'),
                Input::make('news.name')->title('Заголовка RU')->required(),
                Input::make('news.name_kz')->title('Заголовка KZ')->required(),
                Upload::make('news.attachments')
                    ->title('Миниатюра')
                    ->required(),
                Quill::make('news.text')->title('Описание RU')->required(),
                Quill::make('news.text_kz')->title('Описание KZ')->required(),
            ]))->async('asyncGetNews')->size(Modal::SIZE_LG)
        ];
    }

    public function createOrUpdateNews(NewsRequest $request )
    {
        $validated = $request->validated();
        $newsId = $request->input('news.id');
        $news = News::updateOrCreate([
            'id' => $newsId
        ], $validated['news']);
        $news->attachments()->syncWithoutDetaching(
            $request->input('news.attachments', [])
        );
        is_null($newsId) ? Toast::info('Новости успешно добавлено') : Toast::info('Новости успешно обновлено');

    }

    public function delete(News $news)
    {
        $news->delete();
        Toast::info('Новости успешно удалено');
    }

    public function asyncGetNews(News $news): array
    {
        $news->load('attachments');
        return [
            'news' => $news
        ];
    }
}
