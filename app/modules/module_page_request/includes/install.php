<?php

/**
 * @author Revolution#7501
 */

if (!isset($_SESSION['user_admin']) || IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

// задаём основную кодировку страницы.
header('Content-Type: text/html; charset=utf-8');

// Отключаем показ ошибок.
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

//Проверка в базе данных наличие таблиц.
if (isset($Db->db_data['request'])) {
    $checkTable = [
        'lvl_web_requests',
        'lvl_web_request_perm',
        'lvl_web_request_list',
        'lvl_web_request_settings',
        'lvl_web_request_question',
        'lvl_web_request_review',
    ];
    foreach ($checkTable as $key) {
        if (!$Db->mysql_table_search('request', $Db->db_data['request'][0]['USER_ID'], $Db->db_data['request'][0]['DB_num'], $key)) {
            $table[$key] = 1;
        }
    }
}

// Проверка соединения с базой данных.
if (isset($_POST['db_check'])) {
    $con = mysqli_connect($_POST['host'], $_POST['user'], $_POST['pass'], $_POST['db_1']);
    if ($con) {
        $db_check = 2;
    } else {
        $db_check = 1;
    }
    mysqli_close($con);
}

if (isset($_POST['save_db'])) {
    $Db->change_db("request", $_POST['host'], $_POST['user'], $_POST['pass'], $_POST['db_1'], 0, '', ['mod' => '']);
    header("Refresh:2");
}

// Установка таблиц в базу данных
if (isset($_POST['table_install'])) {
    $sql = array(
        "CREATE TABLE `lvl_web_requests`  (
            `id` int NOT NULL AUTO_INCREMENT,
            `title` varchar(300) NULL DEFAULT NULL,
            `sort` int NOT NULL,
            `vk` int NOT NULL,
            `discord` int NOT NULL,
            `telegram` int NOT NULL,
            `rules` int NOT NULL,
            `criteria` int NOT NULL,
            `text` varchar(1000) NULL DEFAULT NULL,
            `time` int NULL DEFAULT NULL,
            `age` varchar(11) NULL DEFAULT NULL,
            `age_act` int NOT NULL,
            `hours` int NULL DEFAULT NULL,
            `hours_act` int NOT NULL,
            `server` int NOT NULL,
            `default_server` int NULL DEFAULT NULL,
            `ignore_servers` varchar(11) NULL DEFAULT NULL,
            `status` int NOT NULL,
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",

        "CREATE TABLE `lvl_web_request_perm`  (
            `aid` int NOT NULL AUTO_INCREMENT,
            `steamid` varchar(256) NOT NULL DEFAULT '',
            `request` int NOT NULL DEFAULT 0,
            `review` int NOT NULL DEFAULT 0,
            PRIMARY KEY (`aid`) USING BTREE
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",

        "CREATE TABLE `lvl_web_request_list`  (
            `id` int NOT NULL AUTO_INCREMENT,
            `rid` int NOT NULL,
            `steamid` varchar(256) NOT NULL,
            `text` text NOT NULL,
            `server` varchar(30) NOT NULL,
            `playtime` int NOT NULL,
            `date` int NOT NULL,
            `status` int NOT NULL,
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",

        "CREATE TABLE `lvl_web_request_question`  (
            `id` int NOT NULL AUTO_INCREMENT,
            `request_id` int NOT NULL,
            `question` text NOT NULL,
            `desc` text NOT NULL,
            `clue` text NOT NULL,
            `sort` int NOT NULL,
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",

        "CREATE TABLE `lvl_web_request_review`  (
            `id` int NOT NULL AUTO_INCREMENT,
            `rid` int NOT NULL,
            `rqid` int NOT NULL,
            `steamid` varchar(256) NOT NULL,
            `text` text NULL,
            `date` int NOT NULL,
            `admin` int NOT NULL,
            `type` int NOT NULL,
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",

        "CREATE TABLE `lvl_web_request_settings`  (
            `url` varchar(512) NOT NULL,
            `auth` int NOT NULL DEFAULT 0
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",

        "INSERT INTO `lvl_web_request_settings` VALUES ('', 0);",
    );
    foreach ($sql as $key) {
        $Db->query('request', $Db->db_data['request'][0]['USER_ID'], $Db->db_data['request'][0]['DB_num'], $key);
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?= $Translate->get_translate_module_phrase('module_page_request', '_WelcomeInstallTitle') ?>
    </title>
</head>
<link rel="stylesheet" href="<?php echo $General->arr_general['site'] ?>app/templates/<?php echo $General->arr_general['theme'] ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo $General->arr_general['site'] ?>storage/assets/css/style.css">
<style>
    :root <?php echo str_replace(',', ';', str_replace('"', '', file_get_contents_fix('app/templates/' . $General->arr_general['theme'] . '/colors.json'))) ?>
</style>

<style>
    .badge_req {
        display: flex;
        padding: 10px 15px;
        border-radius: 4px;
        width: max-content;
        font-size: 13px !important;
        font-weight: 700;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        color: var(--span);
        background-color: var(--bottom-line-table);
        margin-bottom: 0 !important;
    }

    .input-form {
        position: relative;
        text-align: left;
        margin-top: 6px;
        margin-bottom: 6px;
        width: 100%;
    }

    .btn {
        margin-top: 12px;
        float: right;
    }

    .container-fluid {
        width: 100%;
        padding-top: 0px;
    }

    .card {
        margin-bottom: 17px;
    }

    .lds-ellipsis {
        display: inline-block;
        position: relative;
        width: 55px;
        height: 14px;
    }

    .lds-ellipsis div {
        position: absolute;
        top: 5px;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #fff;
        animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }

    .lds-ellipsis div:nth-child(1) {
        left: 6px;
        animation: lds-ellipsis1 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(2) {
        left: 6px;
        animation: lds-ellipsis2 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(3) {
        left: 26px;
        animation: lds-ellipsis2 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(4) {
        left: 45px;
        animation: lds-ellipsis3 0.6s infinite;
    }

    @keyframes lds-ellipsis1 {
        0% {
            transform: scale(0);
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes lds-ellipsis3 {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(0);
        }
    }

    @keyframes lds-ellipsis2 {
        0% {
            transform: translate(0, 0);
        }

        100% {
            transform: translate(19px, 0);
        }
    }

    .br6 {
        border-radius: 6px;
    }

    .inf_bdg_green {
        display: flex;
        justify-content: center;
        background-color: var(--green);
        color: var(--bg);
        font-weight: 700;
        padding: 10px;
        border-radius: 4px;
        margin-top: 5px;
    }

    .inf_bdg_red {
        display: flex;
        justify-content: center;
        background-color: var(--red);
        color: var(--bg);
        font-weight: 700;
        padding: 10px;
        border-radius: 4px;
        margin-top: 5px;
    }

    .vers {
        display: flex;
        background-color: var(--bottom-line-table);
        padding: 10px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 4px;
        justify-content: center;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card br6">
                    <div class="card-header pb0">
                        <h5 class="badge_req">
                            <?= $Translate->get_translate_module_phrase('module_page_request', '_InstallTitle') ?>
                        </h5>
                    </div>
                    <?php if (!empty($table)) : ?>
                        <div class="card-container option_one">
                            <h5 class="badge_req"><?php echo $Translate->get_translate_module_phrase('module_page_request', '_InstallTable') ?> <?php echo $Translate->get_translate_module_phrase('module_page_request', '_Applications_sort') ?></h5><br>
                            <?php echo $Translate->get_translate_module_phrase('module_page_request', '_ForWork') ?><br>
                            <?php foreach ($table as $tableKey => $val) : ?>
                                <b>`<?php echo $tableKey ?>`</b><br>
                            <?php endforeach; ?>
                            <form enctype="multipart/form-data" method="post">
                                <input class="btn" name="table_install" type="submit" value="<?php echo $Translate->get_translate_module_phrase('module_page_request', '_InstallBTN') ?>">
                            </form>
                        </div>
                    <?php else : ?>
                        <div class="card-container option_one">
                            <h5 class="badge_req"><?php echo $Translate->get_translate_module_phrase('module_page_request', '_SettingsBD') ?></h5>
                            <form id="db_check" enctype="multipart/form-data" method="post">
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Host') ?></th>
                                    </div><input name="host" value="<?php echo $_POST['host'] ?>">
                                </div>
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_User') ?></th>
                                    </div><input name="user" value="<?php echo $_POST['user'] ?>">
                                </div>
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Pass') ?></th>
                                    </div><input name="pass" value="<?php echo $_POST['pass'] ?>">
                                </div>
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_DB') ?></th>
                                    </div><input name="db_1" value="<?php echo $_POST['db_1'] ?>">
                                </div>
                            </form>
                            <?php if ($db_check != 2) : ?>
                                <input class="btn w100" name="db_check" type="submit" form="db_check" value="<?php echo $Translate->get_translate_module_phrase('module_page_request', '_DBCheckBTN') ?>">
                            <?php elseif ($db_check == 2) : ?>
                                <input class="btn w100" name="save_db" type="submit" form="db_check" value="<?php echo $Translate->get_translate_module_phrase('module_page_request', '_NextBTN') ?>">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card br6">
                    <div class="card-header">
                        <h5 class="badge_req"><?php echo $Translate->get_translate_module_phrase('module_page_request', '_Info') ?></h5>
                    </div>
                    <div class="card-container">
                        <div class="vers"><?php echo $Translate->get_translate_module_phrase('module_page_request', '_Php') ?></div> <?php if (PHP_VERSION >= '7.4') {
                                                                                                                                            echo '<div class="inf_bdg_green">'  . PHP_VERSION . '</div>';
                                                                                                                                        } else {
                                                                                                                                            echo '<div class="inf_bdg_red">'  . PHP_VERSION . '</div>
                    <div>' . $Translate->get_translate_module_phrase('module_page_request', '_PhpRecomendation') . '</div>';
                                                                                                                                        } ?>
                        <?php if ($db_check == 1) : ?>
                            <div><?php echo $Translate->get_translate_module_phrase('module_page_request', '_DBCheckConnect') ?></div>
                        <?php elseif ($db_check == 2) : ?>
                            <div><?php echo $Translate->get_translate_module_phrase('module_page_request', '_DBCheckConnectSucc') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        $('.btn').click(function() {
            setTimeout(function() {
                $('.btn').replaceWith('<div class="btn"></div>');
                $(".btn").append('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
            }, 100);
        });
    </script>
</body>

</html>