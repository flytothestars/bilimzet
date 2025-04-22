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

class SettingsFieldsAdvancedScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
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
        return [];
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
            Layout::rows([
                Group::make([
                    Upload::make('attachments')
                        ->title('Картинка на обратный связь')
                        ->groups('aboutImage'),
                    Upload::make('attachments')
                        ->title('Логотип сайта')
                        ->groups('aboutImage'),
                    Upload::make('attachments')
                        ->title('Картинка баннер слева')
                        ->groups('aboutImage'),
                    Upload::make('attachments')
                        ->title('Картинка баннер справа')
                        ->groups('aboutImage'),
                ]),
                Button::make('Сохранить')
                    ->method('updateIcon')
                    ->type(Color::PRIMARY)
            ]),
        ];
    }

    public function updateIcon(Request $request)
    {  
        return back()->with('success', 'Images uploaded successfully.');
    }
}