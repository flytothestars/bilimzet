<?php


namespace App\Util;



class Phpbb
{
    public static function createUser($login, $pass)
    {
        $scriptPath = base_path('phpbb-cli.php');
        $loginArg = escapeshellarg($login);
        $passArg = escapeshellarg($pass);
        $cmd = "php $scriptPath add_user $loginArg $passArg";
        $output = "";
        $returnCode = 0;
        $res = exec($cmd,$output, $returnCode);
        return [$returnCode, $res, $output];
    }
}
