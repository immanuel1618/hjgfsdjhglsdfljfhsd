<?php /**
    * @author SeverskiY (@severskteam)
**/

namespace app\modules\module_page_skins\system;

use app\modules\module_page_skins\system\FunctionCore;

class Coins extends FunctionCore
{    
    protected $Db, $General, $Translate, $languages, $coins;

    public function __construct($Db, $General, $Translate)
    {
        $this->Db           = $Db;
        $this->General      = $General;
        $this->Translate    = $Translate;
        $this->languages    = strtolower($_SESSION['language']);

        $file_exists        = realpath($_SERVER['DOCUMENT_ROOT'] . "/app/modules/module_page_skins/cache/collectibles-{$this->languages}.json");
        $collectiblesFile   = MODULES . "module_page_skins/cache/collectibles-{$this->languages}.json";
    
        $this->coins        = file_exists($file_exists) ? $collectiblesFile : MODULES . "module_page_skins/cache/collectibles-en.json";
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
    public function IntefaceCoins($server = 0, $team = 0, $coins = null)
    {
        if (!is_numeric($server) || intval($server) != $server || $server < 0 || $this->Settings('type') == 1 && $server >= $this->Db->table_count['Skins']) return ['html' => $this->Translate('_nonono')];
        if (!is_numeric($team) || intval($team) != $team || $team > 2 || $team < 0) return ['html' => $this->Translate('_nonono')];

        $html = "";
        $Coins = $this->get_cache($this->coins);

        if (!empty($this->DataDBUser())) {
            if ($this->Settings('type') == 1) {
                $teamwp = empty($team) ? 2 : 3;
                $ID_user_items = $this->Db->query('Skins', $server, 0, "SELECT `id` AS `coin` FROM `wp_player_pins` WHERE `steamid` = :player_id AND `weapon_team` = :weapon_team LIMIT 1", [
                    'player_id' => $this->DataDBUser(),
                    'weapon_team' => $teamwp,
                ]);
            } else if ($this->Settings('type') == 2) {
                $ID_user_items = $this->Db->query('Skins', 0, 0, "SELECT `coin` FROM `sc_items` WHERE `player_id` = :player_id AND `server_id` = :server_id AND `team` = :team LIMIT 1", [
                    'player_id' => $this->DataDBUser(),
                    'team' => $team,
                    'server_id' => $server,
                ]);
            }
        }

        if (!empty($coins)) {
            $Coins = array_filter($Coins, function ($skin) use ($coins) {
                return strpos(strtolower($skin['name']), strtolower($coins)) !== false;
            });
        }    
        
        $rarityOrder = [
            'rarity_default' => 1,
            'rarity_uncommon' => 2,
            'rarity_rare' => 3,
            'rarity_mythical' => 4,
            'rarity_legendary' => 5,
            'rarity_ancient' => 6,
            'rarity_contraband' => 7,
        ];
        usort($Coins, function ($a, $b) use ($rarityOrder) {
            $aOrder = $rarityOrder[$a['id_rarity']];
            $bOrder = $rarityOrder[$b['id_rarity']];
        
            return $aOrder - $bOrder;
        });

        foreach ($Coins as $Cs) {

            $id = $Cs['id'];
            $name = $Cs['name'];
            $img = $Cs['image'];
            $desc = $Cs['rarity'];
            $rarity = ' ' . $Cs['id_rarity'];

            $choice_active = "";
            $choose_weapon = $this->Translate('_choose_weapon'); # ПЕРЕВОД
            if($ID_user_items['coin'] == $id) {
                $choice_active = " choice_active";
                $choose_weapon = $this->Translate('_choose_default'); # ПЕРЕВОД
            }
    
            $html .= <<<HTML
                            <div class="block-skin-fon{$choice_active}{$rarity}" id="set_coins" id_coins="{$id}">
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
    public function SCSkinChangerCoins(int $type = 1, $server = 0, $team = 0, int $coins = 0)
    {
        if (!is_numeric($server) || intval($server) != $server || $server < 0 || $this->Settings('type') == 1 && $server >= $this->Db->table_count['Skins']) return ['status' => 'error', 'text' => $this->Translate('_nonono')];
        if (!is_numeric($team) || intval($team) != $team || $team > 2 || $team < 0) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

        if(!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];

        if($this->TableSearch()) return ['status' => 'error', 'text' => $this->Translate('_adm_table_no')]; # ПЕРЕВОД
        if($this->TableSearchServer()) return ['status' => 'error', 'text' => $this->Translate('_adm_no_serv')]; # ПЕРЕВОД

        $Coins = $this->get_cache($this->coins);
        $Coins = array_filter($Coins, function($skin) use ($coins) {
            return $skin['id'] == $coins;
        }); 
        $Coins = reset($Coins);
        if(empty($Coins['id']) && $Coins['id'] != $coins) return ['status' => 'error', 'text' => $this->Translate('_error3')]; # ПЕРЕВОД

        if(empty($this->DataDBUser())) return ['status' => 'error', 'text' => $this->Translate('_error1')]; # ПЕРЕВОД

        if ($this->Settings('type') == 1) {
            $teamwp = empty($team) ? 2 : 3;
            $ID_user_items = $this->Db->query('Skins', 0, 0, "SELECT `id` FROM `wp_player_pins` WHERE `steamid` = :steamid AND `weapon_team` = :weapon_team LIMIT 1", [
                'steamid' => $this->DataDBUser(),
                'weapon_team' => $teamwp,
            ]);
        } else if ($this->Settings('type') == 2) {
            $ID_user_items = $this->Db->query('Skins', 0, 0, "SELECT `id`, `coin` FROM `sc_items` WHERE `player_id` = :player_id AND `server_id` = :server AND `team` = :team LIMIT 1", [
                'player_id' => $this->DataDBUser(),
                'server' => $server,
                'team' => $team,
            ]);
        }

        switch($type) {
            case 0:
                if ($this->Settings('type') == 1) {
                    $teamwp = empty($team) ? 2 : 3;
                    if(!empty($ID_user_items)) {            
                        $this->Db->query('Skins', $server, 0, "UPDATE `wp_player_pins` SET `id` = :coin WHERE `steamid` = :id AND `weapon_team` = :weapon_team LIMIT 1", [
                            "id" => $this->DataDBUser(),
                            "coin" => $Coins['id'],
                            'weapon_team' => $teamwp,
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_coins_ch')];
                    } else {
                        $query = "INSERT INTO `wp_player_pins`(`steamid`, `weapon_team`, `id`) 
                        VALUES (:id, :weapon_team, :coin)";
                        $this->Db->query('Skins', $server, 0, $query, [
                            "id" => $this->DataDBUser(),
                            "coin" => $Coins['id'],
                            'weapon_team' => $teamwp,
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_coins_ch')];
                    }
                } else if ($this->Settings('type') == 2) {   
                    if(!empty($ID_user_items['id'])) {
                        $this->Db->query('Skins', 0, 0, "UPDATE `sc_items` SET `coin` = :coin WHERE `id` = :id LIMIT 1", [
                            "id" => $ID_user_items['id'],
                            "coin" => $Coins['id']
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_coins_ch')];
                    } else {
                        $query = "INSERT INTO `sc_items`(`player_id`, `server_id`, `team`, `agent`, `music`, `coin`, `knife`, `glove`) 
                            VALUES (:player_id, :server_id, :team, 0, 0, :coin, 0, 0)";
                        $this->Db->query('Skins', 0, 0, $query, [
                            'player_id' => $ID_user_items['id'],
                            'server_id' => $server,
                            'team' => $team,
                            'coin' => $Coins['id'],

                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_coins_ch')];
                    }
                }
            case 1:
                if ($this->Settings('type') == 1) {
                    if(!empty($ID_user_items)) {
                        $teamwp = empty($team) ? 2 : 3;
                        $this->Db->query('Skins', $server, 0, "UPDATE `wp_player_pins` SET `id` = NULL WHERE `steamid` = :id AND `weapon_team` = :weapon_team LIMIT 1", [
                            "id" => $this->DataDBUser(),
                            "weapon_team" => $teamwp,
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_coins_del')]; # ПЕРЕВОД
                    } else {
                        return ['status' => 'success', 'text' => $this->Translate('_coins_del_all')]; # ПЕРЕВОД
                    }
                } else if ($this->Settings('type') == 2) {   
                    if(!empty($ID_user_items['id'])) {
                        $this->Db->query('Skins', 0, 0, "UPDATE `sc_items` SET `coin` = '0' WHERE `id` = :id LIMIT 1", [
                            "id" => $ID_user_items['id']
                        ]);
                        return ['status' => 'success', 'text' => $this->Translate('_coins_del')]; # ПЕРЕВОД
                    } else {
                        return ['status' => 'success', 'text' => $this->Translate('_coins_del_all')]; # ПЕРЕВОД
                    }
                }
            default:
                return ['status' => 'error', 'text' => $this->Translate('_error2')]; # ПЕРЕВОД
        }
    }
}