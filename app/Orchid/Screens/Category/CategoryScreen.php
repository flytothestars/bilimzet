<?php

namespace App\Orchid\Screens\Category;

use Orchid\Screen\Screen;
use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryListTable;
use App\Http\Requests\CategoryRequest;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Modal;

class CategoryScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'category_list' => Category::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Категория';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать категория')->modal('createCategory')->method('createOrUpdateCategory')
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
            CategoryListTable::class,
            Layout::modal('createCategory', Layout::rows([
                Input::make('category.name')->title('Заголовка RU')->required(),
                Input::make('category.name_kz')->title('Заголовка KZ')->required(),
                Select::make('category.training')
                        ->options([
                            '0'   => 'Нет',
                            '1' => 'Да',
                        ]),
                Upload::make('category.attachments')
                    ->title('Иконка')
                    ->groups('categoryIcon')
                    ->required(),
            ]))->title('Создать новость')->applyButton('Создать')->size(Modal::SIZE_LG),

            Layout::modal('editCategory', Layout::rows([
                Input::make('category.id')->type('hidden'),
                Input::make('category.name')->title('Заголовка RU')->required(),
                Input::make('category.name_kz')->title('Заголовка KZ')->required(),
                Select::make('category.training')
                        ->options([
                            '0'   => 'Переподготовка',
                            '1' => 'Повышение квалификации',
                        ]),
                Upload::make('category.attachments')
                    ->title('Иконка')
                    ->groups('categoryIcon')
                    ->required(),
            ]))->async('asyncGetCategory')->size(Modal::SIZE_LG),
        ];
    }

    public function createOrUpdateCategory(CategoryRequest $request )
    {
        $validated = $request->validated();
        $categoryId = $request->input('category.id');
        $category = Category::updateOrCreate([
            'id' => $categoryId
        ], $validated['category']);
        $category->attachments()->syncWithoutDetaching(
            $request->input('category.attachments', [])
        );
        is_null($categoryId) ? Toast::info('Категория успешно добавлено') : Toast::info('Категория успешно обновлено');

    }

    public function delete(Category $category)
    {
        $category->delete();
        Toast::info('Категория успешно удалено');
    }

    public function asyncGetCategory(Category $category): array
    {
        $category->load('attachments');
        return [
            'category' => $category
        ];
    }
}
