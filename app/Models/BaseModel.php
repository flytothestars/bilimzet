<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

abstract class BaseModel extends Model
{
    /**
     * Получение локализованного поля
     */
    public function getLocalizedField($field)
    {
        $locale = App::getLocale();

        if (!array_key_exists($field, $this->attributes)) {
            return null;
        }

        if ($locale === 'kz') {
            $localizedField = "{$field}_kz";
            return $this->attributes[$localizedField] ?? $this->attributes[$field];
        }

        return $this->attributes[$field];
    }
}
