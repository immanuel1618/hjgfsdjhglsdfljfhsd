<?php

/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Отключаем показ ошибок.
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('opcache.revalidate_freq', 0);

// Ограничиваем время выполнения скрипта.
set_time_limit(3);

// Проверка на существование файла с настройками
if (!file_exists(SESSIONS . '/options.php')) :
    $options['theme'] = 'neo';
    $options['auth_cock'] = 1;
    $options['css_off_cache'] = 1;
    $options['avatars'] = 1;
    $options['avatars_cache_time'] = 259200;
    $options['only_steam_64'] = 0;
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
endif;

// Проверка на существование файла с базой данных
!file_exists(SESSIONS . '/db.php') && file_put_contents(SESSIONS . '/db.php', '<?php return []; ');

// Получение информации из конфигурационного файла.
$options = require SESSIONS . '/options.php';

// Получение информации о базе данных.
$db = require SESSIONS . '/db.php';

if (!empty($db)) :
    $mysqli = new mysqli($db['Core'][0]['HOST'], $db['Core'][0]['USER'], $db['Core'][0]['PASS'], $db['Core'][0]['DB'][0]['DB'], $db['Core'][0]['PORT']);
    $result = $mysqli->query('SELECT `steamid`, `group`, `flags`, `access` FROM lvl_web_admins');
    $row = $result->fetch_assoc();
    $mysqli->close();
    if (empty($row)) :
        $admins = 1;
    endif;
endif;

// Язык
if (empty($options['language']) && isset($_POST['EN']) || isset($_POST['RU'])) :
    $options['language'] = isset($_POST['EN']) ? 'EN' : 'RU';
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix(get_url(1));
endif;

// Информация о серверах
if (empty($options['short_name']) && empty($options['full_name']) && empty($options['info']) && empty($options['site']) && isset($_POST['servers_info_save'])) {
    $options['short_name'] = $_POST['servers_name'];
    $options['full_name'] = $_POST['servers_full_name'];
    $options['info'] = $_POST['servers_info'];
    $URL = '//' . $_SERVER["SERVER_NAME"] . explode('/app/', $_SERVER['REQUEST_URI'])[0];
    $options['site'] = substr($URL, -1) == '/' ? $URL : $URL . '/';
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix(get_url(1));
}

