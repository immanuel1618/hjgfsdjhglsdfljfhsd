<?php

/**
 * @author -r8 (@r8.dev)
 **/

namespace app\modules\module_page_reports\ext;

use app\modules\module_page_reports\ext\Core;

class AccessCore extends Core
{
    protected $Db, $General;

    public function __construct($Db, $General)
    {
        $this->Db = $Db;
        $this->General = $General;
    }

    public function GetAccess()
    {
        return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_admins`");
    }

    public function UpdateAdminUser()
    {
        $updatefile = MODULES . 'module_page_reports/temp/update_status.php';
        $updatedata = require $updatefile;
        if (!$updatedata['update_needed'] && (time() - $updatedata['last_update']) < Core::GetCache('settings')['update_time']) {
            return;
        }
        if (!empty($this->Db->db_data['AdminSystem'])) {
            $admins = $this->Db->queryAll('AdminSystem', 0, 0, "SELECT DISTINCT
                `as_admins`.`id`,
                `as_admins`.`id` AS `admin_id`,
                `as_admins`.`name`,
                `as_admins`.`steamid`,
                `as_admins`.`comment`,
                `as_admins_servers`.`flags`,
                `as_admins_servers`.`immunity`,
                `as_admins_servers`.`expires` AS `end`,
                `as_admins_servers`.`group_id`,
                (SELECT GROUP_CONCAT(`as_admins_servers`.`server_id`) FROM `as_admins_servers` WHERE `admin_id`=`as_admins`.`id`) AS `server_id`
            FROM 
                `as_admins`
            JOIN 
                `as_admins_servers` 
            ON 
                `as_admins`.`id` = `as_admins_servers`.`admin_id`");
        }
        $returnsid = [];
        foreach (Core::GetServers() as $server) {
            $returnsid[$server['iks_sid']] = $server['sid'];
        }
        $workreturn = $this->Db->queryAll('Reports', 0, 0, "SELECT `steamid`, `sid`, `working` FROM `rs_admins`");
        $worksave = [];
        foreach ($workreturn as $return) {
            $worksave[$return['steamid']][$return['sid']] = $return['working'];
        }
        $this->Db->queryAll('Reports', 0, 0, "TRUNCATE TABLE `rs_admins`");
        $sql = [];
        if (!empty($this->Db->db_data['AdminSystem'])) {
            foreach ($admins as $admin) {
                $server_ids = explode(',', $admin['server_id']);
                if ($admin['server_id'] == '-1') {
                    foreach ($returnsid as $iks_sid => $sid) {
                        $working = isset($worksave[$admin['steamid']][$sid]) ? $worksave[$admin['steamid']][$sid] : 0;
                        $sql[] = "('" . $admin['steamid'] . "', " . $working . ", " . $sid . ")";
                    }
                } else {
                    foreach ($server_ids as $iks_sid) {
                        if (isset($returnsid[$iks_sid])) {
                            $sid = $returnsid[$iks_sid];
                            $working = isset($worksave[$admin['steamid']][$sid]) ? $worksave[$admin['steamid']][$sid] : 0;
                            $sql[] = "('" . $admin['steamid'] . "', " . $working . ", " . $sid . ")";
                        }
                    }
                }
            }
        }
        
        if (!empty($sql)) {
            $query = "INSERT INTO `rs_admins` (`steamid`, `working`, `sid`) VALUES " . implode(', ', $sql);
            $this->Db->queryAll('Reports', 0, 0, $query);
            Core::Rcons('mm_rsa_reload');
        }
        $updatedata = [
            'last_update' => time(),
            'update_needed' => false
        ];
        file_put_contents($updatefile, '<?php return ' . var_export_min($updatedata, true) . ';');
    }

    public function SetUpdate()
    {
        $updatefile = MODULES . 'module_page_reports/temp/update_status.php';

        $updatedata = require $updatefile;
        $updatedata['update_needed'] = true;
        file_put_contents($updatefile, '<?php return ' . var_export_min($updatedata, true) . ';');
        return ['status' => 'success', 'text' => 'Обновление администрации запущено!'];
    }

    public function GetAdminSid($steam)
    {
        return $this->Db->query('Reports', 0, 0, "SELECT GROUP_CONCAT(`sid`) FROM `rs_admins` WHERE `steamid` = $steam");
    }

    public function AddAdmin($POST)
    {
        if (!$POST['sid']) return ['status' => 'error', 'text' => 'Вы не указали сервера!'];
        foreach ($POST['sid'] as $key) {
            $params = [
                "steamid" => con_steam64($POST['steamid']),
                "working" => 0,
                "sid" => $key
            ];
            $this->Db->query('Reports', 0, 0, "INSERT INTO `rs_admins` (`steamid`, `working`, `sid`) VALUES (:steamid, :working, :sid)", $params);
        }
        $result = Core::Rcons('mm_rsa_reload');
        if ($result['status'] == 'success') {
            return ['status' => 'success', 'text' => 'Вы добавили администратора!'];
        } else {
            return ['status' => $result['status'], 'text' => $result['text']];
        }
    }

    public function DelAdmin($POST)
    {
        $this->Db->query('Reports', 0, 0, "DELETE FROM `rs_admins` WHERE `id` = {$POST['id_del']} LIMIT 1");

        $result = Core::Rcons('mm_rsa_reload');
        if ($result['status'] == 'success') {
            return ['status' => 'success', 'text' => 'Вы удалили администратора!'];
        } else {
            return ['status' => $result['status'], 'text' => $result['text']];
        }
    }
}
