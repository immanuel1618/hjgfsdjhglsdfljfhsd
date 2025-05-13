<?php /**
    * @author SeverskiY (@severskteam)
**/

namespace app\modules\module_page_skins\system;

use app\modules\module_page_skins\system\Rcon;
use app\modules\module_page_skins\system\Weapons;
use app\modules\module_page_skins\system\Agents;
use app\modules\module_page_skins\system\Music;
use app\modules\module_page_skins\system\Coins;
use app\modules\module_page_skins\system\Collections;
use app\modules\module_page_skins\system\Cache;

class FunctionCore extends Rcon
{    
    protected $Db, $General, $Translate, $Weapons, $Agents, $Music, $Coins, $Collections, $Cache;

    public function __construct($Db, $General, $Translate)
    {
        $this->Db            = $Db;
        $this->General       = $General;
        $this->Translate     = $Translate;
        $this->Weapons       = new Weapons($Db, $General, $Translate);
        $this->Agents        = new Agents($Db, $General, $Translate);
        $this->Music         = new Music($Db, $General, $Translate);
        $this->Coins         = new Coins($Db, $General, $Translate);
        $this->Collections   = new Collections($Db, $General, $Translate);
        $this->Cache         = new Cache($Db, $General, $Translate);
    }

    # Core кэш всего гавна
    public function Cache()
    {
        return $this->Cache;
    }

    # Обновить все кэши
    public function UpdateCache()
    {
        $this->Cache->CacheSkins();
        $this->Cache->CacheStickers();
        $this->Cache->CacheKeychains();
        $this->Cache->CacheAgents();
        $this->Cache->CacheMusic();
        $this->Cache->CacheMoney();
        return ['status' => 'success', 'text' => $this->Translate('_yspex_ccc_all')]; # ПЕРЕВОД
    }

    # Core скинов
    public function Weapons()
    {
        return $this->Weapons;
    }

    # Core агентов
    public function Agents()
    {
        return $this->Agents;
    }

    # Core музыки
    public function Music()
    {
        return $this->Music;
    }

    public function Collections()
    {
        return $this->Collections;
    }

    # Core монеты
    public function Coins()
    {
        return $this->Coins;
    }
    
    # Вывести кэш
    public function get_cache($id)
    {
        $packed_data = file_get_contents($id);
        return json_decode($packed_data, true);
    }

    # Сохранить кэш
    public function put_cache($id, $arr)
    {
        $packed_data = json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($id, $packed_data);
        return;
    }

    # Вывести список серверов
    public function SCServers()
    {
        return $this->Db->queryAll('Skins', 0, 0, "SELECT * FROM `sc_servers`");
    }

    # Вывести настройки модуля
    public function Settings($text)
    {
        return $this->get_cache(MODULES . "module_page_skins/settings.json")[$text];
    }

    // # Вывести номер сервера для Pisex плагина
    // public function ServersNumber($num = 0)
    // {
    //     return ($this->Settings('all_db') == 1) ? $num : 0;
    // }

	# Функция для перевода через translate
	public function Translate($text)
    {
        if (function_exists($this->Translate->translate)) {
            return $this->Translate->translate('module_page_skins', $text);
        } else {
            return $this->Translate->get_translate_module_phrase('module_page_skins', $text);
        }
    }

    # Функция для добавление в бд данные
    public function AddDBSkins($POST)
    {
        if(empty($POST['host']) && empty($POST['user']) && empty($POST['pass_db']) && empty($POST['name_db']) && empty($POST['name_db'])) {
            return ['status' => 'error', 'text' => "Некоторые поля почему-то пустые..."];
        }
        
        $this->Db->change_db( 
            "Skins", 
            $POST['host'],
            $POST['name_db'],
            $POST['pass_db'],
            $POST['user'],
            '',
            0,
            [ 
                'table' => '', 
                'name' => $POST['name_server'],
                'mod' => '' 
            ]
        );

        return ['status' => 'success', 'text' => $this->Translate('_input_yeye')];
    }

