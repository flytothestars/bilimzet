<?php namespace App\Util;

class ValidationUtils
{
    public static function makeNullable(array &$rules, array $fields)
    {
        foreach ($fields as $field) {
            $rules[$field] = str_replace('required|', 'nullable|', $rules[$field]);
        }
    }
}
