<?php
// Ведущая проверка.
( ! isset( $_SESSION['user_admin'] ) ) && get_iframe( '013','Доступ закрыт' ) && die();

use app\modules\module_page_adminpanel\ext\Admin;

// Создаём экземпляр класса для работы с админкой
$Admin = new Admin ( $General, $Modules, $Db, $Translate );

# Убираем кеширование
if( function_exists("opcache_reset") )
    isset( $_POST ) && opcache_reset();

    
if (isset($_SESSION['user_admin'])) {
// Нажатие на кнопку - Добавить мод.
isset( $_POST['add_mods'] ) && $Admin->action_db_add_mods();
}

if (isset($_SESSION['user_admin'])) {
// Нажатие на кнопку - Добавить сервер.
isset( $_POST['save_server'] ) && $Admin->action_add_server();
}

if (isset($_SESSION['user_admin'])) {
// Нажатие на кнопку - Добавить сервер.
isset( $_POST['save_server_edit'] ) && $Admin->action_edit_server();
}

if (isset($_SESSION['user_admin'])) {
// Нажатие на кнопку - Удалить сервер.
isset( $_POST['del_server'] ) && $Admin->action_del_server();
}

if (isset($_SESSION['user_admin'])) {
// Нажатие на кнопку - Добавить DB.
isset( $_POST['function'] ) && $Admin->action_db_add_connection();
}

// Перемещение блоков - Порядок загрузки модулей.
if (isset($_SESSION['user_admin'])) {
isset( $_POST['data'] ) && $Admin->edit_modules_initialization();
}

if (isset($_SESSION['user_admin'])) {
    if (isset($_POST['add_point'])) {
        exit(json_encode($Admin->AddMenuPoint($_POST, $_GET), true));
    } elseif (isset($_POST['form-edit-conection'])) {
        exit(json_encode($Admin->EditServer($_POST), true));
    } elseif (isset($_POST['edit_point'])) {
        exit(json_encode($Admin->EditMenuPoint($_POST, $_GET), true));
    } elseif (isset($_POST['point_del'])) {
        exit(json_encode($Admin->DeleteMenuPoint($_POST), true));
    } elseif (isset($_POST['category_del'])) {
        exit(json_encode($Admin->DeleteMenuCategory($_POST), true));
    } elseif (isset($_POST['add_info'])) {
        exit(json_encode($Admin->AddInfo($_POST), true));
    } elseif (isset($_POST['create_table'])) {
        exit(json_encode($Admin->CreateTable(), true));
    } elseif (isset($_POST['hide_filter_form'])) {
        exit(json_encode($Admin->SettingsSaveHide($_POST), true));
    } elseif (isset($_POST['stretch_filter_form'])) {
        exit(json_encode($Admin->SettingsSaveStretch($_POST), true));
    } elseif (isset($_POST['hide_city_form'])) {
        exit(json_encode($Admin->SettingsSaveHideCity($_POST), true));
    } elseif (isset($_POST['hide_country_form'])) {
        exit(json_encode($Admin->SettingsSaveHideCountry($_POST), true));
    } elseif (isset($_POST['all_del_logs'])) {
        exit(json_encode($Admin->DelAllLogsWeb(), true));
    } elseif (isset($_POST['log_del'])) {
        exit(json_encode($Admin->DelLogWeb($_POST), true));
    } elseif (isset($_POST['all_del_logs_lk'])) {
        exit(json_encode($Admin->LkCleanLogs(), true));
    } elseif (isset($_POST['log_del_lk'])) {
        exit(json_encode($Admin->LkLogdelete($_POST), true));
    } elseif (isset($_POST['settings_modules'])) {
        exit(json_encode($Admin->edit_module($_POST, $_GET, $_FILES), true));
    } elseif (isset($_POST['baner_del'])) {
        exit(json_encode($Admin->DelSettingsBaner($_POST), true));
    } elseif (isset($_POST['settings_modules_core'])) {
        exit(json_encode($Admin->edit_module_core($_POST, $_GET), true));
    } elseif (isset($_POST['clear_modules_initialization'])) {
        exit(json_encode($Admin->action_clear_modules_initialization(), true));
    } elseif (isset($_POST['create_table_noty'])) {
        exit(json_encode($Admin->CreateTableNoty(), true));
    } elseif (isset($_POST['options_one'])) {
        exit(json_encode($Admin->edit_options(), true));
    } elseif (isset($_POST['all_del_logs_ref'])) {
        exit(json_encode($Admin->DelAllLogsRef(), true));
    } elseif (isset($_POST['log_del_ref'])) {
        exit(json_encode($Admin->DelLogRef($_POST), true));
    }
}

define('PLAYERS_ON_PAGE', '10');
$page_max = ceil(count($Admin->ShopLogs()) / PLAYERS_ON_PAGE);
$page_num = (int) intval(get_section('num', '1'));
$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;

if ($page_num == 1 || $page_num == 2) {
    $startPag = 1;
    $pagActive = $page_num;
} else if ($page_num == $page_max) {
    $startPag = $page_max - 4;
    $pagActive = 5;
} else if ($page_num == $page_max - 1) {
    $startPag = $page_max - 4;
    $pagActive = 4;
} else {
    $startPag = $page_num - 2;
    $pagActive = 3;
}

// Задаём заголовок страницы.
$Modules->set_page_title( $Translate->get_translate_phrase('_Admin_panel') . ' | ' .  $General->arr_general['short_name']);