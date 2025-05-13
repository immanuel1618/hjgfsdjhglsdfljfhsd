<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

set_time_limit(4);

define('IN_LR', true);
define('APP', '../../../../app/');
define('STORAGE', '../../../../storage/');
define('PAGE', APP . 'page/general/');
define('PAGE_CUSTOM', APP . 'page/custom/');
define('MODULES', APP . 'modules/');
define('INCLUDES', APP . 'includes/');
define('CACHE', STORAGE . 'cache/');
define('MODULESCACHE', STORAGE . 'modules_cache/');
define('ASSETS', STORAGE . 'assets/');
define('SESSIONS', CACHE . 'sessions/');
define('LOGS', CACHE . 'logs/');
define('IMG', CACHE . 'img/');
define('ASSETS_CSS', ASSETS . 'css/');
define('ASSETS_JS', ASSETS . 'js/');
define('THEMES', ASSETS_CSS . 'themes/');
define('RANKS_PACK', IMG . 'ranks/');
define('MINUTE_IN_SECONDS', 60);
define('HOUR_IN_SECONDS', 3600);
define('DAY_IN_SECONDS', 86400);
define('WEEK_IN_SECONDS', 604800);
define('MONTH_IN_SECONDS', 2592000);
define('YEAR_IN_SECONDS', 31536000);

session_start();

require '../../../includes/functions.php';
require_once '../../../ext/Db.php';
require_once '../../../ext/Translate.php';
require_once '../../../ext/General.php';
require __DIR__ . '../../../../ext/SourceQuery/bootstrap.php';
use xPaw\SourceQuery\SourceQuery;
$return = [];

$Translate      = new \app\ext\Translate;
$Db             = new \app\ext\Db();
$General        = new \app\ext\General ($Db);
$Query          = new SourceQuery();

if(isset($_POST['online'])){
  $servers = $Db->queryAll( 'Core', 0, 0, "SELECT `id`, `ip`, `name` FROM `lvl_web_servers`" );
  $servers_count = sizeof( $servers );
  for ( $i_ser = 0; $i_ser < $servers_count; $i_ser++ ):
    $server[] = explode( ":", $servers[$i_ser]['ip'] );
    $server_name[] = $servers[$i_ser]['name'];
  endfor;

  for ( $i_server = 0; $i_server < $servers_count; $i_server++ ):
    try {
      $Query->Connect( $server[ $i_server ][0], $server[ $i_server ][1], 3, SourceQuery :: SOURCE );
      $SQuery[ $i_server ]['players'] = $Query->GetPlayers();
      $SQuery[ $i_server ]['ip'] = $server[ $i_server ][0] . ':' . $server[ $i_server ][1];
      $SQuery[ $i_server ]['server_name'] = $server_name[ $i_server ];
    } catch ( Exception $e ) {
      $SQuery[ $i_server ]['players'] = null;
      $SQuery[ $i_server ]['ip'] = $server[ $i_server ][0] . ':' . $server[ $i_server ][1];
      $SQuery[ $i_server ]['server_name'] = $server_name[ $i_server ];
    } finally {
        $Query->Disconnect();
    }
  endfor;

  $lastconnect = false;

  foreach($SQuery as $server_search) {
    foreach($server_search["players"] as $player) {
      if (strcasecmp($player["Name"], $_POST['online']["name"]) == 0) {
        $return['online'] = $server_search['server_name'];
        $return['ip'] = $server_search['ip'];
        $return['text'] = $Translate->get_translate_module_phrase('module_page_profiles', '_Playing_on_the_server');
        $lastconnect = true;
      }
    }
  }
  if($lastconnect == false) {
    $return['online'] = $_POST['online']["lastconnect"];
    $return['text'] = $Translate->get_translate_module_phrase('module_page_profiles', '_Last_connect');
  }
}

if(isset($_POST['faceit'])){
  $settings = file_exists(MODULESCACHE . 'module_page_profiles/settings.php') ? require MODULESCACHE . 'module_page_profiles/settings.php' : null;
  $data = [];
  
  if(!empty($settings['faceit_api_key'])){
    $nh = curl_init();
    curl_setopt($nh, CURLOPT_HTTPHEADER,
      array(
        'Authorization: Bearer ' . $settings['faceit_api_key'],
        'accept: application/json'
      )
    );
    curl_setopt($nh, CURLOPT_URL, 'https://open.faceit.com/data/v4/players?game=cs2&game_player_id=' . $_POST['faceit']);
    curl_setopt($nh, CURLOPT_RETURNTRANSFER, true);
    $array = curl_exec($nh);
    $data = json_decode($array, true);
    $http_code = curl_getinfo($nh, CURLINFO_HTTP_CODE);
    curl_close($nh);
  }
  if($http_code == 200){
    $return['faceit_nickname'] = $data['nickname'];
    $return['faceit_elo'] = $data['games']['cs2']['faceit_elo'];
    if(empty($data['games']['cs2']['skill_level'])){
      $return['skill_level'] = $General->arr_general['site'].'storage/cache/img/ranks/faceit/none.svg';
    } else {
      $return['skill_level'] = $General->arr_general['site'].'storage/cache/img/ranks/faceit/'.$data['games']['cs2']['skill_level'].'.svg';
    }
    $faceit_url = $data['faceit_url'];
    $language = $data['settings']['language'];
    $return['faceit_url'] = str_replace("{lang}", $language, $faceit_url);
  }
}

// Вывод
echo json_encode( $return, JSON_UNESCAPED_UNICODE );
exit;