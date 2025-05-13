<?php /**
  * @author -r8 (@r8.dev)
  **/

use app\modules\module_page_reports\ext\Core;

if( IN_LR != true ) { header_fix($General->arr_general['site']); exit; }

$Router->map('GET|POST', 'reports/[:page]/', 'reports');
$Router->map('GET|POST', 'reports/[:page]/[:sid]/', 'reports');
$Router->map('GET|POST', 'reports/[:page]/[:sid]/[:rid]/', 'reports');
$Map = $Router->match();
$page = $Map['params']['page'] ?? 'list';
$sid = $Map['params']['sid'];
$rid = $Map['params']['rid'];

$Core = new Core($Db, $General, $Translate, $Modules, $Notifications, $sid, $rid);

if (!empty($Db->db_data['Reports'])) {
    if (!isset($_SESSION['steamid64'])) {
        get_iframe('R3', 'Вы не авторизованы на сайте!');
    } elseif ($page == 'settings' && !isset($_SESSION['user_admin'])) {
        get_iframe('R4', 'Вы не являетесь администратором сайта!');
    } elseif (!isset($_SESSION['user_admin']) && empty($Core->AccessCore()->GetAccess())) {
        get_iframe('R5', 'У вас недостаточно прав доступа!');
    } elseif (isset($_SESSION['user_admin'])) { 
    } else {
        $returnAccess = false;
        foreach ($Core->AccessCore()->GetAccess() as $key) {
            if ($key['steamid'] == $_SESSION['steamid64']) {
                $returnAccess = true;
                break;
            }
        }
        if (!$returnAccess) {
            get_iframe('R5', 'У вас недостаточно прав доступа!') && die();
        }
    }
    if ($sid != null) {
        $hasAccess = false;
        if (isset($_SESSION['user_admin'])) {
            $hasAccess = true;
        } else {
            foreach ($Core->AccessCore()->GetAccess() as $access) {
                if ($access['steamid'] == $_SESSION['steamid64'] && $access['sid'] == $sid) {
                    $hasAccess = true;
                    break;
                }
            }
        }
        if (!$hasAccess) {
            get_iframe('R5', 'У вас недостаточно прав доступа к этому серверу!') && die();
        }
    }
    if ($Core->SettingsCore()->TableSearchReports()) {
        get_iframe('R6', 'Сначала установите плагин на сервер и создайте базы!') && die();
    } else {
        if (!in_array($page, ['list', 'report', 'settings'])) {
            get_iframe("R7", "Увы, такой страницы не существует") && die();
        }
    }

} else {
    if (isset($_SESSION['user_admin'])) {
        $page = 'install';
    } else {
        get_iframe('R8', 'Администратор сайта не настроил модуль!') && die();
    }
}

$Modules->set_page_title("" . $Translate->get_translate_module_phrase('module_page_reports', '_ReportsTitle') . " | " .  $General->arr_general['short_name'] . "");

$Modules->set_page_description($Translate->get_translate_module_phrase('module_page_reports', '_Desc'));

require MODULES . "module_page_reports/forward/requests.php";