    # Сохранить настроки модуля
    public function SettingsModule($POST, $type)
    {
        switch($type) {
            case(1):
                $ip_server = explode(':', $POST['ip_server']);
                $server = $this->Db->query('Skins', 0, 0, "SELECT * FROM `sc_servers` WHERE `ip_address` = '{$ip_server[0]}' AND `port` = '{$ip_server[1]}' LIMIT 1");
                if(!empty($server['name'])) {
                    $this->Db->query('Skins', 0, 0, "UPDATE `sc_servers` SET `name` = '{$POST['name_server']}' WHERE `ip_address` = '{$server['ip_address']}' AND `port` = '{$ip_server[1]}' LIMIT 1");
                    return ['status' => 'success', 'text' => $this->Translate('_up_name')]; #ПЕРЕВОД
                } else {
                    $this->Db->query('Skins', 0, 0, "INSERT INTO `sc_servers`(`name`, `ip_address`, `port`) VALUES ('{$POST['name_server']}', '{$ip_server[0]}', '{$ip_server[1]}')");
                    return ['status' => 'success', 'text' => $this->Translate('_add_new')]; #ПЕРЕВОД
                }
            case(2):
                $settings = MODULES . "module_page_skins/settings.json";
                $setting_post = [
                    "type" => $_POST['type_module'],
                    "work" => $_POST['work_module'],
                    "buttons" => $_POST['buttons_module'],
                    "team" => $_POST['team_module'],
                ];
                $this->put_cache($settings, $setting_post);
                return ['status' => 'success', 'text' => $this->Translate('_save_md_set')]; #ПЕРЕВОД     
            case(3):
                $server = $this->Db->query('Skins', 0, 0, "SELECT * FROM `sc_servers` WHERE `id` = '{$POST['id_server']}' LIMIT 1");
                if(!empty($server['name'])) {
                    $this->Db->query('Skins', 0, 0, "DELETE FROM `sc_items` WHERE `server_id` = '{$server['id']}'");
                    $this->Db->query('Skins', 0, 0, "DELETE FROM `sc_skins` WHERE `server_id` = '{$server['id']}'");
                    sleep(1);
                    $this->Db->query('Skins', 0, 0, "DELETE FROM `sc_servers` WHERE `id` = '{$server['id']}' LIMIT 1");
                    return ['status' => 'success', 'text' => "{$this->Translate('_del_serv')} {$server['name']}"]; #ПЕРЕВОД
                } else {
                    return ['status' => 'error', 'text' => $this->Translate('_no_serv')]; #ПЕРЕВОД
                }
            default:
                return ['status' => 'error', 'text' => $this->Translate('_error')]; #ПЕРЕВОД
        }
    }

    # Проверить наличие таблицы
    public function TableSearch() {
        $type = $this->Settings('type');
        $tables = ($type == 1) ? ["wp_player_knife", "wp_player_skins", "wp_player_agents", "wp_player_gloves", "wp_player_music"] : ["sc_items", "sc_player", "sc_servers", "sc_skins"];
        foreach ($tables as $table) {
            $result = $this->Db->mysql_table_search("Skins", 0, 0, $table);
            if ($result == 0) {
                return true;
            }
        }
        return false;
    }

    # Проверить наличие сервера
    public function TableSearchServer() {
        $type = $this->Settings('type');
        if ($type == 2) {
            $result = $this->Db->query('Skins', 0, 0, "SELECT `ip_address` FROM `sc_servers` LIMIT 1");
            if (empty($result['ip_address'])) {
                return true;
            }
        }
        return false;
    }   

    # Запуск ркон команды для всех серверов
    protected function Rcons($command)
    {
        try {
            $_Server_Info = $this->Db->queryAll('Core', 0, 0, "SELECT `ip`, `rcon` FROM `lvl_web_servers`");
            foreach ($_Server_Info as $server) {
                $_IP = explode(':', $server['ip']);
                $_RCON = new Rcon($_IP[0], $_IP[1]);
                if ($_RCON->Connect()) {
                    $_RCON->RconPass($server['rcon']);
                    $_RCON->Command($command);
                    $_RCON->Disconnect();
                }
            }
        } catch (Exception $e) {
            return ['status' => "error", 'text' => "RCON error: {$e->getMessage()}"];
        }
    }
}