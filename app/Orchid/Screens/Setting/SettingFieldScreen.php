<?php

namespace App\Orchid\Screens\Setting;

use App\Orchid\Layouts\Settings\SettingsElements;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\File;

class SettingFieldScreen extends Screen
{

    protected $fieldsEnabled = false;
    protected $input;

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
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Настройка страницы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $filePath = config_path('config_file.json');
        if (File::exists($filePath)) {
            $jsonData = json_decode(File::get($filePath), true);
            $address = isset($jsonData['address']) ? $jsonData['address'] : '';
            $email = isset($jsonData['email']) ? $jsonData['email'] : '';
            $telegram = isset($jsonData['telegram']) ? $jsonData['telegram'] : '';
            $instagram = isset($jsonData['instagram']) ? $jsonData['instagram'] : '';
            $whatsapp = isset($jsonData['whatsapp']) ? $jsonData['whatsapp'] : '';
            $phone = isset($jsonData['phone']) ? $jsonData['phone'] : '';
            $twogis_link = isset($jsonData['twogis_link']) ? $jsonData['twogis_link'] : '';
            $iinbin = isset($jsonData['iinbin']) ? $jsonData['iinbin'] : '';
            $name_company = isset($jsonData['name_company']) ? $jsonData['name_company'] : '';
        } else {
            $address = '';
            $email = '';
            $telegram = '';
            $instagram = '';
            $whatsapp = '';
            $phone = '';
            $twogis_link = '';
            $iinbin = '';
            $name_company = '';
        }

        return [
            SettingsElements::class,
            Layout::rows([
                Group::make([
                    Input::make('name_company')
                        ->title('Название компании')
                        ->placeholder('')
                        ->horizontal()
                        ->value($name_company),

                ]),
                Group::make([
                    Input::make('email')
                        ->title('Почта')
                        ->placeholder('help@nurapost.com')
                        ->horizontal()
                        ->value($email),
    
                    Input::make('iinbin')
                        ->type('text')
                        ->title('ИНН/БИН')
                        ->placeholder('')
                        ->horizontal()
                        ->value($iinbin),
                ]),

                Group::make([
                    Input::make('address')
                        ->title('Адрес главного офиса')
                        ->placeholder('Введите адрес')
                        ->horizontal()
                        ->value($address),
    
                    Input::make('twogis_link')
                        ->type('text')
                        ->title('Ссылка на 2gis')
                        ->placeholder('')
                        ->horizontal()
                        ->value($twogis_link),
                ]),

                Group::make([
                    Input::make('instagram')
                        ->type('text')
                        ->title('Instagram')
                        ->placeholder('')
                        ->horizontal()
                        ->value($instagram),

                    Input::make('telegram')
                        ->type('text')
                        ->title('Telegram')
                        ->placeholder('')
                        ->horizontal()
                        ->value($telegram),
                ]),

                Group::make([
                    Input::make('phone')
                        ->type('tel')
                        ->title('Номер телефона')
                        ->placeholder('+7-777-81-81-818')
                        ->horizontal()
                        ->value($phone),

                    Input::make('whatsapp')
                        ->type('tel')
                        ->title('Whatsapp номер')
                        ->placeholder('+7-777-81-81-818')
                        ->horizontal()
                        ->value($whatsapp),
                ]),

                Button::make('Сохранить')
                    ->method('buttonClickProcessing')
                    ->type(Color::BASIC)
                    ->confirm('Подтвердите вашу изменение в настройках для продолжения')
                    ->parameters([
                        'modalTitle' => 'Подтверждение изменение',
                        'modalSubmit' => 'Подтвердить',
                    ]),
            ]),
        ];
    }

    public function buttonClickProcessing(Request $request)
    {
        $filePath = config_path('config_file.json');

        if (File::exists($filePath)) {
            $jsonData = json_decode(File::get($filePath), true);
        } else {
            $jsonData = [];
        }

        $jsonData['address'] = $request->input('address');
        $jsonData['email'] = $request->input('email');
        $jsonData['instagram'] = $request->input('instagram');
        $jsonData['telegram'] = $request->input('telegram');
        $jsonData['phone'] = $request->input('phone');
        $jsonData['whatsapp'] = $request->input('whatsapp');
        $jsonData['twogis_link'] = $request->input('twogis_link');
        $jsonData['iinbin'] = $request->input('iinbin');
        $jsonData['name_company'] = $request->input('name_company');

        File::put($filePath, json_encode($jsonData));

        Alert::success('Данные успешно сохранены');

        return redirect()->back();
    }
}