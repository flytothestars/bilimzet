<?php


namespace App\Util\Export;


use App\User;

class UserToExcelConverter
{
    public static function exportSingle(User $user, $path)
    {
        self::exportAll([$user], $path);
    }

    public static function exportAll($users, $path)
    {
        $tables = [];
        foreach ($users as $user) {
            $tableConverter = new UserToTableConverter($user);
            $table = $tableConverter->convert(UserExportSchema::FULL_SCHEMA);
            $tables[] = [$user->ull_name, $table];
        }
        TableToExcelExporter::exportAll($tables, $path);
    }
}