// WEB KEY API
if (empty($options['web_key']) && !empty($_POST['web_key'])) {
    $result = curl_init('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $_POST['web_key'] . '&steamids=76561198038416053');
    curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($result);
    $data = json_decode($url, true)['response']['players'];
    if ($data[0]['steamid'] == 76561198038416053) {
        $options['web_key'] = $_POST['web_key'];
        file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
        header_fix(get_url(1));
    } else {
        $error = true;
    }
}

// admin

if (isset($_POST['check_admin_steam'])) {
    $_SESSION['admin'] = con_steam64($_POST['admin']);
    $result = curl_init('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $options['web_key'] . '&steamids=' . $_SESSION['admin'] . ' ');
    curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($result);
    $data = json_decode($url, true)['response']['players'][0];
}

if (!empty($admins) && isset($_POST['check_admin_steam_da']) && isset($_SESSION['admin'])) {
    $mysqli = new mysqli($db['Core'][0]['HOST'], $db['Core'][0]['USER'], $db['Core'][0]['PASS'], $db['Core'][0]['DB'][0]['DB'], $db['Core'][0]['PORT']);
    $mysqli->query("INSERT INTO lvl_web_admins (steamid, `group`, `flags`, `access`) VALUES ( '{$_SESSION['admin']}', '', 'z', '100' )");
    $mysqli->close();
    refresh();
}

if (isset($_POST['check_admin_steam_net']) && isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
    header_fix(get_url(1));
}

// Проверка соединения с базой данных

if (empty($db) && isset($_POST['db_check'])) {

    $mysqli = new mysqli($_POST['HOST'], $_POST['USER'], $_POST['PASS'], $_POST['DATABASE'], $_POST['PORT']);

    if (mysqli_connect_errno())
        exit('<h2>Connect failed: ' . mysqli_connect_error() . '</h2>');

    $db_check == 2;

    $mysqli->query('CREATE TABLE IF NOT EXISTS lr_web_attendance (
            `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            `date` VARCHAR(10) NOT NULL,
            `visits` INT(11) NOT NULL) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS lr_web_online (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            `user` VARCHAR(17) NOT NULL,
            `ip` VARCHAR(128) NOT NULL,
            `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS lr_web_notifications (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            `steam` VARCHAR(128) NOT NULL,
            `title` VARCHAR(256) NOT NULL,	
            `text` VARCHAR(256) NOT NULL,
            `values_insert` VARCHAR(512) NOT NULL,
            `url` VARCHAR(128) NOT NULL,
            `icon` VARCHAR(64) NOT NULL,
            `button` VARCHAR(256),
            `seen` INT NOT NULL,
            `status` INT NOT NULL
            ) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS lvl_web_admins (
            `steamid` VARCHAR(17) PRIMARY KEY, 
            `group` VARCHAR(256) NOT NULL,
            `flags` VARCHAR(256) NOT NULL,
            `access` INT(3) NOT NULL
            ) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS lvl_web_servers (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            `ip` VARCHAR(64) NOT NULL,
            `fakeip` VARCHAR(64) NOT NULL,
            `name` VARCHAR(64) NOT NULL,
            `name_custom` VARCHAR(128) NOT NULL,
            `rcon` VARCHAR(64) NOT NULL,
            `server_stats` VARCHAR(64) NOT NULL,
            `server_vip` VARCHAR(64) NOT NULL,
            `server_vip_id` INT(11) NOT NULL,
            `server_sb` VARCHAR(64) NOT NULL,
            `server_sb_id` VARCHAR(64) NOT NULL,
            `server_shop` VARCHAR(64) NOT NULL,
            `server_lk` VARCHAR(64) NOT NULL,
            `server_mod` VARCHAR(255) NOT NULL,
            `server_city` VARCHAR(255) NOT NULL,
            `server_country` VARCHAR(255) NOT NULL,
            `server_bage` VARCHAR(255) NOT NULL
            ) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lr_web_cookie_tokens` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `steam` varchar(255) NOT NULL DEFAULT "0",
            `cookie_expire` varchar(255) NOT NULL DEFAULT "0",
            `cookie_token` varchar(255) NOT NULL DEFAULT "0",
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lvl_web_profiles`  (
            `auth` varchar(20) NOT NULL,
            `vk` text,
            `discord` text,
            `tg` text,
            `twitch` text,
            `status` text(255),
            `background` varchar(10) NOT NULL DEFAULT 1,
            UNIQUE INDEX `auth`(`auth`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lk` ( 
            `auth` VARCHAR(64) NOT NULL , 
            `name` VARCHAR(64) NOT NULL , 
            `cash` FLOAT NOT NULL , 
            `all_cash` FLOAT NOT NULL 
            ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lk_discord` (
            `url` TEXT NOT NULL , 
            `auth` INT NOT NULL DEFAULT 0 
            ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;');

    $mysqli->query('INSERT INTO `lk_discord`(`url`, `auth`) VALUES ("",0)');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lvl_web_profiles`  (
            `auth` varchar(20) NOT NULL,
            `vk` text,
            `discord` text,
            `tg` text,
            `twitch` text,
            `status` text(255),
            `background` varchar(10) NOT NULL DEFAULT 1,
            UNIQUE INDEX `auth`(`auth`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lk_logs` (
            `log_id` INT NOT NULL AUTO_INCREMENT ,
            `log_name` TEXT NOT NULL , 
            `log_value` TEXT NOT NULL , 
            `log_time` TEXT NOT NULL , 
            `log_content` TEXT NOT NULL , 
            PRIMARY KEY (`log_id`)
            ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lk_pays` ( 
            `pay_id` INT NOT NULL AUTO_INCREMENT , 
            `pay_order` INT NOT NULL , 
            `pay_auth` TEXT NOT NULL , 
            `pay_summ` FLOAT NOT NULL , 
            `pay_data` TEXT NOT NULL , 
            `pay_system` TEXT NOT NULL , 
            `pay_promo` TEXT NOT NULL , 
            `pay_status` INT NOT NULL DEFAULT 0 , 
            PRIMARY KEY (`pay_id`)
            ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lk_pay_service` ( 
            `id` INT NOT NULL , 
            `name_kassa` TEXT NOT NULL , 
            `shop_id` TEXT NOT NULL , 
            `secret_key_1` TEXT NOT NULL , 
            `secret_key_2` TEXT NOT NULL , 
            `status` INT NOT NULL DEFAULT 0 
            ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;');

    $mysqli->query('CREATE TABLE IF NOT EXISTS `lk_promocodes` ( 
            `id` INT NOT NULL AUTO_INCREMENT , 
            `code` TEXT NOT NULL , 
            `percent` FLOAT NOT NULL , 
            `attempts` INT NOT NULL , 
            `auth1` INT NOT NULL , 
            PRIMARY KEY (`id`)
            ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;');

    $db = [
        'Core' => [
            [
                'HOST' => $_POST['HOST'],
                'PORT' => $_POST['PORT'],
                'USER' => $_POST['USER'],
                'PASS' => $_POST['PASS'],
                'DB' => [
                    [
                        'DB' => $_POST['DATABASE'],
                        'Prefix' => [
                            ['table' => 'lvl_']
                        ]
                    ]
                ]
            ]
        ],
        'lk' => [
            [
                'HOST' => $_POST['HOST'],
                'PORT' => $_POST['PORT'],
                'USER' => $_POST['USER'],
                'PASS' => $_POST['PASS'],
                'DB' => [
                    [
                        'DB' => $_POST['DATABASE'],
                        'Prefix' => [
                            ['table' => 'lk']
                        ]
                    ]
                ]
            ]
        ]
    ];
    $mysqli->close();
    file_put_contents(SESSIONS . '/db.php', '<?php return ' . var_export_opt($db, true) . ";");
    refresh();
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ваш уникальный сайт!</title>
</head>
<link rel="stylesheet" href="<?= '//' . $_SERVER["SERVER_NAME"] . explode('/app/', $_SERVER['REQUEST_URI'])[0] ?>/storage/assets/css/style.css">
<link rel="stylesheet" href="<?= '//' . $_SERVER["SERVER_NAME"] . explode('/app/', $_SERVER['REQUEST_URI'])[0] ?>/app/templates/neo/assets/css/style.css">
<link rel="stylesheet" href="<?= '//' . $_SERVER["SERVER_NAME"] . explode('/app/', $_SERVER['REQUEST_URI'])[0] ?>/app/page/custom/install/assets/css/style.css">
<style>
    :root <?= str_replace('"', '', str_replace('",', ';', file_get_contents_fix('app/templates/neo/colors.json'))) ?>
</style>
<body>
    <div class="wrapper">
        <?php
        if (empty($options['language'])) :
            require PAGE_CUSTOM . 'install/pages/language.php';
        elseif (!extension_loaded('bcmath') || !extension_loaded('curl') || !extension_loaded('json') || !extension_loaded('zip') || !extension_loaded('gmp')) :
            require PAGE_CUSTOM . 'install/pages/extension.php';
        elseif (substr(sprintf('%o', fileperms(SESSIONS)), -4) !== '0777' || substr(sprintf('%o', fileperms(CACHE . 'img/avatars/')), -4) !== '0777' || substr(sprintf('%o', fileperms(MODULESCACHE)), -4) !== '0777') :
            require PAGE_CUSTOM . 'install/pages/permissions.php';
        elseif (empty($db['Core'])) :
            require PAGE_CUSTOM . 'install/pages/db.php';
        elseif (empty($options['web_key'])) :
            require PAGE_CUSTOM . 'install/pages/webkey.php';
        elseif (!empty($admins)) :
            require PAGE_CUSTOM . 'install/pages/admin.php';
        elseif (empty($options['full_name']) || empty($options['short_name']) || empty($options['info']) || empty($options['site'])) :
            require PAGE_CUSTOM . 'install/pages/name.php';
        else :
            header_fix('//' . $_SERVER["SERVER_NAME"] . explode('/app/', $_SERVER['REQUEST_URI'])[0]);
            die();
        endif ?>
    </div>
</body>
</html>