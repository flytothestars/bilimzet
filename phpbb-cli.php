<?php
if (PHP_SAPI !== 'cli')
{
   die('Run this script from cli');
}
if(!isset($argv[1])) {
    die('Allowed commands: add_user');
}

if($argv[1] === 'add_user') {
    if(count($argv) !== 4) {
        die('Help: php phpbb-cli.php add_user <nick> <pass>');
    }

    $username = $argv[2];
    $password = $argv[3];
    echo "creating user with username=$username, password=$password\n";

    define('IN_PHPBB', true);
    $phpbb_root_path = __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'forum' . DIRECTORY_SEPARATOR;
    $phpEx = substr(strrchr(__FILE__, '.'), 1);
    include($phpbb_root_path . 'common.' . $phpEx);
    include($phpbb_root_path . 'includes' . DIRECTORY_SEPARATOR . 'functions_user.' . $phpEx);

    global $db;

    // an email address for the user
    $email_address = 'my_email@domain_name.tld';

    $coppa = false;

    // default is 4 for registered users, or 5 for coppa users.
    $group_id = ($coppa) ? 5 : 4;
    // since group IDs may change, you may want to use a query to make sure you are grabbing the right default group...
    $group_name = ($coppa) ? 'REGISTERED_COPPA' : 'REGISTERED';
    $sql = 'SELECT group_id
            FROM ' . GROUPS_TABLE . "
            WHERE group_name = '" . $db->sql_escape($group_name) . "'
                AND group_type = " . GROUP_SPECIAL;
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $group_id = $row['group_id'];

    // timezone of the user... Based on GMT in the format of '-6', '-4', 3, 9 etc...
    $timezone = '+3';

    // two digit default language for this use of a language pack that is installed on the board.
    $language = 'ru';

    // user type, this is USER_INACTIVE, or USER_NORMAL depending on if the user needs to activate himself, or does not.
    // on registration, if the user must click the activation link in their email to activate their account, their account
    // is set to USER_INACTIVE until they are activated. If they are activated instantly, they would be USER_NORMAL
    $user_type = USER_NORMAL;

    // IP address of the user stored in the Database.
    $user_ip = $user->ip;

    // registration time of the user, timestamp format.
    $registration_time = time();



    // these are just examples and some sample (common) data when creating a new user.
    // you can include any information
    $user_row = array(
        'username'              => $username,
        'user_password'         => phpbb_hash($password),
        'user_email'            => $email_address,
        'group_id'              => (int) $group_id,
        'user_timezone'         => (float) $timezone,
        'user_lang'             => $language,
        'user_type'             => $user_type,
        'user_ip'               => $user_ip,
        'user_regdate'          => $registration_time,
    );

    // Custom Profile fields, this will be covered in another article.
    // for now this is just a stub
    // all the information has been compiled, add the user
    // the user_add() function will automatically add the user to the correct groups
    // and adding the appropriate database entries for this user...
    // tables affected: users table, profile_fields_data table, groups table, and config table.
    $user_id = user_add($user_row);

    var_dump($user_id);
} else {
    die("Unknown command: $argv[1]");
}
