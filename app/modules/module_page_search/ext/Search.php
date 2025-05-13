<?php 

namespace app\modules\module_page_search\ext;

class Search
{
    /**
     * @var int Максмальное количество блоков в результате
     */
    protected $limit = 15;

    /**
     * @var int Минмальное количество опыта для поиска
     */
    protected $min_value = 0;

    protected $search_data;
    protected $search_serialize;
    protected $Db;
    protected $General;

    public function __construct($Db, $General)
    {
        if( isset( $_POST["search"] ) && !empty( $_POST["search"] ) )
        {
            $this->Db             = $Db;
            $this->General        = $General;
            $this->search_data    = (string) htmlentities( $_POST["search"] );

            if( !$this->search_serialize = $this->steamConvert() )
                self::return(["error" => "Неизвестный тип поиска!"]);
        }
        else self::return(["error" => "Неизвестный тип поиска!"]);
    }

    public function returnJson()
    {
        $players = $this->findPlayerInDb();

        if( !empty( $players ) )
        {
            $avatars = [];
            foreach( $players as $key => $val )
                $avatars[] = (int) con_steam64($val["steam"]);
            
            $this->checkAvatarsUsers($avatars);
                
            foreach( $players as $key => $val )
            {
                $players[$key]["avatar"]    = $this->General->getAvatar(con_steam64( $val["steam"]), 3 );
                $players[$key]["steam64"]   = con_steam64($val["steam"]);
            }
        }

        self::return([
            "players" => $players
        ]);
    }

    protected function findPlayerInDb()
    {
        $result = [];
    
        for ($i = 0; $i < $this->Db->table_count['LevelsRanks']; $i++) {
            $val = $this->Db->db_data['LevelsRanks'][$i];
            $query = "";
            $params = [
                'min_value' => $this->min_value,
                'limit' => $this->limit
            ];
    
            if ($this->getSearchType() === "name") {
                $query = "SELECT `steam`, `name` FROM `{$val["Table"]}` WHERE `value` >= :min_value AND `name` LIKE :search_term LIMIT :limit";
                $params['search_term'] = '%' . $this->getSearchResult() . '%';
            } else {
                $searchResult = $this->steam0to1($this->getSearchResult());
                $query = "SELECT `steam`, `name` FROM `{$val["Table"]}` WHERE `value` >= :min_value AND (`steam` = :steam1 OR `steam` = :steam2) LIMIT :limit";
                $params['steam1'] = $searchResult['steam1'];
                $params['steam2'] = $searchResult['steam2'];
            }
    
            $queryResult = $this->Db->queryAll('LevelsRanks', $val['USER_ID'], $val['DB_num'], $query, $params);
            if ($queryResult) {
                $result = array_merge($result, $queryResult);
            }
        }
    
        return $this->unique_multidim_array($result, "steam");
    }

    protected function steamConvert()
    {
        $val = $this->search_data;

        if( empty( $val ) )
            return false;
            
        if( strpos($val, 'https://steamcommunity.com/id/') !== false || strpos($val, 'https://steamcommunity.com/profiles/') !== false )
        {
            $steam_url = $this->parseXMLSteam($val);

            if( !empty( $steam_url ) )
                return [
                    "steam" => (string) $steam_url
                ];
        }

        try
        {
            return [
                "steam" => (string) (new SteamidConverter( $val ))->RenderSteam2()
            ];
        } 
        catch( \Exception $e )
        {
            return [
                "name" => htmlentities($val)
            ];
        }
    }

    protected function checkAvatarsUsers( array $avatars )
    {
        $expired = time() - $this->General->arr_general["avatars_cache_time"];
        
        foreach ($avatars as $k => $avatar) 
        {
            $cache = 'storage/cache/img/avatars/' . $avatar . '.json';
            if( file_exists( $cache ) && filemtime( $cache ) > $expired && file_exists( $cache ) && filemtime( $cache ) > $expired ) unset($avatars[$k]);
        }

        $result = curl_init( 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $this->General->arr_general["web_key"] . '&steamids=' . implode( ",", $avatars ) );
        curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
        $url = curl_exec($result);
        curl_close( $result );

        $data = json_decode( $url, true )['response']['players'];

        foreach( $data as $key => $val )
        {
            $result2 = curl_init('https://api.steampowered.com/IPlayerService/GetAnimatedAvatar/v1/?key=' . $this->General->arr_general["web_key"] . '&steamid=' . $val['steamid']);
            curl_setopt($result2, CURLOPT_RETURNTRANSFER, 1);
            $data2 = json_decode(curl_exec($result2), true);
            curl_close($result2);
    
            $result3 = curl_init('https://api.steampowered.com/IPlayerService/GetAvatarFrame/v1/?key=' . $this->General->arr_general["web_key"] . '&steamid=' . $val['steamid']);
            curl_setopt($result3, CURLOPT_RETURNTRANSFER, 1);
            $data3 = json_decode(curl_exec($result3), true);
            curl_close($result3);

            isset( $val['avatarfull'] ) && !empty( $val['avatarfull'] ) && file_put_contents( "storage/cache/img/avatars/" . $val['steamid'] . ".json", json_encode([
                'avatar' => $val['avatarfull'],
                'name'   => $val['personaname'],
                'slim'   => $val['avatar'],
                'animated' => isset($data2['response']['avatar']['image_small']) ? 'https://cdn.akamai.steamstatic.com/steamcommunity/public/images/' . $data2['response']['avatar']['image_small'] : '',
                'frame' => isset($data3['response']['avatar_frame']['image_small']) ? 'https://cdn.akamai.steamstatic.com/steamcommunity/public/images/' . $data3['response']['avatar_frame']['image_small'] : ''
            ]));
        }
    }

    protected function getSearchType()
    {
        if( isset( $this->search_serialize["steam"] ) )
            return "steam";
        
        return "name";
    }

    public function getSearchResult()
    {
        return $this->search_serialize[$this->getSearchType()];
    }

    protected function steam0to1($steam)
    {
        return [
            'steam1' => str_replace("STEAM_0", "STEAM_1", $steam),
            'steam2' => str_replace("STEAM_1", "STEAM_0", $steam)
        ];
    }    

    protected function unique_multidim_array($array, $key) 
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) 
        {
            if (!in_array($val[$key], $key_array)) 
            {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    protected function parseXMLSteam( $url )
    {
        if( $steam = Cache::get("url_$url") )
            return $steam;

        if( strpos($url, 'https://steamcommunity.com/profiles/') !== false )
        {
            $explode    = explode("/", $url);
            $steam      = $this->simpleconverter( (int) $explode[array_key_last($explode)]);

            Cache::put("url_$url", $steam);

            return !empty( $steam ) ? $steam : "";
        }

        try 
        {
            $new_url    = sprintf("%s/?xml=1", $url);
            $file       = simplexml_load_file($new_url);
            
            if( !empty( $file ) && isset( $file->steamID64[0] ) )
            {
                $steam  = $this->simpleconverter( (int) $file->steamID64[0] );
                Cache::put("url_$url", $steam);
                return $steam;
            }

            Cache::put("url_$url", "");

            return "";
        } 
        catch( \Exception $e )
        {
            return "";
        }
    }

    protected function simpleconverter($steam)
    {
        try
        {
            return (string) (new SteamidConverter( $steam ))->RenderSteam2();
        } 
        catch( \Exception $e )
        {
            return (string) htmlentities( $steam );
        }
    }

    protected static function return( $data )
    {
        return exit(json_encode(["result" => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}