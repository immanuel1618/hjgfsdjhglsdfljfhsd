<?php
use app\modules\module_page_admins_online\ext\Controllers\ModuleController;
use app\modules\module_page_admins_online\ext\Controllers\AdminsController;
use app\modules\module_page_admins_online\ext\Controllers\SettingsController;

if (IN_LR != true) { header_fix($General->arr_general['site']); exit; }

define('MODULE_NAME', 'module_page_admins_online');
define('MODULE_WEB_ROUTES', MODULE_NAME . '/routes/web.php');
define('MODULE_API_ROUTES', MODULE_NAME . '/routes/api.php');

$Module = new ModuleController($Db, $Translate);

$Router->map('GET|POST', 'admins_online/[:page]/', 'admins_online');
$Router->map('GET|POST', 'admins_online/[:page]/[:action]/', 'admins_online');
$Map = $Router->match();
$page = $Map['params']['page'] ?? '';
$action = $Map['params']['action'] ?? '';

$adminsController = new AdminsController($Db, $Translate);
$settingsController = new SettingsController($Db, $Translate);

$settings = $settingsController->GetSettings();
$connectedServers = $settingsController->GetConnectedServersList();
$accesses = $settingsController->GetAccesses();

$server_id = !empty($_GET['server_id']) ? $_GET['server_id'] : -1;
$steamid64 = !empty($_GET['steamid64']) ? $_GET['steamid64'] : null;
$from = !empty($_GET['from']) ? $_GET['from']: null;
$to = !empty($_GET['to']) ? ($_GET['to'] + 84924): null;

$admins = $adminsController->GetAdmins($server_id, $steamid64, $norma, $from, $to);

require_once MODULES . MODULE_API_ROUTES;

$Modules->set_page_title( 
    $Translate->get_translate_module_phrase(MODULE_NAME, '_AdmOnline') . ' | ' . $General->arr_general['short_name']
);

if ($settingsController->HasAccess() === false) {  header_fix($General->arr_general['site']); exit; }

?>
<link rel="stylesheet" type="text/css" href="/app/modules/module_page_admins_online/assets/css/vanilla-calendar.min.css<?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>">
<script src="/app/modules/module_page_admins_online/assets/js/vanilla-calendar.min.js" defer></script>