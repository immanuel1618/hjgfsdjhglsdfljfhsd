<?php
define('IN_LR', true);
define('APP', '../../../../app/');
define('STORAGE', '../../../../storage/');
define('CACHE', STORAGE . 'cache/');
define('SESSIONS', CACHE . 'sessions/');
define('MODULES', APP . 'modules/');

require '../../../includes/functions.php';
require_once '../../../ext/Db.php';
require_once '../../../ext/General.php';

$Db    = new \app\ext\Db();
$General = new \app\ext\General($Db);

$return = [];

function GetCache($file)
{
  return file_exists(MODULES . 'module_page_reports/assets/cache/' . $file . '.php') ? require MODULES . 'module_page_reports/assets/cache/' . $file . '.php' : null;
}

function writeCache($steam, $key, $data)
{
  $cachetime = 86400;
  $filename = MODULES . 'module_page_reports/temp/api/cache.json';
  $cache = [];

  if (file_exists($filename)) {
    $cache = json_decode(file_get_contents($filename), true);
  }
  $time = time();
  foreach ($cache as $key1 => $row) {
    foreach ($row as $dataKey => $entry) {
      if ($time - $entry['timestamp'] > $cachetime) {
        unset($cache[$key1][$dataKey]);
      }
    }
    if (empty($cache[$key1])) {
      unset($cache[$key1]);
    }
  }
  $cache[$steam][$key] = [
    'timestamp' => $time,
    'data' => $data
  ];
  file_put_contents($filename, json_encode($cache, JSON_PRETTY_PRINT));
}
function readCache($steam, $key)
{
  $cachetime = 86400;
  $filename = MODULES . 'module_page_reports/temp/api/cache.json';
  if (file_exists($filename)) {
    $cache = json_decode(file_get_contents($filename), true);
    if (isset($cache[$steam][$key]) && (time() - $cache[$steam][$key]['timestamp'] < $cachetime)) {
      return $cache[$steam][$key]['data'];
    }
  }
}

function GetBanPlayer($steam)
{
  $cache = readCache($steam, 'bans');
  if ($cache !== null) {
    return $cache;
  }
  $api_key = GetCache('settings')['blockdb_apikey'];
  if ($api_key) {
    $url = "https://api.blockdb.ru/v1/bans/$steam";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Accept: application/json',
      'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['check_votebkm' => true]));

    $result = curl_exec($ch);

    curl_close($ch);
    $decoded = json_decode($result, true);

    if ($decoded['status'] == 'OK') {
      $bans = $decoded['bans'];
      writeCache($steam, 'bans', $bans);
      return $bans;
    }
  }
}

function GetSteamData($steam)
{
  global $General;

  $cacheTimeCreated = readCache($steam, 'timecreated');
  $cachePlaytime = readCache($steam, 'playtime_cs2');

  if ($cacheTimeCreated !== null && $cachePlaytime !== null) {
    return ['timecreated' => $cacheTimeCreated, 'playtime_cs2' => $cachePlaytime];
  }

  $multiCurl = curl_multi_init();
  $curlHandles = [];

  $urlTimeCreated = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $General->arr_general['web_key'] . '&steamids=' . $steam;
  $curlHandles['timecreated'] = curl_init($urlTimeCreated);
  curl_setopt($curlHandles['timecreated'], CURLOPT_RETURNTRANSFER, 1);
  curl_multi_add_handle($multiCurl, $curlHandles['timecreated']);

  $urlPlaytime = 'https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=' . $General->arr_general['web_key'] . '&steamid=' . $steam;
  $curlHandles['playtime_cs2'] = curl_init($urlPlaytime);
  curl_setopt($curlHandles['playtime_cs2'], CURLOPT_RETURNTRANSFER, 1);
  curl_multi_add_handle($multiCurl, $curlHandles['playtime_cs2']);

  $running = null;
  do {
    curl_multi_exec($multiCurl, $running);
  } while ($running);

  $responseTimeCreated = json_decode(curl_multi_getcontent($curlHandles['timecreated']), true)['response']['players'][0]['timecreated'];
  $responsePlaytime = json_decode(curl_multi_getcontent($curlHandles['playtime_cs2']), true)['response']['games'];

  curl_multi_remove_handle($multiCurl, $curlHandles['timecreated']);
  curl_multi_remove_handle($multiCurl, $curlHandles['playtime_cs2']);
  curl_multi_close($multiCurl);

  $playtime = 0;
  foreach ($responsePlaytime as $game) {
    if ($game['appid'] == 730) {
      $playtime = round($game['playtime_forever'] / 60);
      break;
    }
  }

  writeCache($steam, 'timecreated', $responseTimeCreated);
  writeCache($steam, 'playtime_cs2', $playtime);

  return ['timecreated' => $responseTimeCreated, 'playtime_cs2' => $playtime];
}

function PutApiReport($steamid_intruder)
{
  $data = GetSteamData($steamid_intruder);
  $time = !empty($data['timecreated']) ? date('d.m.Y', $data['timecreated']) : 'Неизвестно';
  $playtime = !empty($data['playtime_cs2']) ? $data['playtime_cs2'] : 'Неизвестно';
  $bans = '';
  $bansdata = '';
  if (!empty(GetCache('settings')['blockdb_apikey'])) {
    $data2 = GetBanPlayer($steamid_intruder);
    if (!empty($data2)) {
      foreach ($data2 as $key) {
        $ctime = date('d.m.Y', $key['created_at']);
        $pname = $key['project_name'];
        $reason = $key['reason'];
        $bansdata .= <<<HTML
          <div class="blockdb_item">
              <span>
                  <li>{$ctime}</li>
                  <li>Проект: {$pname}</li>
              </span>
              <span>
                  <li>Причина</li>
                  <li class="blockdb_reason">{$reason}</li>
              </span>
          </div>
          HTML;
      }
    }
  }
  if (!empty(GetCache('settings')['blockdb_apikey'])) {
    $data2 = GetBanPlayer($steamid_intruder);
    if (!empty($data2)) {
      $bans = <<<HTML
          <div class="report_intruder_blockdb">
              <svg x="0" y="0" viewBox="0 0 100 100" xml:space="preserve">
                  <g>
                      <path d="M50 2.5C23.766 2.5 2.5 23.766 2.5 50S23.766 97.5 50 97.5 97.5 76.234 97.5 50 76.234 2.5 50 2.5zM14.375 50c.017-19.675 15.98-35.611 35.656-35.594a35.625 35.625 0 0 1 20.631 6.604c-.118.104-.252.178-.37.297L21.306 70.291c-.119.12-.193.253-.297.372A35.402 35.402 0 0 1 14.375 50zM50 85.625a35.402 35.402 0 0 1-20.662-6.635c.118-.104.252-.178.37-.297l48.985-48.984c.119-.12.193-.253.297-.371C90.4 45.365 86.66 67.609 70.632 79.02A35.625 35.625 0 0 1 50 85.625z"></path>
                  </g>
              </svg>
              Баны игрока в CS2
          </div>
          <div class="blockdb_list">
              {$bansdata}
          </div>
      HTML;
    }
  }

  return ['string' => $time, 'bans' => $bans, 'string2' => $playtime];
}

if (isset($_POST['acc_time']) && isset($_POST['steamid'])) {
  if (preg_match('/^(7656119)([0-9]{10})$/', $_POST['steamid'])) {
    $return = PutApiReport($_POST['steamid']);
  } else {
    $return = [];
  }
}


echo json_encode($return, JSON_UNESCAPED_UNICODE);
exit();
