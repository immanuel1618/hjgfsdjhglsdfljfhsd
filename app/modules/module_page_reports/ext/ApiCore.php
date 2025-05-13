<?php
/**
  * @author -r8 (@r8.dev)
  **/

namespace app\modules\module_page_reports\ext;

use app\modules\module_page_reports\ext\Core;

class ApiCore extends Core {
    private $version = 'v1';

    private $api_key;

    public function __construct($General) {
        $this->General = $General;
        $this->api_key = Core::GetCache('settings')['blockdb_apikey'];
    }

    private function writeCache($steam, $key, $data) {
        $cachetime = 86400;
        $filename = MODULES . 'module_page_reports/temp/api/cache.json';
        $cache = [];
    
        if (file_exists($filename)) {
            $cache = json_decode(file_get_contents($filename), true);
        }
        $time = time();
        foreach ($cache as $key1 => $row) {
            foreach ($row as $dataKey => $entry) {
                if ($time - $entry['timestamp'] > $cachetime) {
                    unset($cache[$key1][$dataKey]);
                }
            }
            if (empty($cache[$key1])) {
                unset($cache[$key1]);
            }
        }
        $cache[$steam][$key] = [
            'timestamp' => $time,
            'data' => $data
        ];
        file_put_contents($filename, json_encode($cache, JSON_PRETTY_PRINT));
    }

    private function readCache($steam, $key) {
        $cachetime = 86400;
        $filename = MODULES . 'module_page_reports/temp/api/cache.json';
        if (file_exists($filename)) {
            $cache = json_decode(file_get_contents($filename), true);
            if (isset($cache[$steam][$key]) && (time() - $cache[$steam][$key]['timestamp'] < $cachetime)) {
                return $cache[$steam][$key]['data'];
            }
        }
    }

    public function GetBanPlayer($steam) {
        $cache = $this->readCache($steam, 'bans');
        if ($cache !== null) {
            return $cache;
        }
        if ($this->api_key) {
            $url = "https://api.blockdb.ru/$this->version/bans/$steam";
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Authorization: Bearer ' . $this->api_key
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['check_votebkm' => true]));
    
            $result = curl_exec($ch);
    
            curl_close($ch);
            $decoded = json_decode($result, true);
    
            if ($decoded['status'] == 'OK') {
                $bans = $decoded['bans'];
                $this->writeCache($steam, 'bans', $bans);
                return $bans;
            }
        }
    }

    public function GetTimeCreatedAcc($steam) {
        $cache = $this->readCache($steam, 'timecreated');
        if ($cache !== null) {
            return $cache;
        }

        $result = curl_init('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $this->General->arr_general['web_key'] . '&steamids=' . $steam);
        curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
        $url = curl_exec($result);
        curl_close($result);
        $data = json_decode($url, true)['response']['players'][0]['timecreated'];

        $this->writeCache($steam, 'timecreated', $data);
        return $data;
    }
    
    public function GetTimePlayCS2($steam) {
        $cache = $this->readCache($steam, 'playtime_cs2');
        if ($cache !== null) {
            return $cache;
        }
        $result = curl_init('https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=' . $this->General->arr_general['web_key'] . '&steamid=' . $steam);
        curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
        $url = curl_exec($result);
        curl_close($result);
        $data = json_decode($url, true)['response']['games'];
    
        foreach ($data as $game) {
            if ($game['appid'] == 730) {
                $playtime = round($game['playtime_forever'] / 60);
                $this->writeCache($steam, 'playtime_cs2', $playtime);
                return $playtime;
            }
        }
        $this->writeCache($steam, 'playtime_cs2', 0);
        return 0;
    }
}