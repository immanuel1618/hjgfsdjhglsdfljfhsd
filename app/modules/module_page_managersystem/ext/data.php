<?php

/**
 * @author -r8 (@r8.dev)
 **/

use app\modules\module_page_managersystem\ext\Core;

$Core = new Core($Db, $General, $Translate, $Modules, $Router, $Notifications);

$Router->map('GET|POST', 'managersystem/[addadmin|addvip|addban|addmute|settings|access|admingroup|vipgroup|banreason|mutereason|punishmenttime|privilegestime|install|addwarn|onlineadmins:page]/', 'addadmin');
$Map = $Router->match();

define('PLAYERS_ON_PAGE', '20');
$page_num = (int) intval(get_section('num', '1'));
$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;
$server_group = $Core->AdminCore()->ServerGroup();
$res_system = $Core->AdminCore()->ModDBFor();

if (!$Core->TableSearch()) {
    $Access = $Db->queryAll('Core', 0, 0, "SELECT `id`, `steamid_access`, `add_admin_access`, `add_ban_access`, `add_mute_access`, `add_vip_access`, `add_warn_access`, `add_timecheck_access`, `add_access` FROM `lvl_web_managersystem_access`");

    $AddAdminAccess = false;
    $AddVipAccess = false;
    if (!$AddAdminAccess && isset($_SESSION['user_admin'])) {
        $AddAdminAccess = true;
    }
    if (!empty($Access)) {
        foreach ($Access as $key) {
            if ($key['steamid_access'] == $_SESSION['steamid64']) {
                $AddAdminAccess = $key['add_admin_access'] == true;
                $AddVipAccess = $key['add_vip_access'] == true;
            }
        }
    }
    $page = $AddAdminAccess ? ($Map['params']['page'] ?? 'addadmin') : ($AddVipAccess ? ($Map['params']['page'] ?? 'addvip') : ($Map['params']['page'] ?? 'addban'));
    if (!isset($_SESSION['steamid64'])) {
        get_iframe('MS2', 'Вы не авторизованы на сайте!');
    } elseif (isset($_SESSION['user_admin'])) {
    } elseif (empty($Access)) {
        get_iframe('MS4', 'У вас недостаточно прав доступа!');
    } else {
        $hasAccess = false;
        foreach ($Access as $key) {
            if ($key['steamid_access'] == $_SESSION['steamid64']) {
                $hasAccess = true;
                break;
            }
        }
        if (!$hasAccess) {
            get_iframe('MS4', 'У вас недостаточно прав доступа!');
        }
    }
    if (empty($res_system[$server_group]['admin_mod'])) {
        $page = $Map['params']['page'] ?? 'install';
    }
    if (in_array($page, ['settings', 'admingroup', 'vipgroup', 'banreason', 'mutereason', 'punishmenttime', 'privilegestime'])) if (!isset($_SESSION['steamid64'])) {
        get_iframe('MS2', 'Вы не авторизованы на сайте!');
    } elseif (!isset($_SESSION['user_admin'])) {
        get_iframe('MS3', 'Вы не являетесь администратором сайта!');
    }
    if ($page === 'access') {
        if (!isset($_SESSION['steamid64'])) {
            get_iframe('MS2', 'Вы не авторизованы на сайте!');
        }
        if (isset($_SESSION['user_admin'])) {
        } else {
            if (!empty($Access)) {
                foreach ($Access as $key) {
                    if ($key['steamid_access'] == $_SESSION['steamid64'] && $key['add_access'] == 0) {
                        get_iframe('MS4', 'У вас недостаточно прав доступа!');
                    }
                }
            }
        }
    }
    if ($page === 'addadmin') {
        if (!isset($_SESSION['steamid64'])) {
            get_iframe('MS2', 'Вы не авторизованы на сайте!');
        } elseif (empty($res_system[$server_group]['admin_mod'])) {
            get_iframe('MS1', 'Не подключен ни один из поддерживаемых модов! (AdminSystem | IksAdmin');
        }
        if (isset($_SESSION['user_admin'])) {
        } else {
            if (!empty($Access)) {
                foreach ($Access as $key) {
                    if ($key['steamid_access'] == $_SESSION['steamid64'] && $key['add_admin_access'] == 0) {
                        get_iframe('MS4', 'У вас недостаточно прав доступа!');
                    }
                }
            }
        }
    }
    if ($page === 'addvip') {
        if (!isset($_SESSION['steamid64'])) {
            get_iframe('MS2', 'Вы не авторизованы на сайте!');
        } elseif (empty($Db->db_data['Vips'])) {
            get_iframe('MS1', 'Не подключен поддерживаемый мод! (Vips)');
        }
        if (isset($_SESSION['user_admin'])) {
        } else {
            if (!empty($Access)) {
                foreach ($Access as $key) {
                    if ($key['steamid_access'] == $_SESSION['steamid64'] && $key['add_vip_access'] == 0) {
                        get_iframe('MS4', 'У вас недостаточно прав доступа!');
                    }
                }
            }
        }
    }
    if ($page === 'addban') {
        if (!isset($_SESSION['steamid64'])) {
            get_iframe('MS2', 'Вы не авторизованы на сайте!');
        } elseif (empty($res_system[$server_group]['admin_mod'])) {
            get_iframe('MS1', 'Не подключен ни один из поддерживаемых модов! (AdminSystem | IksAdmin)');
        }
        if (isset($_SESSION['user_admin'])) {
        } else {
            if (!empty($Access)) {
                foreach ($Access as $key) {
                    if ($key['steamid_access'] == $_SESSION['steamid64'] && $key['add_ban_access'] == 0) {
                        get_iframe('MS4', 'У вас недостаточно прав доступа!');
                    }
                }
            }
        }
    }
    if ($page === 'addmute') {
        if (!isset($_SESSION['steamid64'])) {
            get_iframe('MS2', 'Вы не авторизованы на сайте!');
        } elseif (empty($res_system[$server_group]['admin_mod'])) {
            get_iframe('MS1', 'Не подключен ни один из поддерживаемых модов! (AdminSystem | IksAdmin)');
        }
        if (isset($_SESSION['user_admin'])) {
        } else {
            if (!empty($Access)) {
                foreach ($Access as $key) {
                    if ($key['steamid_access'] == $_SESSION['steamid64'] && $key['add_mute_access'] == 0) {
                        get_iframe('MS4', 'У вас недостаточно прав доступа!');
                    }
                }
            }
        }
    }
    if ($page === 'install') {
        if (!empty($res_system[$server_group]['admin_mod'])) {
            get_iframe('MS1', 'Установка уже произведена!');
        }
    }
    if ($page === 'addwarn') {
        if (!isset($_SESSION['steamid64'])) {
            get_iframe('MS2', 'Вы не авторизованы на сайте!');
        } elseif (empty($res_system[$server_group]['admin_mod'])) {
            get_iframe('MS1', 'Не подключен ни один из поддерживаемых модов! (AdminSystem | IksAdmin');
        }
        if (isset($_SESSION['user_admin'])) {
        } else {
            if (!empty($Access)) {
                foreach ($Access as $key) {
                    if ($key['steamid_access'] == $_SESSION['steamid64'] && $key['add_warn_access'] == 0) {
                        get_iframe('MS4', 'У вас недостаточно прав доступа!');
                    }
                }
            }
        }
    }
    if ($page === 'onlineadmins') {
        if (!isset($_SESSION['steamid64'])) {
            get_iframe('MS2', 'Вы не авторизованы на сайте!');
        } elseif (empty($Db->db_data['AdminReward'])) {
            get_iframe('MS1', 'Не подключен поддерживаемый мод! (AdminReward)');
        }
        if (isset($_SESSION['user_admin'])) {
        } else {
            if (!empty($Access)) {
                foreach ($Access as $key) {
                    if ($key['steamid_access'] == $_SESSION['steamid64'] && $key['add_timecheck_access'] == 0) {
                        get_iframe('MS4', 'У вас недостаточно прав доступа!');
                    }
                }
            }
        }
    }
    if ($page === 'addwarn') {
        $page_max = ceil($Db->queryNum('Core', 0, 0, "SELECT COUNT(*) FROM `lvl_web_managersystem_warn`")[0] / PLAYERS_ON_PAGE);
    }
} else {
    if (isset($_SESSION['user_admin'])) {
        if (empty($res_system[$server_group]['admin_mod'])) {
            $page = $Map['params']['page'] ?? 'install';
        }
        if (!empty($res_system[$server_group]['admin_mod'])) {
            $page = $Map['params']['page'] ?? 'settings';
        }
    } else {
        get_iframe('MS5', 'Администратор сайта не настроил модуль!');
    }
}

