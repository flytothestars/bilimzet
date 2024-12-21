<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),
            
            Input::make('user.full_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Input::make('user.phone')
                ->type('text')
                ->required()
                ->title(__('Телефон номер'))
                ->placeholder(__('77771122334')),
            
            Input::make('user.iin')
                ->type('text')
                ->required()
                ->title(__('ИИН'))
                ->placeholder(__('ИИН')),


            Input::make('user.address')
                ->type('text')
                ->required()
                ->title(__('Адрес'))
                ->placeholder(__('Адрес')),


            Input::make('user.position')
                ->type('text')
                ->required()
                ->title(__('Должность'))
                ->placeholder(__('Должность')),


            Input::make('user.company_name')
                ->type('text')
                ->required()
                ->title(__('Место работы'))
                ->placeholder(__('Место работы')),
        ];
    }
}
