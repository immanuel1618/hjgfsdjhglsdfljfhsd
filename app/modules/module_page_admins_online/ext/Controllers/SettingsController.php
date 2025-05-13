<?php

namespace app\modules\module_page_admins_online\ext\Controllers;

use app\modules\module_page_admins_online\ext\ErrorLog;

class SettingsController
{
    public function __construct($Db, $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
    }

    public function GetSettings()
    {
        $settings = $this->Db->query('Core', 0, 0, 'SELECT * FROM `lvl_web_admins_stats`', []);

        if (empty($settings)):
            $this->Db->query('Core', 0, 0, 'INSERT INTO `lvl_web_admins_stats` (`period`, `required_playtime`, `all_admin_access`) VALUES (:period, :required_playtime, :all_admin_access)', [
                'period' => 2629743,
                'required_playtime' => null,
                'all_admin_access' => 1
            ]);

            return $this->Db->query('Core', 0, 0, 'SELECT * FROM `lvl_web_admins_stats`', []);
        endif;

        return $settings;
    }

    public function UpdateSettings()
    {
        if (!isset($_SESSION['user_admin']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_NO_RIGHTS')];

        if (empty($_POST['period']) || !is_numeric($_POST['period']) || $_POST['period'] < 0)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_INVALID_FILLED_FIELDS')];

        $this->Db->query('Core', 0, 0, 'UPDATE `lvl_web_admins_stats` SET period = :period, required_playtime = :needtime', [
            'period' => $_POST['period'],
            'needtime' => empty($_POST['needtime']) ? null : $_POST['needtime']
        ]);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_UPDATE_SETTINGS')];
    }

    public function GetConnectedServersList()
    {
        $query = "
            SELECT s.ip, s.name, s.id
            FROM lvl_web_servers s
            INNER JOIN lvl_web_admins_stats_servers ass ON s.id = ass.server_id
        ";
        $servers = $this->Db->queryAll('Core', 0, 0, $query, []);

        return $servers;
    }

    public function GetServersList()
    {
        $servers = $this->Db->queryAll('Core', 0, 0, 'SELECT * FROM `lvl_web_admins_stats_servers', []);

        return $servers;
    }

    public function AddServer()
    {
        if (!isset($_SESSION['user_admin']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_NO_RIGHTS')];

        if (empty($_POST['lr_server_id']) || !is_numeric($_POST['lr_server_id']) || $_POST['lr_server_id'] < 0 || empty($_POST['lr_server_id']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_INVALID_FILLED_FIELDS')];

        $exists = $this->Db->query('Core', 0, 0, 'SELECT `server_id` FROM `lvl_web_admins_stats_servers` WHERE (`server_id` = :server_id) OR (`iks_server_id` = :iks_server_id)', [
            'server_id' => $_POST['lr_server_id'],
            'iks_server_id' => $_POST['iks_server_id']
        ]);

        if (!empty($exists))
            return ['status' => 'error', 'text' => 'Запись уже существует'];

        $this->Db->query('Core', 0, 0, 'INSERT INTO `lvl_web_admins_stats_servers` (`server_id`, `iks_server_id`) VALUES (:server_id, :iks_server_id)', [
            'server_id' => $_POST['lr_server_id'],
            'iks_server_id' => $_POST['iks_server_id']
        ]);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_LINK_SERVER')];
    }

    public function DeleteServer()
    {
        if (!isset($_SESSION['user_admin']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_NO_RIGHTS')];

        if (empty($_POST['server_id']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_INVALID_FILLED_FIELDS')];

        $this->Db->query('Core', 0, 0, 'DELETE FROM `lvl_web_admins_stats_servers` WHERE `server_id` = :server_id', [
            'server_id' => $_POST['server_id'],
        ]);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_DELETE_SERVER')];
    }

    public function UpdateAccess()
    {
        if (!isset($_SESSION['user_admin']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_NO_RIGHTS')];

        $this->Db->query('Core', 0, 0, 'UPDATE `lvl_web_admins_stats` SET `all_admin_access` = :access', [
            'access' => empty($_POST['autoaddiks']) ? 0 : 1
        ]);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_UPDATE_STATUS')];
    }

    public function GetAccesses()
    {
        if (!isset($_SESSION['user_admin']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_NO_RIGHTS')];

        $accesses = $this->Db->queryAll('Core', 0, 0, 'SELECT * FROM `lvl_web_admins_stats_access`', []);

        return $accesses;
    }

    public function DeleteAccess()
    {
        if (!isset($_SESSION['user_admin']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_NO_RIGHTS')];

        if (empty($_POST['id']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_INVALID_FILLED_FIELDS')];

        $this->Db->query('Core', 0, 0, 'DELETE FROM `lvl_web_admins_stats_access` WHERE `id` = :id', [
            'id' => $_POST['id']
        ]);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_WITHDRAWN_ACCESS')];
    }

    public function AddAccess()
    {
        if (!isset($_SESSION['user_admin']))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_NO_RIGHTS')];

        if (empty($_POST['steamid64']) || !is_numeric($_POST['steamid64']) || $_POST['steamid64'] < 0)
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_INVALID_FILLED_FIELDS')];

        $exists = $this->Db->query('Core', 0, 0, 'SELECT `id` FROM `lvl_web_admins_stats_access` WHERE (`steamid64` = :steamid64)', [
            'steamid64' => $_POST['steamid64']
        ]);

        if (!empty($exists))
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_INVALID_FILLED_FIELDS')];

        $this->Db->query('Core', 0, 0, 'INSERT INTO `lvl_web_admins_stats_access` (`steamid64`) VALUES (:steamid64)', [
            'steamid64' => $_POST['steamid64']
        ]);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_admins_online', '_ADD_ACCESS')];
    }

    public function HasAccess()
    {
        if (isset($_SESSION['user_admin']))
            return true;
        if (!empty($this->Db->db_data['AdminSystem'])) {
            $admin = $this->Db->query('Core', 0, 0, 'SELECT `steamid` FROM `as_admins` WHERE (`steamid` = :steamid64)', [
                'steamid64' => $_SESSION['steamid64']
            ]);
        }

        $settings = $this->Db->query('Core', 0, 0, 'SELECT * FROM `lvl_web_admins_stats`', []);

        if ($settings['all_admin_access'] == 1 && !empty($admin))
            return true;

        $accesses = $this->Db->queryAll('Core', 0, 0, 'SELECT * FROM `lvl_web_admins_stats_access`', []);

        if ($settings['all_admin_access'] == 0):
            foreach ($accesses as $access):
                if ($access['steamid64'] == $_SESSION['steamid64'])
                    return true;
            endforeach;
        endif;

        return false;
    }
}
