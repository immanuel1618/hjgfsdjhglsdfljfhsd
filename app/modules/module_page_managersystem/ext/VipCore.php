<?php /**
  * @author -r8 (@r8.dev)
  **/

namespace app\modules\module_page_managersystem\ext;

use app\modules\module_page_managersystem\ext\Core;

class VipCore extends Core
{
    protected $Db, $General, $Translate, $Modules;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications, $Router)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
        $this->Router = $Router;
        $this->GetServerIdVip = $this->GetServerIdVip();
    }

    public function ServerGroupVip()
    {
        return (int) intval(get_section('server_id_vip', '0'));
    }

    public function GetServerIdVip()
    {
        $this->Router->map('GET|POST', 'managersystem/[addvip:page]/[:server_id]/', 'addvip');
        return $this->Router->match()['params']['server_id'] ?? 'all';
    }

    public function ModDBForVip()
    {
        if (!empty($this->Db->db_data['Vips'])) {
            for ($i = 0; $i < $this->Db->table_count['Vips']; $i++) {
                $res_vip[] = [
                    'USER_ID' => $this->Db->db_data['Vips'][$i]['USER_ID'],
                    'DB_num' => $this->Db->db_data['Vips'][$i]['DB_num'],
                    'Table' => $this->Db->db_data['Vips'][$i]['Table'],
                    'Name' => $this->Db->db_data['Vips'][$i]['name']
                ];
            }
        }

        return $res_vip;
    }

    public function Vip_Add($POST)
    {
        if (!empty($this->Db->db_data['Vips'])) {
            $steam3 = $this->Steam3_ID($POST['account_id']);
            if ($this->GetCache('settings')['vip_one_table'] == 1 && !empty($this->GetCache('serversvip'))) {
                if ($this->GetServerIdVip() == 'all') {
                    $server = implode($POST['sid']);
                    $server_id = implode(' | ', $POST['sid']);
                } else {
                    $server = $this->GetServerIdVip();
                    $server_id = $this->GetServerIdVip();
                }
            } else {
                $server = $POST['sid'];
                $server_id = $POST['sid'];
            }

            if ($this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` WHERE `account_id` = :steamid AND `sid` = :sid;", ['steamid' => $steam3, 'sid' => $server]))
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamYes')];
            if (!$steam3)
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
            if ($this->GetCache('settings')['group_choice_vip'] == 0 && $this->GetCache('settings')['time_choice_privileges'] == 0) {
                if (empty($POST['group']))
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupVipNo')];
                if (!isset($server) || $server === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
                }
                if (!isset($POST['expires']) || $POST['expires'] === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                }
                if ($POST['expires'] < 0)
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                if ($POST['expires'] == 0) {
                    $end = 0;
                } else
                    $end = (float) ($POST['expires']) * 24 * 60 * 60 + time();

                $VipAdd = [
                    "account_id" => $steam3,
                    "name" => empty($this->General->checkName(con_steam3to64_int($steam3))) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName(con_steam3to64_int($steam3)),
                    "group" => $POST['group'],
                    "expires" => $end,
                    "sid" => $server,
                ];

                if (empty(array_filter($VipAdd))) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                } else {
                    $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "INSERT INTO `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` (`account_id`, `name`, `sid`, `group`, `expires`) VALUES (:account_id, :name, :sid, :group, :expires);", $VipAdd);
                    $end_2 = (float) ($POST['expires']) * 24 * 60 * 60;
                    $end_embed = empty($end_2) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($end_2);

                    $response = $this->Rcons("css_reload_vip_player {$POST['steamid']}; mm_reload_vip {$POST['steamid']}");

                    if ($response == 'error') {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                    } elseif ($response == 'errorpass') {
                        return ['status' => 'error', 'text' => 'Не найден RCON пароль!'];
                    } else {
                        $embed = [
                            "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                            "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebVipAdd')} [{$this->General->checkName(con_steam3to64_int($steam3))}](http:" . $this->General->arr_general['site'] . "profiles/" . con_steam3to64_int($steam3) . "/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebGroups')} {$POST['group']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                            "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                            "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                            "image" => [
                                "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                            ],
                            "thumbnail" => [
                                "url" => "{$this->General->getAvatar(con_steam3to64_int($steam3), 1)}"
                            ]
                        ];
                        $this->DiscordWebhook($embed);
                        $this->Notifications->SendNotification($POST['account_id'], '_MSPageName', '_MSVipGift', ['vgroup' => $POST['group'], 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipAdd')];
                    }
                }
            }
            if ($this->GetCache('settings')['group_choice_vip'] == 1 && $this->GetCache('settings')['time_choice_privileges'] == 0) {
                if (!isset($server) || $server === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
                }
                if (!isset($POST['expires']) || $POST['expires'] === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                }
                if ($POST['expires'] < 0)
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                if ($POST['expires'] == 0) {
                    $end = 0;
                } else
                    $end = (float) ($POST['expires']) * 24 * 60 * 60 + time();

                $res = '';
                foreach ($this->GetCache('vipgroup') as $group) {
                    if ($group['id'] == $POST['group_choice_vip']) {
                        $res = $group['name_group'];
                        break;
                    }
                }

                if ($res) {
                    $VipAddGroup = [
                        "account_id" => $steam3,
                        "name" => empty($this->General->checkName(con_steam3to64_int($steam3))) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName(con_steam3to64_int($steam3)),
                        "group" => $res,
                        "expires" => $end,
                        "sid" => $server,
                        "lastvisit"
                    ];
                }

                if (empty(array_filter($VipAddGroup))) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                } else {
                    $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "INSERT INTO `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` (`account_id`, `name`, `sid`, `group`, `expires`) VALUES (:account_id, :name, :sid, :group, :expires);", $VipAddGroup);
                    $end_2 = (float) ($POST['expires']) * 24 * 60 * 60;
                    $end_embed = empty($end_2) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($end_2);

                    $response = $this->Rcons("css_reload_vip_player {$POST['steamid']}; mm_reload_vip {$POST['steamid']}");

                    if ($response == 'error') {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                    } elseif ($response == 'errorpass') {
                        return ['status' => 'error', 'text' => 'Не найден RCON пароль!'];
                    } else {
                        $embed = [
                            "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                            "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebVipAdd')} [{$this->General->checkName(con_steam3to64_int($steam3))}](http:" . $this->General->arr_general['site'] . "profiles/" . con_steam3to64_int($steam3) . "/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebGroups')} {$res}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                            "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                            "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                            "image" => [
                                "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                            ],
                            "thumbnail" => [
                                "url" => "{$this->General->getAvatar(con_steam3to64_int($steam3), 1)}"
                            ]
                        ];
                        $this->DiscordWebhook($embed);
                        $this->Notifications->SendNotification($POST['account_id'], '_MSPageName', '_MSVipGift', ['vgroup' => $res, 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipAdd')];
                    }
                }
            }
            if ($this->GetCache('settings')['group_choice_vip'] == 0 && $this->GetCache('settings')['time_choice_privileges'] == 1) {
                if (empty($POST['group']))
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupVipNo')];
                if (!isset($server) || $server === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
                }

                $res = '';
                foreach ($this->GetCache('privilegestime') as $time) {
                    if ($time['id'] == $POST['time_choice_privileges']) {
                        $res = $time['duration'];
                        break;
                    }
                }

                if (empty($POST['time_choice_privileges']) && (!isset($POST['expires']) || $POST['expires'] === '')) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                } elseif (!empty($POST['time_choice_privileges']) && (!empty($POST['expires']) || $POST['expires'] !== '')) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                } elseif ($POST['expires'] < 0) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                } elseif ((!empty($POST['expires']) || $POST['expires'] !== '') && empty($POST['time_choice_privileges'])) {
                    $end = (float) ($POST['expires']) * 24 * 60 * 60 + time();
                } elseif (empty($POST['time_choice_privileges']) && $POST['expires'] == 0) {
                    $end = 0;
                } elseif ((!isset($POST['expires']) || $POST['expires'] === '') && $res == 0) {
                    $end = 0;
                } elseif (!empty($POST['time_choice_privileges']) && (!isset($POST['expires']) || $POST['expires'] === '')) {
                    $end = $res + time();
                } 

                $VipAddTime = [
                    "account_id" => $steam3,
                    "name" => empty($this->General->checkName(con_steam3to64_int($steam3))) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName(con_steam3to64_int($steam3)),
                    "group" => $POST['group'],
                    "expires" => $end,
                    "sid" => $server,
                ];

                if (empty(array_filter($VipAddTime))) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                } else {
                    $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "INSERT INTO `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` (`account_id`, `name`, `sid`, `group`, `expires`) VALUES (:account_id, :name, :sid, :group, :expires);", $VipAddTime);
                    $end_embed = empty($res) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res);

                    $response = $this->Rcons("css_reload_vip_player {$POST['steamid']}; mm_reload_vip {$POST['steamid']}");

                    if ($response == 'error') {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                    } elseif ($response == 'errorpass') {
                        return ['status' => 'error', 'text' => 'Не найден RCON пароль!'];
                    } else {
                        $embed = [
                            "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                            "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebVipAdd')} [{$this->General->checkName(con_steam3to64_int($steam3))}](http:" . $this->General->arr_general['site'] . "profiles/" . con_steam3to64_int($steam3) . "/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebGroups')} {$POST['group']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                            "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                            "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                            "image" => [
                                "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                            ],
                            "thumbnail" => [
                                "url" => "{$this->General->getAvatar(con_steam3to64_int($steam3), 1)}"
                            ]
                        ];
                        $this->DiscordWebhook($embed);
                        $this->Notifications->SendNotification($POST['account_id'], '_MSPageName', '_MSVipGift', ['vgroup' => $POST['group'], 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipAdd')];
                    }
                }
            }
            if ($this->GetCache('settings')['group_choice_vip'] == 1 && $this->GetCache('settings')['time_choice_privileges'] == 1) {
                if (!isset($server) || $server === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
                }

                $res_time = '';
                foreach ($this->GetCache('privilegestime') as $time) {
                    if ($time['id'] == $POST['time_choice_privileges']) {
                        $res_time = $time['duration'];
                        break;
                    }
                }

                $res_group = '';
                foreach ($this->GetCache('vipgroup') as $group) {
                    if ($group['id'] == $POST['group_choice_vip']) {
                        $res_group = $group['name_group'];
                        break;
                    }
                }

                if (empty($POST['time_choice_privileges']) && (!isset($POST['expires']) || $POST['expires'] === '')) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime3')];
                } elseif (!empty($POST['time_choice_privileges']) && (!empty($POST['expires']) || $POST['expires'] !== '')) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime4')];
                } elseif ($POST['expires'] < 0) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                } elseif ((!empty($POST['expires']) || $POST['expires'] !== '') && empty($POST['time_choice_privileges'])) {
                    $end = (float) ($POST['expires']) * 24 * 60 * 60 + time();
                } elseif (empty($POST['time_choice_privileges']) && $POST['expires'] == 0) {
                    $end = 0;
                } elseif ((!isset($POST['expires']) || $POST['expires'] === '') && $res_time == 0) {
                    $end = 0;
                } elseif (!empty($POST['time_choice_privileges']) && (!isset($POST['expires']) || $POST['expires'] === '')) {
                    $end = $res_time + time();
                } 
                             
                if ($res_group) {
                    $VipAddAll = [
                        "account_id" => $steam3,
                        "name" => empty($this->General->checkName(con_steam3to64_int($steam3))) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName(con_steam3to64_int($steam3)),
                        "group" => $res_group,
                        "expires" => $end,
                        "sid" => $server,
                    ];
                }

                if (empty(array_filter($VipAddAll))) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                } else {
                    $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "INSERT INTO `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` (`account_id`, `name`, `sid`, `group`, `expires`) VALUES (:account_id, :name, :sid, :group, :expires);", $VipAddAll);
                    $end_embed = empty($res_time) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($res_time);

                    $response = $this->Rcons("css_reload_vip_player {$POST['steamid']}; mm_reload_vip {$POST['steamid']}");

                    if ($response == 'error') {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                    } elseif ($response == 'errorpass') {
                        return ['status' => 'error', 'text' => 'Не найден RCON пароль!'];
                    } else {
                        $embed = [
                            "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                            "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebVipAdd')} [{$this->General->checkName(con_steam3to64_int($steam3))}](http:" . $this->General->arr_general['site'] . "profiles/" . con_steam3to64_int($steam3) . "/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebGroups')} {$res_group}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                            "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                            "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                            "image" => [
                                "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                            ],
                            "thumbnail" => [
                                "url" => "{$this->General->getAvatar(con_steam3to64_int($steam3), 1)}"
                            ]
                        ];
                        $this->DiscordWebhook($embed);
                        $this->Notifications->SendNotification($POST['account_id'], '_MSPageName', '_MSVipGift', ['vgroup' => $res_group, 'module_translation' => 'module_page_managersystem'], '', 'ms', '_Go');
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipAdd')];
                    }
                }
            }
        }
    }

    public function Vip_Del($POST)
    {
        if (!empty($this->Db->db_data['Vips'])) {
            if (empty(array_filter($POST))) {
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
            } else {
                $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "DELETE FROM `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` WHERE `account_id` = '{$POST['steamid']}' AND `sid` = '{$POST['end']}' LIMIT 1");

                $response = $this->Rcons("css_reload_vip_player {$POST['steamid']}; mm_reload_vip {$POST['steamid']}");

                if ($response == 'error') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                } elseif ($response == 'errorpass') {
                    return ['status' => 'error', 'text' => 'Не найден RCON пароль!'];
                } else {
                    $embed = [
                        "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                        "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebDelVip')} [{$this->General->checkName(con_steam3to64_int($POST['steamid']))}](http:" . $this->General->arr_general['site'] . "profiles/" . con_steam3to64_int($POST['steamid']) . "/?search=1)",
                        "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                        "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                        "image" => [
                            "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                        ],
                        "thumbnail" => [
                            "url" => "" . $this->General->getAvatar(con_steam3to64_int($POST['steamid']), 1) . ""
                        ]
                    ];
                    $this->DiscordWebhook($embed);
                    return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipDel')];
                }
            }
        }
    }

    public function Vip_Info_Get($AccId, $Sid) {
        if (!empty($this->Db->db_data['Vips'])) {
            return $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "SELECT * FROM `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` WHERE `account_id` = :account_id AND `sid` = :sid", ['account_id' => $AccId, 'sid' => $Sid]);
        }
    }

    public function Vip_Edit($POST, $GETACC, $GETSID)
    {
        if (!empty($this->Db->db_data['Vips'])) {
            $steam3 = $this->Steam3_ID($POST['account_id']);
            if ($this->GetCache('settings')['vip_one_table'] == 1 && !empty($this->GetCache('serversvip'))) {
                if ($this->GetServerIdVip() == 'all') {
                    $server = implode($POST['sid']);
                    $server_id = implode(' | ', $POST['sid']);
                } else {
                    $server = $this->GetServerIdVip();
                    $server_id = $this->GetServerIdVip();
                }
            } else {
                $server = $POST['sid'];
                $server_id = $POST['sid'];
            }

            if (!$steam3)
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
            if ($this->GetCache('settings')['group_choice_vip'] == 0) {
                if (empty($POST['group']))
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupVipNo')];
                if (!isset($server) || $server === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
                }
                if (!isset($POST['expires']) || $POST['expires'] === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                }
                if ($POST['expires'] < 0)
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                if ($POST['expires'] == 0 && (!isset($POST['expires_plus']) || $POST['expires_plus'] === '')) {
                    $end = 0;
                } elseif ($POST['expires'] == 0 && (isset($POST['expires_plus']) || $POST['expires_plus'] != '')) {
                    return ['status' => 'error', 'text' => 'Невозможно добавить время к сроку навсегда!'];
                } elseif ($POST['expires'] != 0 && (isset($POST['expires_plus']) || $POST['expires_plus'] != '')) {
                    $end_plus = $POST['expires_plus'] * 60 * 60 * 24;
                    $end = $POST['expires'] + $end_plus + time();
                } elseif ((isset($POST['expires']) || $POST['expires'] != '') && (!isset($POST['expires_plus']) || $POST['expires_plus'] === '')) {
                    $end = (float) ($POST['expires']) + time();
                }

                $VipAdd = [
                    "account_id" => $steam3,
                    "name" => empty($this->General->checkName(con_steam3to64_int($steam3))) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName(con_steam3to64_int($steam3)),
                    "group" => $POST['group'],
                    "expires" => $end,
                    "sid" => $server,
                ];

                if (empty(array_filter($VipAdd))) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                } else {
                    $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "UPDATE `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` SET `account_id` = :account_id, `name` = :name, `sid` = :sid, `group` = :group, `expires` = :expires WHERE `account_id` = :account_id AND `sid` = :sid", ['account_id' => $GETACC, 'sid' => $GETSID] + $VipAdd);
                    $end_embed = empty($POST['expires']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['expires']);

                    $response = $this->Rcons("css_reload_vip_player {$POST['steamid']}; mm_reload_vip {$POST['steamid']}");

                    if ($response == 'error') {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                    } elseif ($response == 'errorpass') {
                        return ['status' => 'error', 'text' => 'Не найден RCON пароль!'];
                    } else {
                        $embed = [
                            "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                            "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebVipEdit')} [{$this->General->checkName(con_steam3to64_int($steam3))}](http:" . $this->General->arr_general['site'] . "profiles/" . con_steam3to64_int($steam3) . "/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebGroupsEdit')} {$POST['group']}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                            "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                            "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                            "image" => [
                                "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                            ],
                            "thumbnail" => [
                                "url" => "{$this->General->getAvatar(con_steam3to64_int($steam3), 1)}"
                            ]
                        ];
                        $this->DiscordWebhook($embed);
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditVip')];
                    }
                }
            }
            if ($this->GetCache('settings')['group_choice_vip'] == 1) {
                if (!isset($server) || $server === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
                }
                if (!isset($POST['expires']) || $POST['expires'] === '') {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNo')];
                }
                if ($POST['expires'] < 0)
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];
                if ($POST['expires'] == 0 && (!isset($POST['expires_plus']) || $POST['expires_plus'] === '')) {
                    $end = 0;
                } elseif ($POST['expires'] == 0 && (isset($POST['expires_plus']) || $POST['expires_plus'] != '')) {
                    return ['status' => 'error', 'text' => 'Невозможно добавить время к сроку навсегда!'];
                } elseif ($POST['expires'] != 0 && (isset($POST['expires_plus']) || $POST['expires_plus'] != '')) {
                    $end_plus = $POST['expires_plus'] * 60 * 60 * 24;
                    $end = $POST['expires'] + $end_plus + time();
                } elseif ((isset($POST['expires']) || $POST['expires'] != '') && (!isset($POST['expires_plus']) || $POST['expires_plus'] === '')) {
                    $end = (float) ($POST['expires']) + time();
                }

                $res = '';
                foreach ($this->GetCache('vipgroup') as $group) {
                    if ($group['id'] == $POST['group_choice_vip']) {
                        $res = $group['name_group'];
                        break;
                    }
                }

                if ($res) {
                    $VipAddGroup = [
                        "account_id" => $steam3,
                        "name" => empty($this->General->checkName(con_steam3to64_int($steam3))) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : $this->General->checkName(con_steam3to64_int($steam3)),
                        "group" => $res,
                        "expires" => $end,
                        "sid" => $server,
                    ];
                }

                if (empty(array_filter($VipAddGroup))) {
                    return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                } else {
                    $this->Db->query('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'], "UPDATE `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` SET `account_id` = :account_id, `name` = :name, `sid` = :sid, `group` = :group, `expires` = :expires WHERE `account_id` = :account_id AND `sid` = :sid", ['account_id' => $GETACC, 'sid' => $GETSID] + $VipAddGroup);
                    $end_embed = empty($POST['expires']) ? $this->Translate->get_translate_phrase('_Forever') : $this->Modules->action_time_exchange($POST['expires']);

                    $response = $this->Rcons("css_reload_vip_player {$POST['steamid']}; mm_reload_vip {$POST['steamid']}");

                    if ($response == 'error') {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSErrorRcon')];
                    } elseif ($response == 'errorpass') {
                        return ['status' => 'error', 'text' => 'Не найден RCON пароль!'];
                    } else {
                        $embed = [
                            "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                            "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebVipEdit')} [{$this->General->checkName(con_steam3to64_int($steam3))}](http:" . $this->General->arr_general['site'] . "profiles/" . con_steam3to64_int($steam3) . "/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebGroupsEdit')} {$res}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebTime')} {$end_embed}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebID')} {$server_id}",
                            "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                            "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                            "image" => [
                                "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                            ],
                            "thumbnail" => [
                                "url" => "{$this->General->getAvatar(con_steam3to64_int($steam3), 1)}"
                            ]
                        ];
                        $this->DiscordWebhook($embed);
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditVip')];
                    }
                }
            }
        }
    }

    public function Del_Expires_Vip()
    {
        $this->Db->queryAll('Vips', $this->ModDBForVip()[$this->ServerGroupVip()]['USER_ID'], $this->ModDBForVip()[0]['DB_num'],  "DELETE FROM `" . $this->ModDBForVip()[$this->ServerGroupVip()]['Table'] . "users` WHERE `expires` < " . time() . " AND `expires` != 0");
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSChistVip')];
    }
}