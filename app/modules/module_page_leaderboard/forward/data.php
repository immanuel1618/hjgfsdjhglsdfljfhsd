<?php

$General->get_default_url_section('filter', 'value', array('value', 'kills', 'assists', 'playtime', 'headshots', 'deaths', 'playtime', 'kd', 'lastconnect') );

define('PLAYERS_ON_PAGE', '20');

$page_max = 0;

$server_group = (int) intval (get_section('server_group', '0'));

if ($server_group >= $Db->table_statistics_count) {
    get_iframe('L1', 'Данный сервер не существует') && die();
    $server_group = 0;
}

// Получаем номер страницы
$page_num = (int) intval (get_section('num', '1'));

$page_num <= 0 && get_iframe('L2', 'Данная страница не существует') && die();

// Проверка на подключенный мод - Levels Ranks
if (!empty($Db->db_data['LevelsRanks'])) {
    for ($d = 0; $d < $Db->table_count['LevelsRanks']; $d++) {
        $res_data[] = 
        [
            'statistics'    => 'LevelsRanks',          
            'name_servers'  => $Db->db_data['LevelsRanks'][$d]['name'],
            'mod'           => $Db->db_data['LevelsRanks'][$d]['mod'],
            'USER_ID'       => $Db->db_data['LevelsRanks'][$d]['USER_ID'],
            'data_db'       => $Db->db_data['LevelsRanks'][$d]['DB_num'],
            'data_servers'  => $Db->db_data['LevelsRanks'][$d]['Table']
        ];                    
    }
}

$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;

$page_max = ceil($Db->queryNum( 'LevelsRanks', $res_data[$server_group]['USER_ID'], $res_data[$server_group]['data_db'], "SELECT COUNT(*) FROM " . $res_data[$server_group]['data_servers'] . " WHERE `lastconnect` > 0")[0] / PLAYERS_ON_PAGE );
$res = $Db->queryAll('LevelsRanks', $res_data[$server_group]['USER_ID'], $res_data[$server_group]['data_db'], "SELECT `name`, `rank`, `steam`, `playtime`, `value`, `kills`, `assists`, `lastconnect`, `headshots`, `deaths`, CASE WHEN `deaths` = 0 THEN `deaths` = 1 END, TRUNCATE( `kills`/`deaths`, 2 ) AS `kd` FROM " . $res_data[$server_group]['data_servers'] . " WHERE `lastconnect` > 0 ORDER BY " . $_SESSION['filter'] . " DESC LIMIT " . ($page_num_min + 3) . "," . PLAYERS_ON_PAGE . "");
$top3 = $Db->queryAll( 'LevelsRanks', $res_data[$server_group]['USER_ID'], $res_data[$server_group]['data_db'], "SELECT `name`, `rank`, `steam`, `playtime`, `value`, `kills`, TRUNCATE( `kills`/`deaths`, 2 ) AS `kd` FROM " . $res_data[ $server_group ]['data_servers'] . " WHERE `lastconnect` > 0 order by `value` desc limit 3");
$user = $Db->queryAll( 'LevelsRanks', $res_data[$server_group]['USER_ID'], $res_data[$server_group]['data_db'], "SELECT `name`, `rank`, `steam`, `playtime`, `value`, `kills`, `assists`, `lastconnect`, `headshots`, `deaths`, CASE WHEN `deaths` = 0 THEN `deaths` = 1 END, TRUNCATE( `kills`/`deaths`, 2 ) AS `kd` FROM " . $res_data[ $server_group ]['data_servers'] . " WHERE `steam` = :steam", ["steam" => $_SESSION['steamid32']]);

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

$page_num > $page_max && get_iframe('L2', 'Данная страница не существует') && die();

$Modules->set_page_title( 'Лидерборд | ' . $General->arr_general['short_name']);