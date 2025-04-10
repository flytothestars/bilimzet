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
            $basic = &$jsonData['basic'];

            $address = isset($basic['address']) ? $basic['address'] : '';
            $email = isset($basic['email']) ? $basic['email'] : '';
            $telegram = isset($basic['telegram']) ? $basic['telegram'] : '';
            $instagram = isset($basic['instagram']) ? $basic['instagram'] : '';
            $whatsapp = isset($basic['whatsapp']) ? $basic['whatsapp'] : '';
            $phone = isset($basic['phone']) ? $basic['phone'] : '';
            $twogis_link = isset($basic['twogis_link']) ? $basic['twogis_link'] : '';
            $iinbin = isset($basic['iinbin']) ? $basic['iinbin'] : '';
            $name_company = isset($basic['name_company']) ? $basic['name_company'] : '';
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
                    ->type(Color::PRIMARY)
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
            $basic = &$jsonData['basic'];
        } else {
            $basic = ['basic' => []];
        }

        $basic['address'] = $request->input('address');
        $basic['email'] = $request->input('email');
        $basic['instagram'] = $request->input('instagram');
        $basic['telegram'] = $request->input('telegram');
        $basic['phone'] = $request->input('phone');
        $basic['whatsapp'] = $request->input('whatsapp');
        $basic['twogis_link'] = $request->input('twogis_link');
        $basic['iinbin'] = $request->input('iinbin');
        $basic['name_company'] = $request->input('name_company');

        File::put($filePath, json_encode($jsonData));

        Alert::success('Данные успешно сохранены');

        return redirect()->back();
    }
}