<?php /**
  * @author -r8 (@r8.dev)
  **/

namespace app\modules\module_page_managersystem\ext;

use app\modules\module_page_managersystem\ext\Rcon;
use app\modules\module_page_managersystem\ext\AdminCore;
use app\modules\module_page_managersystem\ext\VipCore;
use app\modules\module_page_managersystem\ext\SettingsCore;

class Core extends Rcon
{
    protected $Db, $General, $Translate, $Modules, $Router, $Notifications, $AdminCore, $VipCore, $SettingsCore, $Search;

    public function __construct($Db, $General, $Translate, $Modules, $Router, $Notifications)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Router = $Router;
        $this->Notifications = $Notifications;
        $this->AdminCore = new AdminCore($Db, $General, $Translate, $Modules, $Notifications, $Router);
        $this->VipCore = new VipCore($Db, $General, $Translate, $Modules, $Notifications, $Router);
        $this->SettingsCore = new SettingsCore($Db, $General, $Translate, $Modules, $Notifications, $Router);
        $this->Search = new Search($Db, $General, $Modules, $Translate, $Notifications, $Router);
    }

    public function AdminCore()
    {
        return $this->AdminCore;
    }

    public function set_url_section_new($url, $params)
    {
        // Получаем массив всех подразделов.
        $query = $_GET;

        // Объединяем текущие параметры с новыми.
        $query = array_merge($query, $params);

        // Генерируем новую ссылку.
        $finally = urldecode(http_build_query($query));
        return $url . '?' . $finally;
    }

    public function VipCore()
    {
        return $this->VipCore;
    }

    public function SettingsCore()
    {
        return $this->SettingsCore;
    }

    public function Search()
    {
        return $this->Search;
    }

    public function get_module_cache()
    {
        $cache_file = '../temp/cache.json';

        if (file_exists($cache_file)) {
            $json_data = file_get_contents($cache_file);
            return json_decode($json_data, true);
        } else {
            !file_exists('../temp') && mkdir('../temp', 0777, true);
            file_put_contents($cache_file, json_encode([]));
            return [];
        }
    }

    public function set_module_cache($data)
    {
        !file_exists('../temp') && mkdir('../temp', 0777, true);
        $cache_file = '../temp/cache.json';
        file_put_contents($cache_file, json_encode($data, JSON_PRETTY_PRINT));
    }


    public function clearOldWarns(){
        $cache = $this->get_module_cache();
        if (empty($cache) || (!empty($cache['time']) && time() > $cache['time'])) {
            $cache['time'] = time() + 600;
            $this->set_module_cache($cache);
            $this->Db->query('Core', 0, 0, "DELETE FROM `lvl_web_managersystem_warn` WHERE `time` < UNIX_TIMESTAMP()");
        }
    }

    public function GetCache($file)
    {
        return file_exists(MODULES . 'module_page_managersystem/assets/cache/' . $file . '.php') ? require MODULES . 'module_page_managersystem/assets/cache/' . $file . '.php' : null;
    }

    public function PutCache($file, $data)
    {
        return file_exists(MODULES . 'module_page_managersystem/assets/cache/' . $file . '.php') ? file_put_contents(MODULES . 'module_page_managersystem/assets/cache/' . $file . '.php', '<?php return ' . var_export($data, true) . ';') : null;
    }

    public function AddBanBlockDB($steam, $reason, $duration, $user_ip = '') {
        $api_key = $this->GetCache('settings')['blockdbapikey'];
        $version = 'v1';
        
        $url = "https://api.blockdb.ru/$version/bans/";
        
        $data = array(
            'steamid64' => intval($steam),
            'reason' => $reason,
            'duration' => $duration,
            'user_ip' => $user_ip ?? ''
        );
        
        $payload = json_encode($data);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        
        if (curl_errno($ch)) {
            return "error";
        }
        curl_close($ch);
        
        if ($http_code >= 200 && $http_code < 300) {
            $decoded = json_decode($response, true);
            return json_encode($decoded, JSON_PRETTY_PRINT);
        } else {
            return "error";
        }
    }

    public function UnBanBlockDB($steam) {
        $api_key = $this->GetCache('settings')['blockdbapikey'];
        $version = 'v1';
    
        $url = "https://api.blockdb.ru/$version/bans/";
    
        $data = array(
            'steamid64' => intval($steam)
        );
    
        $payload = json_encode($data);
    
        $options = array(
            'http' => array(
                'method' => 'DELETE',
                'header' => "Content-type: application/json\r\n" .
                            "Accept: application/json\r\n" .
                            "Authorization: Bearer $api_key\r\n",
                'content' => $payload
            )
        );
    
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
    
        if ($response === false) {
            return "error";
        } else {
            $http_code = $http_response_header[0];
            if (strpos($http_code, '200') !== false) {
                return "success";
            } else {
                return "error";
            }
        }
    }    

    public function InstallMod($POST)
    {
        if (empty($POST['host']) && empty($POST['user']) && empty($POST['pass_db']) && empty($POST['name_db']) && empty($POST['name_server'])) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSPusto')];
        }

        if ($POST['admin_system'] == 'AdminSystem') {
            $table = 'as_';
        } elseif ($POST['admin_system'] == 'IksAdmin') {
            $table = 'iks_';
        }


        $this->Db->change_db(
            "{$POST['admin_system']}",
            $POST['host'],
            $POST['name_db'],
            $POST['pass_db'],
            $POST['user'],
            $table,
            0,
            [
                'name' => $POST['name_server'],
                'mod' => ''
            ]
        );

        if ($this->General->arr_general['theme'] == 'rich') {
            $put_container = file_get_contents(__DIR__ . '/../assets/cache/container_cache.php');
            $containerFilePath = __DIR__ . '/../../../templates/rich/interface/container.php';
            $fileContent = file_get_contents($containerFilePath);

            if (strpos($fileContent, $put_container) === false) {
                $fileContent = str_replace('<div class="admin_links">', '<div class="admin_links">' . PHP_EOL . $put_container, $fileContent);
                file_put_contents($containerFilePath, $fileContent);
            }
        }

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MSGoodMod')];
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

    public function DiscordWebhook($embed)
    {
        $data = [
            'embeds' => [$embed],
        ];

        $options = [
            'http' => [
                'header' => 'Content-type: application/json',
                'method' => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($this->GetCache('settings')['webhookurl'], false, $context);

        return $result !== false;
    }

    public function action_time_exchange_exact($seconds, $type = 0)
    {
        $div = array(2592000, 604800, 86400, 3600, 60, 1);
        $desc = array($this->Translate->get_translate_module_phrase('module_page_managersystem', '_MesGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_NedGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_DnGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_CGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_SGeneralTime'));
        $ret = array();
        foreach ($div as $index => $value) {
            $quotent = floor($seconds / $value);
            if ($quotent > 0) {
                $ret[$desc[$index]] = $quotent;
                $seconds %= $value;
            }
        }
        if (isset($ret[$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MesGeneralTime')])) {
            $result = array();
            foreach (array($this->Translate->get_translate_module_phrase('module_page_managersystem', '_MesGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_NedGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_DnGeneralTime')) as $unit) {
                if (isset($ret[$unit])) {
                    $result[] = $ret[$unit] . " $unit";
                }
            }
            return implode(' ', $result);
        } elseif (isset($ret[$this->Translate->get_translate_module_phrase('module_page_managersystem', '_NedGeneralTime')])) {
            $result = array();
            foreach (array($this->Translate->get_translate_module_phrase('module_page_managersystem', '_NedGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_DnGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_CGeneralTime')) as $unit) {
                if (isset($ret[$unit])) {
                    $result[] = $ret[$unit] . " $unit";
                }
            }
            return implode(' ', $result);
        } elseif (isset($ret[$this->Translate->get_translate_module_phrase('module_page_managersystem', '_DnGeneralTime')])) {
            $result = array();
            foreach (array($this->Translate->get_translate_module_phrase('module_page_managersystem', '_DnGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_CGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MGeneralTime')) as $unit) {
                if (isset($ret[$unit])) {
                    $result[] = $ret[$unit] . " $unit";
                }
            }
            return implode(' ', $result);
        } elseif (isset($ret[$this->Translate->get_translate_module_phrase('module_page_managersystem', '_CGeneralTime')])) {
            $result = array();
            foreach (array($this->Translate->get_translate_module_phrase('module_page_managersystem', '_CGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_MGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_SGeneralTime')) as $unit) {
                if (isset($ret[$unit])) {
                    $result[] = $ret[$unit] . " $unit";
                }
            }
            return implode(' ', $result);
        } elseif (isset($ret[$this->Translate->get_translate_module_phrase('module_page_managersystem', '_MGeneralTime')])) {
            $result = array();
            foreach (array($this->Translate->get_translate_module_phrase('module_page_managersystem', '_MGeneralTime'), $this->Translate->get_translate_module_phrase('module_page_managersystem', '_SGeneralTime')) as $unit) {
                if (isset($ret[$unit])) {
                    $result[] = $ret[$unit] . " $unit";
                }
            }
            return implode(' ', $result);
        } elseif (isset($ret[$this->Translate->get_translate_module_phrase('module_page_managersystem', '_SGeneralTime')])) {
            return $ret[$this->Translate->get_translate_module_phrase('module_page_managersystem', '_SGeneralTime')] . ' ' . $this->Translate->get_translate_module_phrase('module_page_managersystem', '_SGeneralTime');
        }
    }

    public function TableSearch()
    {
        $checkTable = array('lvl_web_managersystem_groups_admin', 'lvl_web_managersystem_access', 'lvl_web_managersystem_warn');
        foreach ($checkTable as $key) {
            $result = $this->Db->mysql_table_search("Core", 0, 0, $key);
            if ($result == 0) {
                return true;
            }
        }
        return false;
    }

    public function Steam64_ID($steam64)
    {
        switch (true):
            case (preg_match('/^(7656119)([0-9]{10})/', $steam64)):
                return $steam64;
            case (preg_match('/^STEAM_[01]:[01]:[0-9]{2,12}$/', $steam64)):
                return con_steam32to64($steam64);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam64)):
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam64), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
                return $getsearch;
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam64)):
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam64), "/");
                return $search_steam;
            case (preg_match('/^\[U:(.*)\:(.*)\]/', $steam64)):
                return con_steam3to64_int(str_replace(array('[U:1:', '[U:0:', ']'), '', $steam64));
            default:
                return false;
        endswitch;
    }

    public function Steam3_ID($steam3)
    {
        switch (true):
            case (preg_match('/^\[U:(.*)\:(.*)\]/', $steam3)):
                return str_replace(array('[U:1:', '[U:0:', ']'), '', $steam3);
            case (preg_match('/^STEAM_[01]:[01]:[0-9]{2,12}$/', $steam3)):
                return con_steam32to3_int($steam3);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam3)):
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam3), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
                return con_steam64to3_int($getsearch);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam3)):
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam3), "/");
                return con_steam64to3_int($search_steam);
            case (preg_match('/^(7656119)([0-9]{10})/', $steam3)):
                return con_steam64to3_int($steam3);
            default:
                return false;
        endswitch;
    }

    public function Steam64_Search($steam64)
    {
        switch (true):
            case (preg_match('/^(7656119)([0-9]{10})/', $steam64)):
                return $steam64;
            case (preg_match('/^STEAM_[01]:[01]:[0-9]{2,12}$/', $steam64)):
                return con_steam32to64($steam64);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam64)):
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam64), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
                return $getsearch;
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam64)):
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam64), "/");
                return $search_steam;
            case (preg_match('/^\[U:(.*)\:(.*)\]/', $steam64)):
                return con_steam3to64_int(str_replace(array('[U:1:', '[U:0:', ']'), '', $steam64));
            default:
                return $steam64;
        endswitch;
    }

    public function Steam3_Search($steam3)
    {
        switch (true):
            case (preg_match('/^\[U:(.*)\:(.*)\]/', $steam3)):
                return str_replace(array('[U:1:', '[U:0:', ']'), '', $steam3);
            case (preg_match('/^STEAM_[01]:[01]:[0-9]{2,12}$/', $steam3)):
                return con_steam32to3_int($steam3);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam3)):
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam3), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
                return con_steam64to3_int($getsearch);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam3)):
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam3), "/");
                return con_steam64to3_int($search_steam);
            case (preg_match('/^(7656119)([0-9]{10})/', $steam3)):
                return con_steam64to3_int($steam3);
            default:
                return $steam3;
        endswitch;
    }

    public function Steam32_Search($steam32)
    {
        switch (true):
            case (preg_match('/^STEAM_[01]:[01]:[0-9]{2,12}$/', $steam32)):
                return $steam32;
            case (preg_match('/^(7656119)([0-9]{10})/', $steam32)):
                return con_steam64to32($steam32);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam32)):
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam32), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
                return con_steam64to32($getsearch);
            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam32)):
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam32), "/");
                return con_steam64to32($search_steam);
            case (preg_match('/^\[U:(.*)\:(.*)\]/', $steam32)):
                return con_steam3to32_int(str_replace(array('[U:1:', '[U:0:', ']'), '', $steam32));
            default:
                return false;
        endswitch;
    }

    public function get_steam_32_short($steam32)
    {
        $type = "/[0-9a-zA-Z_]{7}:([0-9]{1}):([0-9]+)/u";
        preg_match_all($type, $steam32, $arr, PREG_SET_ORDER);
        if (!empty($arr[0][2])) :
            return $arr[0][1] . ':' . $arr[0][2];
        else :
            return false;
        endif;
    }
}