<?php

namespace app\modules\module_page_profiles\ext;

class Player
{

    /**
     * @var string
     */
    public $steam_32;

    /**
     * @var int
     */
    public $steam_64;

    /**
     * @var int
     */
    public $server_group;

    /**
     * @var array
     */
    public $arr_default_info;

    /**
     * @var array
     */
    public $msettings;

    /**
     * @var array
     */
    public $weapons = ['weapon_knife' => '-', 'weapon_knife_m9_bayonet' => '-', 'weapon_knife_butterfly' => '-', 'weapon_knife_falchion' => '-', 'weapon_knife_def' => '-', 'weapon_knife_flip' => '-', 'weapon_knife_gut' => '-', 'weapon_knife_push' => '-', 'weapon_knife_t' => '-', 'weapon_knife_tactical' => '-'];

    /**
     * @var array
     */
    public $top_weapons;

    /**
     * @var int
     */
    public $top_position;

    /**
     * @var array
     */
    public $found = [];

    /**
     * @var object
     */
    public $Db;

    /**
     * @var array
     */
    public $check_user = [];

    /**
     * @var array
     */
    public $maps = ['de_mirage' => '-', 'de_dust2' => '-', 'de_cache' => '-', 'de_inferno' => '-', 'de_nuke' => '-', 'de_cbble' => '-', 'de_overpass' => '-', 'de_train' => '-'];

    /**
     * @var string
     */
    public $geo = '-';

    /**
     * @var int
     */
    public $search;

    /**
     * @var int
     */
    public $found_fix;

    /**
     * @var int
     */
    public $lws;

    /**
     * @var int
     */
    public $settings;

