<?php

use app\modules\module_page_request\ext\Requests;

$RQ = new Requests($Translate, $Notifications, $General, $Modules, $Db, $Auth);

$request_id = (int) intval(get_section('id', '0'));

define('PLAYERS_ON_PAGE', '15');
$page_max = 0;

$page_num = (int) intval (get_section('num', '1'));
$page_num <= 0 && get_iframe('R2', 'Данная страница не существует') && die();

$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;

if (empty($Db->db_data['request'])) {
    require MODULES . 'module_page_request/includes/install.php';
    exit;
}

if( isset( $_POST ) && !empty( $_FILES["img"] ) )
    die( json_encode($RQ->UploadMSGPhoto($_FILES['img']), true ));

if (!empty($Db->db_data['request'])) {
    $servers = $RQ->RequestsServers();
    $data = $RQ->RequestsSettings();
    $requests = $RQ->getRequests();
    if(!empty($requests)){
        if(!in_array($request_id, array_keys($requests))){
            get_iframe('R1', 'Данная страница не существует') && die();
        }
        $Question = $RQ->getQuestions($requests[$request_id]['id']);
        $ignore_servers = explode(';', $requests[$request_id]['ignore_servers']);
    }
    if(isset( $_SESSION['steamid'])):
        $myList = $RQ->getMyList();
    endif;
}

if (isset($_SESSION['steamid32']) && isset($_GET['page'])) {
    switch (strip_tags($_GET['page'])) {
        case 'my':
            if(!empty($myList)){
                if (isset($_GET['rid'])) {
                    $List = $RQ->getMyListId($_GET['rid']);
                    if(empty($List)){
                        header('Location: ' . $General->arr_general['site'].'request/?page=my');
                        exit;
                    }
                    $Request = $RQ->getRequest($List['rid']);
                    $Review = $RQ->getMyReview($_GET['rid']);
                }
            }
            break;
        case 'admin':
            if ($RQ->access >= 5) {
                $List = $RQ->getListRequests();
            }
            break;
        case 'list':
            if ($RQ->access >= 3) {
                $page_max = ceil(count($RQ->getAllList(strip_tags($_GET['type']), strip_tags($_GET['status']))) / PLAYERS_ON_PAGE);
                $List = $RQ->getAllListPagination($page_num_min, PLAYERS_ON_PAGE, strip_tags($_GET['type']), strip_tags($_GET['status']));
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
                
                $page_num > $page_max && get_iframe('R2', 'Данная страница не существует') && die();
                break;
            }
        case 'question':
            break;
        case 'review':
            if ($RQ->access >= 3) {
                $List = $RQ->getList($_GET['rid']);
                $Request = $RQ->getRequest($List['rid']);
                $Review = $RQ->getReview($_GET['rid']);
            }
            break;
        case 'perm':
            if ($RQ->access >= 8) {
                $Admins = $RQ->getAdmins();
            }
            break;
        default:
            exit;
            break;
    }
}

// Задаём заголовок страницы.
$Modules->set_page_title('Заявки от игроков');

// Задаём описание страницы.
$Modules->set_page_description('Прием заявок на сайте');

//Проверка в базе данных наличие таблиц.
if (isset($Db->db_data['request'])) {
    $checkTable = [
        'lvl_web_requests',
        'lvl_web_request_list',
        'lvl_web_request_perm',
        'lvl_web_request_settings',
        'lvl_web_request_question',
        'lvl_web_request_review',
    ];
    foreach ($checkTable as $key) {
        if (!$Db->mysql_table_search('request', $Db->db_data['request'][0]['USER_ID'], $Db->db_data['request'][0]['DB_num'], $key)) {
            require MODULES . 'module_page_request/includes/install.php';
            exit;
        }
    }
}
