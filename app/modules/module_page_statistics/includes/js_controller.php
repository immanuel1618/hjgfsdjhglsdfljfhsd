<?php
if($_POST['stats']) {
    define('IN_LR', true);
    define('APP', '../../../../app/');
    define('STORAGE', '../../../../storage/');
    define('CACHE', STORAGE . 'cache/');
    define('MODULES', APP . 'modules/');
    define('SESSIONS', CACHE . 'sessions/');

    session_start();

    require '../../../ext/Db.php';
    $Db = new app\ext\Db;

    function ensure_directory_exists($dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    function set_module_cache($module, $data, $name) {
        $dir = MODULES . $module . '/temp';
        ensure_directory_exists($dir);
        file_put_contents($dir . '/' . $name . '.php', '<?php return ' . var_export($data, true) . ';');
    }

    function get_module_cache($module, $name) {
        $file = MODULES . $module . '/temp/' . $name . '.php';
        if (file_exists($file)) {
            return require $file;
        } else {
            $dir = MODULES . $module . '/temp';
            ensure_directory_exists($dir);
            file_put_contents($file, '<?php return [];');
            return [];
        }
    }

    $stats = [
        'CountPlayers' => 0,
        'CountAdmins' => 0,
        'CountBans' => 0,
        'CountMutes' => 0,
        'CountVip' => 0,
        'CountPlayers24' => 0,
        'Time' => time() + 30,
    ];

    $data = get_module_cache('module_page_statistics', 'stats');
    if (time() > ($data['Time'] ?? 0)) {
        for ($i = 0; $i < $Db->table_count['LevelsRanks']; $i++) {
            $stats['CountPlayers'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][$i]['USER_ID'], $Db->db_data['LevelsRanks'][$i]['DB_num'], 'SELECT COUNT(*) FROM ' . $Db->db_data['LevelsRanks'][$i]['Table'] . ' LIMIT 1')[0];
            $stats['CountPlayers24'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][$i]['USER_ID'], $Db->db_data['LevelsRanks'][$i]['DB_num'], 'SELECT COUNT(*) FROM ' . $Db->db_data['LevelsRanks'][$i]['Table'] . ' WHERE `lastconnect` >= UNIX_TIMESTAMP(CURDATE()) LIMIT 1')[0];
        }
        if (!empty($Db->db_data['AdminSystem'])) {
            for ($i = 0; $i < $Db->table_count['AdminSystem']; $i++) {
                $countBanMutes = $Db->query(
                    'AdminSystem',
                    $Db->db_data['AdminSystem'][$i]['USER_ID'],
                    $Db->db_data['AdminSystem'][$i]['DB_num'],
                    "SELECT 
                        (SELECT COUNT(*) FROM `as_admins` WHERE `id` != 1 LIMIT 1) AS count_admins, 
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '1' LIMIT 1) AS count_mutes,
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '2' LIMIT 1) AS count_gags,
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '3' LIMIT 1) AS count_silence,
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '0' LIMIT 1) AS count_bans"
                );
                $stats['CountMutes'] += $countBanMutes['count_mutes'] + $countBanMutes['count_gags'] + $countBanMutes['count_silence'];
                $stats['CountAdmins'] += $countBanMutes['count_admins'];
                $stats['CountBans'] += $countBanMutes['count_bans'];
            }
        }
        if (!empty($Db->db_data['Vips'])) {
            for ($i = 0; $i < $Db->table_count['Vips']; $i++) {
                $stats['CountVip'] += $Db->queryNum('Vips', $Db->db_data['Vips'][$i]['USER_ID'], $Db->db_data['Vips'][$i]['DB_num'], "SELECT COUNT(*) FROM `vip_users` LIMIT 1")[0];
            }
        }
        set_module_cache('module_page_statistics', $stats, 'stats');
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    exit();
}