<?php /**
  * @author -r8 (@r8.dev)
  **/

namespace app\modules\module_page_reports\ext;

use app\modules\module_page_reports\ext\Rcon;

class Core extends Rcon
{
    protected $Db, $General, $Translate, $Modules, $Notifications, $sid, $rid, $ReportCore, $SettingsCore, $ApiCore, $AccessCore;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications, $sid, $rid)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
        $this->sid = $sid;
        $this->rid = $rid;
        $this->ReportCore = new ReportCore($Db, $General, $Translate, $Modules, $Notifications, $sid, $rid);
        $this->SettingsCore = new SettingsCore($Db, $General, $Translate, $Modules, $Notifications);
        $this->ApiCore = new ApiCore($General);
        $this->AccessCore = new AccessCore($Db, $General);
    }

    public function ReportCore() 
    {
        return $this->ReportCore;
    }

    public function SettingsCore() 
    {
        return $this->SettingsCore;
    }

    public function ApiCore() 
    {
        return $this->ApiCore;
    }

    public function AccessCore() 
    {
        return $this->AccessCore;
    }

    public function Rcons($command)
    {
        $errors = [];
        $success = false;
        foreach ($this->General->server_list as $server) {
            $ip = explode(':', $server['ip']);
            $newrcon = new Rcon($ip[0], $ip[1]);
            if ($newrcon->Connect()) {
                if (!empty($server['rcon'])) {
                    $newrcon->RconPass($server['rcon']);
                    $newrcon->Command($command);
                    $success = true;
                } else {
                    $errors[] = "Не найден RCON пароль на сервере " . $server['name_custom'];
                }
                $newrcon->Disconnect();
            } else {
                $errors[] = "Не удалось соедениться с сервером " . $server['name_custom'];
            }
        }
        if ($success) {
            return ["status" => "success"];
        } else {
            return ["status" => "error", "text" => $errors];
        }
    }

    public function GetCache($file)
    {
        return file_exists(MODULES . 'module_page_reports/assets/cache/' . $file . '.php') ? require MODULES . 'module_page_reports/assets/cache/' . $file . '.php' : null;
    }

    public function PutCache($file, $data)
    {
        return file_exists(MODULES . 'module_page_reports/assets/cache/' . $file . '.php') ? file_put_contents(MODULES . 'module_page_reports/assets/cache/' . $file . '.php', '<?php return ' . var_export($data, true) . ';') : null;
    }

    public function GetServerRS()
    {
        return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_servers`");
    }

    public function GetServers()
    {
        $resultid = [];
        foreach ($this->GetServerRS() as $serverRS) {
            $resultid[$serverRS['web_id']] = $serverRS;
        }
        $result = [];
        foreach ($this->General->server_list as $serverLR) {
            if (isset($resultid[$serverLR['id']])) {
                $serverRS = $resultid[$serverLR['id']];
                $result[] = [
                    'id' => $serverLR['id'],
                    'name_custom' => $serverLR['name_custom'],
                    'ip' => $serverLR['ip'],
                    'sid' => $serverRS['sid'],
                    'iks_sid' => $serverRS['iks_sid'],
                    'vip_sid' => $serverLR['server_vip_id'],
                ];
            }
        }
        return $result;
    }

    public function GetServerSid($sid) {
        foreach ($this->GetServers() as $server) {
            if ($server['sid'] == $sid) {
                return $server;
            }
        }
        return false;
    }

    public function AddServer($POST) {
        if (empty(array_filter($POST))) {
            return ['status' => 'error', 'text' => 'В массиве не хватает данных!'];
        } else {
            $param = [
                'web' => $POST['web_id'],
                'iks' => $POST['iks_id'] ?? '',
                'sid' => $POST['rs_id']
            ];
            $this->Db->queryAll('Reports', 0, 0, "INSERT INTO `rs_servers` (`web_id`, `iks_sid`, `sid`) VALUES (:web, :iks, :sid)", $param);
            return ['status' => 'success', 'text' => 'Вы добавили новый сервер!'];
        }
    }

    public function DelServer($POST) {
        $this->Db->query('Reports', 0, 0, "DELETE FROM `rs_servers` WHERE `sid` = :sid LIMIT 1", ['sid' => $POST['server']]);
        return ['status' => 'success', 'text' => 'Вы удалили сервер!'];
    }
}