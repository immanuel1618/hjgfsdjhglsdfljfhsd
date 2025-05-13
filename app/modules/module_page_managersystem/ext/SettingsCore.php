<?php

/**
 * @author -r8 (@r8.dev)
 **/

namespace app\modules\module_page_managersystem\ext;

use app\modules\module_page_managersystem\ext\Core;

class SettingsCore extends Core
{
    protected $Db, $General, $Translate, $Modules, $Notifications;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications, $Router)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
        $this->Router = $Router;
        $this->AdminCore = new AdminCore($Db, $General, $Translate, $Modules, $Notifications, $Router);
    }

    public function Create_Table()
    {
        if ($this->TableSearch()) {
            $addtable = array(
                "CREATE TABLE `lvl_web_managersystem_groups_admin` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `name_group` VARCHAR(255) NOT NULL,
                    `flags` VARCHAR(26) NOT NULL,
                    `immunity` INT NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

                "CREATE TABLE `lvl_web_managersystem_access` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `steamid_access` BIGINT(17) NOT NULL,
                    `add_admin_access` INT(1) NOT NULL,
                    `add_ban_access` INT(1) NOT NULL,
                    `add_mute_access` INT(1) NOT NULL,
                    `add_vip_access` INT(1) NOT NULL,
                    `add_warn_access` INT(1) NOT NULL,
                    `add_timecheck_access` INT(1) NOT NULL,
                    `add_access` INT(1) NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

                // "CREATE TABLE `lvl_web_managersystem_group_unification` (
                //     `id` INT NOT NULL AUTO_INCREMENT,
                //     `id_group_admin` INT NOT NULL,
                //     `id_group_vip` INT NOT NULL,
                //     PRIMARY KEY (`id`)
                // ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

                "CREATE TABLE `lvl_web_managersystem_warn` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `steamid` BIGINT(17) NOT NULL,
                    `reason` VARCHAR(255) NOT NULL,
                    `time` BIGINT NOT NULL,
                    `createtime` BIGINT NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            );
            foreach ($addtable as $sql) {
                $this->Db->query('Core', 0, 0, $sql);
            }
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTableGood')];
        }
        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTableError')];
    }

    public function Update_Settings_General($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/settings.php', 0777);
        $settings = $this->GetCache('settings');

        $settings['webhookurl'] = $POST['webhookurl'];
        $settings['blockdbapikey'] = $POST['blockdbapikey'];
        $settings['vip_one_table'] = $POST['vip_one_table'];
        $settings['restriction_flag_z'] = $POST['restriction_flag_z'];
        $settings['restriction_access'] = $POST['restriction_access'];
        if ($settings['group_choice_admin'] == 1) {
            $settings['dangerous_flags'] = '0';
        } else {
            $settings['dangerous_flags'] = $POST['dangerous_flags'];
        }
        $settings['add_punishment_all'] = $POST['add_punishment_all'];
        $settings['warn_auto_del'] = $POST['warn_auto_del'];
        $this->PutCache('settings', $settings);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSaveGood')];
    }


    public function Update_Settings_Additional($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/settings.php', 0777);
        $settings = $this->GetCache('settings');

        $settings['colorwebhook'] = empty($POST['colorwebhook']) ? '#ffaa50' : $POST['colorwebhook'];
        $settings['urlimgwebhook'] = empty($POST['urlimgwebhook']) ? 'https://i.ibb.co/MCB53yK/1.png' : $POST['urlimgwebhook'];
        $settings['group_choice_admin'] = $POST['group_choice_admin'];
        $settings['reason_ban'] = $POST['reason_ban'];
        $settings['reason_mute'] = $POST['reason_mute'];
        $settings['time_choice_punishment'] = $POST['time_choice_punishment'];
        $settings['time_choice_privileges'] = $POST['time_choice_privileges'];
        $settings['count_warn'] = $POST['count_warn'];
        if (!empty($this->Db->db_data['Vips'])) {
            $settings['group_test'] = $POST['group_test'];
            $settings['group_choice_vip'] = $POST['group_choice_vip'];
        } else {
            $settings['group_test'] = '';
            $settings['group_choice_vip'] = '0';
        }
        if ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'] == 'IksAdmin' && !empty($this->Db->db_data['Vips'])) {
            $settings['group_unification'] = $POST['group_unification'];
        } else {
            $settings['group_unification'] = '0';
        }

        $this->PutCache('settings', $settings);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSaveGood')];
    }

    public function Access_Add($POST)
    {
        $steam64 = $this->Steam64_ID($POST['steam_access']);
        if (!$steam64)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];
        if ($this->Db->query('Core', 0, 0, "SELECT * FROM `lvl_web_managersystem_access` WHERE `steamid_access` = :steamid_access;", ['steamid_access' => $steam64]))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamYes')];

        $AccessAdd = [
            "steam_access" => $steam64,
            "access" => $POST['access'],
            "access_admin" => $POST['access_admin'],
            "access_vip" => $POST['access_vip'] ?? '0',
            "access_ban" => $POST['access_ban'],
            "access_mute" => $POST['access_mute'],
            "access_warn" => $POST['access_warn'],
            "access_timecheck" => $POST['access_timecheck'] ?? '0',
        ];

        if (empty(array_filter($AccessAdd))) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
        } else {
            $this->Db->query('Core', 0, 0, "INSERT INTO `lvl_web_managersystem_access` (`steamid_access`, `add_admin_access`, `add_ban_access`, `add_mute_access`, `add_vip_access`, `add_warn_access`, `add_timecheck_access`, `add_access`) VALUES (:steam_access, :access_admin, :access_ban, :access_mute, :access_vip, :access_warn, :access_timecheck, :access);", $AccessAdd);
            $access = ($POST['access'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_admin = ($POST['access_admin'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_vip = ($POST['access_vip'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_ban = ($POST['access_ban'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_mute = ($POST['access_mute'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_warn = ($POST['access_warn'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_timecheck = ($POST['access_timecheck'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');

            $embed = [
                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAccessNew')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAccess')} {$access}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddAccessAdm')} {$access_admin}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddWarnAccess')} {$access_warn}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAccessTime')} {$access_timecheck}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddBanAccess')} {$access_ban}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddMuteAccess')} {$access_mute}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddVipAccess')} {$access_vip}",
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

            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessAdd')];
        }
    }

    public function Access_Edit($POST, $GET)
    {
        $steam64 = $this->Steam64_ID($POST['steam_access']);
        if (!$steam64)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamNo')];

        $AccessAdd = [
            "steam_access" => $steam64,
            "access" => $POST['access'],
            "access_admin" => $POST['access_admin'],
            "access_vip" => $POST['access_vip'] ?? '0',
            "access_ban" => $POST['access_ban'],
            "access_mute" => $POST['access_mute'],
            "access_warn" => $POST['access_warn'],
            "access_timecheck" => $POST['access_timecheck'] ?? '0',
        ];

        if (empty(array_filter($AccessAdd))) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
        } else {
            $this->Db->query('Core', 0, 0, "UPDATE `lvl_web_managersystem_access` SET `steamid_access` = :steam_access, `add_admin_access` = :access_admin, `add_ban_access` = :access_ban, `add_mute_access` = :access_mute, `add_vip_access` = :access_vip, `add_warn_access` = :access_warn, `add_timecheck_access` = :access_timecheck, `add_access` = :access WHERE `id` = :id", ['id' => $GET] + $AccessAdd);
            $access = ($POST['access'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_admin = ($POST['access_admin'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_vip = ($POST['access_vip'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_ban = ($POST['access_ban'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_mute = ($POST['access_mute'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_warn = ($POST['access_warn'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');
            $access_timecheck = ($POST['access_timecheck'] == 1) ? $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') : $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo');

            $embed = [
                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAccessEdit')} [{$this->General->checkName($steam64)}](http:" . $this->General->arr_general['site'] . "profiles/{$steam64}/?search=1){$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebEditAccess')} {$access}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddAccessAdm')} {$access_admin}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddWarnAccess')} {$access_warn}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAccessTime')} {$access_timecheck}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddBanAccess')} {$access_ban}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddMuteAccess')} {$access_mute}{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebAddVipAccess')} {$access_vip}",
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

            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccesEdit')];
        }
    }

    public function Access_Delete($POST)
    {
        if (empty(array_filter($POST))) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
        } else {
            $this->Db->query('Core', 0, 0, "DELETE FROM `lvl_web_managersystem_access` WHERE `steamid_access` = '{$POST['steamid_access']}' LIMIT 1");

            $embed = [
                "title" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin')} {$this->General->checkName($_SESSION['steamid64'])}",
                "description" => "{$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSWebDelccess')} [{$this->General->checkName($POST['steamid_access'])}](http:" . $this->General->arr_general['site'] . "profiles/{$POST['steamid_access']}/)",
                "url" => "http:" . $this->General->arr_general['site'] . "profiles/{$_SESSION['steamid64']}/?search=1",
                "color" => hexdec(preg_replace('/#/', '', $this->GetCache('settings')['colorwebhook'])),
                "image" => [
                    "url" => "" . $this->GetCache('settings')['urlimgwebhook'] . ""
                ],
                "thumbnail" => [
                    "url" => "" . $this->General->getAvatar($POST['steamid_access'], 1) . ""
                ]
            ];

            $this->DiscordWebhook($embed);

            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessDel')];
        }
    }

    public function Access_Info_Get($id)
    {
        return $this->Db->query('Core', 0, 0, "SELECT * FROM `lvl_web_managersystem_access` WHERE `id` = :id", ['id' => $id]);
    }

    public function Admin_Group_Add($POST)
    {
        if (empty($POST['name_group']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupNameNo')];
        if (empty($POST['immunity_group']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSImmNo')];
        if ($POST['immunity_group'] > 100 || $POST['immunity_group'] < 1)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSImm1001')];
        if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
            switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    $flags = array();
                    $flag_letters = range('a', 'z');
                    foreach ($flag_letters as $letter) {
                        $flags["flag_$letter"] = isset($POST["flag_$letter"]) ? $POST["flag_$letter"] : '';
                    }
                    $flags_implode = implode('', $flags);

                    $CreateGroup = [
                        "name_group" => $POST['name_group'],
                        "flags" => $flags_implode,
                        "immunity_group" => $POST['immunity_group'],
                    ];
                    if (empty(array_filter($CreateGroup))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('AdminSystem', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "INSERT INTO `" . $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['Table'] . "groups` (`flags`, `name`, `immunity`) VALUES (:flags, :name_group, :immunity_group);", $CreateGroup);
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupAdd')];
                    }
                case 'IksAdmin':
                    $flags = array();
                    $flag_letters = range('a', 'z');
                    foreach ($flag_letters as $letter) {
                        $flags["flag_$letter"] = isset($POST["flag_$letter"]) ? $POST["flag_$letter"] : '';
                    }
                    $flags_implode = implode('', $flags);

                    $CreateGroup = [
                        "name_group" => $POST['name_group'],
                        "flags" => $flags_implode,
                        "immunity_group" => $POST['immunity_group'],
                    ];
                    if (empty(array_filter($CreateGroup))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('IksAdmin', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "INSERT INTO `" . $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['Table'] . "groups` (`flags`, `name`, `immunity`) VALUES (:flags, :name_group, :immunity_group);", $CreateGroup);
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupAdd')];
                    }
                default;
            }
        }
    }

    public function Admin_Group_Del($POST)
    {
        if (!empty($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod'])) {
            switch ($this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['admin_mod']) {
                case 'AdminSystem':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('AdminSystem', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "DELETE FROM `" . $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['Table'] . "groups` WHERE `id` = '{$POST['id']}' LIMIT 1");
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupDel')];
                    }
                case 'IksAdmin':
                    if (empty(array_filter($POST))) {
                        return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoDataMass')];
                    } else {
                        $this->Db->query('IksAdmin', $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['USER_ID'], $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['DB_num'], "DELETE FROM `" . $this->AdminCore->ModDBFor()[$this->AdminCore->ServerGroup()]['Table'] . "groups` WHERE `id` = '{$POST['id']}' LIMIT 1");
                        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupDel')];
                    }
                default;
            }
        }
    }

    public function Vip_Group_Add($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/vipgroup.php', 0777);
        $Cache = $this->GetCache('vipgroup');

        if (empty($POST['name_group']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupNameNo')];

        if (empty($Cache)) {
            $CurrentId = 0;
        }
        foreach ($Cache as $key) {
            if ($key['id'] > $CurrentId) {
                $CurrentId = $key['id'];
            }
        }
        $GroupId = ++$CurrentId;

        $GroupMass = array(
            'name_group'  => $POST['name_group'],
            'id'          => $GroupId
        );
        $Cache[] = $GroupMass;

        $this->PutCache('vipgroup', $Cache);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupAdd')];
    }

    public function Vip_Group_Del($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/vipgroup.php', 0777);
        $Cache = $this->GetCache('vipgroup');

        $indexToDelete = null;
        foreach ($Cache as $index => $key) {
            if ($key['id'] == $POST['id']) {
                $indexToDelete = $index;
            }
        }

        if ($indexToDelete !== null) {
            unset($Cache[$indexToDelete]);
            $Cache = array_values($Cache);

            $this->PutCache('vipgroup', $Cache);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointDel')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointVipNo')];
        }
    }

    public function Reason_Ban_Add($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/reasonban.php', 0777);
        $Cache = $this->GetCache('reasonban');

        if (empty($POST['reason_name']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameReasonNo')];

        if (empty($Cache)) {
            $CurrentId = 0;
        }
        foreach ($Cache as $key) {
            if ($key['id'] > $CurrentId) {
                $CurrentId = $key['id'];
            }
        }
        $Id = ++$CurrentId;

        $Mass = array(
            'reason_name'  => $POST['reason_name'],
            'id'          => $Id
        );
        $Cache[] = $Mass;

        $this->PutCache('reasonban', $Cache);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonCreate')];
    }

    public function Reason_Ban_Del($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/reasonban.php', 0777);
        $Cache = $this->GetCache('reasonban');

        $indexToDelete = null;
        foreach ($Cache as $index => $key) {
            if ($key['id'] == $POST['id']) {
                $indexToDelete = $index;
            }
        }

        if ($indexToDelete !== null) {
            unset($Cache[$indexToDelete]);
            $Cache = array_values($Cache);

            $this->PutCache('reasonban', $Cache);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonDel')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointResNo')];
        }
    }

    public function Reason_Mute_Add($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/reasonmute.php', 0777);
        $Cache = $this->GetCache('reasonmute');

        if (empty($POST['reason_name']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameReasonNo')];

        if (empty($Cache)) {
            $CurrentId = 0;
        }
        foreach ($Cache as $key) {
            if ($key['id'] > $CurrentId) {
                $CurrentId = $key['id'];
            }
        }
        $Id = ++$CurrentId;

        $Mass = array(
            'reason_name'  => $POST['reason_name'],
            'id'          => $Id
        );
        $Cache[] = $Mass;

        $this->PutCache('reasonmute', $Cache);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonCreate')];
    }

    public function Reason_Mute_Del($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/reasonmute.php', 0777);
        $Cache = $this->GetCache('reasonmute');

        $indexToDelete = null;
        foreach ($Cache as $index => $key) {
            if ($key['id'] == $POST['id']) {
                $indexToDelete = $index;
            }
        }

        if ($indexToDelete !== null) {
            unset($Cache[$indexToDelete]);
            $Cache = array_values($Cache);

            $this->PutCache('reasonmute', $Cache);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonDel')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointResNo')];
        }
    }

    public function Privileges_Time_Add($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/privilegestime.php', 0777);
        $Cache = $this->GetCache('privilegestime');

        if (empty($POST['name_time']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameTimeNo')];
        if (!isset($POST['duration']) || $POST['duration'] === '')
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSecNo')];
        if ($POST['duration'] < 0)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];

        if (empty($Cache)) {
            $CurrentId = 0;
        }
        foreach ($Cache as $key) {
            if ($key['id'] > $CurrentId) {
                $CurrentId = $key['id'];
            }
        }
        $Id = ++$CurrentId;

        $Mass = array(
            'name_time'  => $POST['name_time'],
            'duration' => $POST['duration'],
            'id'          => $Id
        );
        $Cache[] = $Mass;

        $this->PutCache('privilegestime', $Cache);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeAdd')];
    }

    public function Privileges_Time_Del($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/privilegestime.php', 0777);
        $Cache = $this->GetCache('privilegestime');

        $indexToDelete = null;
        foreach ($Cache as $index => $key) {
            if ($key['id'] == $POST['id']) {
                $indexToDelete = $index;
            }
        }

        if ($indexToDelete !== null) {
            unset($Cache[$indexToDelete]);
            $Cache = array_values($Cache);

            $this->PutCache('privilegestime', $Cache);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeDel')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointTimeNo')];
        }
    }

    public function Punishment_Time_Add($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/punishmenttime.php', 0777);
        $Cache = $this->GetCache('punishmenttime');

        if (empty($POST['name_time']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameTimeNo')];
        if (!isset($POST['duration']) || $POST['duration'] === '')
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSecNo')];
        if ($POST['duration'] < 0)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime0')];

        if (empty($Cache)) {
            $CurrentId = 0;
        }
        foreach ($Cache as $key) {
            if ($key['id'] > $CurrentId) {
                $CurrentId = $key['id'];
            }
        }
        $Id = ++$CurrentId;

        $Mass = array(
            'name_time'  => $POST['name_time'],
            'duration' => $POST['duration'],
            'id'          => $Id
        );
        $Cache[] = $Mass;

        $this->PutCache('punishmenttime', $Cache);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeAdd')];
    }

    public function Punishment_Time_Del($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/punishmenttime.php', 0777);
        $Cache = $this->GetCache('punishmenttime');

        $indexToDelete = null;
        foreach ($Cache as $index => $key) {
            if ($key['id'] == $POST['id']) {
                $indexToDelete = $index;
            }
        }

        if ($indexToDelete !== null) {
            unset($Cache[$indexToDelete]);
            $Cache = array_values($Cache);

            $this->PutCache('punishmenttime', $Cache);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeDel')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointTimeNo')];
        }
    }

    public function Create_Server_Iks($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/serversiks.php', 0777);
        $Cache = $this->GetCache('serversiks');

        if (!isset($POST['server_id']) || $POST['server_id'] === '')
            return ['status' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
        if (!isset($POST['server_name']) || $POST['server_name'] === '')
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameServNo')];
        foreach ($Cache as $key) {
            if ($key['server_id'] == $POST['server_id']) {
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
            }
        }

        if (empty($Cache)) {
            $CurrentId = 0;
        }
        foreach ($Cache as $key) {
            if ($key['id'] > $CurrentId) {
                $CurrentId = $key['id'];
            }
        }
        $Id = ++$CurrentId;

        $Mass = array(
            'server_id'  => $POST['server_id'],
            'server_name' => $POST['server_name'],
            'id'          => $Id
        );
        $Cache[] = $Mass;

        $this->PutCache('serversiks', $Cache);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServAdd')];
    }

    public function Del_Server_Iks($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/serversiks.php', 0777);
        $Cache = $this->GetCache('serversiks');

        $indexToDelete = null;
        foreach ($Cache as $index => $key) {
            if ($key['id'] == $POST['id']) {
                $indexToDelete = $index;
            }
        }

        if ($indexToDelete !== null) {
            unset($Cache[$indexToDelete]);
            $Cache = array_values($Cache);

            $this->PutCache('serversiks', $Cache);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServDel')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointServNo')];
        }
    }

    public function Create_Server_Vip($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/serversvip.php', 0777);
        $Cache = $this->GetCache('serversvip');

        if (!isset($POST['server_id']) || $POST['server_id'] === '')
            return ['status' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
        if (!isset($POST['server_name']) || $POST['server_name'] === '')
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameServNo')];
        foreach ($Cache as $key) {
            if ($key['server_id'] == $POST['server_id']) {
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerIDNo')];
            }
        }

        if (empty($Cache)) {
            $CurrentId = 0;
        }
        foreach ($Cache as $key) {
            if ($key['id'] > $CurrentId) {
                $CurrentId = $key['id'];
            }
        }
        $Id = ++$CurrentId;

        $Mass = array(
            'server_id'  => $POST['server_id'],
            'server_name' => $POST['server_name'],
            'id'          => $Id
        );
        $Cache[] = $Mass;

        $this->PutCache('serversvip', $Cache);
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServAdd')];
    }

    public function Del_Server_Vip($POST)
    {
        chmod(MODULES . 'module_page_managersystem/assets/cache/serversvip.php', 0777);
        $Cache = $this->GetCache('serversvip');

        $indexToDelete = null;
        foreach ($Cache as $index => $key) {
            if ($key['id'] == $POST['id']) {
                $indexToDelete = $index;
            }
        }

        if ($indexToDelete !== null) {
            unset($Cache[$indexToDelete]);
            $Cache = array_values($Cache);

            $this->PutCache('serversvip', $Cache);
            return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSServDel')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPointServNo')];
        }
    }
}
