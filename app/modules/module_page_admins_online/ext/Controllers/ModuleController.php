<?php
namespace app\modules\module_page_admins_online\ext\Controllers;

use app\modules\module_page_admins_online\ext\ErrorLog;

class ModuleController
{
    public function __construct($Db, $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
    }

    public function installerStatus() 
    {
        if ($this->areTablesInstalled() === true)
            return 'installed';

        return 'uninstalled';
    }

    private function areTablesInstalled() 
    {
        $tables = array(
            'lvl_web_admins_stats',
            'lvl_web_admins_stats_servers',
            'lvl_web_admins_stats_access'
        );

        foreach ($tables as $table) {
            $exists = $this->Db->mysql_table_search('Core', 0, 0, $table);
            if ($exists == 0)
                return false;
        }
        return true; 
    }

    public function getNicknameBySteam(string $steam): ?string
    {
        $options = require SESSIONS . '/options.php';
        $steam = con_steam32to64($steam);

        $apiKey = $options['web_key'];

        $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$apiKey&steamids=$steam";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        return isset($data['response']['players'][0]) ? $data['response']['players'][0]['personaname'] : null;
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

