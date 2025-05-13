<?php

namespace app\modules\module_page_managersystem\ext;

use app\modules\module_page_managersystem\ext\Core;

class Search extends Core
{
    protected $json_result = [];

    public function __construct($Db, $General, $Modules, $Translate, $Notifications, $Router)
    {
        $this->Db       = $Db;
        $this->General  = $General;
        $this->Modules  = $Modules;
        $this->Translate  = $Translate;
        $this->Notifications = $Notifications;
        $this->AdminCore = new AdminCore($Db, $General, $Translate, $Modules, $Notifications, $Router);
        $this->VipCore = new VipCore($Db, $General, $Translate, $Modules, $Notifications, $Router);
    }

    public function SearchPost($search_admin = "", $search_vip = "", $search_ban = "", $search_mute = "", $search_ar = "")
    {
        if (!empty($search_admin)) {
            $result = $this->Steam64_Search($search_admin);
            $params = ["result" => "%{$result}%"];
            if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
                switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                    case 'AdminSystem':
                        $search = $this->Db->queryAll('AdminSystem', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "SELECT 
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
                            `as_admins`.`id` = `as_admins_servers`.`admin_id`  WHERE `steamid` LIKE :result OR `name` LIKE :result
                        GROUP BY
                            `as_admins`.`id`, `as_admins_servers`.`group_id` LIMIT 20", $params);
                        break;
                    case 'IksAdmin':
                        $search = $this->Db->queryAll('IksAdmin', $this->AdminCore->ModDBFor()[0]['USER_ID'], $this->AdminCore->ModDBFor()[0]['DB_num'], "SELECT 
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
                        LEFT JOIN
                            `iks_groups`
                        ON
                            `iks_admins`.`group_id` = `iks_groups`.`id`
                        WHERE
                            `is_disabled` = 0 AND `iks_admins`.`steam_id` LIKE :result OR `iks_admins`.`name` LIKE :result
                        GROUP BY
                            `iks_admins`.`id`, `iks_admin_to_server`.`admin_id` LIMIT 20", $params);
                        break;
                    default;
                }
            }
        } elseif (!empty($search_vip)) {
            $result = $this->Steam3_Search($search_vip);
            $params = ["result" => "%{$result}%"];
            if (!empty($this->Db->db_data['Vips'])) {
                $search = $this->Db->queryAll('Vips', $this->VipCore->ModDBForVip()[$this->VipCore->ServerGroupVip()]['USER_ID'], $this->VipCore->ModDBForVip()[$this->VipCore->ServerGroupVip()]['DB_num'], "SELECT * FROM `" . $this->VipCore->ModDBForVip()[$this->VipCore->ServerGroupVip()]['Table'] . "users` WHERE `account_id` LIKE :result OR `name` LIKE :result LIMIT 20", $params);
            }
        } elseif (!empty($search_ban)) {
            $result = $this->Steam64_Search($search_ban);
            $params = ["result" => "%{$result}%"];
            if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
                switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                    case 'AdminSystem':
                        $search = $this->Db->queryAll('AdminSystem', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "SELECT *, 
                            (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, 
                            (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` 
                        FROM `" . $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['Table'] . "punishments` 
                            WHERE `punish_type` = 0 AND `steamid` LIKE :result OR `name` LIKE :result 
                        order by `created` desc LIMIT 20", $params);
                        break;
                    case 'IksAdmin':
                        $search = $this->Db->queryAll('IksAdmin', $this->AdminCore->ModDBFor()[0]['USER_ID'], $this->AdminCore->ModDBFor()[0]['DB_num'], "SELECT *, 
                            (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, 
                            (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` 
                        FROM `iks_bans` 
                        WHERE `steam_id` LIKE :result 
                            OR `name` LIKE :result 
                            OR (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) LIKE :result
                            OR (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) LIKE :result
                            OR `ip` LIKE :result 
                        ORDER BY `created_at` DESC LIMIT 20", $params);
                        break;
                    default;
                }
            }
        } elseif (!empty($search_mute)) {
            $result = $this->Steam64_Search($search_mute);
            $params = ["result" => "%{$result}%"];
            if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
                switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                    case 'AdminSystem':
                        $search = $this->Db->queryAll('AdminSystem', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "SELECT *, 
                            (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, 
                            (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` 
                        FROM `" . $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['Table'] . "punishments` 
                            WHERE `punish_type` != 0 AND `steamid` LIKE :result OR `name` LIKE :result 
                        order by `created` desc LIMIT 20", $params);
                        break;
                    case 'IksAdmin':
                        $search = $this->Db->queryAll('IksAdmin', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "SELECT *, 
                            (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, 
                            (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` 
                        FROM `iks_comms` 
                        WHERE `steam_id` LIKE :result 
                            OR `name` LIKE :result 
                            OR (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) LIKE :result
                            OR (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) LIKE :result
                            OR `ip` LIKE :result 
                        ORDER BY `created_at` DESC LIMIT 20", $params);
                        break;
                    default;
                }
            }
        } elseif (!empty($search_ar)) {
            $result = $this->get_steam_32_short($this->Steam32_Search($search_ar));
            $params = ["result" => "%{$result}%"];
            if (!empty($this->Db->db_data['AdminReward'])) {
                if (empty($_GET['start_date']) && empty($_GET['end_date'])) {
                    $start_date = null;
                    $end_date = date('Y-m-d');
                } else {
                    $start_date = $_GET['start_date'];
                    $end_date = $_GET['end_date'];
                }
                $ARAdminInfo = $this->Db->queryAll('AdminReward', $this->Db->db_data['AdminReward'][0]['USER_ID'], $this->Db->db_data['AdminReward'][0]['DB_num'], "SELECT `id`, `steamid`, SUM(`time`) AS total_time, MAX(`date`) AS newest_date FROM `" . $this->Db->db_data['AdminReward'][0]['Table'] . "info` WHERE `date` BETWEEN '{$start_date}' AND '{$end_date}' AND `steamid` LIKE :result GROUP BY `steamid` ORDER BY `total_time` DESC", $params);

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
                $search = array_values(array_slice($ARAdminInfoTime, 0, 20));
            }
        }

        if ($search) {
            if (!empty($search_admin)) {
                if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
                    switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                        case 'AdminSystem':
                            foreach ($search as $key => $row) {
                                $immun_admin = ($row['immunity'] == 0) ? $row['immunity'] : '';
                                if ($row['immunity'] == 0 || $row['immunity'] == -1) {
                                    foreach ($this->AdminCore->Groups() as $group) {
                                        if ($row['group_id'] == $group['id']) {
                                            $immun_admin = $group['immunity'];
                                            break;
                                        }
                                    }
                                }
                                $group_admin = '';
                                $groupFound = false;
                                foreach ($this->AdminCore->Groups() as $group) {
                                    if ($row['group_id'] == 0) {
                                        $group_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                        $groupFound = true;
                                        break;
                                    } else {
                                        if ($row['group_id'] == $group['id']) {
                                            $group_admin = action_text_clear($group['name']);
                                            $groupFound = true;
                                            break;
                                        }
                                    }
                                }
                                if (!$groupFound) {
                                    $group_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                }
                                $steam_admin = $row['steamid'];
                                $group_id = $row['group_id'];
                                $name_admin = empty($this->General->checkName($row['steamid'])) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($row['steamid']));
                                $end_admin = (empty($row['end'])) ? $this->Translate->get_translate_phrase('_Forever') : (($row['end'] < time()) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet') : $this->action_time_exchange_exact($row['end'] - time()));
                                $server_admin = ($row['server_id'] == '-1') ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $row['server_id'];
                                $id_admin = $row['id'];
                                $WarnCount = ceil($this->Db->queryNum('Core', 0, 0, "SELECT COUNT(*) FROM `lvl_web_managersystem_warn` WHERE `steamid` = " . $steam_admin . " AND `time` > UNIX_TIMESTAMP()")[0]);
                                $edit_admin = $this->set_url_section_new(get_url(2), ['ms_admin_edit' => $id_admin, 'group_id' => $group_id]);
                                $server_id = $this->AdminCore->GetServerId();
                                if (empty($row['flags'])) {
                                    foreach ($this->AdminCore->Groups() as $group) {
                                        if ($row['group_id'] == $group['id']) {
                                            $flasg_del = $group['flags'];
                                        }
                                    }
                                } else {
                                    $flasg_del = $row['flags'];
                                };
                                if ($this->GetCache('settings')['restriction_flag_z'] == 0 || (in_array('z', str_split($flasg_del)) == false || $_SESSION['user_admin'])) {
                                    $edit_del_admin = <<<HTML
                                        <a class="btn_req" href="{$edit_admin}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSRedAdmn')}" data-tippy-placement="top">
                                            <svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </a>
                                        <button class="btn_del" id="ms_admin_del" id_del="{$id_admin}" id_group="{$group_id}" id_server="{$server_id}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelAdm')}" data-tippy-placement="top">
                                            <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                        </button>
                                    HTML;
                                } else {
                                    $edit_del_admin = '';
                                }
                                $this->json_result["result"][$key]["search_html"] = <<<HTML
                                    <div class="user_card_bg">
                                        <div class="user_flex_av_nn">
                                            <a href="/profiles/{$steam_admin}/?search=1"><img class="avatar_img" id="{$steam_admin}" src="{$this->General->getAvatar($steam_admin, 1)}" title="" alt=""></a>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff')}"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_admin}/?search=1">{$name_admin}</a>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path></svg></div>
                                                <span class="info_span">{$steam_admin}</span>
                                            </div>
                                            <div class="info_deff_comm">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup1')}"><svg viewBox="0 0 576 512"><path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"></path></svg></div>
                                                <span class="info_span">{$group_admin}</span>
                                            </div>
                                            {$edit_del_admin}
                                        </div>
                                        <div class="user_flex_av_nn">
                                            <div class="info_access_admin">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlags')}"><svg viewBox="0 0 448 512"><path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"></path></svg></div>
                                                <span class="info_span">{$flasg_del}</span>
                                            </div>
                                            <div class="info_access_time">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                                <span class="info_span">{$end_admin}</span>
                                            </div>
                                            <div class="info_access">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSImmunitet')}"><svg viewBox="0 0 512 512"><path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z"/></svg></div>
                                                <span class="info_span">{$immun_admin}</span>
                                            </div>
                                            <div class="info_access_warn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPred')}"><svg viewBox="0 0 512 512"><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg></div>
                                                <span class="info_a">{$WarnCount}/{$this->GetCache('settings')['count_warn']}</span>
                                            </div>
                                            <div class="info_access_type">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput')} {$server_admin}"><svg viewBox="0 0 512 512"><path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path></svg></div>
                                            </div>
                                        </div>
                                    </div>
                                HTML;
                            }
                            break;
                        case 'IksAdmin':
                            foreach ($search as $key => $row) {
                                $immun_admin = ($row['immunity'] == -1 || empty($row['immunity'])) ? $row['immunity'] : '';
                                if ($row['immunity'] == -1 || empty($row['immunity'])) {
                                    foreach ($this->AdminCore->Groups() as $group) {
                                        if ($row['group_id'] == $group['id']) {
                                            $immun_admin = $group['immunity'];
                                            break;
                                        }
                                    }
                                }
                                $group_admin = '';
                                $groupFound = false;
                                foreach ($this->AdminCore->Groups() as $group) {
                                    if ($row['group_id'] == -1 || empty($row['group_id'])) {
                                        $group_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                        $groupFound = true;
                                        break;
                                    } else {
                                        if ($row['group_id'] == $group['id']) {
                                            $group_admin = action_text_clear($group['name']);
                                            $groupFound = true;
                                            break;
                                        }
                                    }
                                }
                                if (!$groupFound) {
                                    $group_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                }
                                $steam_admin = $row['steamid'];
                                $name_admin = empty($this->General->checkName($row['steamid'])) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($row['steamid']));
                                $end_admin = (empty($row['end_at'])) ? $this->Translate->get_translate_phrase('_Forever') : (($row['end_at'] < time()) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet') : $this->action_time_exchange_exact($row['end_at'] - time()));
                                $server_admin = (empty($row['server_id'])) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') : $row['server_id'];
                                $id_admin = $row['id'];
                                $WarnCount = ceil($this->Db->queryNum('Core', 0, 0, "SELECT COUNT(*) FROM `lvl_web_managersystem_warn` WHERE `steamid` = " . $steam_admin . " AND `time` > UNIX_TIMESTAMP()")[0]);
                                $edit_admin = set_url_section(get_url(2), 'ms_admin_edit', $id_admin);
                                if (empty($row['flags'])) {
                                    foreach ($this->AdminCore->Groups() as $group) {
                                        if ($row['group_id'] == $group['id']) {
                                            $flasg_del = $group['flags'];
                                        }
                                    }
                                } else {
                                    $flasg_del = $row['flags'];
                                };
                                if ($this->GetCache('settings')['restriction_flag_z'] == 0 || (in_array('z', str_split($flasg_del)) == false || $_SESSION['user_admin'])) {
                                    $edit_del_admin = <<<HTML
                                        <a class="btn_req" href="{$edit_admin}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSRedAdmn')}" data-tippy-placement="top">
                                            <svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </a>
                                        <button class="btn_del" id="ms_admin_del" id_del="{$steam_admin}" id_end="{$id_admin}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelAdm')}" data-tippy-placement="top">
                                            <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                        </button>
                                    HTML;
                                } else {
                                    $edit_del_admin = '';
                                }
                                $this->json_result["result"][$key]["search_html"] = <<<HTML
                                    <div class="user_card_bg">
                                        <div class="user_flex_av_nn">
                                            <a href="/profiles/{$steam_admin}/?search=1"><img class="avatar_img" id="{$steam_admin}" src="{$this->General->getAvatar($steam_admin, 1)}" title="" alt=""></a>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff')}"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_admin}/?search=1">{$name_admin}</a>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path></svg></div>
                                                <span class="info_span">{$steam_admin}</span>
                                            </div>
                                            <div class="info_deff_comm">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup1')}"><svg viewBox="0 0 576 512"><path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"></path></svg></div>
                                                <span class="info_span">{$group_admin}</span>
                                            </div>
                                            {$edit_del_admin}
                                        </div>
                                        <div class="user_flex_av_nn">
                                            <div class="info_access_admin">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlags')}"><svg viewBox="0 0 448 512"><path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"></path></svg></div>
                                                <span class="info_span">{$flasg_del}</span>
                                            </div>
                                            <div class="info_access_time">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                                <span class="info_span">{$end_admin}</span>
                                            </div>
                                            <div class="info_access">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSImmunitet')}"><svg viewBox="0 0 512 512"><path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z"/></svg></div>
                                                <span class="info_span">{$immun_admin}</span>
                                            </div>
                                            <div class="info_access_warn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPred')}"><svg viewBox="0 0 512 512"><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg></div>
                                                <span class="info_a">{$WarnCount}/{$this->GetCache('settings')['count_warn']}</span>
                                            </div>
                                            <div class="info_access_type">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput')} {$server_admin}"><svg viewBox="0 0 512 512"><path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path></svg></div>
                                            </div>
                                        </div>
                                    </div>
                                HTML;
                            }
                            break;
                        default;
                    }
                }
            } elseif (!empty($search_vip)) {
                if (!empty($this->Db->db_data['Vips'])) {
                    foreach ($search as $key => $row) {
                        $steam_vip = $row['account_id'];
                        $steam_vip64 = con_steam3to64_int($row['account_id']);
                        $name_vip = empty($this->General->checkName($steam_vip)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_vip));
                        $sid_vip = $row['sid'];
                        $edit_vip = set_url_section(get_url(2), 'ms_vip_edit', $steam_vip) . '&sid=' . $sid_vip;
                        $group_vip = action_text_clear($row['group']);
                        $end_vip = (empty($row['expires'])) ? $this->Translate->get_translate_phrase('_Forever') : (($row['expires'] < time()) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet') : $this->action_time_exchange_exact($row['expires'] - time()));
                        $this->json_result["result"][$key]["search_html"] = <<<HTML
                            <div class="user_card_bg">
                                <div class="user_flex_av_nn">
                                    <a href="/profiles/{$steam_vip64}/?search=1"><img class="avatar_img" id="{$steam_vip64}" src="{$this->General->getAvatar(con_steam3to64_int($steam_vip64), 1)}" title="" alt=""></a>
                                    <div class="info_nn_vip">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff')}"><svg viewBox="0 0 576 512"><path d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"></path></svg></div>
                                        <a class="info_a" href="/profiles/{$steam_vip64}/?search=1">{$name_vip}</a>
                                    </div>
                                    <a class="btn_req" href="{$edit_vip}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSREdVip')}" data-tippy-placement="top">
                                        <svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                    </a>
                                    <button class="btn_del" id="ms_vip_del" id_del="{$steam_vip}" id_end="{$sid_vip}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDElVip')}" data-tippy-placement="top">
                                        <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                    </button>
                                </div>
                                <div class="user_flex_av_nn">
                                    <div class="info_nn_vip">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGRoup')}"><svg viewBox="0 0 576 512"><path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"></path></svg></div>
                                        <span class="info_span">{$group_vip}</span>
                                    </div>
                                    <div class="info_nn_vip">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ')}"><svg viewBox="0 0 512 512"><path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path></svg></div>
                                        <span class="info_span">{$sid_vip}</span>
                                    </div>
                                    <div class="info_nn_vip">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                        <span class="info_span">{$end_vip}</span>
                                    </div>
                                </div>
                            </div>
                        HTML;
                    }
                }
            } elseif (!empty($search_ban)) {
                if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
                    switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                        case 'AdminSystem':
                            foreach ($search as $key => $row) {
                                $steam_player = $row['steamid'];
                                $steam_admin = $row['admin_steamid'];
                                $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
                                if (!empty($steam_admin)) {
                                    $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
                                } else {
                                    $name_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSConsol');
                                }
                                if (!empty($row['unpunish_admin_id'])) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnban2');
                                } elseif ($row['expires'] == 0 && empty($row['unpunish_admin_id'])) {
                                    $end_ban = $this->Translate->get_translate_phrase('_Forever');
                                } elseif (time() > $row['expires']) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                } else {
                                    $end_ban = $this->action_time_exchange_exact($row['expires'] - time());
                                }
                                $reason_ban = action_text_clear($row['reason']);
                                $end_ban_time = date('d.m.Y в H:i', $row['created']);
                                $id_player = $row['id'];
                                $this->json_result["result"][$key]["search_html"] = <<<HTML
                                    <div class="user_card_bg">
                                        <div class="user_flex_av_nn">
                                            <a href="/profiles/{$steam_player}/?search=1"><img class="avatar_img" id="{$steam_player}" src="{$this->General->getAvatar($steam_player, 1)}" title="" alt=""></a>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNarush')}"><svg viewBox="0 0 512 512"><path d="M352 493.4c-29.6 12-62.1 18.6-96 18.6s-66.4-6.6-96-18.6V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V477.8C51.5 433.5 0 350.8 0 256C0 114.6 114.6 0 256 0S512 114.6 512 256c0 94.8-51.5 177.5-128 221.8V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V493.4zM195.2 233.6c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2c17.6-23.5 52.8-23.5 70.4 0zm121.6 0c17.6-23.5 52.8-23.5 70.4 0c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2zM208 336v32c0 26.5 21.5 48 48 48s48-21.5 48-48V336c0-26.5-21.5-48-48-48s-48 21.5-48 48z"/></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_player}/?search=1">{$name_player}</a>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path></svg></div>
                                                <span class="info_span">{$steam_player}</span>
                                            </div>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')}"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_admin}/?search=1">{$name_admin}</a>
                                            </div>
                                            <button class="btn_req" id="ms_ban_unban" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnBan1')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z"/></svg>
                                            </button>
                                            <button class="btn_del" id="ms_ban_del" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelBan')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                            </button>
                                        </div>
                                        <div class="user_flex_av_nn">
                                            <div class="info_deff_reason">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd')}"><svg viewBox="0 0 512 512"><path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path></svg></div>
                                                <span class="info_span">{$reason_ban}</span>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                                <span class="info_span">{$end_ban}</span>
                                            </div>
                                            <div class="info_deff_time">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddNaruh')}"><svg viewBox="0 0 448 512"><path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z"/></svg></div>
                                                <span class="info_span">{$end_ban_time}</span>
                                            </div>
                                        </div>
                                    </div>
                                HTML;
                            }
                            break;
                        case 'IksAdmin':
                            foreach ($search as $key => $row) {
                                $steam_player = $row['steam_id'];
                                $steam_admin = $row['admin_steamid'];
                                $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
                                if (!empty($steam_admin) || $steam_admin != 'CONSOLE') {
                                    $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
                                } else {
                                    $name_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSConsol');
                                }
                                if (!empty($row['unbanned_by'])) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnban2');
                                } elseif ($row['end_at'] == 0 && empty($row['unbanned_by'])) {
                                    $end_ban = $this->Translate->get_translate_phrase('_Forever');
                                } elseif (time() > $row['end_at']) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                } else {
                                    $end_ban = $this->action_time_exchange_exact($row['end_at'] - time());
                                }
                                $reason_ban = action_text_clear($row['reason']);
                                $end_ban_time = date('d.m.Y в H:i', $row['created_at']);
                                $id_player = $row['id'];
                                $this->json_result["result"][$key]["search_html"] = <<<HTML
                                    <div class="user_card_bg">
                                        <div class="user_flex_av_nn">
                                            <a href="/profiles/{$steam_player}/?search=1"><img class="avatar_img" id="{$steam_player}" src="{$this->General->getAvatar($steam_player, 1)}" title="" alt=""></a>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNarush')}"><svg viewBox="0 0 512 512"><path d="M352 493.4c-29.6 12-62.1 18.6-96 18.6s-66.4-6.6-96-18.6V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V477.8C51.5 433.5 0 350.8 0 256C0 114.6 114.6 0 256 0S512 114.6 512 256c0 94.8-51.5 177.5-128 221.8V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V493.4zM195.2 233.6c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2c17.6-23.5 52.8-23.5 70.4 0zm121.6 0c17.6-23.5 52.8-23.5 70.4 0c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2zM208 336v32c0 26.5 21.5 48 48 48s48-21.5 48-48V336c0-26.5-21.5-48-48-48s-48 21.5-48 48z"/></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_player}/?search=1">{$name_player}</a>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path></svg></div>
                                                <span class="info_span">{$steam_player}</span>
                                            </div>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')}"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_admin}/?search=1">{$name_admin}</a>
                                            </div>
                                            <button class="btn_req" id="ms_ban_unban" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnBan1')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z"/></svg>
                                            </button>
                                            <button class="btn_del" id="ms_ban_del" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelBan')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                            </button>
                                        </div>
                                        <div class="user_flex_av_nn">
                                            <div class="info_deff_reason">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd')}"><svg viewBox="0 0 512 512"><path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path></svg></div>
                                                <span class="info_span">{$reason_ban}</span>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                                <span class="info_span">{$end_ban}</span>
                                            </div>
                                            <div class="info_deff_time">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddNaruh')}"><svg viewBox="0 0 448 512"><path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z"/></svg></div>
                                                <span class="info_span">{$end_ban_time}</span>
                                            </div>
                                        </div>
                                    </div>
                                HTML;
                            }
                            break;
                        default;
                    }
                }
            } elseif (!empty($search_mute)) {
                if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
                    switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                        case 'AdminSystem':
                            foreach ($search as $key => $row) {
                                $steam_player = $row['steamid'];
                                $steam_admin = $row['admin_steamid'];
                                $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
                                if (!empty($steam_admin)) {
                                    $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
                                } else {
                                    $name_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSConsol');
                                }
                                if (!empty($row['unpunish_admin_id'])) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnban2');
                                } elseif ($row['expires'] == 0 && empty($row['unpunish_admin_id'])) {
                                    $end_ban = $this->Translate->get_translate_phrase('_Forever');
                                } elseif (time() > $row['expires']) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                } else {
                                    $end_ban = $this->action_time_exchange_exact($row['expires'] - time());
                                }
                                $reason_ban = action_text_clear($row['reason']);
                                $end_ban_time = date('d.m.Y в H:i', $row['created']);
                                $id_player = $row['id'];
                                if ($row['punish_type'] == 3) {
                                    $punishmentType = '<svg viewBox="0 0 512 512"><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256z"></path></svg>';
                                    $punishmentType_tippy = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicroChat');
                                } elseif ($row['punish_type'] == 2) {
                                    $punishmentType = '<svg viewBox="0 0 640 512"><path d="M64.03 239.1c0 49.59 21.38 94.1 56.97 130.7c-12.5 50.39-54.31 95.3-54.81 95.8c-2.187 2.297-2.781 5.703-1.5 8.703c1.312 3 4.125 4.797 7.312 4.797c66.31 0 116-31.8 140.6-51.41c32.72 12.31 69.02 19.41 107.4 19.41c37.39 0 72.78-6.663 104.8-18.36L82.93 161.7C70.81 185.9 64.03 212.3 64.03 239.1zM630.8 469.1l-118.1-92.59C551.1 340 576 292.4 576 240c0-114.9-114.6-207.1-255.1-207.1c-67.74 0-129.1 21.55-174.9 56.47L38.81 5.117C28.21-3.154 13.16-1.096 5.115 9.19C-3.072 19.63-1.249 34.72 9.188 42.89l591.1 463.1c10.5 8.203 25.57 6.333 33.7-4.073C643.1 492.4 641.2 477.3 630.8 469.1z"></path></svg>';
                                    $punishmentType_tippy = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat');
                                } elseif ($row['punish_type'] == 1) {
                                    $punishmentType = '<svg viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zM344 430.4c20.4-2.8 39.7-9.1 57.3-18.2l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4z"></path></svg>';
                                    $punishmentType_tippy = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro');
                                }

                                $this->json_result["result"][$key]["search_html"] = <<<HTML
                                    <div class="user_card_bg">
                                        <div class="user_flex_av_nn">
                                            <a href="/profiles/{$steam_player}/?search=1"><img class="avatar_img" id="{$steam_player}" src="{$this->General->getAvatar($steam_player, 1)}" title="" alt=""></a>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNarush')}"><svg viewBox="0 0 512 512"><path d="M352 493.4c-29.6 12-62.1 18.6-96 18.6s-66.4-6.6-96-18.6V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V477.8C51.5 433.5 0 350.8 0 256C0 114.6 114.6 0 256 0S512 114.6 512 256c0 94.8-51.5 177.5-128 221.8V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V493.4zM195.2 233.6c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2c17.6-23.5 52.8-23.5 70.4 0zm121.6 0c17.6-23.5 52.8-23.5 70.4 0c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2zM208 336v32c0 26.5 21.5 48 48 48s48-21.5 48-48V336c0-26.5-21.5-48-48-48s-48 21.5-48 48z"/></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_player}/?search=1">{$name_player}</a>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path></svg></div>
                                                <span class="info_span">{$steam_player}</span>
                                            </div>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')}"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_admin}/?search=1">{$name_admin}</a>
                                            </div>
                                            <button class="btn_req" id="ms_mute_unban" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnMute2')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z"/></svg>
                                            </button>
                                            <button class="btn_del" id="ms_mute_del" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelMute')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                            </button>
                                        </div>
                                        <div class="user_flex_av_nn">
                                            <div class="info_deff_reason">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd')}"><svg viewBox="0 0 512 512"><path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path></svg></div>
                                                <span class="info_span">{$reason_ban}</span>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                                <span class="info_span">{$end_ban}</span>
                                            </div>
                                            <div class="info_deff_reason">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddNaruh')}"><svg viewBox="0 0 448 512"><path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z"/></svg></div>
                                                <span class="info_span">{$end_ban_time}</span>
                                            </div>
                                            <div class="info_access_type">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$punishmentType_tippy}">{$punishmentType}</div>
                                            </div>
                                        </div>
                                    </div>
                                HTML;
                            }
                            break;
                        case 'IksAdmin':
                            foreach ($search as $key => $row) {
                                $steam_player = $row['steam_id'];
                                $steam_admin = $row['admin_steamid'];
                                $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
                                if (!empty($steam_admin) || $steam_admin != 'CONSOLE') {
                                    $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
                                } else {
                                    $name_admin = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSConsol');
                                }
                                if (!empty($row['unbanned_by'])) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnban2');
                                } elseif ($row['end_at'] == 0 && empty($row['unbanned_by'])) {
                                    $end_ban = $this->Translate->get_translate_phrase('_Forever');
                                } elseif (time() > $row['end_at']) {
                                    $end_ban = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                } else {
                                    $end_ban = $this->action_time_exchange_exact($row['end_at'] - time());
                                }
                                $reason_ban = action_text_clear($row['reason']);
                                $end_ban_time = date('d.m.Y в H:i', $row['created_at']);
                                $id_player = $row['id'];
                                if ($row['int(11)'] == 2) {
                                    $punishmentType = '<svg viewBox="0 0 512 512"><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256z"></path></svg>';
                                    $punishmentType_tippy = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicroChat');
                                } elseif ($row['int(11)'] == 1) {
                                    $punishmentType = '<svg viewBox="0 0 640 512"><path d="M64.03 239.1c0 49.59 21.38 94.1 56.97 130.7c-12.5 50.39-54.31 95.3-54.81 95.8c-2.187 2.297-2.781 5.703-1.5 8.703c1.312 3 4.125 4.797 7.312 4.797c66.31 0 116-31.8 140.6-51.41c32.72 12.31 69.02 19.41 107.4 19.41c37.39 0 72.78-6.663 104.8-18.36L82.93 161.7C70.81 185.9 64.03 212.3 64.03 239.1zM630.8 469.1l-118.1-92.59C551.1 340 576 292.4 576 240c0-114.9-114.6-207.1-255.1-207.1c-67.74 0-129.1 21.55-174.9 56.47L38.81 5.117C28.21-3.154 13.16-1.096 5.115 9.19C-3.072 19.63-1.249 34.72 9.188 42.89l591.1 463.1c10.5 8.203 25.57 6.333 33.7-4.073C643.1 492.4 641.2 477.3 630.8 469.1z"></path></svg>';
                                    $punishmentType_tippy = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat');
                                } elseif ($row['int(11)'] == 0) {
                                    $punishmentType = '<svg viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zM344 430.4c20.4-2.8 39.7-9.1 57.3-18.2l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4z"></path></svg>';
                                    $punishmentType_tippy = $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro');
                                }

                                $this->json_result["result"][$key]["search_html"] = <<<HTML
                                    <div class="user_card_bg">
                                        <div class="user_flex_av_nn">
                                            <a href="/profiles/{$steam_player}/?search=1"><img class="avatar_img" id="{$steam_player}" src="{$this->General->getAvatar($steam_player, 1)}" title="" alt=""></a>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNarush')}"><svg viewBox="0 0 512 512"><path d="M352 493.4c-29.6 12-62.1 18.6-96 18.6s-66.4-6.6-96-18.6V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V477.8C51.5 433.5 0 350.8 0 256C0 114.6 114.6 0 256 0S512 114.6 512 256c0 94.8-51.5 177.5-128 221.8V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V493.4zM195.2 233.6c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2c17.6-23.5 52.8-23.5 70.4 0zm121.6 0c17.6-23.5 52.8-23.5 70.4 0c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2zM208 336v32c0 26.5 21.5 48 48 48s48-21.5 48-48V336c0-26.5-21.5-48-48-48s-48 21.5-48 48z"/></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_player}/?search=1">{$name_player}</a>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path></svg></div>
                                                <span class="info_span">{$steam_player}</span>
                                            </div>
                                            <div class="info_nn">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')}"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                                <a class="info_a" href="/profiles/{$steam_admin}/?search=1">{$name_admin}</a>
                                            </div>
                                            <button class="btn_req" id="ms_mute_unban" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnMute2')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z"/></svg>
                                            </button>
                                            <button class="btn_del" id="ms_mute_del" id_del="{$steam_player}" id_end="{$id_player}" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelMute')}" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                            </button>
                                        </div>
                                        <div class="user_flex_av_nn">
                                            <div class="info_deff_reason">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd')}"><svg viewBox="0 0 512 512"><path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path></svg></div>
                                                <span class="info_span">{$reason_ban}</span>
                                            </div>
                                            <div class="info_deff">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                                <span class="info_span">{$end_ban}</span>
                                            </div>
                                            <div class="info_deff_reason">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddNaruh')}"><svg viewBox="0 0 448 512"><path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z"/></svg></div>
                                                <span class="info_span">{$end_ban_time}</span>
                                            </div>
                                            <div class="info_access_type">
                                                <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$punishmentType_tippy}">{$punishmentType}</div>
                                            </div>
                                        </div>
                                    </div>
                                HTML;
                            }
                            break;
                        default;
                    }
                }
            } elseif (!empty($search_ar)) {
                if (!empty($this->Db->db_data['AdminReward'])) {
                    foreach ($search as $key => $row) {
                        $steam_ar = $row['steamid'];
                        $name_ar = empty($this->General->checkName(con_steam32to64($steam_ar))) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : action_text_clear($this->General->checkName(con_steam32to64($steam_ar)));
                        $time_ar = $this->action_time_exchange_exact($row['total_time']);
                        $time_ar_time = date('d.m.Y', $row['newest_date']);
                        $this->json_result["result"][$key]["search_html"] = <<<HTML
                            <div class="user_card_bg">
                                <div class="user_flex_av_nn">
                                    <a href="/profiles/{con_steam32to64($steam_ar)}/?search=1"><img class="avatar_img" id="{con_steam32to64($steam_ar)}" src="{$this->General->getAvatar(con_steam32to64($steam_ar), 1)}" title="" alt=""></a>
                                    <div class="info_nn_vip">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff')}"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                        <a class="info_a" href="/profiles/{con_steam32to64($steam_ar)}/?search=1">{$name_ar}</a>
                                    </div>
                                </div>
                                <div class="user_flex_av_nn">
                                    <div class="info_nn_vip">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGRoup')}"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                        <span class="info_span">{$time_ar}</span>
                                    </div>
                                    <div class="info_deff">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ')}"><svg viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg></div>
                                        <span class="info_span">{$time_ar_time}</span>
                                    </div>
                                </div>
                            </div>
                        HTML;
                    }
                }
            }
        }
    }

    public function returnJSON()
    {
        return json_encode($this->json_result);
    }
}