if (!empty($res_system[$server_group]['admin_mod'])) {
    switch ($res_system[$server_group]['admin_mod']) {
        case 'AdminSystem':
            $server_id = $Core->AdminCore()->GetServerId();
            if ($server_id != 'all') {
                $MSAdminArray = $Db->queryAll('AdminSystem', 0, 0, "SELECT 
                    `as_admins`.`id`,
                    `as_admins`.`id` AS `admin_id`,
                    `as_admins`.`name`,
                    `as_admins`.`steamid`,
                    `as_admins`.`comment`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`flags`) AS `flags`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`immunity`) AS `immunity`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`expires`) AS `end`,
                    `as_admins_servers`.`group_id`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`server_id`) AS `server_id`
                FROM 
                    `as_admins`
                JOIN 
                    `as_admins_servers` 
                ON 
                    `as_admins`.`id` = `as_admins_servers`.`admin_id` WHERE (`server_id` = " . $server_id . " OR `server_id` = '-1')
                GROUP BY
                    `as_admins`.`id`, `as_admins_servers`.`group_id` 
                ORDER BY
                    `group_id` ASC");
                $MSAdmin = array_values(array_slice($MSAdminArray, $page_num_min, PLAYERS_ON_PAGE));
                $MSBan = $Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `as_punishments` WHERE `punish_type`= 0 AND (`server_id` = '$server_id' OR `server_id` = '-1') ORDER BY `created` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
                $MSMute = $Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `as_punishments` WHERE `punish_type` != 0 AND (`server_id` = '$server_id' OR `server_id` = '-1')  ORDER BY `created` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");

                if ($page === 'addadmin') {
                    $page_max = ceil(count($MSAdminArray) / PLAYERS_ON_PAGE);
                } elseif ($page === 'addban') {
                    $page_max = ceil($Db->queryNum('AdminSystem', 0, 0, "SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = 0 AND (`server_id` = '$server_id' OR `server_id` = '-1')")[0] / PLAYERS_ON_PAGE);
                } elseif ($page === 'addmute') {
                    $page_max = ceil($Db->queryNum('AdminSystem', 0, 0, "SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` != 0 AND (`server_id` = '$server_id' OR `server_id` = '-1')")[0] / PLAYERS_ON_PAGE);
                }
            } else {
                $MSAdminArray = $Db->queryAll('AdminSystem', 0, 0, "SELECT 
                    `as_admins`.`id`,
                    `as_admins`.`id` AS `admin_id`,
                    `as_admins`.`name`,
                    `as_admins`.`steamid`,
                    `as_admins`.`comment`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`flags`) AS `flags`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`immunity`) AS `immunity`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`expires`) AS `end`,
                    `as_admins_servers`.`group_id`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`server_id`) AS `server_id`
                FROM 
                    `as_admins`
                JOIN 
                    `as_admins_servers` 
                ON 
                    `as_admins`.`id` = `as_admins_servers`.`admin_id`
                GROUP BY
                    `as_admins`.`id`, `as_admins_servers`.`group_id` 
                ORDER BY
                    `group_id` ASC");
                $MSAdmin = array_values(array_slice($MSAdminArray, $page_num_min, PLAYERS_ON_PAGE));
                $MSBan = $Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `as_punishments` WHERE `punish_type`= 0 ORDER BY `created` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
                $MSMute = $Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `as_punishments` WHERE `punish_type` != 0 ORDER BY `created` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");

                if ($page === 'addadmin') {
                    $page_max = ceil(count($MSAdminArray) / PLAYERS_ON_PAGE);
                } elseif ($page === 'addban') {
                    $page_max = ceil($Db->queryNum('AdminSystem', 0, 0, "SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = 0")[0] / PLAYERS_ON_PAGE);
                } elseif ($page === 'addmute') {
                    $page_max = ceil($Db->queryNum('AdminSystem', 0, 0, "SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` != 0")[0] / PLAYERS_ON_PAGE);
                }
            }
            break;
        case 'IksAdmin':
            $server_id = $Core->AdminCore()->GetServerId();
            if ($server_id != 'all') {
                $MSAdminArray = $Db->queryAll('IksAdmin', 0, 0, "SELECT 
                    `iks_admins`.`id`,
                    `iks_admins`.`name`,
                    `iks_admins`.`steam_id` AS `steamid`,
                    `iks_admins`.`flags`,
                    CASE 
                        WHEN `iks_admins`.`group_id` IS NULL THEN NULL
                        ELSE COALESCE(`iks_groups`.`immunity`, `iks_admins`.`immunity`)
                    END AS `immunity`,
                    `iks_admins`.`end_at` AS `end`,
                    `iks_admins`.`group_id`,
                    GROUP_CONCAT(DISTINCT `iks_admin_to_server`.`server_id`) AS `server_id`
                FROM 
                    `iks_admins`
                JOIN 
                    `iks_admin_to_server` 
                ON 
                    `iks_admins`.`id` = `iks_admin_to_server`.`admin_id`
                LEFT JOIN
                    `iks_groups`
                ON
                    `iks_admins`.`group_id` = `iks_groups`.`id`
                WHERE
                    (`iks_admin_to_server`.`server_id` = :server_id OR `iks_admin_to_server`.`server_id` IS NULL) AND `is_disabled` = 0
                GROUP BY
                    `iks_admins`.`id`, `iks_admin_to_server`.`admin_id`
                ORDER BY `immunity` DESC", ['server_id' => $server_id]);
                $MSAdmin = array_values(array_slice($MSAdminArray, $page_num_min, PLAYERS_ON_PAGE));
                $MSBan = $Db->queryAll('IksAdmin', 0, 0, "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_bans` WHERE (`server_id` = :server_id OR `server_id` IS NULL) ORDER BY `created_at` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "", ['server_id' => $server_id]);
                $MSMute = $Db->queryAll('IksAdmin', 0, 0, "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_comms` WHERE (`server_id` = :server_id OR `server_id` IS NULL) ORDER BY `created_at` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "", ['server_id' => $server_id]);

                if ($page === 'addadmin') {
                    $page_max = ceil(count($MSAdminArray) / PLAYERS_ON_PAGE);
                } elseif ($page === 'addban') {
                    $page_max = ceil($Db->queryNum('IksAdmin', 0, 0, "SELECT COUNT(*) FROM `iks_bans` WHERE (`server_id` = :server_id OR `server_id` IS NULL)", ['server_id' => $server_id])[0] / PLAYERS_ON_PAGE);
                } elseif ($page === 'addmute') {
                    $page_max = ceil($Db->queryNum('IksAdmin', 0, 0, "SELECT COUNT(*) FROM `iks_comms` WHERE (`server_id` = :server_id OR `server_id` IS NULL)", ['server_id' => $server_id])[0] / PLAYERS_ON_PAGE);
                }
            } else {
                $MSAdminArray = $Db->queryAll('IksAdmin', 0, 0, "SELECT 
                    `iks_admins`.`id`,
                    `iks_admins`.`name`,
                    `iks_admins`.`steam_id` AS `steamid`,
                    `iks_admins`.`flags`,
                    CASE 
                        WHEN `iks_admins`.`group_id` IS NULL THEN NULL
                        ELSE COALESCE(`iks_groups`.`immunity`, `iks_admins`.`immunity`)
                    END AS `immunity`,
                    `iks_admins`.`end_at` AS `end`,
                    `iks_admins`.`group_id`,
                    GROUP_CONCAT(DISTINCT `iks_admin_to_server`.`server_id`) AS `server_id`
                FROM 
                    `iks_admins`
                JOIN 
                    `iks_admin_to_server` 
                ON 
                    `iks_admins`.`id` = `iks_admin_to_server`.`admin_id`
                LEFT JOIN
                    `iks_groups`
                ON
                    `iks_admins`.`group_id` = `iks_groups`.`id`
                WHERE
                    `is_disabled` = 0
                GROUP BY
                    `iks_admins`.`id`, `iks_admin_to_server`.`admin_id`
                ORDER BY `immunity` DESC");
                $MSAdmin = array_values(array_slice($MSAdminArray, $page_num_min, PLAYERS_ON_PAGE));
                $MSBan = $Db->queryAll('IksAdmin', 0, 0, "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_bans`  ORDER BY `created_at` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "", ['server_id' => $server_id]);
                $MSMute = $Db->queryAll('IksAdmin', 0, 0, "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_comms` ORDER BY `created_at` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "", ['server_id' => $server_id]);

                if ($page === 'addadmin') {
                    $page_max = ceil(count($MSAdminArray) / PLAYERS_ON_PAGE);
                } elseif ($page === 'addban') {
                    $page_max = ceil($Db->queryNum('IksAdmin', 0, 0, "SELECT COUNT(*) FROM `iks_bans`")[0] / PLAYERS_ON_PAGE);
                } elseif ($page === 'addmute') {
                    $page_max = ceil($Db->queryNum('IksAdmin', 0, 0, "SELECT COUNT(*) FROM `iks_comms`")[0] / PLAYERS_ON_PAGE);
                }
            }
            break;
    }
}

if (!empty($Db->db_data['Vips'])) {
    $server_group_vip = $Core->VipCore()->ServerGroupVip();
    $res_vip = $Core->VipCore()->ModDBForVip();
    if ($Core->GetCache('settings')['vip_one_table'] == 1) {
        $sid = $Core->VipCore()->GetServerIdVip();
        if ($sid != 'all') {
            if (empty($Core->GetCache('settings')['group_test'])) {
                $VipUser = $Db->queryAll('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT `account_id`, `name`, `sid`, `group`, `expires` FROM `" . $res_vip[0]['Table'] . "users` WHERE `sid` = '" . $sid . "' ORDER BY `expires` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
            } else {
                $VipUser = $Db->queryAll('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT `account_id`, `name`, `sid`, `group`, `expires` FROM `" . $res_vip[0]['Table'] . "users` WHERE `sid` = '" . $sid . "' AND `group` != '" . $Core->GetCache('settings')['group_test'] . "' ORDER BY `expires` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
            }
            if ($page === 'addvip') {
                if (empty($Core->GetCache('settings')['group_test'])) {
                    $page_max = ceil($Db->queryNum('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT COUNT(*) FROM `" . $res_vip[0]['Table'] . "users` WHERE `sid` = '" . $sid . "'")[0] / PLAYERS_ON_PAGE);
                } else {
                    $page_max = ceil($Db->queryNum('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT COUNT(*) FROM `" . $res_vip[0]['Table'] . "users` WHERE `sid` = '" . $sid . "' AND `group` != '" . $Core->GetCache('settings')['group_test'] . "'")[0] / PLAYERS_ON_PAGE);
                }
            }
        } else {
            if (empty($Core->GetCache('settings')['group_test'])) {
                $VipUser = $Db->queryAll('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT `account_id`, `name`, `sid`, `group`, `expires` FROM `" . $res_vip[0]['Table'] . "users` ORDER BY `expires` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
            } else {
                $VipUser = $Db->queryAll('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT `account_id`, `name`, `sid`, `group`, `expires` FROM `" . $res_vip[0]['Table'] . "users` WHERE `group` != '" . $Core->GetCache('settings')['group_test'] . "' ORDER BY `expires` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
            }
            if ($page === 'addvip') {
                if (empty($Core->GetCache('settings')['group_test'])) {
                    $page_max = ceil($Db->queryNum('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT COUNT(*) FROM `" . $res_vip[0]['Table'] . "users`")[0] / PLAYERS_ON_PAGE);
                } else {
                    $page_max = ceil($Db->queryNum('Vips', $res_vip[0]['USER_ID'], $res_vip[0]['DB_num'], "SELECT COUNT(*) FROM `" . $res_vip[0]['Table'] . "users` WHERE `group` != '" . $Core->GetCache('settings')['group_test'] . "'")[0] / PLAYERS_ON_PAGE);
                }
            }
        }
    } else {
        if (empty($Core->GetCache('settings')['group_test'])) {
            $VipUser = $Db->queryAll('Vips', $res_vip[$server_group_vip]['USER_ID'], $res_vip[$server_group_vip]['DB_num'], "SELECT `account_id`, `name`, `sid`, `group`, `expires` FROM `" . $res_vip[$server_group_vip]['Table'] . "users` ORDER BY `expires` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
        } else {
            $VipUser = $Db->queryAll('Vips', $res_vip[$server_group_vip]['USER_ID'], $res_vip[$server_group_vip]['DB_num'], "SELECT `account_id`, `name`, `sid`, `group`, `expires` FROM `" . $res_vip[$server_group_vip]['Table'] . "users` WHERE `group` != '" . $Core->GetCache('settings')['group_test'] . "' ORDER BY `expires` DESC LIMIT {$page_num_min}," . PLAYERS_ON_PAGE . "");
        }
        if ($page === 'addvip') {
            if (empty($Core->GetCache('settings')['group_test'])) {
                $page_max = ceil($Db->queryNum('Vips', $res_vip[$server_group_vip]['USER_ID'], $res_vip[$server_group_vip]['DB_num'], "SELECT COUNT(*) FROM `" . $res_vip[$server_group_vip]['Table'] . "users`")[0] / PLAYERS_ON_PAGE);
            } else {
                $page_max = ceil($Db->queryNum('Vips', $res_vip[$server_group_vip]['USER_ID'], $res_vip[$server_group_vip]['DB_num'], "SELECT COUNT(*) FROM `" . $res_vip[$server_group_vip]['Table'] . "users` WHERE `group` != '" . $Core->GetCache('settings')['group_test'] . "'")[0] / PLAYERS_ON_PAGE);
            }
        }
    }
}

if (!empty($Db->db_data['AdminReward'])) {
    $ARServer = $Db->queryAll('AdminReward', $Db->db_data['AdminReward'][0]['USER_ID'], $Db->db_data['AdminReward'][0]['DB_num'], "SELECT `SRV_ID`, `srvname` FROM `" . $Db->db_data['AdminReward'][0]['Table'] . "servers`");
    $SRV_ID = $Core->AdminCore()->GetServerIdAR();
    $ARMinData = $Db->queryAll('AdminReward', $Db->db_data['AdminReward'][0]['USER_ID'], $Db->db_data['AdminReward'][0]['DB_num'], "SELECT MIN(`date`) AS min_date FROM `" . $Db->db_data['AdminReward'][0]['Table'] . "info`");
    if ($page === 'onlineadmins') {
        if (empty($_GET['start_date']) && empty($_GET['end_date'])) {
            $start_date = null;
            $end_date = date('Y-m-d');
        } else {
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
        }
    }
    $ARAdminInfoTime = array();
    if ($SRV_ID != 'all') {
        $ARAdminInfo = $Db->queryAll('AdminReward', $Db->db_data['AdminReward'][0]['USER_ID'], $Db->db_data['AdminReward'][0]['DB_num'], "SELECT `id`, `steamid`, SUM(`time`) AS total_time, MAX(`date`) AS newest_date, `SRV_ID` FROM `" . $Db->db_data['AdminReward'][0]['Table'] . "info` WHERE `SRV_ID` = '{$SRV_ID}' AND `date` BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY `steamid`, `SRV_ID` ORDER BY `total_time` DESC");
    } else {
        $ARAdminInfo = $Db->queryAll('AdminReward', $Db->db_data['AdminReward'][0]['USER_ID'], $Db->db_data['AdminReward'][0]['DB_num'], "SELECT `id`, `steamid`, SUM(`time`) AS total_time, MAX(`date`) AS newest_date FROM `" . $Db->db_data['AdminReward'][0]['Table'] . "info` WHERE `date` BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY `steamid` ORDER BY `total_time` DESC");
    }

    foreach ($ARAdminInfo as $row) {
        $steamid = $row['steamid'];
        $newest_date = strtotime(str_replace('-', '/', $row['newest_date']));
        if (!isset($ARAdminInfoTime[$steamid])) {
            $ARAdminInfoTime[$steamid] = array(
                'steamid' => $steamid,
                'newest_date' => $newest_date,
                'total_time' => 0,
                'id' => $row['id']
            );
        }
        $ARAdminInfoTime[$steamid]['total_time'] += $row['total_time'];
    }

    $ARAdminInfoTime = array_values(array_slice($ARAdminInfoTime, $page_num_min, PLAYERS_ON_PAGE));

    if ($page === 'onlineadmins') {
        $page_max = ceil(count($ARAdminInfo) / PLAYERS_ON_PAGE);
    }
}

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
if (isset($_SESSION['user_admin']) || $hasAccess) {
    if (isset($_POST['save_db'])) {
        exit(json_encode($Core->InstallMod($_POST), true));
    } elseif (isset($_POST['ms_settings_add_table'])) {
        exit(json_encode($Core->SettingsCore()->Create_Table(), true));
    } elseif (isset($_POST['ms_settings_general'])) {
        exit(json_encode($Core->SettingsCore()->Update_Settings_General($_POST), true));
    } elseif (isset($_POST['ms_settings_general_additional'])) {
        exit(json_encode($Core->SettingsCore()->Update_Settings_Additional($_POST), true));
    } elseif (isset($_POST['ms_settings_servers'])) {
        exit(json_encode($Core->SettingsCore()->Create_Server_Iks($_POST), true));
    } elseif (isset($_POST['ms_access_add'])) {
        exit(json_encode($Core->SettingsCore()->Access_Add($_POST), true));
    } elseif (isset($_POST['ms_access_del'])) {
        exit(json_encode($Core->SettingsCore()->Access_Delete($_POST), true));
    } elseif (isset($_POST['ms_access_edit'])) {
        exit(json_encode($Core->SettingsCore()->Access_Edit($_POST, $_GET['ms_access_edit']), true));
    } elseif (isset($_POST['ms_admin_group_add'])) {
        exit(json_encode($Core->SettingsCore()->Admin_Group_Add($_POST), true));
    } elseif (isset($_POST['ms_admin_group_del'])) {
        exit(json_encode($Core->SettingsCore()->Admin_Group_Del($_POST), true));
    } elseif (isset($_POST['ms_vip_group_add'])) {
        exit(json_encode($Core->SettingsCore()->Vip_Group_Add($_POST), true));
    } elseif (isset($_POST['ms_vip_group_del'])) {
        exit(json_encode($Core->SettingsCore()->Vip_Group_Del($_POST), true));
    } elseif (isset($_POST['ms_reason_ban_add'])) {
        exit(json_encode($Core->SettingsCore()->Reason_Ban_Add($_POST), true));
    } elseif (isset($_POST['ms_reason_ban_del'])) {
        exit(json_encode($Core->SettingsCore()->Reason_Ban_Del($_POST), true));
    } elseif (isset($_POST['ms_reason_mute_add'])) {
        exit(json_encode($Core->SettingsCore()->Reason_Mute_Add($_POST), true));
    } elseif (isset($_POST['ms_reason_mute_del'])) {
        exit(json_encode($Core->SettingsCore()->Reason_Mute_Del($_POST), true));
    } elseif (isset($_POST['ms_privileges_time_add'])) {
        exit(json_encode($Core->SettingsCore()->Privileges_Time_Add($_POST), true));
    } elseif (isset($_POST['ms_privileges_time_del'])) {
        exit(json_encode($Core->SettingsCore()->Privileges_Time_Del($_POST), true));
    } elseif (isset($_POST['ms_punishment_time_add'])) {
        exit(json_encode($Core->SettingsCore()->Punishment_Time_Add($_POST), true));
    } elseif (isset($_POST['ms_punishment_time_del'])) {
        exit(json_encode($Core->SettingsCore()->Punishment_Time_Del($_POST), true));
    } elseif (isset($_POST['ms_admins_add'])) {
        exit(json_encode($Core->AdminCore()->Admin_Add($_POST), true));
    } elseif (isset($_POST['ms_admin_del'])) {
        exit(json_encode($Core->AdminCore()->Admin_Del($_POST), true));
    } elseif (isset($_POST['ms_admin_edit'])) {
        exit(json_encode($Core->AdminCore()->Admin_Edit($_POST, $_GET['ms_admin_edit'], $_GET['group_id']), true));
    } elseif (isset($_POST['ms_ban_add'])) {
        exit(json_encode($Core->AdminCore()->Ban_Add($_POST), true));
    } elseif (isset($_POST['ms_ban_del'])) {
        exit(json_encode($Core->AdminCore()->Ban_Del($_POST), true));
    } elseif (isset($_POST['ms_ban_unban'])) {
        exit(json_encode($Core->AdminCore()->Ban_Unban($_POST), true));
    } elseif (isset($_POST['ms_mute_add'])) {
        exit(json_encode($Core->AdminCore()->Mute_Add($_POST), true));
    } elseif (isset($_POST['ms_mute_del'])) {
        exit(json_encode($Core->AdminCore()->Mute_Del($_POST), true));
    } elseif (isset($_POST['ms_mute_unban'])) {
        exit(json_encode($Core->AdminCore()->Mute_Unban($_POST), true));
    } elseif (isset($_POST['ms_vip_add'])) {
        exit(json_encode($Core->VipCore()->Vip_Add($_POST), true));
    } elseif (isset($_POST['ms_vip_del'])) {
        exit(json_encode($Core->VipCore()->Vip_Del($_POST), true));
    } elseif (isset($_POST['ms_vip_edit'])) {
        exit(json_encode($Core->VipCore()->Vip_Edit($_POST, $_GET['ms_vip_edit'],  $_GET['sid']), true));
    } elseif (isset($_POST['ms_server_del'])) {
        exit(json_encode($Core->SettingsCore()->Del_Server_Iks($_POST), true));
    } elseif (isset($_POST['ms_warn_add'])) {
        exit(json_encode($Core->AdminCore()->Add_Warn($_POST), true));
    } elseif (isset($_POST['ms_warn_del'])) {
        exit(json_encode($Core->AdminCore()->Del_Warn($_POST), true));
    } elseif (isset($_POST['ms_expires_del'])) {
        exit(json_encode($Core->VipCore()->Del_Expires_Vip(), true));
    } elseif (isset($_POST['ms_ar_moon_del'])) {
        exit(json_encode($Core->AdminCore()->Del_Ar_Moon(), true));
    } elseif (isset($_POST['ms_ar_del'])) {
        exit(json_encode($Core->AdminCore()->Del_Ar_User($_POST), true));
    } elseif (isset($_POST['ms_server_vip_del'])) {
        exit(json_encode($Core->SettingsCore()->Del_Server_Vip($_POST), true));
    } elseif (isset($_POST['ms_settings_servers_vip'])) {
        exit(json_encode($Core->SettingsCore()->Create_Server_Vip($_POST), true));
    } elseif (isset($_POST['search_admin']) || isset($_POST['search_vip']) || isset($_POST['search_ban']) || isset($_POST['search_mute']) || isset($_POST['search_ar'])) {
        $Core->Search()->SearchPost($_POST['search_admin'], $_POST['search_vip'], $_POST['search_ban'], $_POST['search_mute'], $_POST['search_ar']);
        exit($Core->Search()->returnJSON());
    }
}

$Modules->set_page_title("{$Translate->get_translate_module_phrase('module_page_managersystem', '_MSPageName')} | {$General->arr_general['short_name']}");
