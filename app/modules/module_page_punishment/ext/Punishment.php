<?php

/**
 * @author -r8 (@r8.dev)
 **/

namespace app\modules\module_page_punishment\ext;

use app\modules\module_page_punishment\ext\Rcon;

class Punishment extends Rcon
{
    protected $Db, $General, $Translate, $Modules, $Search, $Notifications, $server_id;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications, $server_id)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
        $this->Search = new Search($Db, $General, $Modules, $Translate, $server_id);
        $this->server_id = $server_id;
    }

    public function Search()
    {
        return $this->Search;
    }

    public function GetSettings()
    {
        return $this->Modules->get_settings_modules('module_page_punishment', 'settings');
    }

    public function GetServerLR()
    {
        for ($d = 0; $d < $this->General->server_list_count; $d++) {
            $r[] = array(
                "name" => $this->General->server_list[$d]['name_custom'],
                "server_sb" => explode(";", $this->General->server_list[$d]['server_sb']),
                "server_sb_id" => $this->General->server_list[$d]['server_sb_id']
            );
        }
        return $r;
    }

    public function Rcons($command)
    {
        $_Server_Info = $this->Db->queryAll('Core', 0, 0, "SELECT `ip`, `rcon` FROM `lvl_web_servers`");
        $success = true;
        foreach ($_Server_Info as $server) {
            $_IP = explode(':', $server['ip']);
            $_RCON = new Rcon($_IP[0], $_IP[1]);
            if ($_RCON->Connect()) {
                if (!empty($server['rcon'])) {
                    $_RCON->RconPass($server['rcon']);
                    $_RCON->Command($command);
                } else {
                    $success = false;
                }
                $_RCON->Disconnect();
            } else {
                $success = false;
            }
        }
        if ($success) {
            return "success";
        } else {
            return "error";
        }
    }

    public function GetBalance()
    {
        if (isset($_SESSION['steamid32'])) {
            preg_match('/:[0-9]{1}:\d+/i', $_SESSION['steamid32'], $auth);
            $param = [
                'auth' => '%' . $auth[0] . '%'
            ];
            $infoUser = $this->Db->queryAll(
                'lk',
                $this->Db->db_data['lk'][0]['USER_ID'],
                $this->Db->db_data['lk'][0]['DB_num'],
                "SELECT cash FROM lk WHERE auth LIKE :auth LIMIT 1",
                $param
            );
            $cash = 'cash';
            if (isset($infoUser[0]))
                return $infoUser[0][$cash];
            else return 0;
        }
    }

    public function UpdateBalance($steam, $price)
    {
        preg_match('/:[0-9]{1}:\d+/i', $steam, $auth);
        $param = ['auth' => '%' . $auth[0] . '%', 'price' => $price];
        $this->Db->queryAll(
            'lk',
            $this->Db->db_data['lk'][0]['USER_ID'],
            $this->Db->db_data['lk'][0]['DB_num'],
            "UPDATE lk SET cash = cash - :price WHERE auth LIKE :auth LIMIT 1",
            $param
        );
        return true;
    }

    public function GetInfoCount()
    {
        $infoCount = [
            'count_mutes' => 0,
            'count_gags' => 0,
            'count_bans' => 0,
            'count_bans_perm' => 0,
            'count_bans_activ' => 0,
            'my_count_bans' => 0,
            'my_count_mutes' => 0,
        ];

        if (!empty($this->Db->db_data['AdminSystem'])) {
            for ($i = 0; $i < $this->Db->table_count['AdminSystem']; $i++) {
                $countBansMutesAdmins = $this->Db->query(
                    'AdminSystem',
                    0,
                    0,
                    "SELECT 
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = 1 LIMIT 1) AS count_mutes,
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = 2 LIMIT 1) AS count_gags,
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = 0 LIMIT 1) AS count_bans,
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = 0 AND `expires` = 0 LIMIT 1) AS count_bans_perm,
                        (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = 0 AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) AND `unpunish_admin_id` IS NULL LIMIT 1) AS count_bans_activ"
                );
                $myBanCount = ceil($this->Db->queryNum('AdminSystem', 0, 0, "SELECT COUNT(*) FROM `as_punishments` WHERE `steamid` = " . $_SESSION['steamid64'] . " AND `punish_type` = 0 AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) AND `unpunish_admin_id` IS NULL")[0]);
                $myVoiceCount = ceil($this->Db->queryNum('AdminSystem', 0, 0, "SELECT COUNT(*) FROM `as_punishments` WHERE `steamid` = " . $_SESSION['steamid64'] . " AND `punish_type` = 1 AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) AND `unpunish_admin_id` IS NULL")[0]);
                $myGagCount = ceil($this->Db->queryNum('AdminSystem', 0, 0, "SELECT COUNT(*) FROM `as_punishments` WHERE `steamid` = " . $_SESSION['steamid64'] . " AND `punish_type` = 2 AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) AND `unpunish_admin_id` IS NULL")[0]);
                $myMuteCount = $myVoiceCount + $myGagCount;
                $infoCount['count_admins'] += $countBansMutesAdmins['count_admins'];
                $infoCount['count_mutes'] += $countBansMutesAdmins['count_mutes'];
                $infoCount['count_gags'] += $countBansMutesAdmins['count_gags'];
                $infoCount['count_bans'] += $countBansMutesAdmins['count_bans'];
                $infoCount['count_bans_perm'] += $countBansMutesAdmins['count_bans_perm'];
                $infoCount['count_bans_activ'] += $countBansMutesAdmins['count_bans_activ'];
                $infoCount['my_count_bans'] += $myBanCount;
                $infoCount['my_count_mutes'] += $myMuteCount;
            }
        }
        return $infoCount;
    }

    public function RenderingPageList($page, $limit)
    {
        $page = $page ?? 'bans';
        is_numeric($limit) ? intval($limit) : $limit = 20;
        if (!empty($this->Db->db_data['AdminSystem'])) {
            if ($page == 'bans') {
                $list = $this->Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `as_punishments` WHERE `punish_type` = 0 ORDER BY `created` DESC LIMIT 0, ".$limit."");
                $count = count($list);
                $JSONSear = <<<HTML
                    <div class="input-form w350">
                        <input type="text" placeholder="{$this->Translate->get_translate_module_phrase('module_page_punishment', '_searchPlayers')}" id="search_ban">
                    </div>
                HTML;
                foreach ($list as $key => $row) {
                    $idban = $row['id'];
                    $steam_player = $row['steamid'];
                    $steam_admin = $row['admin_steamid'];
                    $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
                    $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));

                    if (!empty($row['unpunish_admin_id'])) {
                        $end_ban = 'Разбанен';
                        $style_ban = 'remove_punish';
                    } elseif ($row['expires'] == '0') {
                        $end_ban = $this->Translate->get_translate_phrase('_Forever');
                        $style_ban = 'permanent_punish';
                    } elseif (time() > $row['expires']) {
                        $end_ban = $this->Modules->action_time_exchange_exact($row['expires'] - $row['created']);
                        $style_ban = 'expired_punish';
                    } else {
                        $end_ban = $this->Modules->action_time_exchange_exact($row['expires'] - time());
                        $style_ban = 'current_punish';
                    }
                    $reason_ban = action_text_clear($row['reason']);
                    $JSONResult[$key]["html_list"] = <<<HTML
                        <li class="modal_open" page="{$page}" id="{$idban}">
                            <span>
                                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                    <g>
                                        <path d="M6 7.5a5.25 5.25 0 1 1 5.25 5.25A5.26 5.26 0 0 1 6 7.5zM21.92 17a4.68 4.68 0 0 1-1.47 3.42h-.05a4.7 4.7 0 0 1-3.22 1.28 4.73 4.73 0 0 1-3.51-7.92s0-.07.07-.1a4.7 4.7 0 0 1 3.4-1.46A4.75 4.75 0 0 1 21.92 17zm-3.16 2.82-4.41-4.4a3.22 3.22 0 0 0 2.82 4.83 3.18 3.18 0 0 0 1.59-.43zM20.42 17a3.25 3.25 0 0 0-5.06-2.7l4.51 4.51a3.22 3.22 0 0 0 .55-1.81zm-8.37-3.48a.71.71 0 0 0-.57-.27H8.87a6.92 6.92 0 0 0-6.62 5 2.76 2.76 0 0 0 2.65 3.5h7.22a.76.76 0 0 0 .56-.24 1.3 1.3 0 0 0 .1-.15 6.22 6.22 0 0 1-.73-7.84z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="none_span">
                                <img style="position: absolute; transform: scale(1.17);" src="{$this->General->getFrame($steam_player)}" id="frame" frameid="{$steam_player}">
                                <img class="avatar_img" src="{$this->General->getAvatar($steam_player, 3)}" id="avatar" avatarid="{$steam_player}">
                            </span>
                            <span>{$name_player}</span>
                            <span>{$reason_ban}</span>
                            <span class="{$style_ban} none_span">{$end_ban}</span>
                            <span class="none_span">{$name_admin}</span>
                        </li>
                    HTML;
                }
            } elseif ($page == 'comms') {
                $list = $this->Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`  FROM `as_punishments` WHERE `punish_type` != 0 ORDER BY `created` DESC LIMIT 0, ".$limit."");
                $count = count($list);
                $JSONSear = <<<HTML
                    <div class="input-form w350">
                        <input type="text" placeholder="{$this->Translate->get_translate_module_phrase('module_page_punishment', '_searchPlayers')}" id="search_mute">
                    </div>
                HTML;
                foreach ($list as $key => $row) {
                    $idban = $row['id'];
                    $steam_player = $row['steamid'];
                    $steam_admin = $row['admin_steamid'];
                    $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
                    $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));

                    if (!empty($row['unpunish_admin_id'])) {
                        $end_ban = 'Размучен';
                        $style_ban = 'remove_punish';
                    } elseif ($row['expires'] == '0') {
                        $end_ban = $this->Translate->get_translate_phrase('_Forever');
                        $style_ban = 'permanent_punish';
                    } elseif (time() > $row['expires']) {
                        $end_ban = $this->Modules->action_time_exchange_exact($row['expires'] - $row['created']);
                        $style_ban = 'expired_punish';
                    } else {
                        $end_ban = $this->Modules->action_time_exchange_exact($row['expires'] - time());
                        $style_ban = 'current_punish';
                    }
                    $reason_ban = action_text_clear($row['reason']);
                    if ($row['punish_type'] == 3) {
                        $punishmentType = '<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve"><g><path d="M8.5 11a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 8.5 11zm7-3a1.5 1.5 0 1 0 .001 3.001A1.5 1.5 0 0 0 15.5 8zM12 0C5.383 0 0 5.383 0 12s5.383 12 12 12c2.388 0 4.61-.709 6.482-1.917-.104-.085-.215-.16-.311-.256-.3-.3-.58-.698-.863-1.367A9.927 9.927 0 0 1 12 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10c0 .995-.151 1.955-.423 2.863.817.361 1.37.624 1.799.928A11.93 11.93 0 0 0 24 11.999C24 5.383 18.617 0 12 0zM6 18h2v-4H6zm5-4H9v4h2zm1 4h2v-4h-2zm3 0h2v-4h-2zm3.75-2a.75.75 0 0 0-.75.75c0 .088.609 2.674 1.587 3.665.387.392.902.585 1.414.585s1.024-.195 1.414-.585c.78-.78.78-2.048 0-2.828C21.599 16.876 19.327 16 18.75 16z"></path></g></svg>';
                    } elseif ($row['punish_type'] == 2) {
                        $punishmentType = '<svg x="0" y="0" viewBox="0 0 100 100" xml:space="preserve" fill-rule="evenodd"><g><path d="m19.665 18.164 56.25 56.25a3.126 3.126 0 0 0 4.42 0 3.127 3.127 0 0 0 0-4.419l-56.25-56.25a3.126 3.126 0 0 0-4.42 0 3.127 3.127 0 0 0 0 4.419zM52.635 87.5v-6.395a33.153 33.153 0 0 0 18.212-7.596l-4.441-4.44A26.932 26.932 0 0 1 49.51 75c-14.931 0-27.053-12.122-27.053-27.053a3.126 3.126 0 0 0-6.25 0c0 17.327 13.261 31.582 30.178 33.158V87.5H35.447a3.126 3.126 0 0 0 0 6.25h28.125a3.126 3.126 0 0 0 0-6.25zm21.4-28.127 4.645 4.645a33.13 33.13 0 0 0 4.133-16.071 3.126 3.126 0 0 0-6.25 0 26.94 26.94 0 0 1-2.528 11.426z"></path><path d="M28.117 30.78v18.64c0 12.073 9.802 21.875 21.875 21.875a21.785 21.785 0 0 0 13.764-4.877zm3.23-14.094 39.464 39.463a21.828 21.828 0 0 0 1.056-6.729V28.125c0-12.073-9.802-21.875-21.875-21.875-7.881 0-14.795 4.177-18.645 10.436z"></path></g></svg>';
                    } elseif ($row['punish_type'] == 1) {
                        $punishmentType = '<svg x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M18.753 9.833a4.992 4.992 0 0 0-6.92 6.92zM13.247 18.167a4.992 4.992 0 0 0 6.92-6.92z"></path><path d="M23 3H9a5.006 5.006 0 0 0-5 5v12a5.006 5.006 0 0 0 5 5h1.219l.811 3.242a1 1 0 0 0 1.6.539L17.351 25H23a5.006 5.006 0 0 0 5-5V8a5.006 5.006 0 0 0-5-5zm-7 18a6.979 6.979 0 0 1-4.934-2.041s-.011 0-.015-.01-.006-.01-.01-.015a7 7 0 0 1 9.893-9.893s.011 0 .015.01.006.01.01.015A7 7 0 0 1 16 21z"></path></g></svg>';
                    }
                    $JSONResult[$key]["html_list"] = <<<HTML
                        <li class="modal_open" page="{$page}" id="{$idban}">
                            <span>
                                {$punishmentType}
                            </span>
                            <span class="none_span">
                                <img style="position: absolute; transform: scale(1.17);" src="{$this->General->getFrame($steam_player)}" id="frame" frameid="{$steam_player}">
                                <img class="avatar_img" src="{$this->General->getAvatar($steam_player, 3)}" id="avatar" avatarid="{$steam_player}">
                            </span>
                            <span>{$name_player}</span>
                            <span>{$reason_ban}</span>
                            <span class="{$style_ban} none_span">{$end_ban}</span>
                            <span class="none_span">{$name_admin}</span>
                        </li>
                    HTML;
                }
            }
        }
        return ["html" => $JSONResult, "count" => $count, "search" => $JSONSear];
    }

    public function RenderingModalWindow($page, $id)
    {
        $Access = $this->Db->queryAll('Core', 0, 0, "SELECT `id`, `steamid_access`, `add_admin_access`, `add_ban_access`, `add_mute_access`, `add_vip_access`, `add_warn_access`, `add_timecheck_access`, `add_access` FROM `lvl_web_managersystem_access`");
        if (!empty($this->Db->db_data['AdminSystem'])) {
            if ($page == 'bans') {
                $modal = $this->Db->query('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`  FROM `as_punishments` WHERE `id` = :id AND `punish_type` = 0 LIMIT 1", ['id' => $id]);
                $modalsearch = $this->Db->query('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`  FROM `as_punishments` WHERE `id` = :id AND `punish_type` = 0 AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) LIMIT 1", ['id' => $id]);
                $steam_player = $modal['steamid'];
                $steam_admin = $modal['admin_steamid'];
                $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($modal['name']) : action_text_clear($this->General->checkName($steam_player));
                $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($modal['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
                if (!empty($modal['unpunish_admin_id'])) {
                    $end_ban = 'Разбанен';
                } elseif ($modal['expires'] == '0') {
                    $end_ban = $this->Translate->get_translate_phrase('_Forever');
                } elseif (time() > $modal['expires']) {
                    $end_ban = $this->Modules->action_time_exchange_exact($modal['expires'] - $modal['created']);
                } else {
                    $end_ban = $this->Modules->action_time_exchange_exact($modal['expires'] - time());
                }

                $c_ban_time = date('d.m.Y H:i', $modal['created']);
                $button_unabn_buy = '';
                if ($this->GetSettings()['func_unban'] == 1 && !empty($modalsearch)) {
                    $button_unabn_buy = <<<HTML
                        <div class="punish_buy btn_unban" page="{$page}" idpunish="{$id}" type="buy">
                            {$this->Translate->get_translate_module_phrase('module_page_punishment', '_BuyUnban')}
                            <span>{$this->GetSettings()['price_unban']} {$this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse')}</span>
                        </div>
                    HTML;
                }
                $button_unabn = '';
                if ((file_exists(MODULES . 'module_page_managersystem/description.json') || isset($_SESSION['user_admin'])) && !empty($modalsearch)) {
                    foreach ($Access as $admin) {
                        if (isset($_SESSION['user_admin']) || ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_ban_access'] == 1)) {
                            $button_unabn = <<<HTML
                                <div class="secondary_btn w100 btn_unban" page="{$page}" idpunish="{$id}" type="admin">
                                    {$this->Translate->get_translate_module_phrase('module_page_punishment', '_RemovePunishButton')}
                                </div>
                            HTML;
                        }
                    }
                }
                if (!empty($button_unabn_buy) && !empty($button_unabn)) {
                    $hr = <<<HTML
                        <hr>
                    HTML;
                    $div = <<<HTML
                        <div class="punish_buttons">
                    HTML;
                    $divc = <<<HTML
                        </div>
                    HTML;
                }
                $JSONResult["html_modal"] = <<<HTML
                    <div class="punish_body">
                        {$div}
                            {$button_unabn_buy}
                            {$button_unabn}
                        {$divc}
                        {$hr}
                        <div class="punish_info">
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 448 448" xml:space="preserve">
                                        <g>
                                            <path d="M352 128c0 70.692-57.308 128-128 128S96 198.692 96 128 153.308 0 224 0s128 57.308 128 128zm-44.48 117.12c-49.913 35.838-117.127 35.838-167.04 0C83.528 275.823 48.015 335.299 48 400c0 26.51 21.49 48 48 48h256c26.51 0 48-21.49 48-48-.015-64.701-35.528-124.177-92.48-154.88z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_PunishedPlayer')}</p>
                                    <span><a href="/profiles/{$steam_player}/?search=1" target="_blank">{$name_player}</a></span>
                                </div>
                            </div>
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                        <g>
                                            <path d="M30 22v3c0 2.757-2.243 5-5 5h-3a1 1 0 1 1 0-2h3c1.654 0 3-1.346 3-3v-3a1 1 0 1 1 2 0zM25 2h-3a1 1 0 1 0 0 2h3c1.654 0 3 1.346 3 3v3a1 1 0 1 0 2 0V7c0-2.757-2.243-5-5-5zM10 28H7c-1.654 0-3-1.346-3-3v-3a1 1 0 1 0-2 0v3c0 2.757 2.243 5 5 5h3a1 1 0 1 0 0-2zM3 11a1 1 0 0 0 1-1V7c0-1.654 1.346-3 3-3h3a1 1 0 1 0 0-2H7C4.243 2 2 4.243 2 7v3a1 1 0 0 0 1 1zm9.141 5.164a6.68 6.68 0 0 0-1.085.886A6.915 6.915 0 0 0 9 22a1 1 0 0 0 1 1h12.02a1 1 0 0 0 .977-1.215 6.9 6.9 0 0 0-2.044-4.726 6.736 6.736 0 0 0-1.094-.894A4.962 4.962 0 0 0 21 13c0-2.757-2.243-5-5-5s-5 2.243-5 5c0 1.178.416 2.284 1.141 3.164z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_SteamidPlayer')}</p>
                                    <span>{$steam_player}</span>
                                </div>
                            </div>
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                        <g>
                                            <path d="M30 6.93V11H2V6.93A2.969 2.969 0 0 1 5 4h2v2a3 3 0 0 0 6 0V4h6v2a3 3 0 0 0 6 0V4h2a2.969 2.969 0 0 1 3 2.93zM2 13v16.07A2.969 2.969 0 0 0 5 32h22a2.969 2.969 0 0 0 3-2.93V13zm9 14a1.003 1.003 0 0 1-1 1H8a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm0-7a1.003 1.003 0 0 1-1 1H8a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm7 7a1.003 1.003 0 0 1-1 1h-2a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm0-7a1.003 1.003 0 0 1-1 1h-2a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm7 0a1.003 1.003 0 0 1-1 1h-2a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1z"></path>
                                            <path d="M11 4v2a1 1 0 0 1-2 0V4a1 1 0 0 1 2 0zM23 4v2a1 1 0 0 1-2 0V4a1 1 0 0 1 2 0z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_DatePunishment')}</p>
                                    <span>{$c_ban_time}</span>
                                </div>
                            </div>
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                        <g>
                                            <path d="M426.667 102.99V58.066C439.358 50.667 448 37.059 448 21.333V10.667A10.66 10.66 0 0 0 437.333 0H74.667A10.66 10.66 0 0 0 64 10.667v10.667c0 15.725 8.642 29.333 21.333 36.733v44.923c0 42.271 18.021 82.729 49.438 111L181.448 256l-46.677 42.01c-31.417 28.271-49.438 68.729-49.438 111v44.923C72.642 461.333 64 474.941 64 490.667v10.667A10.66 10.66 0 0 0 74.667 512h362.667a10.66 10.66 0 0 0 10.667-10.667v-10.667c0-15.725-8.642-29.333-21.333-36.733V409.01c0-42.271-18.021-82.729-49.438-111L330.552 256l46.677-42.01c31.417-28.271 49.438-68.73 49.438-111zm-77.979 79.291-64.292 57.865c-4.5 4.042-7.063 9.802-7.063 15.854s2.563 11.813 7.063 15.854l64.292 57.865C371.125 349.917 384 378.823 384 409.01V448h-26.672l-92.797-123.729c-4.021-5.375-13.042-5.375-17.063 0L154.672 448H128v-38.99c0-30.188 12.875-59.094 35.313-79.292l64.292-57.865c4.5-4.042 7.063-9.802 7.063-15.854s-2.563-11.813-7.063-15.854l-64.292-57.865C140.875 162.083 128 133.177 128 102.99V64h256v38.99c0 30.187-12.875 59.093-35.312 79.291z"></path>
                                            <path d="M329.521 149.333H182.469c-4.219 0-8.042 2.49-9.75 6.344a10.655 10.655 0 0 0 1.854 11.49l74.271 68.521c2.031 1.844 4.594 2.76 7.156 2.76s5.125-.917 7.156-2.76l74.26-68.521a10.654 10.654 0 0 0 1.854-11.49 10.665 10.665 0 0 0-9.749-6.344z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_TermModal')}</p>
                                    <span>{$end_ban}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="punish_take_admin">{$this->Translate->get_translate_module_phrase('module_page_punishment', '_IssuedBy')} - <a href="/profiles/{$steam_admin}/?search=1" target="_blank">{$name_admin}</a></div>
                    </div>
                HTML;
            }
            if ($page == 'comms') {
                $modalarray = $this->Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`  FROM `as_punishments` WHERE `id` = :id AND `punish_type` != 0 LIMIT 1", ['id' => $id]);
                $modalarray1 = $this->Db->queryAll('AdminSystem', 0, 0, "SELECT *, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`  FROM `as_punishments` WHERE `id` = :id AND `punish_type` != 0 AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) LIMIT 1", ['id' => $id]);
                $modal = reset($modalarray);
                $modalsearch = reset($modalarray1);
                $id = $modal['id'];
                $steam_player = $modal['steamid'];
                $steam_admin = $modal['admin_steamid'];
                $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($modal['name']) : action_text_clear($this->General->checkName($steam_player));
                $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($modal['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
                if (!empty($key['unpunish_admin_id'])) {
                    $end_ban = 'Размучен';
                } elseif ($modal['expires'] == '0') {
                    $end_ban = $this->Translate->get_translate_phrase('_Forever');
                } elseif (time() > $modal['expires']) {
                    $end_ban = $this->Modules->action_time_exchange_exact($modal['expires'] - $modal['created']);
                } else {
                    $end_ban = $this->Modules->action_time_exchange_exact($modal['expires'] - time());
                }
                $c_ban_time = date('d.m.Y H:i', $modal['created']);
                $button_unabn_buy = '';
                if ($this->GetSettings()['func_unmute'] == 1 && !empty($modalsearch)) {
                    $button_unabn_buy = <<<HTML
                        <div class="punish_buy btn_unban" page="{$page}" idpunish="{$id}" type="buy">
                            {$this->Translate->get_translate_module_phrase('module_page_punishment', '_BuyUnban')}
                            <span>{$this->GetSettings()['price_unmute']} {$this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse')}</span>
                        </div>
                    HTML;
                }
                $button_unabn = '';
                if ((file_exists(MODULES . 'module_page_managersystem/description.json') || isset($_SESSION['user_admin'])) && !empty($modalsearch)) {
                    foreach ($Access as $admin) {
                        if (isset($_SESSION['user_admin']) || ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_mute_access'] == 1)) {
                            $button_unabn = <<<HTML
                                <div class="secondary_btn w100 btn_unban" page="{$page}" idpunish="{$id}" type="admin">
                                    {$this->Translate->get_translate_module_phrase('module_page_punishment', '_RemovePunishButton')}
                                </div>
                            HTML;
                        }
                    }
                }
                if (!empty($button_unabn_buy) && !empty($button_unabn)) {
                    $hr = <<<HTML
                        <hr>
                    HTML;
                }
                $JSONResult["html_modal"] = <<<HTML
                    <div class="punish_body">
                        <div class="punish_buttons">
                            {$button_unabn_buy}
                            {$button_unabn}
                        </div>
                        {$hr}
                        <div class="punish_info">
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 448 448" xml:space="preserve">
                                        <g>
                                            <path d="M352 128c0 70.692-57.308 128-128 128S96 198.692 96 128 153.308 0 224 0s128 57.308 128 128zm-44.48 117.12c-49.913 35.838-117.127 35.838-167.04 0C83.528 275.823 48.015 335.299 48 400c0 26.51 21.49 48 48 48h256c26.51 0 48-21.49 48-48-.015-64.701-35.528-124.177-92.48-154.88z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_PunishedPlayer')}</p>
                                    <span><a href="/profiles/{$steam_player}/?search=1" target="_blank">{$name_player}</a></span>
                                </div>
                            </div>
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                        <g>
                                            <path d="M30 22v3c0 2.757-2.243 5-5 5h-3a1 1 0 1 1 0-2h3c1.654 0 3-1.346 3-3v-3a1 1 0 1 1 2 0zM25 2h-3a1 1 0 1 0 0 2h3c1.654 0 3 1.346 3 3v3a1 1 0 1 0 2 0V7c0-2.757-2.243-5-5-5zM10 28H7c-1.654 0-3-1.346-3-3v-3a1 1 0 1 0-2 0v3c0 2.757 2.243 5 5 5h3a1 1 0 1 0 0-2zM3 11a1 1 0 0 0 1-1V7c0-1.654 1.346-3 3-3h3a1 1 0 1 0 0-2H7C4.243 2 2 4.243 2 7v3a1 1 0 0 0 1 1zm9.141 5.164a6.68 6.68 0 0 0-1.085.886A6.915 6.915 0 0 0 9 22a1 1 0 0 0 1 1h12.02a1 1 0 0 0 .977-1.215 6.9 6.9 0 0 0-2.044-4.726 6.736 6.736 0 0 0-1.094-.894A4.962 4.962 0 0 0 21 13c0-2.757-2.243-5-5-5s-5 2.243-5 5c0 1.178.416 2.284 1.141 3.164z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_SteamidPlayer')}</p>
                                    <span>{$steam_player}</span>
                                </div>
                            </div>
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                        <g>
                                            <path d="M30 6.93V11H2V6.93A2.969 2.969 0 0 1 5 4h2v2a3 3 0 0 0 6 0V4h6v2a3 3 0 0 0 6 0V4h2a2.969 2.969 0 0 1 3 2.93zM2 13v16.07A2.969 2.969 0 0 0 5 32h22a2.969 2.969 0 0 0 3-2.93V13zm9 14a1.003 1.003 0 0 1-1 1H8a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm0-7a1.003 1.003 0 0 1-1 1H8a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm7 7a1.003 1.003 0 0 1-1 1h-2a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm0-7a1.003 1.003 0 0 1-1 1h-2a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1zm7 0a1.003 1.003 0 0 1-1 1h-2a1.003 1.003 0 0 1-1-1v-2a1.003 1.003 0 0 1 1-1h2a1.003 1.003 0 0 1 1 1z"></path>
                                            <path d="M11 4v2a1 1 0 0 1-2 0V4a1 1 0 0 1 2 0zM23 4v2a1 1 0 0 1-2 0V4a1 1 0 0 1 2 0z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_DatePunishment')}</p>
                                    <span>{$c_ban_time}</span>
                                </div>
                            </div>
                            <div class="punish_subinfo">
                                <div class="icon_subinfo">
                                    <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                        <g>
                                            <path d="M426.667 102.99V58.066C439.358 50.667 448 37.059 448 21.333V10.667A10.66 10.66 0 0 0 437.333 0H74.667A10.66 10.66 0 0 0 64 10.667v10.667c0 15.725 8.642 29.333 21.333 36.733v44.923c0 42.271 18.021 82.729 49.438 111L181.448 256l-46.677 42.01c-31.417 28.271-49.438 68.729-49.438 111v44.923C72.642 461.333 64 474.941 64 490.667v10.667A10.66 10.66 0 0 0 74.667 512h362.667a10.66 10.66 0 0 0 10.667-10.667v-10.667c0-15.725-8.642-29.333-21.333-36.733V409.01c0-42.271-18.021-82.729-49.438-111L330.552 256l46.677-42.01c31.417-28.271 49.438-68.73 49.438-111zm-77.979 79.291-64.292 57.865c-4.5 4.042-7.063 9.802-7.063 15.854s2.563 11.813 7.063 15.854l64.292 57.865C371.125 349.917 384 378.823 384 409.01V448h-26.672l-92.797-123.729c-4.021-5.375-13.042-5.375-17.063 0L154.672 448H128v-38.99c0-30.188 12.875-59.094 35.313-79.292l64.292-57.865c4.5-4.042 7.063-9.802 7.063-15.854s-2.563-11.813-7.063-15.854l-64.292-57.865C140.875 162.083 128 133.177 128 102.99V64h256v38.99c0 30.187-12.875 59.093-35.312 79.291z"></path>
                                            <path d="M329.521 149.333H182.469c-4.219 0-8.042 2.49-9.75 6.344a10.655 10.655 0 0 0 1.854 11.49l74.271 68.521c2.031 1.844 4.594 2.76 7.156 2.76s5.125-.917 7.156-2.76l74.26-68.521a10.654 10.654 0 0 0 1.854-11.49 10.665 10.665 0 0 0-9.749-6.344z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text_subinfo">
                                    <p>{$this->Translate->get_translate_module_phrase('module_page_punishment', '_TermModal')}</p>
                                    <span>{$end_ban}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="punish_take_admin">{$this->Translate->get_translate_module_phrase('module_page_punishment', '_IssuedBy')} - <a href="/profiles/{$steam_admin}/?search=1" target="_blank">{$name_admin}</a></div>
                    </div>
                HTML;
            }
        }
        return $JSONResult;
    }

    public function PunishmentUnban($idpunish = null, $page, $type, $sid = null)
    {
        if (!empty($this->Db->db_data['AdminSystem'])) {
            if ($page == 'bans') {
                if ($type == 'buy') {
                    if (empty($_SESSION['steamid64'])) return ['status' => 'error', 'text' => 'Вы не авторизированны!'];
                    $usersearch = $this->Db->query('AdminSystem', 0, 0, "SELECT * FROM `as_punishments` WHERE `id` = :id AND `punish_type` = 0 AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) LIMIT 1", ['id' => $idpunish]);
                    $user = reset($usersearch);
                    if (empty($usersearch)) return ['status' => 'error', 'text' => 'Наказание не действительно!'];
                    if ($this->GetSettings()['price_unban'] > $this->GetBalance()) return ['status' => 'error', 'text' => 'У вас недостаточно средств!'];
                    $this->Db->query('AdminSystem', 0, 0, "UPDATE `as_punishments` SET `unpunish_admin_id` = 1 WHERE `id` = :id LIMIT 1", ['id' => $idpunish]);
                    $this->UpdateBalance($_SESSION['steamid32'], $this->GetSettings()['price_unban']);
                    $result = $this->Rcons("mm_as_reload_punish ".$user['steamid']);
                    if ($result == 'error') {
                        return ['status' => 'error', 'text' => 'Ошибка отправки RCON! Обратитесь к администратору сайта.'];
                    } else {
                        $this->Notifications->SendNotification($_SESSION['steamid'], '_punishment', '_UnBan', ['module_translation' => 'module_page_punishment'], '', 'punish', '_Go');
                        return ['status' => 'success', 'text' => 'Вы успешно приобрели услугу "Разбан"!'];
                    }
                } elseif ($type == 'admin') {
                    if (empty($_SESSION['steamid64'])) return ['status' => 'error', 'text' => 'Вы не авторизированны!'];
                    $usersearch = $this->Db->query('AdminSystem', 0, 0, "SELECT * FROM `as_punishments` WHERE `id` = :id AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) LIMIT 1", ['id' => $idpunish]);
                    $user = reset($usersearch);
                    if (empty($usersearch)) return ['status' => 'error', 'text' => 'Наказание не действительно!'];
                    $this->Db->query('AdminSystem', 0, 0, "UPDATE `as_punishments` SET `unpunish_admin_id` = 1 WHERE `id` = :id LIMIT 1", ['id' => $idpunish]);
                    $result = $this->Rcons("mm_as_reload_punish ".$user['steamid']);
                    if ($result == 'error') {
                        return ['status' => 'error', 'text' => 'Ошибка отправки RCON! Обратитесь к администратору сайта.'];
                    } else {
                        return ['status' => 'success', 'text' => 'Вы успешно разбанили игрока!'];
                    }
                }
            } elseif ($page == 'comms') {
                if ($type == 'buy') {
                    if (empty($_SESSION['steamid64'])) return ['status' => 'error', 'text' => 'Вы не авторизированны!'];
                    $usersearchmute = $this->Db->query('AdminSystem', 0, 0, "SELECT * FROM `as_punishments` WHERE `id` = :id AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) LIMIT 1", ['id' => $idpunish]);
                    $user = reset($usersearchmute);
                    if (empty($usersearchmute)) return ['status' => 'error', 'text' => 'Наказание не действительно!'];
                    if ($this->GetSettings()['price_unmute'] > $this->GetBalance()) return ['status' => 'error', 'text' => 'У вас недостаточно средств!'];
                    $this->Db->queryAll('AdminSystem', 0, 0, "UPDATE `as_punishments` SET `unpunish_admin_id` = 1 WHERE `id` = :id", ['id' => $idpunish]);
                    $this->UpdateBalance($_SESSION['steamid32'], $this->GetSettings()['price_unmute']);
                    $result = $this->Rcons("mm_as_reload_punish ".$user['steamid']);
                    if ($result == 'error') {
                        return ['status' => 'error', 'text' => 'Ошибка отправки RCON! Обратитесь к администратору сайта.'];
                    } else {
                        $this->Notifications->SendNotification($_SESSION['steamid'], '_punishment', '_UnMute', ['module_translation' => 'module_page_punishment'], '', 'punish', '_Go');
                        return ['status' => 'success', 'text' => 'Вы успешно приобрели услугу "Размут"!'];
                    }
                } elseif ($type == 'admin') {
                    if (empty($_SESSION['steamid64'])) return ['status' => 'error', 'text' => 'Вы не авторизированны!'];
                    $usersearchmute = $this->Db->query('AdminSystem', 0, 0, "SELECT * FROM `as_punishments` WHERE `id` = :id AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) LIMIT 1", ['id' => $idpunish]);
                    $user = reset($usersearchmute);
                    if (empty($usersearchmute)) return ['status' => 'error', 'text' => 'Наказание не действительно!'];
                    $this->Db->queryAll('AdminSystem', 0, 0, "UPDATE `as_punishments` SET `unpunish_admin_id` = 1 WHERE `id` = :id", ['id' => $idpunish]);
                    $result = $this->Rcons("mm_as_reload_punish ".$user['steamid']);
                    if ($result == 'error') {
                        return ['status' => 'error', 'text' => 'Ошибка отправки RCON! Обратитесь к администратору сайта.'];
                    } else {
                        return ['status' => 'success', 'text' => 'Вы успешно размутили игрока!'];
                    }
                }
            }
        }
    }
}