    function __construct($General, $Db, $Translate, $Modules, $id, $sg, $search)
    {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Работа с базой данных.
        $this->Db = $Db;

        // Работа с ядром.
        $this->General = $General;

        $this->Translate = $Translate;

        $this->Modules = $Modules;

        // Присвоение группы серверов.
        $this->server_group = (int) intval($sg);

        // Конвертация Steam ID
        substr($id, 0, 5) === "STEAM" ? $this->steam_32 = $id : $this->steam_32 = con_steam32($id);

        $check_it = false;

        if (!empty($Db->db_data['LevelsRanks'])) :
            for ($i = 0, $c = sizeof($Db->db_data['LevelsRanks']); $i < $c; $i++) :
                $dates[] = $Db->db_data['LevelsRanks'][$i];
            endfor;
        endif;

        for ($i = 0; $i < $Db->table_statistics_count; $i++) :

            switch ($dates[$i]['DB_mod']) {
                case 'LevelsRanks':
                    $this->check_user[] = $Db->query($dates[$i]['DB_mod'], $dates[$i]['USER_ID'], $dates[$i]['DB_num'], "SELECT `steam` FROM `" . $dates[$i]['Table'] . "` WHERE `steam` LIKE '%" . $this->get_steam_32_short() . "%' AND `lastconnect` > 0 limit 1");
                    break;
            }

            // Поиск игрока в таблицах.
            if (!empty($this->check_user[$i])) :

                $this->found[$i] = [
                    "DB_mod"        => $dates[$i]['DB_mod'],
                    "DB"            => (int) $dates[$i]['DB_num'],
                    "USER_ID"       => (int) $dates[$i]['USER_ID'],
                    "Table"         => $dates[$i]['Table'],
                    'name_servers'  => $dates[$i]['name'],
                    'mod'           => (int) $dates[$i]['mod'],
                    'steam'         => (int) $dates[$i]['steam'],
                    'ranks_pack'    => $dates[$i]['ranks_pack'],
                    'ranks_id'      => (int) empty($dates[$i]['ranks_id']) ? 0 : $dates[$i]['ranks_id'],
                    "server_group"  => (int) $i,
                ];

                if ($check_it == false) :
                    $check_it = $this->found[$i]['server_group'] == $this->server_group ? true : false;
                    if (!empty($search) && $search == 1) :
                        if (!empty($this->found[$i]['server_group'])) :
                            $check_it = true;
                            if (empty($_GET['server_group'])) :
                                $this->server_group = $i;
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        endfor;

        empty($this->found[$this->server_group]) && get_iframe('P1', 'Данная страница не существует') && die();

        $this->found_fix = array_values($this->found);

        $this->arr_default_info = $this->get_db_arr_default_info();

        $this->top_position = $this->get_db_top_position();

        $this->lws = $this->lvl_web_servers();

        $this->settings = $this->Modules->get_settings_modules('module_page_profiles', 'settings');

        if (!empty($this->found[$this->server_group]['DB_mod']) && $this->found[$this->server_group]['DB_mod'] == 'LevelsRanks') :

            # Плагин -> ExStats Weapons
            $Db->mysql_table_search('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], $this->found[$this->server_group]['Table'] . '_weapons') == 1 && !empty($result = $this->get_db_exstats_weapons()) && ($this->weapons = $result) && arsort($this->weapons);

            for ($i = 0; $i < 0; $i++) :
                $this->top_weapons[$i]['name'] = sizeof($this->weapons) ? array_search(max($this->weapons), $this->weapons) : 'weapon_knife';
                $this->top_weapons[$i]['kills'] = sizeof($this->weapons) ?  max($this->weapons) : '-';
                unset($this->weapons[$this->top_weapons[$i]['name']]);
            endfor;

            # Плагин -> ExStats Maps
            if ($Db->mysql_table_search('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], $this->found[$this->server_group]['Table'] . '_maps') == 1) :
                $this->maps = $this->get_db_plugin_module_maps();
                arsort($this->maps);
            endif;
        endif;

        $this->msettings = [
            'OP' => [
                'phrase' => '_First_round_kills',
                'icon' => 'fire',
            ],
            'Penetrated' => [
                'phrase' => '_Penetrated_kills',
                'icon' => 'format-valign-top',
            ],
            'NoScope' => [
                'phrase' => '_Killing_without_scope',
                'icon' => 'circle-o',
            ],
            'Run' => [
                'phrase' => '_Kills_on_run',
                'icon' => 'run',
            ],
            'Flash' => [
                'phrase' => '_Kills_flash',
                'icon' => 'eye-off',
            ],
            'Jump' => [
                'phrase' => '_Jump_kills',
                'icon' => 'star-outline',
            ],
            'Smoke' => [
                'phrase' => '_Smoke_kills',
                'icon' => 'mood-bad',
            ],
            'Whirl' => [
                'phrase' => '_Kills_whirl',
                'icon' => 'replay',
            ],
            'LastClip' => [
                'phrase' => '_Kills_last_shoot',
                'icon' => 'repeat-one',
            ]
        ];
    }

    public function get_value()
    {
        return (int) empty($this->arr_default_info['value']) ? 0 : $this->arr_default_info['value'];
    }

    public function get_steam_32()
    {
        $type = "/([0-9a-zA-Z_]{7}):([0-9]{1}):([0-9]+)/u";
        preg_match_all($type, $this->steam_32, $arr, PREG_SET_ORDER);
        if (!empty($arr[0][1]) && !empty($arr[0][3])) :
            return $arr[0][1] . ':' . $arr[0][2] . ':' . $arr[0][3];
        else :
            return false;
        endif;
    }

    /**
     * Конвертация Steam ID 3 -> 32 (int).
     *
     * @since 0.2
     *
     * @param string       $steamid3  Steam ID 3 игрока.
     *
     * @return int                    Выводит итог конвертации.
     */
    function con_steam3to32_int($steamid3, $else = 0)
    {
        if (is_numeric($steamid3)) :
            $a = $steamid3 % 2;
            $b = intval($steamid3 / 2);
            return 'STEAM_1:' . $a . ':' . $b;
        elseif ($else === 1) :
            return $steamid3[0] == 'S' ? con_steam64($steamid3) : $steamid3;
        else :
            return $steamid3;
        endif;
    }

    public function get_steam_32_short()
    {
        $type = "/[0-9a-zA-Z_]{7}:([0-9]{1}):([0-9]+)/u";
        preg_match_all($type, $this->steam_32, $arr, PREG_SET_ORDER);
        if (!empty($arr[0][2])) :
            return $arr[0][1] . ':' . $arr[0][2];
        else :
            return false;
        endif;
    }

    public function get_steam_64()
    {
        return con_steam64($this->get_steam_32());
    }

    public function get_steam_3_32()
    {
        return con_steam3to32_int($this->get_steam_32());
    }

    public function get_steam_id()
    {
        return con_steam32toId($this->get_steam_32());
    }

    public function get_name()
    {
        return (string) empty($this->arr_default_info['name']) ? 'Unknown' : $this->arr_default_info['name'];
    }

    public function get_rank()
    {
        return (int) $this->arr_default_info['rank'] ?? 0;
    }

    public function get_lastconnect()
    {
        return (int) empty($this->arr_default_info['lastconnect']) ? 0 : $this->Translate->get_translate_module_phrase('module_page_profiles', '_Was_ingame') . date("d.m.Y " . $this->Translate->get_translate_module_phrase('module_page_profiles', '_On_ingame') . " H:i", $this->arr_default_info['lastconnect']);
    }

    public function get_online_player()
    {
        return (int) empty($this->arr_default_info['lastconnect']) ? 0 : $this->arr_default_info['lastconnect'];
    }

    public function get_kills()
    {
        return (int) empty($this->arr_default_info['kills']) ? 0 : $this->arr_default_info['kills'];
    }

    public function get_deaths()
    {
        return (int) empty($this->arr_default_info['deaths']) ? 0 : $this->arr_default_info['deaths'];
    }

    public function get_kd()
    {
        $a = empty($this->get_deaths()) ? $this->get_kills() : round($this->get_kills() / $this->get_deaths(), 2);
        return $a;
    }

    public function get_shoots()
    {
        return (int) empty($this->arr_default_info['shoots']) ? 0 : $this->arr_default_info['shoots'];
    }

    public function get_hits()
    {
        return (int) empty($this->arr_default_info['hits']) ? 0 : $this->arr_default_info['hits'];
    }

    public function get_percent_hits()
    {
        $a = 0;
        !empty($this->get_shoots()) && $a = (float) round(100 * $this->get_hits() / $this->get_shoots(), 1);
        return $a . ' % ';
    }

    public function get_headshots()
    {
        return (int) empty($this->arr_default_info['headshots']) ? 0 : $this->arr_default_info['headshots'];
    }

    public function get_percent_headshots()
    {
        $a = 0;
        !empty($this->get_kills()) && $a = (float) round(100 * $this->get_headshots() / $this->get_kills(), 1);
        return  $a . ' % ';
    }

    public function get_assists()
    {
        switch ($this->found[$this->server_group]['DB_mod']) {
            case 'LevelsRanks':
                return (int) $this->arr_default_info['assists'];
        }
    }

    public function get_round_win()
    {
        return (int) empty($this->arr_default_info['round_win']) ? 0 : $this->arr_default_info['round_win'];
    }

    public function get_round_lose()
    {
        return (int) empty($this->arr_default_info['round_lose']) ? 0 : $this->arr_default_info['round_lose'];
    }

    public function get_percent_win()
    {
        $a = 0;
        !empty($this->get_round_lose()) && $a = (float) round(100 * $this->get_round_win() / ($this->get_round_win() + $this->get_round_lose()), 1);
        return $a . '%';
    }

    public function get_playtime()
    {
        return (int) empty($this->arr_default_info['playtime']) ? 0 : round($this->arr_default_info['playtime'] / 60 / 60, 0);
    }

    public function get_top_position()
    {
        return (int) $this->top_position;
    }

    private function get_db_arr_default_info()
    {
        if (!empty($this->found[$this->server_group]['DB_mod'])) :
            switch ($this->found[$this->server_group]['DB_mod']) {
                case 'LevelsRanks':
                    return $this->Db->query('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], "SELECT `name`, `rank`, `steam`, `playtime`, `value`, `kills`, `headshots`, `assists`, `deaths`, `round_win`, `round_lose`, `shoots`, `hits`, `lastconnect` FROM `" . $this->found[$this->server_group]['Table'] . "` WHERE `steam` LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1");
            }
        else :
            return [];
        endif;
    }

    private function get_db_top_position()
    {
        if (!empty($this->found[$this->server_group]['DB_mod'])) :
            switch ($this->found[$this->server_group]['DB_mod']) {
                case 'LevelsRanks':
                    return $this->Db->query('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], "SELECT COUNT(1) AS `top` FROM (SELECT DISTINCT `value` FROM `" . $this->found[$this->server_group]['Table'] . "` WHERE `value` >= " . $this->get_value() . " AND `lastconnect` > 0) t;")['top']; //NqUy065N18eJq3ze
            }
        else :
            return [];
        endif;
    }

    private function get_db_exstats_weapons()
    {
        switch ($this->found[$this->server_group]['DB_mod']) {
            case 'LevelsRanks':
                $a = $this->Db->queryAll('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], "SELECT `classname`, `kills` FROM `" . $this->found[$this->server_group]['Table'] . "_weapons` WHERE `steam` LIKE '%" . $this->get_steam_32_short() . "%'");
                $b = [];
                for ($i = 0, $c = sizeof($a); $i < $c; $i++) :
                    $b += [$a[$i]['classname'] => $a[$i]['kills']];
                endfor;
                return $b;
        }
    }

    private function get_db_plugin_module_unusualkills()
    {
        switch ($this->found[$this->server_group]['DB_mod']) {
            case 'LevelsRanks':
                return $this->Db->query('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], "SELECT `OP`, `Penetrated`, `NoScope`, `Run`, `Jump`, `Flash`, Smoke, `Whirl`, `LastClip` FROM `" . $this->found[$this->server_group]['Table'] . "_unusualkills` WHERE `SteamID` LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1");
        }
    }

    public function get_unusualkills()
    {
        if (!empty($this->found[$this->server_group]['DB_mod']) && $this->found[$this->server_group]['DB_mod'] == 'LevelsRanks') :
            # Плагин -> Unusual Kills
            if ($this->Db->mysql_table_search('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], $this->found[$this->server_group]['Table'] . '_unusualkills') == 1) :
                return $this->get_db_plugin_module_unusualkills();
            else :
                return [];
            endif;
        endif;
    }

    public function get_unusualkills_op()
    {
        return (int) $this->get_unusualkills()['OP'];
    }

    public function get_unusualkills_penetrated()
    {
        return (int) $this->get_unusualkills()['Penetrated'];
    }

    public function get_unusualkills_noscope()
    {
        return (int) $this->get_unusualkills()['NoScope'];
    }

    public function get_unusualkills_run()
    {
        return (int) $this->get_unusualkills()['Run'];
    }

    public function get_unusualkills_jump()
    {
        return (int) $this->get_unusualkills()['Jump'];
    }

    public function get_unusualkills_flash()
    {
        return (int) $this->get_unusualkills()['Flash'];
    }

    public function get_unusualkills_smoke()
    {
        return (int) $this->get_unusualkills()['Smoke'];
    }

    public function get_unusualkills_whirl()
    {
        return (int) $this->get_unusualkills()['Whirl'];
    }

    public function get_unusualkills_last_clip()
    {
        return (int) $this->get_unusualkills()['LastClip'];
    }

    private function get_db_plugin_module_maps()
    {
        $a = $this->Db->queryAll('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], "SELECT `name_map`, `countplays` FROM `" . $this->found[$this->server_group]['Table'] . "_maps` WHERE `steam` LIKE '%" . $this->get_steam_32_short() . "%'");
        $b = [];
        for ($i = 0, $c = sizeof($a); $i < $c; $i++) :
            $b += [$a[$i]['name_map'] => $a[$i]['countplays']];
        endfor;
        return $b;
    }

    public function get_db_plugin_module_geoip()
    {
        if (!empty($this->found[$this->server_group]['DB_mod']) && $this->found[$this->server_group]['DB_mod'] == 'LevelsRanks') :
            if ($this->Db->mysql_table_search('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], $this->found[$this->server_group]['Table'] . '_geoip') == 1) :
                return $this->Db->query('LevelsRanks', $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], "SELECT `country`, `city`, `clientip` FROM `" . $this->found[$this->server_group]['Table'] . "_geoip` WHERE `steam` LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1");
            else :
                return [];
            endif;
        endif;
    }

    public function lvl_web_servers()
    {
        for ($d = 0; $d < $this->General->server_list_count; $d++) :
            if (!empty($this->General->server_list[$d]['server_stats']) && $this->General->server_list[$d]['server_stats'] == sprintf('%s;%d;%d;%s', $this->found[$this->server_group]['DB_mod'], $this->found[$this->server_group]['USER_ID'], $this->found[$this->server_group]['DB'], $this->found[$this->server_group]['Table'])) :
                return array(
                    "server_id" => $this->General->server_list[$d]['id'],
                    "server_shop" => explode(";", $this->General->server_list[$d]['server_shop']),
                    "server_vip" => explode(";", $this->General->server_list[$d]['server_vip']),
                    "server_vip_id" => explode(";", $this->General->server_list[$d]['server_vip_id']),
                    "server_sb" => explode(";", $this->General->server_list[$d]['server_sb']),
                    "server_sb_id" => $this->General->server_list[$d]['server_sb_id']
                );
            endif;
        endfor;
    }

    public function get_db_Bans()
    {
        if (!empty($this->Db->db_data['IksAdmin']) && $this->lws['server_sb'][0] == 'IksAdmin') :
            if (!empty($this->settings['punishment_all_servers'])) {
                return $this->Db->queryAll('IksAdmin', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_bans` WHERE `steam_id` = :steam ORDER BY `created_at` DESC LIMIT 30", ['steam' => $this->get_steam_64()]);
            } else {
                return $this->Db->queryAll('IksAdmin', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_bans` WHERE `steam_id` = :steam AND (`server_id` = :server_id OR `server_id` IS NULL) ORDER BY `created_at` DESC LIMIT 30", ['steam' => $this->get_steam_64(), 'server_id' => $this->lws['server_sb_id']]);
            }
        elseif (!empty($this->Db->db_data['AdminSystem']) && $this->lws['server_sb'][0] == 'AdminSystem'):
            if (!empty($this->settings['punishment_all_servers'])) {
                return $this->Db->queryAll('AdminSystem', (int) $this->lws['server_sb'][1], $this->lws['server_sb'][2], "SELECT *,  (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name` FROM `as_punishments` WHERE `steamid` = :steam AND `punish_type` = '0' ORDER BY `created` DESC LIMIT 30", ['steam' => $this->get_steam_64()]);
            } else {
                return $this->Db->queryAll('AdminSystem', (int) $this->lws['server_sb'][1], $this->lws['server_sb'][2], "SELECT *, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name` FROM `as_punishments` WHERE `steamid` = :steam AND `punish_type` = '0' AND (`server_id` = :server_id OR `server_id` = '-1') ORDER BY `created` DESC LIMIT 30", ['steam' => $this->get_steam_64(), 'server_id' => $this->lws['server_sb_id']]);
            }
        else :
            return [];
        endif;
    }

    public function get_db_Comms()
    {
        if (!empty($this->Db->db_data['IksAdmin']) && $this->lws['server_sb'][0] == 'IksAdmin') :
            if (!empty($this->settings['punishment_all_servers'])) {
                return $this->Db->queryAll('IksAdmin', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_comms` WHERE `steam_id` = :steam ORDER BY `created_at` DESC LIMIT 30", ['steam' => $this->get_steam_64()]);
            } else {
                return $this->Db->queryAll('IksAdmin', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT *, (SELECT `name` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_name`, (SELECT `steam_id` FROM `iks_admins` WHERE `id` = `admin_id`) AS `admin_steamid` FROM `iks_comms` WHERE `steam_id` = :steam AND (`server_id` = :server_id OR `server_id` IS NULL) ORDER BY `created_at` DESC LIMIT 30", ['steam' => $this->get_steam_64(), 'server_id' => $this->lws['server_sb_id']]);
            }
        elseif (!empty($this->Db->db_data['AdminSystem']) && $this->lws['server_sb'][0] == 'AdminSystem') :
            if (!empty($this->settings['punishment_all_servers'])) {
                return $this->Db->queryAll('AdminSystem', (int) $this->lws['server_sb'][1], $this->lws['server_sb'][2], "SELECT *, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name` FROM `as_punishments` WHERE `steamid` = :steam AND `punish_type` != '0' ORDER BY `created` DESC LIMIT 30", ['steam' => $this->get_steam_64()]);
            } else {
                return $this->Db->queryAll('AdminSystem', (int) $this->lws['server_sb'][1], $this->lws['server_sb'][2], "SELECT *, (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid`, (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name` FROM `as_punishments` WHERE `steamid` = :steam AND `punish_type` != '0' AND (`server_id` = :server_id OR `server_id` = '-1') ORDER BY `created` DESC LIMIT 30", ['steam' => $this->get_steam_64(), 'server_id' => $this->lws['server_sb_id']]);
            }
        else :
            return [];
        endif;
    }

    public function get_db_Admins()
    {
        $server_id = $this->lws['server_sb_id'];
        $steam = $this->get_steam_64();
        if (!empty($this->settings['punishment_all_servers'])) {
            if (!empty($this->Db->db_data['AdminSystem']) && $this->lws['server_sb'][0] == 'AdminSystem') {
                return $this->Db->query('AdminSystem', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT 
                    `as_admins`.`id` AS `admin_id`,
                    `as_admins`.`name`,
                    `as_admins`.`steamid`,
                    `as_admins`.`comment`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`flags`) AS `flags`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`immunity`) AS `immunity`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`expires`) AS `end`,
                    `as_admins_servers`.`group_id`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`server_id`) AS `server_id`,
                    (SELECT COUNT(1) FROM `as_punishments` WHERE `admin_id` = `as_admins`.`id` AND `punish_type` = 0) AS `bans_count`,
                    (SELECT COUNT(1) FROM `as_punishments` WHERE `admin_id` = `as_admins`.`id` AND (`punish_type` = 1 OR `punish_type` = 3)) AS `mutes_count`,
                    (SELECT COUNT(1) FROM `as_punishments` WHERE `admin_id` = `as_admins`.`id` AND (`punish_type` = 2 OR `punish_type` = 3)) AS `gags_count`
                FROM 
                    `as_admins`
                JOIN 
                    `as_admins_servers` 
                ON 
                    `as_admins`.`id` = `as_admins_servers`.`admin_id`
                WHERE 
                    `as_admins`.`steamid` = :steam
                    AND (`as_admins_servers`.`server_id` = :server_id OR `as_admins_servers`.`server_id` = '-1')
                    AND (`as_admins_servers`.`expires` > UNIX_TIMESTAMP() OR `as_admins_servers`.`expires` = 0)
                GROUP BY
                    `as_admins`.`id`, `as_admins_servers`.`group_id`;", ['steam' => $steam, 'server_id' => $server_id]);
            } else {
                return [];
            }
        } else {
            if (!empty($this->Db->db_data['AdminSystem']) && $this->lws['server_sb'][0] == 'AdminSystem') {
                return $this->Db->query('AdminSystem', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT 
                    `as_admins`.`id` AS `admin_id`,
                    `as_admins`.`name`,
                    `as_admins`.`steamid`,
                    `as_admins`.`comment`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`flags`) AS `flags`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`immunity`) AS `immunity`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`expires`) AS `end`,
                    `as_admins_servers`.`group_id`,
                    GROUP_CONCAT(DISTINCT `as_admins_servers`.`server_id`) AS `server_id`,
                    (SELECT COUNT(1) FROM `as_punishments` WHERE `admin_id` = `as_admins`.`id` AND (`as_punishments`.`server_id` = :server_id OR `as_punishments`.`server_id` = '-1') AND `punish_type` = 0) AS `bans_count`,
                    (SELECT COUNT(1) FROM `as_punishments` WHERE `admin_id` = `as_admins`.`id` AND (`as_punishments`.`server_id` = :server_id OR `as_punishments`.`server_id` = '-1') AND (`punish_type` = 1 OR `punish_type` = 3)) AS `mutes_count`,
                    (SELECT COUNT(1) FROM `as_punishments` WHERE `admin_id` = `as_admins`.`id` AND (`as_punishments`.`server_id` = :server_id OR `as_punishments`.`server_id` = '-1') AND (`punish_type` = 2 OR `punish_type` = 3)) AS `gags_count`
                FROM 
                    `as_admins`
                JOIN 
                    `as_admins_servers` 
                ON 
                    `as_admins`.`id` = `as_admins_servers`.`admin_id`
                WHERE 
                    `as_admins`.`steamid` = :steam
                    AND (`as_admins_servers`.`server_id` = :server_id OR `as_admins_servers`.`server_id` = '-1')
                    AND (`as_admins_servers`.`expires` > UNIX_TIMESTAMP() OR `as_admins_servers`.`expires` = 0)
                GROUP BY
                    `as_admins`.`id`, `as_admins_servers`.`group_id`;", ['steam' => $steam, 'server_id' => $server_id]);
            } else {
                return [];
            }
        }
    }

    public function get_db_Groups()
    {
        if (!empty($this->Db->db_data['IksAdmin']) && $this->lws['server_sb'][0] == 'IksAdmin') :
            return $this->Db->queryAll('IksAdmin', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT `id`, `name`, `flags`, `immunity` FROM `iks_groups`");
        elseif (!empty($this->Db->db_data['AdminSystem']) && $this->lws['server_sb'][0] == 'AdminSystem') :
            return $this->Db->queryAll('AdminSystem', (int) $this->lws['server_sb'][1], (int) $this->lws['server_sb'][2], "SELECT `id`, `name`, `flags`, `immunity` FROM `as_groups`");
        else :
            return [];
        endif;
    }

    public function get_db_Warns()
    {
        if (file_exists(MODULES . 'module_page_managersystem/description.json')) :
            return $this->Db->queryAll('Core', 0, 0, "SELECT `id`, `steamid`, `reason`, `time`, `createtime` FROM `lvl_web_managersystem_warn` WHERE `steamid` = " . $this->get_steam_64() . " AND `time` > UNIX_TIMESTAMP()");
        endif;
    }
    public function get_db_WarnsCount()
    {
        if (file_exists(MODULES . 'module_page_managersystem/description.json')) :
            return ceil($this->Db->queryNum('Core', 0, 0, "SELECT COUNT(*) FROM `lvl_web_managersystem_warn` WHERE `steamid` = " . $this->get_steam_64() . " AND `time` > UNIX_TIMESTAMP()")[0]);
        endif;
    }

    public function get_db_RepCount()
    {
        if (file_exists(MODULES . 'module_page_reports/description.json')) :
            return ceil($this->Db->queryNum('Reports', 0, 0, "SELECT COUNT(*) FROM `rs_reports` WHERE `steamid_admin_verdict` = " . $this->get_steam_64() . "")[0]);
        endif;
    }

    public function get_db_Vips()
    {
        if (empty($this->settings['use_all_vips_servers_in_one_table'])) :
            if (!empty($this->lws['server_vip'][0]) && !empty($this->Db->db_data['Vips'])) :
                return $this->Db->query('Vips', (int) $this->lws['server_vip'][1], (int) $this->lws['server_vip'][2], "SELECT `vip_users`.`group`, `vip_users`.`expires` FROM `vip_users` WHERE `vip_users`.`account_id` LIKE '%" . con_steam3($this->get_steam_32()) . "%'");
            else :
                return [];
            endif;
        else :
            if (!empty($this->lws['server_vip'][0]) && !empty($this->Db->db_data['Vips'])) :
                return $this->Db->query('Vips', (int) $this->lws['server_vip'][1], (int) $this->lws['server_vip'][2], "SELECT `vip_users`.`group`, `vip_users`.`expires`, `vip_users`.`sid` FROM `vip_users` WHERE `vip_users`.`sid` = '" . (int) $this->lws['server_vip_id'][0] . "' AND `vip_users`.`account_id` LIKE '%" . con_steam3($this->get_steam_32()) . "%'");
            else :
                return [];
            endif;
        endif;
    }
    public function get_friends()
    {
        return json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=" . $this->General->arr_general['web_key'] . "&steamid=" . $this->get_steam_64() . "&relationship=all"), true);
    }

    public function get_info()
    {
        return $this->Db->query('Core', 0, 0, "SELECT * FROM lvl_web_profiles WHERE `auth` LIKE '%" . $this->get_steam_64() . "%'");
    }

    public function edit_info()
    {
        $option = [
            'auth' => $this->get_steam_64(),
            'vk' => $_POST['vk'],
            'tg' => $_POST['telegram'],
            'background' => $_POST['background'],
            'status' => $_POST['status'],
            'twitch' => $_POST['twitch']
        ];
    
        $this->Db->query('Core', 0, 0, "UPDATE lvl_web_profiles SET vk = :vk, tg = :tg, background = :background, twitch = :twitch, status = :status WHERE auth = :auth", $option);
    }  
    
    public function get_db_lk()
    {
        if (!empty($this->Db->db_data['lk'])) :
            return $this->Db->queryAll('lk', $this->Db->db_data['lk'][0]['USER_ID'], $this->Db->db_data['lk'][0]['DB_num'], "SELECT 
                (SELECT `lk`.`all_cash` FROM `lk` WHERE `lk`.`auth` LIKE '%" . $this->get_steam_32_short() . "%') AS `all_cash`,
                (SELECT `lk`.`cash` FROM `lk` WHERE `lk`.`auth` LIKE '%" . $this->get_steam_32_short() . "%') AS `cash`,
                `lk_pays`.`pay_id`, 
                `lk_pays`.`pay_order`, 
                `lk_pays`.`pay_summ`, 
                `lk_pays`.`pay_data`, 
                `lk_pays`.`pay_system`, 
                `lk_pays`.`pay_promo`, 
                `lk_pays`.`pay_status` 
                FROM `lk_pays` 
                WHERE `lk_pays`.`pay_status` = 1 AND `lk_pays`.`pay_auth`
                LIKE '%" . $this->get_steam_32_short() . "%' ORDER BY `pay_id` DESC");
        else :
            return [];
        endif;
    }
    public function get_balance()
    {
        if (isset($this->General->Db->db_data['lk'])) {
            $param = ['auth' => '%' . $this->get_steam_32_short() . '%'];
            $infoUser = $this->General->Db->queryAll('lk', $this->General->Db->db_data['lk'][0]['USER_ID'], $this->General->Db->db_data['lk'][0]['DB_num'], "SELECT `cash` FROM `lk` WHERE `auth` LIKE :auth LIMIT 1", $param);
            $cash = 'cash';
            return number_format($infoUser[0][$cash], 0, ' ', ' ');
        }
        return false;
    }
    public function get_db_shop()
    {
        if (file_exists(MODULES . 'module_page_store/description.json')) :
            if (file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) :
                $shop = require MODULES . 'module_page_store/cache/logs_cache.php';
                return [
                    'shop' => '3',
                    'array' => $shop
                ];
            elseif ($this->Db->mysql_table_search('Core', 0, 0, "lvl_web_shop_logs")) :
                $shop = $this->Db->queryAll('Core', 0, 0, "SELECT 
                `lvl_web_shop_logs`.`id`,
                `lvl_web_shop_logs`.`steam`,
                `lvl_web_shop_logs`.`title`, 
                `lvl_web_shop_logs`.`promo`, 
                `lvl_web_shop_logs`.`date`,
                `lvl_web_shop_logs`.`status`
                FROM `lvl_web_shop_logs` 
                WHERE `lvl_web_shop_logs`.`status` = 1 AND `lvl_web_shop_logs`.`steam`
                LIKE '%" . $this->get_steam_32_short() . "%'");
                return [
                    'shop' => '4',
                    'array' => $shop
                ];
            endif;
        else :
            return [
                'shop' => '0',
                'array' => []
            ];
        endif;
    }
}
