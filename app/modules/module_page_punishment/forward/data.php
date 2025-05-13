<?php /**
  * @author -r8 (@r8.dev)
  **/

use app\modules\module_page_punishment\ext\Punishment;
$Router->map('GET|POST', 'punishment/[:sid]/', 'punishment');
$Map = $Router->match();
$server_id = $Map['params']['sid'] ?? 'all';

if (empty($Db->db_data['IksAdmin']) && empty($Db->db_data['AdminSystem'])) {
    get_iframe('P1', 'Не подключен ни один из поддерживаемых модов! (AdminSystem | IksAdmin)') && die();
}

$Punishment = new Punishment($Db, $General, $Translate, $Modules, $Notifications, $server_id);

if (isset($_POST['list'])) {
    exit(json_encode($Punishment->RenderingPageList($_POST['page'], $_POST['limit']), true));
} elseif (isset($_POST['modal'])) {
    exit(json_encode($Punishment->RenderingModalWindow($_POST['page'], $_POST['id']), true));
} elseif (isset($_POST['btn_unban'])) {
    exit(json_encode($Punishment->PunishmentUnban($_POST['idpunish'], $_POST['page'], $_POST['type'], $_POST['sid']), true));
} elseif (isset($_POST['search_ban']) || isset($_POST['search_mute'])) { 
    exit(json_encode($Punishment->Search()->SearchPost($_POST['search_ban'], $_POST['search_mute'])));
}

$Modules->set_page_title("{$Translate->get_translate_module_phrase('module_page_punishment', '_punishment')} | {$General->arr_general['short_name']}");