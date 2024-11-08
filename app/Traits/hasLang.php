<?php

namespace App\Traits;

trait hasLang
{
    public function byLang($defaultRusField)
    {
        return app()->getLocale() == 'ru'
            ? $defaultRusField
            : app()->getLocale();
    }
}