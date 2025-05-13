<?php
define('IN_LR', true);
define('STORAGE', '../../../../storage/');
define('CACHE', STORAGE . 'cache/');
define('SESSIONS', CACHE . 'sessions/');

// Include essential functions.
require '../../../includes/functions.php';

// Include SourceQuery.
require __DIR__ . '../../../../ext/SourceQuery/bootstrap.php';

use xPaw\SourceQuery\SourceQuery;

$return = [];

$servers = $_POST['servers'] ?? [];
$servers_count = count($servers);

foreach ($servers as $i => $server) {
    $server_info = explode(":", $server['ip']);
    $server_ip = $server_info[0];
    $server_port = $server_info[1];
    $fake_ip = $server['fakeip'];
    $server_name = $server['name_custom'];
    $server_mod = $server['server_mod'];
    $server_country = mb_strtolower($server['server_country']);
    $server_city = $server['server_city'];
    $server_bage = $server['server_bage'];

    $Query = new SourceQuery();
    
    try {
        $Query->Connect($server_ip, $server_port, 1, SourceQuery::SOURCE);
        $info = $Query->GetInfo();
        $players = $Query->GetPlayers();
        $players = array_map(function($player) {
            return [
                'Name' => htmlspecialchars($player['Name']),
                'Frags' => (int)$player['Frags'],
                'TimeF' => htmlspecialchars($player['TimeF']),
            ];
        }, $players);

        $map_name = array_reverse(explode("/", $info['Map']))[0];
        $map_image_path = CACHE . 'img/maps/' . $info['AppID'] . '/' . $map_name . '.jpg';
        $map_image = file_exists($map_image_path) ? $map_name : '-';

        $return[$i] = [
            'ip' => $fake_ip,
            'HostName' => $server_name,
            'Map' => $map_name,
            'Map_image' => $map_image,
            'Players' => $info['Players'],
            'MaxPlayers' => $info['MaxPlayers'],
            'Mod' => $info['AppID'],
            'GameMode' => $server_mod,
            'City' => $server_city,
            'Country' => $server_country,
            'Bage' => $server_bage,
            'players' => $players,
        ];
    } catch (Exception $e) {
        $return[$i] = [
            'ip' => $fake_ip,
            'HostName' => 'Сервер отключен',
            'Map' => '-',
            'Map_image' => '-',
            'Players' => 0,
            'MaxPlayers' => 0,
            'Mod' => '730',
            'GameMode' => $server_mod,
            'City' => '',
            'Country' => '',
            'Bage' => '☠️ Недоступен',
            'players' => [],
        ];
    } finally {
        $Query->Disconnect();
    }
}

echo json_encode($return, JSON_UNESCAPED_UNICODE);
exit();