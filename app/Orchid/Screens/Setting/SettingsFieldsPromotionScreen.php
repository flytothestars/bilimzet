<?php

namespace App\Orchid\Screens\Setting;

use Orchid\Screen\Action;
use Orchid\Support\Color;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Orchid\Layouts\Settings\SettingsElements;
use Orchid\Support\Facades\Alert;
use App\Orchid\Layouts\Settings\PromotionListTable;
use App\Models\Promotion;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;

class SettingsFieldsPromotionScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'promotion_list' => Promotion::orderby('created_at', 'desc')->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Настройка страницы';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return '';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('Создать акции')->modal('createPromotion')->method('createOrUpdatePromotion')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @throws \Throwable
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            SettingsElements::class,
            PromotionListTable::class,
            Layout::modal('createPromotion', Layout::rows([
                Input::make('promotion.title')->title('Заголовка RU')->required(),
                Input::make('promotion.title_kz')->title('Заголовка KZ')->required(),
                Input::make('promotion.description')->title('Описание RU')->required(),
                Input::make('promotion.description_kz')->title('Описание KZ')->required(),
                
            ]))->title('Создать')->applyButton('Создать')->size(Modal::SIZE_LG),
            Layout::modal('editpromotion', Layout::rows([
                Input::make('promotion.id')->type('hidden'),
                Input::make('promotion.title')->title('Заголовка RU')->required(),
                Input::make('promotion.title_kz')->title('Заголовка KZ')->required(),
                Input::make('promotion.description')->title('Описание RU')->required(),
                Input::make('promotion.description_kz')->title('Описание KZ')->required(),
            ]))->async('asyncGetPromotion')->size(Modal::SIZE_LG)
        ];
    }

    public function createOrUpdatePromotion(NewsRequest $request )
    {
        $validated = $request->validated();
        $promotionId = $request->input('promotion.id');
        $promotion = Promotion::updateOrCreate([
            'id' => $promotionId
        ], $validated['promotion']);
        $promotion->attachments()->syncWithoutDetaching(
            $request->input('promotion.attachments', [])
        );
        is_null($promotionId) ? Toast::info('Успешно добавлено') : Toast::info('Успешно обновлено');

    }

    public function delete(Promotion $promotion)
    {
        $promotion->delete();
        Toast::info('Успешно удалено');
    }

    public function asyncGetPromotion(Promotion $promotion): array
    {
        $promotion->load('attachments');
        return [
            'promotion' => $promotion
        ];
    }
}