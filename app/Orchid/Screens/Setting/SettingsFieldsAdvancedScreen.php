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
                    Input::make('img-icon')
                        ->type('file')
                        ->title('Логотип')
                        ->horizontal(),
                    Input::make('img-banner')
                        ->type('file')
                        ->title('Баннер')
                        ->horizontal(),
                ]),
                Button::make('Сохранить')
                    ->method('updateIcon')
                    ->type(Color::PRIMARY)
            ]),
        ];
    }

    public function updateIcon(Request $request)
    {
        // Получаем логотип и баннер из запроса
        $logo = $request->file('img-icon');
        $banner = $request->file('img-banner');

        // Путь к директории
        $directory = public_path('images');

        if ($logo) {
            $logoFilename = 'bilimzet_logo.' . $logo->getClientOriginalExtension();

            // Удаление существующего логотипа, если он есть
            if (File::exists($directory . '/' . $logoFilename)) {
                File::delete($directory . '/' . $logoFilename);
            }

            // Сохранение нового логотипа
            $logo->move($directory, $logoFilename);
        }

        if ($banner) {
            $bannerFile = $banner;
            $bannerExtension = $bannerFile->getClientOriginalExtension();
            $bannerFilename = 'welcome.' . $bannerExtension;

            // Удаление существующих файлов с именем welcome и любым расширением
            $this->deleteExistingFiles($directory, 'welcome');

            // Сохранение нового баннера
            $bannerFile->move($directory, $bannerFilename);
        }

        return back()->with('success', 'Images uploaded successfully.');
    }

    private function deleteExistingFiles($directory, $basename)
    {
        // Получаем все файлы в директории
        $files = File::files($directory);

        // Проходимся по каждому файлу и проверяем имя
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_FILENAME) === $basename) {
                File::delete($file);
            }
        }
    }
}