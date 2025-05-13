<?php /**
    * @author SeverskiY (@severskteam)
**/

namespace app\modules\module_page_skins\system;

use app\modules\module_page_skins\system\FunctionCore;

class Music extends FunctionCore
{    
    protected $Db, $General, $Translate, $languages, $music;

    public function __construct($Db, $General, $Translate)
    {
        $this->Db        = $Db;
        $this->General   = $General;
        $this->Translate = $Translate;
        $this->languages = strtolower($_SESSION['language']);

        $file_exists     = realpath($_SERVER['DOCUMENT_ROOT'] . "/app/modules/module_page_skins/cache/music-{$this->languages}.json");
        $musicFile       = MODULES . "module_page_skins/cache/music-{$this->languages}.json";
    
        $this->music     = file_exists($file_exists) ? $musicFile : MODULES . "module_page_skins/cache/music-en.json";
    }

    # Данные пользователя для Pisex плагина
    private function DataDBUser()
    {
        $steamid = $_SESSION['steamid64'];

        if ($this->Settings('type') == 1) {
            return $steamid;
        } 

        $user = $this->Db->query('Skins', 0, 0, "SELECT `id` FROM `sc_player` WHERE `steamid` = :steamid LIMIT 1", [
            'steamid' => $steamid
        ]);
    
        if (isset($user['id'])) {
            return $user['id'];
        }
    
        $this->insertUser($steamid);
        $user = $this->Db->query('Skins', 0, 0, "SELECT `id` FROM `sc_player` WHERE `steamid` = :steamid LIMIT 1", [
            'steamid' => $steamid
        ]);
    
        return $user['id'];
    }

    private function insertUser($steamid)
    {
        $name = $this->General->checkName($steamid);
        $this->Db->query('Skins', 0, 0, "INSERT INTO `sc_player` (`name`, `steamid`) VALUES (:name, :steamid)", [
            'name'    => isset($name) ? $name : "Unknown",
            'steamid' => $steamid
        ]);
    } 

    # Вывод музыки по командам
    public function IntefaceMusic($server = 0, $team = 0, $music = null)
    {
        if (!is_numeric($server) || intval($server) != $server || $server < 0 || $this->Settings('type') == 1 && $server >= $this->Db->table_count['Skins']) return ['html' => $this->Translate('_nonono')];
        if (!is_numeric($team) || intval($team) != $team || $team > 2 || $team < 0) return ['html' => $this->Translate('_nonono')];

        $html = "";
        $Music = $this->get_cache($this->music);

        if(!empty($this->DataDBUser())) {
            if ($this->Settings('type') == 1) {
                $teamwp = empty($team) ? 2 : 3;
                $ID_user_items = $this->Db->query('Skins', $server, 0, "SELECT `music_id` AS `music` FROM `wp_player_music` WHERE `steamid` = :player_id AND `weapon_team` = :weapon_team LIMIT 1", [
                    'player_id' => $this->DataDBUser(),
                    'weapon_team' => $teamwp,
                ]);
            } else if ($this->Settings('type') == 2) {
                $ID_user_items = $this->Db->query('Skins', 0, 0, "SELECT `music` FROM `sc_items` WHERE `player_id` = :player_id AND `server_id` = :server_id AND `team` = :team LIMIT 1", [
                    'player_id' => $this->DataDBUser(),
                    'team' => $team,
                    'server_id' => $server,
                ]);
            }
        }

        if (!empty($music)) {
            $Music = array_filter($Music, function ($skin) use ($music) {
                return strpos(strtolower($skin['name']), strtolower($music)) !== false;
            });
        }     

        foreach ($Music as $Mus) {

            $id = $Mus['id'];
            $name = $Mus['name'];
            $img = $Mus['image'];
            $desc = $Mus['rarity'];
            $rarity = ' ' . $Mus['id_rarity'];

            $choice_active = "";
            $choose_weapon = $this->Translate('_choose_weapon'); # ПЕРЕВОД
            if($ID_user_items['music'] == $id) {
                $choice_active = " choice_active";
                $choose_weapon = $this->Translate('_choose_default'); # ПЕРЕВОД
            }
    
            $html .= <<<HTML
                            <div class="block-skin-fon{$choice_active}{$rarity}" id="set_music" id_music="{$id}">
                                <b class="button-skin">{$choose_weapon}</b>
                                <div class="block-skin-img">
                                    <img class="loader_img_all" src="{$img}" loading="lazy" alt="{$name}">
                                </div>
                                <div class="block-skin-info">
                                    <b>{$name}</b>
                                    <span>{$desc}</span>
                                </div>
                            </div>
                         HTML;
        }
    
        return ['html' => $html ?: $this->Translate('_skins_no')];
    }

