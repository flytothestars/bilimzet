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
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;


class SettingsFieldsAboutScreen extends Screen
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
        $filePath = config_path('config_file.json');
        if (File::exists($filePath)) {
            $jsonData = json_decode(File::get($filePath), true);
            $basic = &$jsonData['about'];

            $description = isset($basic['description']) ? $basic['description'] : '';
        } else {
            $description = '';
        }
        return [

            SettingsElements::class,
            Layout::rows([
                Group::make([
                    TextArea::make('description')->title('О нас')->required()->rows(10)->value($description),
                    Upload::make('attachments')
                        ->title('Картинка')
                        ->groups('aboutImage'),
                ]),
                Group::make([
                    Upload::make('attachments')
                        ->title('Слайдер')
                        ->groups('aboutSliderImage'),
                ]),
                Button::make('Сохранить')
                    ->method('saveAbout')
                    ->type(Color::PRIMARY)
            ]),
        ];
    }

    public function saveAbout(Request $request)
    {
        
        $filePath = config_path('config_file.json');

        if (File::exists($filePath)) {
            $jsonData = json_decode(File::get($filePath), true);
            $basic = &$jsonData['about'];
        } else {
            $basic = ['about' => []];
        }

        $basic['description'] = $request->input('description');
        $basic['attachments_id'] = $request->input('attachments');

        File::put($filePath, json_encode($jsonData));

        Alert::success('Данные успешно сохранены');

        return back()->with('success', 'Images uploaded successfully.');
    }
}