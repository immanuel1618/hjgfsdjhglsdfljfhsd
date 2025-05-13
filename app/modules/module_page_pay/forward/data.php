<?php

use app\modules\module_page_pay\ext\Lk_module;

if (IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

$LK = new Lk_module($Translate, $Notifications, $General, $Modules, $Db);

if (isset($_POST['user'])) {
    $LK->LkUpdateBalance($_POST);
    exit;
} else if (isset($_POST['users_clean'])) {
    $LK->LkDelUsers();
    exit;
} else if (isset($_POST['search_users'])) {
    $LK->SearchUser($_POST['search_users']);
}
define('PLAYERS_ON_PAGE', '10');
$page_num = get_section('num', '1');
$page_max = $LK->UsersPageMax(PLAYERS_ON_PAGE);
$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;
$playersAll = $LK->LkGetAllPlayers($page_num_min, PLAYERS_ON_PAGE);
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

if (isset($_SESSION['user_admin'])  && isset($_GET['section'])) {
    switch ($_GET['section']) {
        case 'gateways':
            if (!empty($_POST['gateway'])) {
                $LK->LkAddGateway($_POST);
                exit;
            } else if (isset($_POST['gateway_edit'])) {
                $LK->LkEditGateway($_POST);
                exit;
            } else if (isset($_POST['chart'])) {
                $LK->LkChart();
                exit;
            } else if (isset($_POST['gateway_delete'])) {
                $LK->LkDeleteGateway($_POST);
                exit;
            } else if (isset($_POST['webhoock_url'])) {
                $LK->LkAddDiscord($_POST);
                exit;
            }
            break;
        case 'promocodes':
            if (isset($_POST['addpromo'])) {
                $LK->LkAddPromocode($_POST);
                exit;
            } else if (isset($_POST['editid'])) {
                $LK->LkEditPromocode($_POST);
                exit;
            } else if (isset($_POST['promocode_delete'])) {
                $LK->LkDeletePromocode($_POST);
                exit;
            }
            break;
        case 'search':
            if (isset($_POST['search_users'])) {
                $LK->SearchUser($_POST['search_users']);
            } else  if (isset($_POST['user'])) {
                $LK->LkUpdateBalance($_POST);
                exit;
            }
            break;
    }
}

if (!empty($_GET['gateway'])) {
    require MODULES . 'module_page_pay/includes/result.php';
    exit;
}

if (empty($Db->db_data['lk'])) {
    require MODULES . 'module_page_pay/includes/install.php';
    exit;
}

//Проверка в базе данных наличие таблиц.
if (isset($Db->db_data['lk'])) {
    $checkTable =  array(
        'lk',
        'lk_discord',
        'lk_logs',
        'lk_pays',
        'lk_pay_service',
        'lk_promocodes',
    );
    foreach ($checkTable as $key) {
        if (!$Db->mysql_table_search('lk', $Db->db_data['lk'][0]['USER_ID'], $Db->db_data['lk'][0]['DB_num'], $key)) {
            require MODULES . 'module_page_pay/includes/install.php';
            exit;
        }
    }
}

// Задаём заголовок страницы.
$Modules->set_page_title($Translate->get_translate_module_phrase('module_page_pay', '_LK') . ' | ' . $General->arr_general['short_name']);