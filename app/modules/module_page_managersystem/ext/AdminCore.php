<?php

/**
 * @author -r8 (@r8.dev)
 **/

namespace app\modules\module_page_managersystem\ext;

use app\modules\module_page_managersystem\ext\Core;

class AdminCore extends Core
{
    protected $Db, $General, $Translate, $Modules, $Notifications, $Router, $GetServerIdAR, $GetServerId;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications, $Router)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
        $this->Router = $Router;
        $this->GetServerIdAR = $this->GetServerIdAR();
        $this->GetServerId = $this->GetServerId();
    }

    public function Warn()
    {
        return $this->Db->queryAll('Core', 0, 0, "SELECT `id`, `steamid`, `reason`, `time`, `createtime` FROM `lvl_web_managersystem_warn` ORDER BY `createtime` DESC");
    }

    public function Groups()
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    return $this->Db->queryAll('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `id`, `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups`");
                    break;
                case 'IksAdmin':
                    return $this->Db->queryAll('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `id`, `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups`");
                    break;
                default;
            }
        }
    }

    public function ServerGroup()
    {
        return (int) intval(get_section('server_id_admin', '0'));
    }

    public function GetServerId()
    {
        $this->Router->map('GET|POST', 'managersystem/[addadmin|addban|addmute:page]/[:server_id]/', 'addadmin');
        return $this->Router->match()['params']['server_id'] ?? 'all';
    }

    public function GetServerIdAR()
    {
        $this->Router->map('GET|POST', 'managersystem/[onlineadmins:page]/[:SRV_ID]/', 'onlineadmins');
        return $this->Router->match()['params']['SRV_ID'] ?? 'all';
    }

    public function ModDBFor()
    {
        if (!empty($this->Db->db_data['AdminSystem'])) {
            for ($i = 0; $i < $this->Db->table_count['AdminSystem']; $i++) {
                $res_system[] = [
                    'admin_mod' => 'AdminSystem',
                    'USER_ID' => $this->Db->db_data['AdminSystem'][$i]['USER_ID'],
                    'DB_num' => $this->Db->db_data['AdminSystem'][$i]['DB_num'],
                    'Table' => $this->Db->db_data['AdminSystem'][$i]['Table'],
                    'Name' => $this->Db->db_data['AdminSystem'][$i]['name']
                ];
            }
        }

        if (!empty($this->Db->db_data['IksAdmin'])) {
            for ($i = 0; $i < $this->Db->table_count['IksAdmin']; $i++) {
                $res_system[] = [
                    'admin_mod' => 'IksAdmin',
                    'USER_ID' => $this->Db->db_data['IksAdmin'][$i]['USER_ID'],
                    'DB_num' => $this->Db->db_data['IksAdmin'][$i]['DB_num'],
                    'Table' => $this->Db->db_data['IksAdmin'][$i]['Table'],
                    'Name' => $this->Db->db_data['IksAdmin'][$i]['name']
                ];
            }
        }

        return $res_system;
    }

    public function Admin_Add($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    $steam64 = $this->Steam64_ID($POST['steamid']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($this->GetCache('serversiks'))) {
                        if ($this->GetServerId() == 'all') {
                            $server = count($POST['server_id']) > 1 ? $POST['server_id'] : $POST['server_id'][0] ?? '-1';
                            $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode(' | ', $POST['server_id']);
                        } else {
                            $server = $this->GetServerId();
                            $server_id = $this->GetServerId();
                        }
                    } else {
                        $server = $POST['server_id'] ?? '-1';
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $POST['server_id'];
                    }
                    if ($this->GetCache('settings')['group_choice_admin'] == 1 && $this->GetCache('settings')['time_choice_privileges'] == 0) {
                        if (!isset($POST['end']) || $POST['end'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                        }
                        if ($POST['end'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['end'] == 0) {
                            $end = 0;
                        } else {
                            $end = (float) ($POST['end']) * 24 * 60 * 60 + time();
                        }

                        $res = $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups` WHERE `id` = :id", ['id' => $POST['group_choice_admin']]);

                        if ($res) {
                            $AdminAdd = [
                                "steamid" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "flags" => '',
                                "immunity" => -1,
                                "expires" => $end,
                                "server_id" => $server,
                                "group_id" => $POST['group_choice_admin'],
                            ];
                        }

                        if (empty(array_filter($AdminAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            $isset_admin = $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steamid` = :steamid;", [
                                "steamid" => $steam64
                            ]);
                            if (!isset($isset_admin['steamid'])):
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins` (`name`, `steamid`) VALUES (:name, :steamid);", [
                                    "steamid" => $steam64,
                                    "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                ]);
                            endif;
                            $admin_id = $this->Db->lastInsertId('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num']);
                            if (count($server) > 1):
                                foreach ($server as $server_for):
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins_servers` (`admin_id`, `flags`, `immunity`, `group_id`, `expires`, `server_id`) VALUES (:admin_id, :flags, :immunity, :group_id, :expires, :server_id) ON DUPLICATE KEY UPDATE `flags` = :flags, `immunity` = :immunity, `group_id` = :group_id, `expires` = :expires, `server_id` = :server_id;", [
                                        "admin_id" => $admin_id,
                                        "flags" => '',
                                        "immunity" => 0,
                                        "expires" => $end,
                                        "server_id" => $server_for,
                                        "group_id" => $POST['group_choice_admin'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins_servers` (`admin_id`, `flags`, `immunity`, `group_id`, `expires`, `server_id`) VALUES (:admin_id, :flags, :immunity, :group_id, :expires, :server_id) ON DUPLICATE KEY UPDATE `flags` = :flags, `immunity` = :immunity, `group_id` = :group_id, `expires` = :expires, `server_id` = :server_id;", [
                                    "admin_id" => $admin_id,
                                    "flags" => '',
                                    "immunity" => 0,
                                    "expires" => $end,
                                    "server_id" => $server,
                                    "group_id" => $POST['group_choice_admin'],
                                ]);
                            endif;
                            $end_2 = (float) ($POST['end']) * 24 * 60 * 60;
                            $end_embed = empty($end_2) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($end_2);

                            $response = $this->Rcons("mm_as_reload_admin " . $steam64);

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebNewAdmin')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebPravGroup')} {$res['name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebFlags')} {$res['flags']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebImm')} {$res['immunity']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                $this->Notifications->SendNotification($steam64, '_MSPageName', '_MSAdminGift', ['agroup' => $res['name'], 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['group_choice_admin'] == 1 && $this->GetCache('settings')['time_choice_privileges'] == 1) {
                        $res_time = '';
                        foreach ($this->GetCache('privilegestime') as $time) {
                            if ($time['id'] == $POST['time_choice_privileges']) {
                                $res_time = $time['duration'];
                                break;
                            }
                        }
                        $res_group = $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups` WHERE `id` = :id", ['id' => $POST['group_choice_admin']]);

                        if (empty($POST['time_choice_privileges']) && (!isset($POST['end']) || $POST['end'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_privileges']) && (!empty($POST['end']) || $POST['end'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['end'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['end']) || $POST['end'] !== '') && empty($POST['time_choice_privileges']) && $POST['end'] != 0) {
                            $end = (float) ($POST['end']) * 24 * 60 * 60 + time();
                        } elseif (empty($POST['time_choice_privileges']) && $POST['end'] == 0) {
                            $end = 0;
                        } elseif ((!isset($POST['end']) || $POST['end'] === '') && $res_time == 0) {
                            $end = 0;
                        } elseif (!empty($POST['time_choice_privileges']) && (!isset($POST['end']) || $POST['end'] === '')) {
                            $end = $res_time + time();
                        }

                        if ($res_group) {
                            $AdminAdd = [
                                "steamid" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "flags" => '',
                                "immunity" => 0,
                                "expires" => $end,
                                "server_id" => $server,
                                "group_id" => $POST['group_choice_admin'],
                            ];
                        }

                        if (empty(array_filter($AdminAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            $isset_admin = $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steamid` = :steamid;", [
                                "steamid" => $steam64
                            ]);
                            if (!isset($isset_admin['steamid'])):
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins` (`name`, `steamid`) VALUES (:name, :steamid);", [
                                    "steamid" => $steam64,
                                    "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                ]);
                                $admin_id = $this->Db->lastInsertId('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num']);
                            else:
                                $admin_id = $isset_admin['id'];
                            endif;
                            if (empty($admin_id))
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            if (count($server) > 1):
                                foreach ($server as $server_for):
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins_servers` (`admin_id`, `flags`, `immunity`, `group_id`, `expires`, `server_id`) VALUES (:admin_id, :flags, :immunity, :group_id, :expires, :server_id) ON DUPLICATE KEY UPDATE `flags` = :flags, `immunity` = :immunity, `group_id` = :group_id, `expires` = :expires, `server_id` = :server_id;", [
                                        "admin_id" => $admin_id,
                                        "flags" => '',
                                        "immunity" => 0,
                                        "expires" => $end,
                                        "server_id" => $server_for,
                                        "group_id" => $POST['group_choice_admin'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins_servers` (`admin_id`, `flags`, `immunity`, `group_id`, `expires`, `server_id`) VALUES (:admin_id, :flags, :immunity, :group_id, :expires, :server_id) ON DUPLICATE KEY UPDATE `flags` = :flags, `immunity` = :immunity, `group_id` = :group_id, `expires` = :expires, `server_id` = :server_id;", [
                                    "admin_id" => $admin_id,
                                    "flags" => '',
                                    "immunity" => 0,
                                    "expires" => $end,
                                    "server_id" => $server,
                                    "group_id" => $POST['group_choice_admin'],
                                ]);
                            endif;

                            $end_embed = empty($res_time) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res_time);

                            $response = $this->Rcons("mm_as_reload_admin " . $steam64);

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebNewAdmin')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebPravGroup')} {$res_group['name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebFlags')} {$res_group['flags']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebImm')} {$res_group['immunity']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                $this->Notifications->SendNotification($steam64, '_MSPageName', '_MSAdminGift', ['agroup' => $res_group['name'], 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminAdd')];
                            }
                        }
                    }
                    break;
                case 'IksAdmin':
                    $steam64 = $this->Steam64_ID($POST['steamid']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($this->GetCache('serversiks'))) {
                        if ($this->GetServerId() == 'all') {
                            $server = count($POST['server_id']) > 1 ? $POST['server_id'] : $POST['server_id'][0] ?? NULL;
                            $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode(' | ', $POST['server_id']);
                        } else {
                            $server = $this->GetServerId();
                            $server_id = $this->GetServerId();
                        }
                    } else {
                        $server = $POST['server_id'] ?? NULL;
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $POST['server_id'];
                    }
                    if ($this->GetCache('settings')['group_choice_admin'] == 1 && $this->GetCache('settings')['time_choice_privileges'] == 0) {
                        if (!isset($POST['end']) || $POST['end'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                        }
                        if ($POST['end'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['end'] == 0) {
                            $end = NULL;
                        } else {
                            $end = (float) ($POST['end']) * 24 * 60 * 60 + time();
                        }

                        $res = $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups` WHERE `id` = :id", ['id' => $POST['group_choice_admin']]);

                        if ($res) {
                            $AdminAdd = [
                                "steam_id" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "flags" => NULL,
                                "immunity" => NULL,
                                "end_at" => $end,
                                "server_id" => $server,
                                "group_id" => $POST['group_choice_admin'],
                                "is_disabled" => 0,
                                "created_at" => time(),
                                "updated_at" => time()
                            ];
                        }

                        if (empty(array_filter($AdminAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            $isset_admin = $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steam_id` = :steam_id AND `group_id` = :group_id;", [
                                "steam_id" => $steam64,
                                "group_id" => $AdminAdd['group_id']
                            ]);
                            if (!isset($isset_admin['steam_id']) || $isset_admin['group_id'] != $AdminAdd['group_id']):
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins` (`steam_id`, `name`, `flags`, `immunity`, `end_at`, `group_id`, `is_disabled`, `created_at`, `updated_at`) VALUES (:steam_id, :name, :flags, :immunity, :end_at, :group_id, :is_disabled, :created_at, :updated_at);", [
                                    "steam_id" => $steam64,
                                    "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                    "flags" => $AdminAdd['flags'],
                                    "immunity" => $AdminAdd['immunity'],
                                    "end_at" => $AdminAdd['end_at'],
                                    "group_id" => $AdminAdd['group_id'],
                                    "is_disabled" => $AdminAdd['is_disabled'],
                                    "created_at" => $AdminAdd['created_at'],
                                    "updated_at" => $AdminAdd['updated_at'],
                                ]);
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "admins` SET `name` = :name, `flags` = :flags, `immunity` = :immunity, `end_at` = :end_at, `group_id` = :group_id, `is_disabled` = :is_disabled, `updated_at` = :updated_at, `deleted_at` = :deleted_at WHERE `steam_id` = :steam_id AND `group_id` = :group_id;", [
                                    "steam_id" => $steam64,
                                    "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                    "flags" => $AdminAdd['flags'],
                                    "immunity" => $AdminAdd['immunity'],
                                    "end_at" => $AdminAdd['end_at'],
                                    "group_id" => $AdminAdd['group_id'],
                                    "is_disabled" => $AdminAdd['is_disabled'],
                                    "updated_at" => $AdminAdd['updated_at'],
                                    "deleted_at" => NULL,
                                ]);
                            endif;
                            $admin_id = $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `id` FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steam_id` = :steam_id AND `group_id` = :group_id;", [
                                'steam_id' => $steam64,
                                'group_id' => $AdminAdd['group_id']
                            ]);
                            if (count($server) > 1):
                                foreach ($server as $server_for):
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admin_to_server` (`admin_id`, `server_id`) VALUES (:admin_id, :server_id);", [
                                        "admin_id" => $admin_id['id'],
                                        "server_id" => $server_for
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admin_to_server` (`admin_id`, `server_id`) VALUES (:admin_id, :server_id);", [
                                    "admin_id" => $admin_id['id'],
                                    "server_id" => $server
                                ]);
                            endif;
                            $end_2 = (float) ($POST['end']) * 24 * 60 * 60;
                            $end_embed = empty($end_2) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($end_2);

                            $response = $this->Rcons("css_reload_infractions " . $steam64);

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebNewAdmin')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebPravGroup')} {$res['name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebFlags')} {$res['flags']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebImm')} {$res['immunity']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                $this->Notifications->SendNotification($steam64, '_MSPageName', '_MSAdminGift', ['agroup' => $res['name'], 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['group_choice_admin'] == 1 && $this->GetCache('settings')['time_choice_privileges'] == 1) {
                        $res_time = '';
                        foreach ($this->GetCache('privilegestime') as $time) {
                            if ($time['id'] == $POST['time_choice_privileges']) {
                                $res_time = $time['duration'];
                                break;
                            }
                        }
                        $res_group = $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups` WHERE `id` = :id", ['id' => $POST['group_choice_admin']]);

                        if (empty($POST['time_choice_privileges']) && (!isset($POST['end']) || $POST['end'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_privileges']) && (!empty($POST['end']) || $POST['end'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['end'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['end']) || $POST['end'] !== '') && empty($POST['time_choice_privileges']) && $POST['end'] != 0) {
                            $end = (float) ($POST['end']) * 24 * 60 * 60 + time();
                        } elseif (empty($POST['time_choice_privileges']) && $POST['end'] == 0) {
                            $end = NULL;
                        } elseif ((!isset($POST['end']) || $POST['end'] === '') && $res_time == 0) {
                            $end = NULL;
                        } elseif (!empty($POST['time_choice_privileges']) && (!isset($POST['end']) || $POST['end'] === '')) {
                            $end = $res_time + time();
                        }

                        if ($res_group) {
                            $AdminAdd = [
                                "steam_id" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "flags" => NULL,
                                "immunity" => NULL,
                                "end_at" => $end,
                                "server_id" => $server,
                                "group_id" => $POST['group_choice_admin'],
                                "is_disabled" => 0,
                                "created_at" => time(),
                                "updated_at" => time()
                            ];
                        }

                        if (empty(array_filter($AdminAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            $isset_admin = $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steam_id` = :steam_id AND `group_id` = :group_id;", [
                                "steam_id" => $steam64,
                                "group_id" => $AdminAdd['group_id']
                            ]);
                            if (!isset($isset_admin['steam_id']) || $isset_admin['group_id'] != $AdminAdd['group_id']):
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins` (`steam_id`, `name`, `flags`, `immunity`, `end_at`, `group_id`, `is_disabled`, `created_at`, `updated_at`) VALUES (:steam_id, :name, :flags, :immunity, :end_at, :group_id, :is_disabled, :created_at, :updated_at);", [
                                    "steam_id" => $steam64,
                                    "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                    "flags" => $AdminAdd['flags'],
                                    "immunity" => $AdminAdd['immunity'],
                                    "end_at" => $AdminAdd['end_at'],
                                    "group_id" => $AdminAdd['group_id'],
                                    "is_disabled" => $AdminAdd['is_disabled'],
                                    "created_at" => $AdminAdd['created_at'],
                                    "updated_at" => $AdminAdd['updated_at'],
                                ]);
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "admins` SET `name` = :name, `flags` = :flags, `immunity` = :immunity, `end_at` = :end_at, `group_id` = :group_id, `is_disabled` = :is_disabled, `updated_at` = :updated_at, `deleted_at` = :deleted_at WHERE `steam_id` = :steam_id AND `group_id` = :group_id;", [
                                    "steam_id" => $steam64,
                                    "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                    "flags" => $AdminAdd['flags'],
                                    "immunity" => $AdminAdd['immunity'],
                                    "end_at" => $AdminAdd['end_at'],
                                    "group_id" => $AdminAdd['group_id'],
                                    "is_disabled" => $AdminAdd['is_disabled'],
                                    "updated_at" => $AdminAdd['updated_at'],
                                    "deleted_at" => NULL,
                                ]);
                            endif;
                            $admin_id = $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `id` FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steam_id` = :steam_id AND `group_id` = :group_id;", [
                                'steam_id' => $steam64,
                                'group_id' => $AdminAdd['group_id']
                            ]);
                            if (count($server) > 1):
                                foreach ($server as $server_for):
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admin_to_server` (`admin_id`, `server_id`) VALUES (:admin_id, :server_id);", [
                                        "admin_id" => $admin_id['id'],
                                        "server_id" => $server_for
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admin_to_server` (`admin_id`, `server_id`) VALUES (:admin_id, :server_id);", [
                                    "admin_id" => $admin_id['id'],
                                    "server_id" => $server
                                ]);
                            endif;
                            $end_embed = empty($res_time) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res_time);

                            $response = $this->Rcons("css_reload_infractions " . $steam64);

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebNewAdmin')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebPravGroup')} {$res_group['name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebFlags')} {$res_group['flags']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebImm')} {$res_group['immunity']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                $this->Notifications->SendNotification($steam64, '_MSPageName', '_MSAdminGift', ['agroup' => $res_group['name'], 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminAdd')];
                            }
                        }
                    }
                    break;
            }
        }
    }

    public function Admin_Del($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $admin = $this->getAdminIdServerByID($POST['steamid']);
                        $admin_count = $admin['count'] ?? 0;
                        if ($admin_count <= 1) {
                            $this->Db->query('AdminSystem', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[$this->ServerGroup()]['Table'] . "admins` WHERE `id` = '{$POST['steamid']}' LIMIT 1");
                        }
                        if ($POST['server'] == 'all') {
                            $this->Db->query('AdminSystem', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[$this->ServerGroup()]['Table'] . "admins_servers` WHERE `admin_id` = '{$POST['steamid']}' AND `group_id` = '{$POST['group']}'");
                        } else {
                            $this->Db->query('AdminSystem', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[$this->ServerGroup()]['Table'] . "admins_servers` WHERE `admin_id` = '{$POST['steamid']}' AND `group_id` = '{$POST['group']}' AND `server_id` = '{$POST['server']}'");
                        }

                        $response = $this->Rcons("mm_as_reload_admin {$admin['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebDelAdmin')} [{$this->General->checkName($admin['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$admin['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($admin['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            $this->Notifications->SendNotification($admin['steamid'], '_MSPageName', '_MSAdminDelGift', ['module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminDel')];
                        }
                    }
                    break;
                case 'IksAdmin':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $admin = $this->getAdminIdServerByID($POST['steamid']);
                        $this->Db->query('IksAdmin', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[$this->ServerGroup()]['Table'] . "admins` SET `is_disabled` = 1, `deleted_at` = UNIX_TIMESTAMP() WHERE `id` = :id AND `group_id` = :group_id LIMIT 1", ['id' => $POST['steamid'], 'group_id' => $POST['group']]);

                        $response = $this->Rcons("css_reload_infractions {$admin['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebDelAdmin')} [{$this->General->checkName($admin['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$admin['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($admin['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            $this->Notifications->SendNotification($admin['steamid'], '_MSPageName', '_MSAdminDelGift', ['module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminDel')];
                        }
                    }
                    break;
                default;
            }
        }
    }

    public function Admin_Info_Get($IdAdmin, $group = '')
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    if (empty($group)) {
                        return $this->Db->query('AdminSystem', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT 
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
                        `as_admins`.`id` = `as_admins_servers`.`admin_id` WHERE `as_admins`.`id` = :id 
                    GROUP BY
                        `as_admins`.`id`, `as_admins_servers`.`group_id` LIMIT 1", ['id' => $IdAdmin]);
                    } else {
                        return $this->Db->query('AdminSystem', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT 
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
                        `as_admins`.`id` = `as_admins_servers`.`admin_id` WHERE `as_admins`.`id` = :id AND `as_admins_servers`.`group_id` = :group
                    GROUP BY
                        `as_admins`.`id`, `as_admins_servers`.`group_id` LIMIT 1", ['id' => $IdAdmin, 'group' => $group]);
                    }

                case 'IksAdmin':
                    return $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT 
                    `iks_admins`.`id`,
                    `iks_admins`.`name`,
                    `iks_admins`.`steam_id` AS `steamid`,
                    `iks_admins`.`flags`,
                    `iks_admins`.`immunity`,
                    `iks_admins`.`end_at` AS `end`,
                    `iks_admins`.`group_id`,
                    GROUP_CONCAT(DISTINCT `iks_admin_to_server`.`server_id`) AS `server_id`
                FROM 
                    `iks_admins`
                JOIN 
                    `iks_admin_to_server` 
                ON 
                    `iks_admins`.`id` = `iks_admin_to_server`.`admin_id`
                WHERE
                    `iks_admins`.`id` = :id
                GROUP BY
                    `iks_admins`.`id`, `iks_admin_to_server`.`admin_id`", ['id' => $IdAdmin]);
                default;
            }
        }
    }

    public function Admin_Edit($POST, $GET)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    $steam64 = $this->Steam64_ID($POST['steamid']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($this->GetCache('serversiks'))) {
                        if ($this->GetServerId() == 'all') {
                            $server = count($POST['server_id']) > 1 ? $POST['server_id'] : $POST['server_id'][0] ?? '-1';
                            $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode(' | ', $POST['server_id']);
                        } else {
                            $server = $this->GetServerId();
                            $server_id = $this->GetServerId();
                        }
                    } else {
                        $server = $POST['server_id'] ?? '-1';
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $POST['server_id'];
                    }
                    if ($this->GetCache('settings')['group_choice_admin'] == 1) {
                        if (!isset($POST['end']) || $POST['end'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                        }
                        if ($POST['end'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['end'] == 0) {
                            $end = 0;
                        } else
                            $end = (float) ($POST['end']) + time();
                        $res = $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups` WHERE `id` = :id", ['id' => $POST['group_choice_admin']]);

                        if ($res) {
                            $AdminAdd = [
                                "steamid" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "flags" => '',
                                "immunity" => 0,
                                "expires" => $end,
                                "server_id" => $server,
                                "group_id" => $POST['group_choice_admin'],
                            ];
                        }

                        if (empty(array_filter($AdminAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "admins` SET `steamid` = :steamid, `name` = :name WHERE `id` = :id", [
                                'id' => $GET,
                                "steamid" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            ]);
                            $this->Db->queryAll('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[0]['Table'] . "admins_servers` WHERE `admin_id` = :id AND `group_id` = :group_id", [
                                'id' => $GET,
                                'group_id' => $POST['group_choice_admin'],
                            ]);
                            if (count($server) > 1):
                                foreach ($server as $server_for):
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins_servers` (`admin_id`, `flags`, `immunity`, `group_id`, `expires`, `server_id`) VALUES (:admin_id, :flags, :immunity, :group_id, :expires, :server_id) ON DUPLICATE KEY UPDATE `flags` = :flags, `immunity` = :immunity, `group_id` = :group_id, `expires` = :expires, `server_id` = :server_id;", [
                                        "admin_id" => $GET,
                                        "flags" => '',
                                        "immunity" => 0,
                                        "expires" => $end,
                                        "server_id" => $server_for,
                                        "group_id" => $POST['group_choice_admin'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admins_servers` (`admin_id`, `flags`, `immunity`, `group_id`, `expires`, `server_id`) VALUES (:admin_id, :flags, :immunity, :group_id, :expires, :server_id) ON DUPLICATE KEY UPDATE `flags` = :flags, `immunity` = :immunity, `group_id` = :group_id, `expires` = :expires, `server_id` = :server_id;", [
                                    "admin_id" => $GET,
                                    "flags" => '',
                                    "immunity" => 0,
                                    "expires" => $end,
                                    "server_id" => $server,
                                    "group_id" => $POST['group_choice_admin'],
                                ]);
                            endif;
                            $end_embed = empty($POST['end']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['end']);

                            $response = $this->Rcons("mm_as_reload_admin " . $steam64);

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebEditAdmin')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebEditPravGroup')} {$res['name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebFlags')} {$res['flags']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebImm')} {$res['immunity']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditAdmin')];
                            }
                        }
                    }
                    break;
                case 'IksAdmin':
                    $steam64 = $this->Steam64_ID($POST['steamid']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($this->GetCache('serversiks'))) {
                        if ($this->GetServerId() == 'all') {
                            $server = count($POST['server_id']) > 1 ? $POST['server_id'] : $POST['server_id'][0] ?? NULL;
                            $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode(' | ', $POST['server_id']);
                        } else {
                            $server = $this->GetServerId();
                            $server_id = $this->GetServerId();
                        }
                    } else {
                        $server = $POST['server_id'] ?? NULL;
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $POST['server_id'];
                    }
                    if ($this->GetCache('settings')['group_choice_admin'] == 1) {
                        if (!isset($POST['end']) || $POST['end'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                        }
                        if ($POST['end'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['end'] == 0) {
                            $end = NULL;
                        } else
                            $end = (float) ($POST['end']) + time();
                        $res = $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT `name`, `flags`, `immunity` FROM `" . $this->ModDBFor()[0]['Table'] . "groups` WHERE `id` = :id", ['id' => $POST['group_choice_admin']]);

                        if ($res) {
                            $AdminAdd = [
                                "steam_id" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "flags" => NULL,
                                "immunity" => NULL,
                                "end_at" => $end,
                                "server_id" => $server,
                                "group_id" => $POST['group_choice_admin'],
                                "is_disabled" => 0,
                                "created_at" => time(),
                                "updated_at" => time()
                            ];
                        }

                        if (empty(array_filter($AdminAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "admins` SET `steam_id` = :steam_id, `name` = :name, `flags` = :flags, `immunity` = :immunity, `end_at` = :end_at, `group_id` = :group_id, `is_disabled` = :is_disabled, `updated_at` = :updated_at WHERE `id` = :id", [
                                'id' => $GET,
                                "steam_id" => $steam64,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "flags" => $AdminAdd['flags'],
                                "immunity" => $AdminAdd['immunity'],
                                "end_at" => $AdminAdd['end_at'],
                                "group_id" => $AdminAdd['group_id'],
                                "is_disabled" => $AdminAdd['is_disabled'],
                                "updated_at" => time()
                            ]);
                            $this->Db->queryAll('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[0]['Table'] . "admin_to_server` WHERE `admin_id` = :id", [
                                'id' => $GET
                            ]);
                            if (count($server) > 1):
                                foreach ($server as $server_for):
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admin_to_server` (`admin_id`,  `server_id`) VALUES (:admin_id, :server_id);", [
                                        "admin_id" => $GET,
                                        "server_id" => $server_for,
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "admin_to_server` (`admin_id`,  `server_id`) VALUES (:admin_id,  :server_id);", [
                                    "admin_id" => $GET,
                                    "server_id" => $server,
                                ]);
                            endif;
                            $end_embed = empty($POST['end']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['end']);

                            $response = $this->Rcons("css_reload_infractions " . $steam64);

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebEditAdmin')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebEditPravGroup')} {$res['name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebFlags')} {$res['flags']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebImm')} {$res['immunity']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditAdmin')];
                            }
                        }
                    }
                    break;
                default;
            }
        }
    }

    public function getAdminIdBySteam($steamid)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    return $this->Db->query('AdminSystem', 0, 0, "SELECT `id` FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steamid` = :steamid", ['steamid' => $steamid]);
                    break;
                case 'IksAdmin':
                    return $this->Db->query('IksAdmin', 0, 0, "SELECT `id` FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `steam_id` = :steam_id", ['steam_id' => $steamid]);
                    break;
            }
        }
    }

    public function getAdminIdServerByID($id)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    return $this->Db->query('AdminSystem', 0, 0, "SELECT `id`, `steamid`, (SELECT COUNT(*) FROM `as_admins_servers` WHERE `admin_id` = `as_admins`.`id`) as 'count' FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `id` = :id", ['id' => $id]);
                    break;
                case 'IksAdmin':
                    return $this->Db->query('IksAdmin', 0, 0, "SELECT `id`, `steam_id`, (SELECT COUNT(*) FROM `iks_admin_to_server` WHERE `admin_id` = `iks_admins`.`id`) as 'count' FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `id` = :id", ['id' => $id]);
                    break;
            }
        }
    }

    public function Ban_Add($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    $steam64 = $this->Steam64_ID($POST['steam_player']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($POST['ip'])) {
                        $ip = $POST['ip'];
                    } else {
                        $ip = '';
                    }
                    if (!empty($this->GetCache('serversiks'))) {
                        if ($this->GetServerId() == 'all') {
                            $server = $POST['server_id'] ?? '-1';
                            $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode($POST['server_id']);
                        } else {
                            $server = $this->GetServerId();
                            $server_id = $this->GetServerId();
                        }
                    } else {
                        $server = $POST['server_id'] ?? '-1';
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $POST['server_id'];
                    }

                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_ban'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end_ban = 0;
                        } else {
                            $end_ban = time() + $POST['duration'];
                        }

                        $BanAdd = [
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "steamid" => $steam64,
                            "ip" => $ip,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created" => time(),
                            "expires" => $end_ban,
                            "reason" => $POST['reason_name'],
                            "unpunish_admin_id" => NULL,
                            "server_id" => $server ?? '-1',
                            "punish_type" => 0,
                        ];


                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $BanAdd['name'],
                                        'steamid' => $BanAdd['steamid'],
                                        'ip' => $BanAdd['ip'],
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created' => $BanAdd['created'],
                                        'expires' => $BanAdd['expires'],
                                        'reason' => $BanAdd['reason'],
                                        'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                        'server_id' => $server_id,
                                        'punish_type' => $BanAdd['punish_type'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                    'name' => $BanAdd['name'],
                                    'steamid' => $BanAdd['steamid'],
                                    'ip' => $BanAdd['ip'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created' => $BanAdd['created'],
                                    'expires' => $BanAdd['expires'],
                                    'reason' => $BanAdd['reason'],
                                    'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                    'server_id' => $BanAdd['server_id'],
                                    'punish_type' => $BanAdd['punish_type'],
                                ]);
                            endif;

                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                            $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_ban'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        $res = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                            $duration = $POST['duration'];
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res + time();
                            $duration = $res;
                        }

                        $BanAdd = [
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "steamid" => $steam64,
                            "ip" => $ip,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created" => time(),
                            "expires" => $end,
                            "reason" => $POST['reason_name'],
                            "unpunish_admin_id" => NULL,
                            "server_id" => $server ?? '-1',
                            "punish_type" => 0,
                        ];
                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $BanAdd['name'],
                                        'steamid' => $BanAdd['steamid'],
                                        'ip' => $BanAdd['ip'],
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created' => $BanAdd['created'],
                                        'expires' => $BanAdd['expires'],
                                        'reason' => $BanAdd['reason'],
                                        'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                        'server_id' => $server_id,
                                        'punish_type' => $BanAdd['punish_type'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                    'name' => $BanAdd['name'],
                                    'steamid' => $BanAdd['steamid'],
                                    'ip' => $BanAdd['ip'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created' => $BanAdd['created'],
                                    'expires' => $BanAdd['expires'],
                                    'reason' => $BanAdd['reason'],
                                    'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                    'server_id' => $BanAdd['server_id'],
                                    'punish_type' => $BanAdd['punish_type'],
                                ]);
                            endif;
                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($res) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res);

                            $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_ban'] == 1) {
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end_ban = 0;
                        } else {
                            $end_ban = time() + $POST['duration'];
                        }
                        $res = '';
                        foreach ($this->GetCache('reasonban') as $reason) {
                            if ($reason['id'] == $POST['reason_ban']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        if ($res) {
                            $BanAdd = [
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "steamid" => $steam64,
                                "ip" => $ip,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created" => time(),
                                "expires" => $end_ban,
                                "reason" => $res,
                                "unpunish_admin_id" => NULL,
                                "server_id" => $server ?? '-1',
                                "punish_type" => 0,
                            ];
                        }

                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $BanAdd['name'],
                                        'steamid' => $BanAdd['steamid'],
                                        'ip' => $BanAdd['ip'],
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created' => $BanAdd['created'],
                                        'expires' => $BanAdd['expires'],
                                        'reason' => $BanAdd['reason'],
                                        'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                        'server_id' => $server_id,
                                        'punish_type' => $BanAdd['punish_type'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                    'name' => $BanAdd['name'],
                                    'steamid' => $BanAdd['steamid'],
                                    'ip' => $BanAdd['ip'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created' => $BanAdd['created'],
                                    'expires' => $BanAdd['expires'],
                                    'reason' => $BanAdd['reason'],
                                    'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                    'server_id' => $BanAdd['server_id'],
                                    'punish_type' => $BanAdd['punish_type'],
                                ]);
                            endif;
                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                            $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_ban'] == 1) {
                        $res = '';
                        foreach ($this->GetCache('reasonban') as $reason) {
                            if ($reason['id'] == $POST['reason_ban']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        $res_time = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res_time = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                            $duration = $POST['duration'];
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res_time == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res_time + time();
                            $duration = $res_time;
                        }

                        if ($res) {
                            $BanAdd = [
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "steamid" => $steam64,
                                "ip" => $ip,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created" => time(),
                                "expires" => $end,
                                "reason" => $res,
                                "unpunish_admin_id" => NULL,
                                "server_id" => $server ?? '-1',
                                "punish_type" => 0,
                            ];
                        }

                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $BanAdd['name'],
                                        'steamid' => $BanAdd['steamid'],
                                        'ip' => $BanAdd['ip'],
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created' => $BanAdd['created'],
                                        'expires' => $BanAdd['expires'],
                                        'reason' => $BanAdd['reason'],
                                        'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                        'server_id' => $server_id,
                                        'punish_type' => $BanAdd['punish_type'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                    'name' => $BanAdd['name'],
                                    'steamid' => $BanAdd['steamid'],
                                    'ip' => $BanAdd['ip'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created' => $BanAdd['created'],
                                    'expires' => $BanAdd['expires'],
                                    'reason' => $BanAdd['reason'],
                                    'unpunish_admin_id' => $BanAdd['unpunish_admin_id'],
                                    'server_id' => $BanAdd['server_id'],
                                    'punish_type' => $BanAdd['punish_type'],
                                ]);
                            endif;
                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($res_time) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res_time);

                            $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    break;
                case 'IksAdmin':
                    $steam64 = $this->Steam64_ID($POST['steam_player']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($POST['ip'])) {
                        $ip = $POST['ip'];
                    } else {
                        $ip = NULL;
                    }
                    if (!empty($steam64) && !empty($ip)) {
                        $ban_type = 2;
                    } elseif (empty($steam64) && !empty($ip)) {
                        $ban_type = 1;
                    } elseif (!empty($steam64) && empty($ip)) {
                        $ban_type = 0;
                    } else {
                        $ban_type = 0;
                    }
                    if (!empty($this->GetCache('serversiks'))) {
                        if ($this->GetServerId() == 'all') {
                            $server = $POST['server_id'] ?? NULL;
                            $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode($POST['server_id']);
                        } else {
                            $server = $this->GetServerId();
                            $server_id = $this->GetServerId();
                        }
                    } else {
                        $server = $POST['server_id'] ?? NULL;
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $POST['server_id'];
                    }

                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_ban'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end = 0;
                        } else {
                            $end = time() + $POST['duration'];
                        }

                        if ($end != 0 && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        $BanAdd = [
                            "steam_id" => $steam64,
                            "ip" => $ip,
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "duration" => $duration,
                            "reason" => $POST['reason_name'],
                            "ban_type" => $ban_type,
                            "server_id" => $server,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created_at" => time(),
                            "end_at" => $end,
                            "updated_at" => time(),
                        ];


                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $BanAdd['steam_id'],
                                        'ip' => $BanAdd['ip'],
                                        'name' => $BanAdd['name'],
                                        'duration' => $BanAdd['duration'],
                                        'reason' => $BanAdd['reason'],
                                        'ban_type' => $BanAdd['ban_type'],
                                        'server_id' => $server_id,
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created_at' => $BanAdd['created_at'],
                                        'end_at' => $BanAdd['end_at'],
                                        'updated_at' => $BanAdd['updated_at'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                    'steam_id' => $BanAdd['steam_id'],
                                    'ip' => $BanAdd['ip'],
                                    'name' => $BanAdd['name'],
                                    'duration' => $BanAdd['duration'],
                                    'reason' => $BanAdd['reason'],
                                    'ban_type' => $BanAdd['ban_type'],
                                    'server_id' => $BanAdd['server_id'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created_at' => $BanAdd['created_at'],
                                    'end_at' => $BanAdd['end_at'],
                                    'updated_at' => $BanAdd['updated_at'],
                                ]);
                            endif;

                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                            $response = $this->Rcons("css_reload_infractions {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_ban'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        $res = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                            $duration = $POST['duration'];
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res + time();
                            $duration = $res;
                        }

                        if ($end != 0 && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        $BanAdd = [
                            "steam_id" => $steam64,
                            "ip" => $ip,
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "duration" => $duration,
                            "reason" => $POST['reason_name'],
                            "ban_type" => $ban_type,
                            "server_id" => $server,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created_at" => time(),
                            "end_at" => $end,
                            "updated_at" => time(),
                        ];
                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $BanAdd['steam_id'],
                                        'ip' => $BanAdd['ip'],
                                        'name' => $BanAdd['name'],
                                        'duration' => $BanAdd['duration'],
                                        'reason' => $BanAdd['reason'],
                                        'ban_type' => $BanAdd['ban_type'],
                                        'server_id' => $server_id,
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created_at' => $BanAdd['created_at'],
                                        'end_at' => $BanAdd['end_at'],
                                        'updated_at' => $BanAdd['updated_at'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                    'steam_id' => $BanAdd['steam_id'],
                                    'ip' => $BanAdd['ip'],
                                    'name' => $BanAdd['name'],
                                    'duration' => $BanAdd['duration'],
                                    'reason' => $BanAdd['reason'],
                                    'ban_type' => $BanAdd['ban_type'],
                                    'server_id' => $BanAdd['server_id'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created_at' => $BanAdd['created_at'],
                                    'end_at' => $BanAdd['end_at'],
                                    'updated_at' => $BanAdd['updated_at'],
                                ]);
                            endif;
                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($res) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res);

                            $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_ban'] == 1) {
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end = 0;
                        } else {
                            $end = time() + $POST['duration'];
                        }
                        $res = '';
                        foreach ($this->GetCache('reasonban') as $reason) {
                            if ($reason['id'] == $POST['reason_ban']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        if ($end != 0 && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        if ($res) {
                            $BanAdd = [
                                "steam_id" => $steam64,
                                "ip" => $ip,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "duration" => $duration,
                                "reason" => $res,
                                "ban_type" => $ban_type,
                                "server_id" => $server,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created_at" => time(),
                                "end_at" => $end,
                                "updated_at" => time(),
                            ];
                        }

                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $BanAdd['steam_id'],
                                        'ip' => $BanAdd['ip'],
                                        'name' => $BanAdd['name'],
                                        'duration' => $BanAdd['duration'],
                                        'reason' => $BanAdd['reason'],
                                        'ban_type' => $BanAdd['ban_type'],
                                        'server_id' => $server_id,
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created_at' => $BanAdd['created_at'],
                                        'end_at' => $BanAdd['end_at'],
                                        'updated_at' => $BanAdd['updated_at'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                    'steam_id' => $BanAdd['steam_id'],
                                    'ip' => $BanAdd['ip'],
                                    'name' => $BanAdd['name'],
                                    'duration' => $BanAdd['duration'],
                                    'reason' => $BanAdd['reason'],
                                    'ban_type' => $BanAdd['ban_type'],
                                    'server_id' => $BanAdd['server_id'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created_at' => $BanAdd['created_at'],
                                    'end_at' => $BanAdd['end_at'],
                                    'updated_at' => $BanAdd['updated_at'],
                                ]);
                            endif;
                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                            $response = $this->Rcons("css_reload_infractions {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_ban'] == 1) {
                        $res = '';
                        foreach ($this->GetCache('reasonban') as $reason) {
                            if ($reason['id'] == $POST['reason_ban']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        $res_time = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res_time = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res_time == 0) {
                            $end = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res_time + time();
                        }

                        if ($end != NULL && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        if ($res) {
                            $BanAdd = [
                                "steam_id" => $steam64,
                                "ip" => $ip,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "duration" => $duration,
                                "reason" => $res,
                                "ban_type" => $ban_type,
                                "server_id" => $server,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created_at" => time(),
                                "end_at" => $end,
                                "updated_at" => time(),
                            ];
                        }

                        if (empty(array_filter($BanAdd))) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                        } else {
                            if (count($server) > 1):
                                foreach ($server as $server_id):
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $BanAdd['steam_id'],
                                        'ip' => $BanAdd['ip'],
                                        'name' => $BanAdd['name'],
                                        'duration' => $BanAdd['duration'],
                                        'reason' => $BanAdd['reason'],
                                        'ban_type' => $BanAdd['ban_type'],
                                        'server_id' => $server_id,
                                        'admin_id' => $BanAdd['admin_id'],
                                        'created_at' => $BanAdd['created_at'],
                                        'end_at' => $BanAdd['end_at'],
                                        'updated_at' => $BanAdd['updated_at'],
                                    ]);
                                endforeach;
                            else:
                                $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "bans` (`steam_id`, `ip`, `name`, `duration`, `reason`, `ban_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :ban_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                    'steam_id' => $BanAdd['steam_id'],
                                    'ip' => $BanAdd['ip'],
                                    'name' => $BanAdd['name'],
                                    'duration' => $BanAdd['duration'],
                                    'reason' => $BanAdd['reason'],
                                    'ban_type' => $BanAdd['ban_type'],
                                    'server_id' => $BanAdd['server_id'],
                                    'admin_id' => $BanAdd['admin_id'],
                                    'created_at' => $BanAdd['created_at'],
                                    'end_at' => $BanAdd['end_at'],
                                    'updated_at' => $BanAdd['updated_at'],
                                ]);
                            endif;
                            if ($this->GetCache('settings')['blockdbapikey']) {
                                $this->AddBanBlockDB($BanAdd['steamid'], $BanAdd['reason'], $BanAdd['duration'], $BanAdd['ip']);
                            }
                            $end_embed = empty($res_time) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res_time);

                            $response = $this->Rcons("css_reload_infractions {$steam64}");

                            if ($response == 'error') {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                            } else {
                                $embed = [
                                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                    "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                    "image" => [
                                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                    ],
                                    "thumbnail" => [
                                        "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                    ]
                                ];
                                $this->DiscordWebhook($embed);
                                return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanAdd')];
                            }
                        }
                    }
                    break;
            }
        }
    }

    public function Ban_Del($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[0]['Table'] . "punishments` WHERE `steamid` = :steamid AND `id` = :id AND `punish_type` = :punish_type LIMIT 1", [
                            'steamid' => $POST['steamid'],
                            'id' => $POST['end'],
                            'punish_type' => 0
                        ]);
                        if ($this->GetCache('settings')['blockdbapikey']) {
                            $this->UnBanBlockDB($POST['steamid']);
                        }
                        $response = $this->Rcons("mm_as_reload_punish  {$POST['steamid']}");
                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanDel')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanDel')];
                        }
                    }
                    break;
                case 'IksAdmin':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[0]['Table'] . "bans` WHERE `steam_id` = :steam_id AND `id` = :id LIMIT 1", [
                            'steam_id' => $POST['steamid'],
                            'id' => $POST['end']
                        ]);
                        if ($this->GetCache('settings')['blockdbapikey']) {
                            $this->UnBanBlockDB($POST['steamid']);
                        }
                        $response = $this->Rcons("css_reload_infractions {$POST['steamid']}");
                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebBanDel')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSBanDel')];
                        }
                    }
                    break;
                default;
            }
        }
    }

    public function Ban_Unban($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "punishments` SET `unpunish_admin_id` = :unpunish_admin_id WHERE `steamid` = :steamid AND `id` = :id AND `punish_type` = :punish_type", [
                            'unpunish_admin_id' => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            'steamid' => $POST['steamid'],
                            'id' => $POST['end'],
                            'punish_type' => 0
                        ]);
                        if ($this->GetCache('settings')['blockdbapikey']) {
                            $this->UnBanBlockDB($POST['steamid']);
                        }

                        $response = $this->Rcons("mm_as_reload_punish {$POST['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebUnBan')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnBan')];
                        }
                    }
                    break;
                case 'IksAdmin':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "bans` SET `unbanned_by` = :unbanned_by, `unban_reason` = :unban_reason WHERE `steam_id` = :steam_id AND `id` = :id", [
                            'unbanned_by' => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            'unban_reason' => 'Unbaned from Managersystem',
                            'steam_id' => $POST['steamid'],
                            'id' => $POST['end']
                        ]);
                        if ($this->GetCache('settings')['blockdbapikey']) {
                            $this->UnBanBlockDB($POST['steamid']);
                        }

                        $response = $this->Rcons("css_reload_infractions {$POST['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebUnBan')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnBan')];
                        }
                    }
                    break;
                default;
            }
        }
    }

    public function Mute_Add($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    $steam64 = $this->Steam64_ID($POST['steam_player']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($POST['ip'])) {
                        $ip = $POST['ip'];
                    } else {
                        $ip = '';
                    }
                    $type_mute = ($POST['type_punishment'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro') : (($POST['type_punishment'] == 2) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicroChat'));
                    if ($POST['type_punishment'] == 1) {
                        $mute_type = 1;
                    } elseif ($POST['type_punishment'] == 2) {
                        $mute_type = 2;
                    } else {
                        $mute_type = 3;
                    }
                    if ($this->GetServerId() == 'all') {
                        $server = $POST['server_id'] ?? '-1';
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode($POST['server_id']);
                    } else {
                        $server = $this->GetServerId();
                        $server_id = $this->GetServerId();
                    }

                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_mute'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end_mute = 0;
                        } else {
                            $end_mute = time() + $POST['duration'];
                        }

                        $MuteAdd = [
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "steamid" => $steam64,
                            "ip" => $ip,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created" => time(),
                            "expires" => $end_mute,
                            "reason" => $POST['reason_name'],
                            "unpunish_admin_id" => NULL,
                            "server_id" => $server,
                            "punish_type" => $mute_type,
                        ];


                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                            'name' => $MuteAdd['name'],
                                            'steamid' => $MuteAdd['steamid'],
                                            'ip' => $MuteAdd['ip'],
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created' => $MuteAdd['created'],
                                            'expires' => $MuteAdd['expires'],
                                            'reason' => $MuteAdd['reason'],
                                            'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                            'server_id' => $server_id,
                                            'punish_type' => $MuteAdd['punish_type'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $MuteAdd['name'],
                                        'steamid' => $MuteAdd['steamid'],
                                        'ip' => $MuteAdd['ip'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created' => $MuteAdd['created'],
                                        'expires' => $MuteAdd['expires'],
                                        'reason' => $MuteAdd['reason'],
                                        'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'punish_type' => $MuteAdd['punish_type'],
                                    ]);
                                endif;
                                $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                                $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_mute'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        $res = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                            $duration = $POST['duration'];
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res + time();
                            $duration = $res;
                        }

                        $MuteAdd = [
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "steamid" => $steam64,
                            "ip" => $ip,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created" => time(),
                            "expires" => $end,
                            "reason" => $POST['reason_name'],
                            "unpunish_admin_id" => NULL,
                            "server_id" => $server ?? '-1',
                            "punish_type" => $mute_type,
                        ];

                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                            'name' => $MuteAdd['name'],
                                            'steamid' => $MuteAdd['steamid'],
                                            'ip' => $MuteAdd['ip'],
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created' => $MuteAdd['created'],
                                            'expires' => $MuteAdd['expires'],
                                            'reason' => $MuteAdd['reason'],
                                            'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                            'server_id' => $server_id,
                                            'punish_type' => $MuteAdd['punish_type'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $MuteAdd['name'],
                                        'steamid' => $MuteAdd['steamid'],
                                        'ip' => $MuteAdd['ip'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created' => $MuteAdd['created'],
                                        'expires' => $MuteAdd['expires'],
                                        'reason' => $MuteAdd['reason'],
                                        'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'punish_type' => $MuteAdd['punish_type'],
                                    ]);
                                endif;
                                $end_embed = empty($res) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res);
                                if ($this->GetServerId() == 'all') {
                                    $server_id = isset($POST['server_id']) ? implode(' | ', $POST['server_id']) : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers');
                                } else {
                                    $server_id = $this->GetServerId();
                                }

                                $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_mute'] == 1) {
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end_mute = 0;
                        } else {
                            $end_mute = time() + $POST['duration'];
                        }
                        $res = '';
                        foreach ($this->GetCache('reasonmute') as $reason) {
                            if ($reason['id'] == $POST['reason_mute']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        if ($res) {
                            $MuteAdd = [
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "steamid" => $steam64,
                                "ip" => $ip,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created" => time(),
                                "expires" => $end_mute,
                                "reason" => $res,
                                "unpunish_admin_id" => NULL,
                                "server_id" => $server ?? '-1',
                                "punish_type" => $mute_type,
                            ];
                        }
                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                            'name' => $MuteAdd['name'],
                                            'steamid' => $MuteAdd['steamid'],
                                            'ip' => $MuteAdd['ip'],
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created' => $MuteAdd['created'],
                                            'expires' => $MuteAdd['expires'],
                                            'reason' => $MuteAdd['reason'],
                                            'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                            'server_id' => $server_id,
                                            'punish_type' => $MuteAdd['punish_type'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $MuteAdd['name'],
                                        'steamid' => $MuteAdd['steamid'],
                                        'ip' => $MuteAdd['ip'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created' => $MuteAdd['created'],
                                        'expires' => $MuteAdd['expires'],
                                        'reason' => $MuteAdd['reason'],
                                        'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'punish_type' => $MuteAdd['punish_type'],
                                    ]);
                                endif;
                                $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                                $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_mute'] == 1) {
                        $res = '';
                        foreach ($this->GetCache('reasonmute') as $reason) {
                            if ($reason['id'] == $POST['reason_mute']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        $res_time = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res_time = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                            $duration = $POST['duration'];
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res_time == 0) {
                            $end = 0;
                            $duration = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res_time + time();
                            $duration = $res_time;
                        }

                        if ($res) {
                            $MuteAdd = [
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "steamid" => $steam64,
                                "ip" => $ip,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created" => time(),
                                "expires" => $end,
                                "reason" => $res,
                                "unpunish_admin_id" => NULL,
                                "server_id" => $server ?? '-1',
                                "punish_type" => $mute_type,
                            ];
                        }

                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                            'name' => $MuteAdd['name'],
                                            'steamid' => $MuteAdd['steamid'],
                                            'ip' => $MuteAdd['ip'],
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created' => $MuteAdd['created'],
                                            'expires' => $MuteAdd['expires'],
                                            'reason' => $MuteAdd['reason'],
                                            'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                            'server_id' => $server_id,
                                            'punish_type' => $MuteAdd['punish_type'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "punishments` (`name`, `steamid`, `ip`, `admin_id`, `created`, `expires`, `reason`, `unpunish_admin_id`, `server_id`, `punish_type`) VALUES (:name, :steamid, :ip, :admin_id, :created, :expires, :reason, :unpunish_admin_id, :server_id, :punish_type);", [
                                        'name' => $MuteAdd['name'],
                                        'steamid' => $MuteAdd['steamid'],
                                        'ip' => $MuteAdd['ip'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created' => $MuteAdd['created'],
                                        'expires' => $MuteAdd['expires'],
                                        'reason' => $MuteAdd['reason'],
                                        'unpunish_admin_id' => $MuteAdd['unpunish_admin_id'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'punish_type' => $MuteAdd['punish_type'],
                                    ]);
                                endif;
                                $end_embed = empty($res_time) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res_time);

                                $response = $this->Rcons("mm_as_reload_punish {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    break;
                case 'IksAdmin':
                    $steam64 = $this->Steam64_ID($POST['steam_player']);
                    if (!$steam64)
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
                    if (!empty($POST['ip'])) {
                        $ip = $POST['ip'];
                    } else {
                        $ip = NULL;
                    }
                    $type_mute = ($POST['type_punishment'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro') : (($POST['type_punishment'] == 2) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicroChat'));
                    if ($this->GetServerId() == 'all') {
                        $server = $POST['server_id'] ?? NULL;
                        $server_id = empty($POST['server_id']) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : implode($POST['server_id']);
                    } else {
                        $server = $this->GetServerId();
                        $server_id = $this->GetServerId();
                    }

                    if ($POST['type_punishment'] == 1) {
                        $mute_type = 0;
                    } elseif ($POST['type_punishment'] == 2) {
                        $mute_type = 1;
                    } elseif ($POST['type_punishment'] == 3) {
                        $mute_type = 2;
                    } else {
                        $mute_type = 0;
                    }

                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_mute'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end = 0;
                        } else {
                            $end = time() + $POST['duration'];
                        }

                        if ($end != 0 && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        $MuteAdd = [
                            "steam_id" => $steam64,
                            "ip" => $ip,
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "duration" => $duration,
                            "reason" => $POST['reason_name'],
                            "server_id" => $server,
                            "mute_type" => $mute_type,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created_at" => time(),
                            "end_at" => $end,
                            "updated_at" => time(),
                        ];

                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                            'steam_id' => $MuteAdd['steam_id'],
                                            'ip' => $MuteAdd['ip'],
                                            'name' => $MuteAdd['name'],
                                            'duration' => $MuteAdd['duration'],
                                            'reason' => $MuteAdd['reason'],
                                            'mute_type' => $MuteAdd['mute_type'],
                                            'server_id' => $server_id,
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created_at' => $MuteAdd['created_at'],
                                            'end_at' => $MuteAdd['end_at'],
                                            'updated_at' => $MuteAdd['updated_at'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $MuteAdd['steam_id'],
                                        'ip' => $MuteAdd['ip'],
                                        'name' => $MuteAdd['name'],
                                        'duration' => $MuteAdd['duration'],
                                        'reason' => $MuteAdd['reason'],
                                        'mute_type' => $MuteAdd['mute_type'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created_at' => $MuteAdd['created_at'],
                                        'end_at' => $MuteAdd['end_at'],
                                        'updated_at' => $MuteAdd['updated_at'],
                                    ]);
                                endif;

                                $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                                $response = $this->Rcons("css_reload_infractions {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_mute'] == 0) {
                        if (empty($POST['reason_name']))
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
                        $res = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res == 0) {
                            $end = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res + time();
                        }

                        if ($end != 0 && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        $MuteAdd = [
                            "steam_id" => $steam64,
                            "ip" => $ip,
                            "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                            "duration" => $duration,
                            "reason" => $POST['reason_name'],
                            "server_id" => $server,
                            "mute_type" => $mute_type,
                            "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            "created_at" => time(),
                            "end_at" => $end,
                            "updated_at" => time(),
                        ];

                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                            'steam_id' => $MuteAdd['steam_id'],
                                            'ip' => $MuteAdd['ip'],
                                            'name' => $MuteAdd['name'],
                                            'duration' => $MuteAdd['duration'],
                                            'reason' => $MuteAdd['reason'],
                                            'mute_type' => $MuteAdd['mute_type'],
                                            'server_id' => $server_id,
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created_at' => $MuteAdd['created_at'],
                                            'end_at' => $MuteAdd['end_at'],
                                            'updated_at' => $MuteAdd['updated_at'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $MuteAdd['steam_id'],
                                        'ip' => $MuteAdd['ip'],
                                        'name' => $MuteAdd['name'],
                                        'duration' => $MuteAdd['duration'],
                                        'reason' => $MuteAdd['reason'],
                                        'mute_type' => $MuteAdd['mute_type'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created_at' => $MuteAdd['created_at'],
                                        'end_at' => $MuteAdd['end_at'],
                                        'updated_at' => $MuteAdd['updated_at'],
                                    ]);
                                endif;
                                $end_embed = empty($res) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res);
                                if ($this->GetServerId() == 'all') {
                                    $server_id = isset($POST['server_id']) ? implode(' | ', $POST['server_id']) : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers');
                                } else {
                                    $server_id = $this->GetServerId();
                                }

                                $response = $this->Rcons("css_reload_infractions {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason_name']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 0 && $this->GetCache('settings')['reason_mute'] == 1) {
                        if (!isset($POST['duration']) || $POST['duration'] === '') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNoNo')];
                        }
                        if ($POST['duration'] < 0)
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        if ($POST['duration'] == 0) {
                            $end = 0;
                        } else {
                            $end = time() + $POST['duration'];
                        }
                        $res = '';
                        foreach ($this->GetCache('reasonmute') as $reason) {
                            if ($reason['id'] == $POST['reason_mute']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        if ($end != NULL && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        if ($res) {
                            $MuteAdd = [
                                "steam_id" => $steam64,
                                "ip" => $ip,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "duration" => $duration,
                                "reason" => $res,
                                "mute_type" => $mute_type,
                                "server_id" => $server,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created_at" => time(),
                                "end_at" => $end,
                                "updated_at" => time(),
                            ];
                        }
                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                            'steam_id' => $MuteAdd['steam_id'],
                                            'ip' => $MuteAdd['ip'],
                                            'name' => $MuteAdd['name'],
                                            'duration' => $MuteAdd['duration'],
                                            'reason' => $MuteAdd['reason'],
                                            'mute_type' => $MuteAdd['mute_type'],
                                            'server_id' => $server_id,
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created_at' => $MuteAdd['created_at'],
                                            'end_at' => $MuteAdd['end_at'],
                                            'updated_at' => $MuteAdd['updated_at'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $MuteAdd['steam_id'],
                                        'ip' => $MuteAdd['ip'],
                                        'name' => $MuteAdd['name'],
                                        'duration' => $MuteAdd['duration'],
                                        'reason' => $MuteAdd['reason'],
                                        'mute_type' => $MuteAdd['mute_type'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created_at' => $MuteAdd['created_at'],
                                        'end_at' => $MuteAdd['end_at'],
                                        'updated_at' => $MuteAdd['updated_at'],
                                    ]);
                                endif;
                                $end_embed = empty($POST['duration']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['duration']);

                                $response = $this->Rcons("css_reload_infractions {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    if ($this->GetCache('settings')['time_choice_punishment'] == 1 && $this->GetCache('settings')['reason_mute'] == 1) {
                        $res = '';
                        foreach ($this->GetCache('reasonmute') as $reason) {
                            if ($reason['id'] == $POST['reason_mute']) {
                                $res = $reason['reason_name'];
                                break;
                            }
                        }

                        $res_time = '';
                        foreach ($this->GetCache('punishmenttime') as $time) {
                            if ($time['id'] == $POST['time_choice_punishment']) {
                                $res_time = $time['duration'];
                                break;
                            }
                        }

                        if (empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                        } elseif (!empty($POST['time_choice_punishment']) && (!empty($POST['duration']) || $POST['duration'] !== '')) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                        } elseif ($POST['duration'] < 0) {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                        } elseif ((!empty($POST['duration']) || $POST['duration'] !== '') && empty($POST['time_choice_punishment'])) {
                            $end = (float) ($POST['duration']) + time();
                        } elseif (empty($POST['time_choice_punishment']) && $POST['duration'] == 0) {
                            $end = 0;
                        } elseif ((!isset($POST['duration']) || $POST['duration'] === '') && $res_time == 0) {
                            $end = 0;
                        } elseif (!empty($POST['time_choice_punishment']) && (!isset($POST['duration']) || $POST['duration'] === '')) {
                            $end = $res_time + time();
                        }

                        if ($end != 0 && $end > time()) {
                            $duration = $end - time();
                        } else {
                            $duration = 0;
                        }

                        if ($res) {
                            $MuteAdd = [
                                "steam_id" => $steam64,
                                "ip" => $ip,
                                "name" => empty($this->General->checkName($steam64)) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName($steam64),
                                "duration" => $duration,
                                "reason" => $res,
                                "mute_type" => $mute_type,
                                "server_id" => $server,
                                "admin_id" => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                                "created_at" => time(),
                                "end_at" => $end,
                                "updated_at" => time(),
                            ];
                        }

                        if (isset($POST['type_punishment'])) {
                            if (empty(array_filter($MuteAdd))) {
                                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                            } else {
                                if (count($server) > 1):
                                    foreach ($server as $server_id):
                                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                            'steam_id' => $MuteAdd['steam_id'],
                                            'ip' => $MuteAdd['ip'],
                                            'name' => $MuteAdd['name'],
                                            'duration' => $MuteAdd['duration'],
                                            'reason' => $MuteAdd['reason'],
                                            'mute_type' => $MuteAdd['mute_type'],
                                            'server_id' => $server_id,
                                            'admin_id' => $MuteAdd['admin_id'],
                                            'created_at' => $MuteAdd['created_at'],
                                            'end_at' => $MuteAdd['end_at'],
                                            'updated_at' => $MuteAdd['updated_at'],
                                        ]);
                                    endforeach;
                                else:
                                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "INSERT INTO `" . $this->ModDBFor()[0]['Table'] . "comms` (`steam_id`, `ip`, `name`, `duration`, `reason`, `mute_type`, `server_id`, `admin_id`, `created_at`, `end_at`, `updated_at`) VALUES (:steam_id, :ip, :name, :duration, :reason, :mute_type, :server_id, :admin_id, :created_at, :end_at, :updated_at);", [
                                        'steam_id' => $MuteAdd['steam_id'],
                                        'ip' => $MuteAdd['ip'],
                                        'name' => $MuteAdd['name'],
                                        'duration' => $MuteAdd['duration'],
                                        'reason' => $MuteAdd['reason'],
                                        'mute_type' => $MuteAdd['mute_type'],
                                        'server_id' => $MuteAdd['server_id'],
                                        'admin_id' => $MuteAdd['admin_id'],
                                        'created_at' => $MuteAdd['created_at'],
                                        'end_at' => $MuteAdd['end_at'],
                                        'updated_at' => $MuteAdd['updated_at'],
                                    ]);
                                endif;
                                $end_embed = empty($res_time) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res_time);

                                $response = $this->Rcons("css_reload_infractions {$steam64}");

                                if ($response == 'error') {
                                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                                } else {
                                    $embed = [
                                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteAdd')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$res}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTypeMute')} {$type_mute} {$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                        "image" => [
                                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                        ],
                                        "thumbnail" => [
                                            "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                                        ]
                                    ];
                                    $this->DiscordWebhook($embed);
                                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteAdd')];
                                }
                            }
                        } else {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNo')];
                        }
                    }
                    break;
            }
        }
    }

    public function Mute_Del($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[0]['Table'] . "punishments` WHERE `steamid` = :steamid AND `id` = :id AND `punish_type` != 0 LIMIT 1", [
                            'steamid' => $POST['steamid'],
                            'id' => $POST['end']
                        ]);

                        $response = $this->Rcons("mm_as_reload_punish {$POST['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteDel')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteDel')];
                        }
                    }
                    break;
                case 'IksAdmin':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[0]['Table'] . "comms` WHERE `steam_id` = :steam_id AND `id` = :id LIMIT 1", [
                            'steam_id' => $POST['steamid'],
                            'id' => $POST['end']
                        ]);

                        $response = $this->Rcons("css_reload_infractions {$POST['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebMuteDel')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMuteDel')];
                        }
                    }
                    break;
                default;
            }
        }
    }

    public function Mute_Unban($POST)
    {
        if (!empty($this->ModDBFor()[$this->ServerGroup()]['admin_mod'])) {
            switch ($this->ModDBFor()[$this->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('AdminSystem', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "punishments` SET `unpunish_admin_id` = :unpunish_admin_id WHERE `steamid` = :steamid AND `id` = :id AND `punish_type` != 0", [
                            'unpunish_admin_id' => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            'steamid' => $POST['steamid'],
                            'id' => $POST['end']
                        ]);

                        $response = $this->Rcons("mm_as_reload_punish {$POST['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebUnMute')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnMute')];
                        }
                    }
                    break;
                case 'IksAdmin':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "UPDATE `" . $this->ModDBFor()[0]['Table'] . "comms` SET `unbanned_by` = :unbanned_by, `unban_reason` = :unban_reason WHERE `steam_id` = :steam_id AND `id` = :id", [
                            'unbanned_by' => $this->getAdminIdBySteam($_SESSION['steamid64'])['id'] ?? '1',
                            'unban_reason' => 'Unbaned from Managersystem',
                            'steam_id' => $POST['steamid'],
                            'id' => $POST['end']
                        ]);

                        $response = $this->Rcons("css_reload_infractions {$POST['steamid']}");

                        if ($response == 'error') {
                            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                        } else {
                            $embed = [
                                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebUnMute')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                                "image" => [
                                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                                ],
                                "thumbnail" => [
                                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                                ]
                            ];
                            $this->DiscordWebhook($embed);
                            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnMute')];
                        }
                    }
                    break;
                default;
            }
        }
    }

    public function Add_Warn($POST)
    {
        $steam64 = $this->Steam64_ID($POST['steamid']);
        if (!$steam64)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
        if ($this->ModDBFor()[$this->ServerGroup()]['admin_mod'] == 'IksAdmin') {
            if (!$this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `sid` = :steamid", ['steamid' => $steam64]))
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoAdmin')];
        } else {
            if (!$this->Db->query('AdminSystem', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBFor()[$this->ServerGroup()]['Table'] . "admins` WHERE `steamid` = :steamid;", ['steamid' => $steam64]))
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoAdmin')];
        }
        if (empty($POST['reason']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonNo')];
        if ($POST['time'] < 1)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
        $end = (float) ($POST['time']) * 24 * 60 * 60 + time();
        $AddWarn = [
            "steamid" => $steam64,
            "reason" => $POST['reason'],
            "time" => $end,
            "createtime" => time(),
        ];
        if (empty(array_filter($AddWarn))) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
        } else {
            $this->Db->query('Core', 0, 0, "INSERT INTO `lvl_web_managersystem_warn` (`steamid`, `reason`, `time`, `createtime`) VALUES (:steamid, :reason, :time, :createtime);", $AddWarn);
            $end_2 = (float) ($POST['time']) * 24 * 60 * 60;
            $end_embed = empty($end_2) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($end_2);
            $embed = [
                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebHookPred')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebYslow')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebReason')} {$POST['reason']}",
                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                "image" => [
                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                ],
                "thumbnail" => [
                    "url" => "" . $this->General->getAvatar($steam64, 1) . ""
                ]
            ];
            $this->DiscordWebhook($embed);
            $count = $this->Db->query('Core', 0, 0, "SELECT COUNT(*) FROM `lvl_web_managersystem_warn` WHERE `steamid` = " . $AddWarn['steamid'] . "", $AddWarn);
            $this->Notifications->SendNotification($steam64, '_MSPageName', '_MSWarning', ['count' => $count["COUNT(*)"], 'warn' => $this->GetCache('settings')['count_warn'], 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
            if ($this->GetCache('settings')['warn_auto_del'] == 1) {
                $this->Warn_Del_Admin();
            }
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddPred')];
        }
    }

    public function Del_Warn($POST)
    {
        if (empty(array_filter($POST))) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
        } else {
            $this->Db->query('Core', 0, 0, "DELETE FROM `lvl_web_managersystem_warn` WHERE `steamid` = '{$POST['steamid']}' AND `id` = '{$POST['end']}' LIMIT 1");
            $embed = [
                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelPred')} [{$this->General->checkName($POST['steamid'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid']}/?search=1)",
                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                "image" => [
                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                ],
                "thumbnail" => [
                    "url" => "" . $this->General->getAvatar($POST['steamid'], 1) . ""
                ]
            ];
            $this->DiscordWebhook($embed);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelPred')];
        }
    }

    public function Warn_Del_Admin()
    {
        $counts = [];
        foreach ($this->Warn() as $warn) {
            if ($warn['time'] < time()) {
                continue;
            }

            $steamid = $warn['steamid'];
            if (!isset($counts[$steamid])) {
                $counts[$steamid] = 0;
            }
            $counts[$steamid]++;
        }

        $steamidsToDelete = [];
        foreach ($counts as $steamid => $count) {
            if ($count >= ($this->GetCache('settings')['count_warn'])) {
                $steamidsToDelete[] = $steamid;
            }
        }

        if (!empty($steamidsToDelete)) {
            foreach ($steamidsToDelete as $steamid) {
                if ($this->ModDBFor()[$this->ServerGroup()]['admin_mod'] == 'IksAdmin') {
                    $this->Db->query('IksAdmin', $this->ModDBFor()[0]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[0]['Table'] . "admins` WHERE `sid` = '$steamid'");
                } else {
                    $this->Db->query('AdminSystem', $this->ModDBFor()[$this->ServerGroup()]['USER_ID'], $this->ModDBFor()[0]['DB_num'], "DELETE FROM `" . $this->ModDBFor()[$this->ServerGroup()]['Table'] . "admins` WHERE `steamid` = '$steamid'");
                }
                $embed = [
                    "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSysPred')}",
                    "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSysPredDel')} [{$this->General->checkName($steamid)}](http:" . $this->General->arr_general['site'] . "profiles/{$steamid}/?search=1)",
                    "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                    "image" => [
                        "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                    ],
                    "thumbnail" => [
                        "url" => "" . $this->General->getAvatar($steamid, 1) . ""
                    ]
                ];
                $this->DiscordWebhook($embed);
                $this->Notifications->SendNotification($POST['steamid'], '_MSPageName', '_MSAdminDelGift', ['module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                $this->Db->query('Core', 0, 0, "DELETE FROM `lvl_web_managersystem_warn` WHERE `steamid` = '$steamid'");
            }
        }
    }

    public function Del_Ar_Moon()
    {
        $this->Db->queryAll('AdminReward', $this->Db->db_data['AdminReward'][0]['USER_ID'], $this->Db->db_data['AdminReward'][0]['DB_num'], "DELETE FROM `" . $this->Db->db_data['AdminReward'][0]['Table'] . "info` WHERE DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m') != DATE_FORMAT(NOW(), '%Y-%m') AND YEAR(`date`) != YEAR(NOW()) OR MONTH(`date`) != MONTH(NOW())");
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSArStatDel')];
    }

    public function Del_Ar_User($POST)
    {
        $this->Db->queryAll('AdminReward', $this->Db->db_data['AdminReward'][0]['USER_ID'], $this->Db->db_data['AdminReward'][0]['DB_num'], "DELETE FROM `" . $this->Db->db_data['AdminReward'][0]['Table'] . "info` WHERE `steamid` = '{$POST['steamid']}'");
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSArStatDel')];
    }
}
