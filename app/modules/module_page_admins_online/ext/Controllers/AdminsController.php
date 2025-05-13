<?php

namespace app\modules\module_page_admins_online\ext\Controllers;

use app\modules\module_page_admins_online\ext\ErrorLog;

class AdminsController
{
    private $Db;
    private $Translate;
    private $Notifications;

    public function __construct($Db, $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
    }

    public function GetAdmins($server_id, $steamid64, $norma, $from, $to)
    {
        if (!empty($this->Db->db_data['AdminSystem'])) {
            $sql = 'SELECT DISTINCT ads.* 
                FROM as_admins ads
                JOIN as_admin_time asr ON ads.steamid = asr.admin_id
                JOIN as_admins_servers ass ON ads.id = ass.admin_id
                WHERE 1=1';
            $params = [];

            if ($server_id !== -1) {
                $sql .= ' AND (ass.server_id = :serverId OR ass.server_id = -1)';
                $params['serverId'] = $server_id;
            }

            if ($steamid64 !== null) {
                $sql .= ' AND ads.steamid = :admin_id';
                $params['admin_id'] = $steamid64;
            }

            if ($from !== null) {
                $sql .= ' AND asr.connect_time >= :connect_time';
                $params['connect_time'] = $from;
            }

            $admins = $this->Db->queryAll('AdminSystem', 0, 0, $sql, $params);
        }

        return $admins;
    }

    public function GetSessionLogs($steamid64, $from, $to, $server_id)
    {
        if (!empty($this->Db->db_data['AdminSystem'])) {
            $sql = 'SELECT * FROM `as_admin_time` WHERE 1=1';
            $params = [];

            if ($from != null) {
                $sql .= ' AND `connect_time` >= :connect_time';
                $params['connect_time'] = $from;
            }

            if ($server_id != -1) {
                $sql .= ' AND (server_id = :serverId)';
                $params['serverId'] = $server_id;
            }

            if ($to != null) {
                $sql .= ' AND `connect_time` <= :disconnect_time';
                $params['disconnect_time'] = $to;
            }

            $sql .= ' AND `admin_id` = :steamid64';
            $params['steamid64'] = $steamid64;

            $sql .= ' AND `connect_time` < `disconnect_time` ORDER BY `connect_time` DESC';

            $sessionLogs = $this->Db->queryAll('AdminSystem', 0, 0, $sql, $params);
        }

        return $sessionLogs;
    }

    public function GetPlayedTime($steamid64, $from, $to, $server_id)
    {
        if (!empty($this->Db->db_data['AdminSystem'])) {
            $sql = 'SELECT SUM(`played_time`) AS `total_played_time` FROM `as_admin_time` WHERE 1=1';
            $params = [];

            if ($from != null) {
                $sql .= ' AND `connect_time` >= :connect_time';
                $params['connect_time'] = $from;
            }

            if ($server_id !== -1) {
                $sql .= ' AND (server_id = :serverId)';
                $params['serverId'] = $server_id;
            }

            if ($to != null) {
                $sql .= ' AND `connect_time` <= :disconnect_time';
                $params['disconnect_time'] = $to;
            }

            $sql .= ' AND `admin_id` = :steamid64';
            $params['steamid64'] = $steamid64;

            $playedTime =  $this->Db->queryAll('AdminSystem', 0, 0, $sql, $params);
        }
        return $playedTime;
    }
}