    # Функция для выполнение смены агентов и их удаление...
    public function SCSkinChangerMusic(int $type = 2, $server = 0, $team = 0, int $music = 0)
    {

        if (!is_numeric($server) || intval($server) != $server || $server < 0 || $this->Settings('type') == 1 && $server >= $this->Db->table_count['Skins']) return ['status' => 'error', 'text' => $this->Translate('_nonono')];
        if (!is_numeric($team) || intval($team) != $team || $team > 2 || $team < 0) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

        if (!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];

        if ($this->TableSearch()) return ['status' => 'error', 'text' => $this->Translate('_adm_table_no')]; # ПЕРЕВОД
        if ($this->TableSearchServer()) return ['status' => 'error', 'text' => $this->Translate('_adm_no_serv')]; # ПЕРЕВОД

        $Music = $this->get_cache($this->music);
        $Music = array_filter($Music, function($skin) use ($music) {
            return $skin['id'] == $music;
        }); 
        $Music = reset($Music);
        if (empty($Music['id']) && $Music['id'] != $music) return ['status' => 'error', 'text' => $this->Translate('_error3')]; # ПЕРЕВОД

        if (empty($this->DataDBUser())) return ['status' => 'error', 'text' => $this->Translate('_error1')]; # ПЕРЕВОД

        if ($this->Settings('type') == 1) {
            $teamwp = empty($team) ? 2 : 3;
            $ID_user_items = $this->Db->query('Skins', 0, 0, "SELECT `music_id` FROM `wp_player_music` WHERE `steamid` = :player_id AND `weapon_team` = :weapon_team LIMIT 1", [
                'steamid' => $this->DataDBUser(),
                'weapon_team' => $teamwp,
            ]);
        } else if ($this->Settings('type') == 2) {
            $ID_user_items = $this->Db->query('Skins', 0, 0, "SELECT `id` FROM `sc_items` WHERE `player_id` = :player_id AND `server_id` = :server AND `team` = :team LIMIT 1", [
                'player_id' => $this->DataDBUser(),
                'server' => $server,
                'team' => $team,
            ]);
        }

        switch($type) {
            case 0:
                if ($this->Settings('type') == 1) {
                    $teamwp = empty($team) ? 2 : 3;
                    if (!empty($ID_user_items)) {            
                        $this->Db->query('Skins', $server, 0, "UPDATE `wp_player_music` SET `music_id` = :music WHERE `steamid` = :id AND `weapon_team` = :weapon_team LIMIT 1", [
                            "id" => $this->DataDBUser(),
                            "music" => $Music['id'],
                            'weapon_team' => $teamwp,
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_ch')];
                    } else {
                        $query = "INSERT INTO `wp_player_music`(`steamid`, `weapon_team`, `music_id`) 
                        VALUES (:id, :weapon_team, :music_id)";
                        $this->Db->query('Skins', $server, 0, $query, [
                            "id" => $this->DataDBUser(),
                            "music_id" => $Music['id'],
                            'weapon_team' => $teamwp,
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_ch')];
                    }
                } else if ($this->Settings('type') == 2) {   
                    if (!empty($ID_user_items['id'])) {
                        $this->Db->query('Skins', 0, 0, "UPDATE `sc_items` SET `music` = :music WHERE `id` = :id LIMIT 1", [
                            "id" => $ID_user_items['id'],
                            "music" => $Music['id']
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_ch')];
                    } else {
                        $query = "INSERT INTO `sc_items`(`player_id`, `server_id`, `team`, `agent`, `music`, `coin`, `knife`, `glove`) 
                            VALUES (:player_id, :server, :team, 0, :music, 0, 0, 0)";
                        $this->Db->query('Skins', 0, 0, $query, [
                            'player_id' => $ID_user_items['id'],
                            'server_id' => $server,
                            'team' => $team,
                            'music' => $Music['id'],  
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_ch')];
                    }
                }
            case 1:
                if ($this->Settings('type') == 1) {
                    if (!empty($ID_user_items)) {
                        $teamwp = empty($team) ? 2 : 3;
                        $this->Db->query('Skins', $server, 0, "UPDATE `wp_player_music` SET `music_id` = NULL WHERE `steamid` = :id AND `weapon_team` = :weapon_team LIMIT 1", [
                            "id" => $this->DataDBUser(),
                            "weapon_team" => $teamwp,
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_del')]; # ПЕРЕВОД
                    } else {
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_del_all')]; # ПЕРЕВОД
                    }
                } else if ($this->Settings('type') == 2) {   
                    if (!empty($ID_user_items['id'])) {
                        $this->Db->query('Skins', 0, 0, "UPDATE `sc_items` SET `music` = '0' WHERE `id` = :id LIMIT 1", [
                            "id" => $ID_user_items['id']
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_del')]; # ПЕРЕВОД
                    } else {
                        return ['status' => 'success', 'text' => $this->Translate('_mkit_del_all')]; # ПЕРЕВОД
                    }
                }
            default:
                return ['status' => 'error', 'text' => $this->Translate('_error2')]; # ПЕРЕВОД
        }
    }
}