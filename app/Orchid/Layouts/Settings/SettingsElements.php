<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layouts\TabMenu;

class SettingsElements extends TabMenu
{
    /**
     * Get the menu elements to be displayed.
     *
     * @return Menu[]
     */
    protected function navigations(): iterable
    {
        return [
            Menu::make('Базовые настройки')
                ->route('platform.settings.basic'),

            Menu::make('Advanced Настройки')
                ->route('platform.settings.advanced'),

            Menu::make('О центре')
                ->route('platform.settings.about'),
            
            Menu::make('Акции')
                ->route('platform.settings.promotion'),
        ];
    }
}