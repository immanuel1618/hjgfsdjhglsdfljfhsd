<?php

if (IN_LR != true) { header_fix($General->arr_general['site']); exit; }

if (!isset($_SESSION['user_admin']) || $Module->installerStatus() == 'installed') { header_fix($General->arr_general['site'] . 'admins_online'); exit; }

$checkTables =  array (
    'lvl_web_admins_stats',
    'lvl_web_admins_stats_servers',
    'lvl_web_admins_stats_access'
);

$absentTables = [];
foreach ($checkTables as $table) {
    if(!$Db->mysql_table_search('Core', $Db->db_data['Core'][0]['USER_ID'], $Db->db_data['Core'][0]['DB_num'], $table)){
        $absentTables[$table] = true;
    }
}

$queryies = [];
if (!empty($absentTables) || true) {
    $queryies = [      
        "CREATE TABLE IF NOT EXISTS `lvl_web_admins_stats` (`period` int default 2629743, `required_playtime` int default null, `all_admin_access` tinyint default 1);",
        "CREATE TABLE IF NOT EXISTS `lvl_web_admins_stats_servers` (`id` int not null AUTO_INCREMENT, `server_id` int not null, `iks_server_id` varchar(20) not null, PRIMARY key(`id`));",
        "CREATE TABLE IF NOT EXISTS `lvl_web_admins_stats_access` (`id` int not null AUTO_INCREMENT, `steamid64` bigint not null, PRIMARY key(`id`));"
    ];
}

foreach ($queryies as $query) {
    $Db->query('Core', 0, 0, $query);
}