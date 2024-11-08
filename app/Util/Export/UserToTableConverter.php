<?php


namespace App\Util\Export;


use App\User;

class UserToTableConverter
{
    const META_TITLE = '__meta__title';

    /* @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    private function include($title, $subSchema)
    {
        return $this->convert($subSchema);
    }

    public function convert($schema)
    {
        $resRows = [];
        foreach ($schema as $schemaRow) {
            $fn = $schemaRow[1];
            $genRows = $this->$fn($schemaRow[0], $schemaRow[2]);
            $resRows = array_merge($resRows, $genRows);
        }
        return $resRows;
    }

    private function prop($title, $key)
    {
        $value = $this->user->$key;
        if (is_bool($value)) {
            if ($value) {
                $value = 'Да';
            } else {
                $value = 'Нет';
            }
        };
        return [[$title, $value]];
    }

    private function file($title, $key)
    {
        $uploads = User::getUploadsDir();
        $name = $this->user->$key ?? '';
        if (empty($name)) {
            return [[$title, '']];
        }
        return [[$title, $uploads->getUrlFor($name)]];
    }

    private function str($title, $key)
    {
        return [[$title, $key]];
    }

    private function title($title, $key)
    {
        return [[self::META_TITLE, $title]];
    }
}
