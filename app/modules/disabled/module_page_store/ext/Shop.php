<?php

/**
 * @author WizZzarD <artur.rusanov2013@gmail.com>
 *
 * @link https://steamcommunity.com/id/WizzarD_1/
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_store\ext;

require_once "Rcon.php";

use app\modules\module_page_store\ext\Rcon;

class Shop
{
    public $Db;
    public $Translate;
    public $Notifications;
    public $Auth;
    public $General;
    public function __construct($Db, $Translate, $Notifications, $Auth, $General)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->Notifications = $Notifications;
        $this->Auth = $Auth;
        $this->General = $General;
    }

    // Получение кэша
    public function getCache()
    {
        return require MODULES . 'module_page_store/cache/cache.php';
    }
    // Получение настроек
    public function getCart()
    {
        return require MODULES . 'module_page_store/cache/cart.php';
    }
    // Получение логов
    public function getLogs()
    {
        return require MODULES . 'module_page_store/cache/logs_cache.php';
    }
    // Получение скидки
    public function getDiscount()
    {
        return require MODULES . 'module_page_store/cache/discount.php';
    }
    // Изменение кэша
    protected function setCache($cache)
    {
        file_put_contents(MODULES . 'module_page_store/cache/cache.php', '<?php return ' . var_export_opt($cache, true) . ";");
    }
    protected function setCart($promo)
    {
        file_put_contents(MODULES . 'module_page_store/cache/cart.php', '<?php return ' . var_export_opt($promo, true) . ";");
    }
    // Изменение логов
    protected function setLogs($logs)
    {
        file_put_contents(MODULES . 'module_page_store/cache/logs_cache.php', '<?php return ' . var_export_opt($logs, true) . ";");
    }
    // Изменение скидки
    protected function setDiscount($discount)
    {
        file_put_contents(MODULES . 'module_page_store/cache/discount.php', '<?php return ' . var_export_opt($discount, true) . ";");
    }
    // Получение серверов, добавленных в LR
    public function getLrServers()
    {
        return $this->Db->queryAll(
            'Core',
            $this->Db->db_data['Core'][0]['USER_ID'],
            $this->Db->db_data['Core'][0]['DB_num'],
            "SELECT `id`,`name` FROM `lvl_web_servers`"
        );
    }
    // Получение баланса
    public function getBalance()
    {
        if (isset($_SESSION['steamid32'])) {
            preg_match('/:[0-9]{1}:\d+/i', $_SESSION['steamid32'], $auth);
            $param = [
                'auth' => '%' . $auth[0] . '%'
            ];
            $infoUser = $this->Db->queryAll(
                'lk',
                $this->Db->db_data['lk'][0]['USER_ID'],
                $this->Db->db_data['lk'][0]['DB_num'],
                "SELECT cash FROM lk WHERE auth LIKE :auth LIMIT 1",
                $param
            );
            $cash = 'cash';
            if (isset($infoUser[0]))
                return $infoUser[0][$cash];
            else return 0;
        }
    }
    // Получение таблиц
    protected function getServerTable($id, $type = "*")
    {
        switch ($type) {
            case "Stats":
                $type_table = "server_stats";
                break;
            case "Vip":
                $type_table = "server_vip";
                break;
            case "Sb":
                $type_table = "server_sb";
                break;
            default:
                $type_table = "*";
        }
        if ($type_table != "*")
            return explode(";", $this->Db->queryAll(
                'Core',
                $this->Db->db_data['Core'][0]['USER_ID'],
                $this->Db->db_data['Core'][0]['DB_num'],
                "SELECT {$type_table} FROM `lvl_web_servers` WHERE id = :id",
                ['id' => $id]
            )[0][$type_table]);
        else
            return $this->Db->queryAll(
                'Core',
                $this->Db->db_data['Core'][0]['USER_ID'],
                $this->Db->db_data['Core'][0]['DB_num'],
                "SELECT * FROM `lvl_web_servers` WHERE id = :id",
                ['id' => $id]
            )[0];
    }
    // Получение ID сервера для VIP
    protected function getVipServerId($id)
    {
        return $this->Db->queryAll(
            'Core',
            $this->Db->db_data['Core'][0]['USER_ID'],
            $this->Db->db_data['Core'][0]['DB_num'],
            "SELECT * FROM `lvl_web_servers` WHERE id = :id",
            ['id' => $id]
        )[0]['server_vip_id'];
    }
    protected function getIksServerId($id)
    {
        return $this->Db->queryAll(
            'Core',
            $this->Db->db_data['Core'][0]['USER_ID'],
            $this->Db->db_data['Core'][0]['DB_num'],
            "SELECT * FROM `lvl_web_servers` WHERE id = :id",
            ['id' => $id]
        )[0]['server_sb_id'];
    }
    // Обновление баланса
    protected function updateBalance($steam, $price)
    {
        preg_match('/:[0-9]{1}:\d+/i', $steam, $auth);
        $param = ['auth' => '%' . $auth[0] . '%', 'price' => $price];
        $this->Db->queryAll(
            'lk',
            $this->Db->db_data['lk'][0]['USER_ID'],
            $this->Db->db_data['lk'][0]['DB_num'],
            "UPDATE lk SET cash = cash - :price WHERE auth LIKE :auth LIMIT 1",
            $param
        );
        return true;
    }
    // Проверка на наличие VIP группы у пользователя
    protected function checkVipGroup($vip_table, $steam3, $sid, $type)
    {
        $param = [];
        if ($type == 0) {
            $param['sid'] = $sid;
            $param['steam3'] = $steam3;
            $query = "SELECT COUNT(*) FROM {$vip_table[3]}users WHERE account_id = :steam3 AND sid = :sid";
        }
        return $this->Db->queryNum($vip_table[0], $vip_table[1], $vip_table[2], $query, $param)[0] == 1;
    }

    protected function checkIksAdmin($table, $steam)
    {
        $param = ['steam' => $steam];
        return $this->Db->queryNum(
            'IksAdmin',
            $table[1],
            $table[2],
            "SELECT COUNT(*) FROM {$table[3]}admins WHERE `sid` = :steam",
            $param
        )[0] == 1;
    }
    protected function getIksTime($table, $steam, $group)
    {
        $found_user = $this->Db->queryAll($table[0], $table[1], $table[2], "SELECT * FROM {$table[3]}admins WHERE `sid` = :steam", ['steam' => $steam])[0];
        if ($found_user['group_id'] == $group)
            return $found_user['end'];
        else
            return -1;
    }
    protected function deleteIksAdmin($table, $steam)
    {
        $this->Db->query(
            'IksAdmin',
            $table[1],
            $table[2],
            "DELETE FROM {$table[3]}admins WHERE `sid` = :steam",
            ['steam' => $steam]
        );
    }
    // Получение срока длительности VIP привилегии
    protected function getExpiresAndVipGroup($vip_table, $steam3, $sid, $type)
    {
        $param = [];
        if ($type == 0) {
            $param['sid'] = $sid;
            $param['steam3'] = $steam3;
            $query = "SELECT * FROM {$vip_table[3]}users WHERE account_id = :steam3 AND sid = :sid";
        }
        $result = $this->Db->queryAll($vip_table[0], $vip_table[1], $vip_table[2], $query, $param)[0];
        $result['expires'];
        $result['group'];
        return $result;
    }
    // Обновление VIP группы для пользователя
    protected function updateVipGroup($vip_table, $steam3, $sid, $time, $group_name, $type)
    {
        $param  = [
            'group_name' => $group_name,
            'time' => $time
        ];
        if ($type == 0) {
            $param['steam3'] = $steam3;
            $param['sid'] = $sid;
            $query = "UPDATE {$vip_table[3]}users SET `group` = :group_name , `expires` = :time WHERE account_id = :steam3 AND sid = :sid";
        }
        $this->Db->query($vip_table[0], $vip_table[1], $vip_table[2], $query, $param);
    }
    // Добавление пользователю VIP группы
    protected function addVipGroup($vip_table, $steam3, $sid, $time, $group_name, $name, $type)
    {
        $param  = [
            'name' => $name,
            'group_name' => $group_name,
            'time' => $time,
        ];
        if ($type == 0) {
            $param['steam3'] = $steam3;
            $param['lastvisit'] = time();
            $param['sid'] = $sid;
            $query = "INSERT INTO {$vip_table[3]}users (`account_id`, `name`, `lastvisit`, `sid`, `group`, `expires`) 
                      VALUES (:steam3, :name, :lastvisit, :sid, :group_name, :time)";
        }
        $this->Db->query($vip_table[0], $vip_table[1], $vip_table[2], $query, $param);
    }
    protected function addIksAdmin($table, $server, $steam, $name, $time, $group_id, $server_sb_id)
    {
        $AdminAdd = [
            "steamid"            => $steam,
            "name"               => empty($this->General->checkName($steam)) ? $name : $this->General->checkName($steam),
            "flags"              => '',
            "immunity"           => -1,
            "end"                => $time,
            "server_id"          => $server_sb_id,
            "group_id"           => $group_id,
        ];

        $this->Db->query('IksAdmin', $table[1], $table[2], "INSERT INTO `{$table[3]}admins` (`sid`, `name`, `flags`, `immunity`, `group_id`, `end`, `server_id`) VALUES (:steamid, :name, :flags, :immunity, :group_id, :end, :server_id);", $AdminAdd);
    }
    // Изменение VIP группы
    protected function changeVipGroup($shop, $sid, $id, $name, $time, $steam3)
    {
        if (empty($this->Db->db_data['Vips']))
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorNoVips')
            );
        if (!isset($shop[$sid][$id]['group_name']))
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorGroup')
            );

        $type = $shop[$sid][$id]['type'];
        $table = $this->getServerTable($shop[$sid]['id'], "Vip");
        $sid_vip = $this->getVipServerId($shop[$sid]['id']);

        if ($this->checkVipGroup($table, $steam3, $sid_vip, $type)) {
            $info_privilage = $this->getExpiresAndVipGroup($table, $steam3, $sid_vip, $type);
            if ($info_privilage['group'] == $shop[$sid][$id]['group_name'])
                if ($info_privilage['expires'] == 0 || $time == 0)
                    $time = 0;
                else
                    $time += $info_privilage['expires'] - time();
            $this->updateVipGroup($table, $steam3, $sid_vip, $time, $shop[$sid][$id]['group_name'], $type);
        } else {
            $this->addVipGroup($table, $steam3, $sid_vip, $time, $shop[$sid][$id]['group_name'], $name, $type);
        }
        if ($type == 0) {
            $response = $this->Rcons($shop[$sid]['id'], "css_vip_updateuser {$steam3}");
        }
        if ($response == 'error') {
            return array(
                "type" => 'success',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_successWithOutRcon')
            );
        }
        return array(
            "type" => 'success',
            "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_success') . $shop[$server][$cid][$id]['group_name']
        );
    }

    protected function changeIksAdmin($shop, $server, $id, $steam, $name, $time)
    {
        if (empty($this->Db->db_data['IksAdmin']))
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorNoSb')
            );
        if ($shop[$server][$id]['group_name'] == '')
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorGroup') . $shop[$server][$id]['group_name'] . "fd"
            );
        if (!isset($shop[$server]['sb_id']))
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorIdAdmin')
            );
        $group_srv = $shop[$server][$id]['group_name'];
        $table = $this->getServerTable($shop[$server]['id'], "Sb");

        if ($this->checkIksAdmin($table, $steam)) {
            $found_time = $this->getIksTime($table, $steam, $group_srv);
            if ($found_time == 0)
                $time = 0;
            else if ($found_time != -1 && $time != 0) {
                $time += $found_time - time();
            }
            $this->deleteIksAdmin($table, $steam);
        }
        $this->addIksAdmin($table, $shop[$server][$id]['id'], $steam, $name, $time, $group_srv, $shop[$server]['sb_id']);
        $response = $this->Rcons($shop[$server]['id'], 'css_reload_admins');
        if ($response == 'error') {
            return array(
                "type" => 'success',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_successWithOutRcon')
            );
        }
        return array(
            "type" => 'success',
            "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_success') . $shop[$server][$id]['group_name']
        );
    }
    // Покупка SHOP кредитов хзшка FIX MB
    protected function buyShopCredits($id, $amount, $steam)
    {
        $steam[6] = 1;
        $response = $this->Rcons($id, 'sm_shop_givecredits "' . $steam . '" ' . $amount);
        if ($response == 'error') {
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorBuyAmount')
            );
        } else {
            return array(
                "type" => 'success',
                "result"  => $this->Translate->get_translate_module_phrase('module_page_store', '_successShopCred') . $amount . " " . $this->Translate->get_translate_module_phrase('module_page_store', '_credits_name')
            );
        }
    }
    // Кастомная RCON команда 
    protected function sendRconCommand($sid, $command, $steam, $name, $time)
    {
        $steam3 = con_steam32to3_int($steam);
        $steam64 = con_steam32to64($steam);
        $steam32_0 = $steam;
        $steam32_0[6] = 0;
        $steam32_1 = $steam;
        $steam32_1[6] = 1;
        $command = str_replace("%n",   $name,      $command);
        $command = str_replace("%s0",  $steam32_0, $command);
        $command = str_replace("%s1",  $steam32_1, $command);
        $command = str_replace("%s3",  $steam3,    $command);
        $command = str_replace("%s64", $steam64,   $command);
        $command = str_replace("%t",   $time,      $command);
        $response = $this->Rcons($sid, $command);
        if ($response == 'error') {
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorCommand')
            );
        } else {
            return array(
                "type" => 'success',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_successCommand')
            );
        }
    }
    // Покупка LR опыта
    protected function buyLrExp($id, $steam, $amount)
    {
        $stats_table = $this->getServerTable($id, "Stats");
        if ($this->Db->queryNum(
            $stats_table[0],
            $stats_table[1],
            $stats_table[2],
            "SELECT COUNT('*') FROM `{$stats_table[3]}` WHERE steam = :steam",
            ['steam' => $steam]
        )[0] == 1) {
            $steam[6] = 1;
            $response = $this->Rcons($id, "lr_giveexp \"" . $steam . "\" \"" . $amount . "\"");
            if ($response == "error") {
                return array(
                    "type" => 'error',
                    "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorCommand')
                );
            } else {
                return array(
                    "type" => 'success',
                    "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_successExpBuy')
                );
            }
        } else {
            return array(
                "type" => 'error',
                "result" => $this->Translate->get_translate_module_phrase('module_page_store', '_errorNoUserInLr')
            );
        }
    }
    // Отправка уведомления
    protected function sendNotifications($steam, $translate_text, $param, $icon)
    {
        $this->Notifications->SendNotification(
            $steam,
            '_SHOP',
            $translate_text,
            [
                'param' => $param,
                'module_translation' => 'module_page_store'
            ],
            '',
            'store',
            ''
        );
    }
    // RCON запрос 
    protected function Rcons($sid, $command)
    {
        $params = ['sid'    => $sid];
        $_Server_Info = $this->Db->queryAll('Core', 0, 0, 'SELECT * FROM lvl_web_servers WHERE id = :sid', $params);
        if (empty($_Server_Info[0]['ip'])) return "error";
        $_IP = explode(':', $_Server_Info[0]['ip']);
        $_RCON = new Rcon($_IP[0], $_IP[1]);
        if ($_RCON->Connect()) {
            $_RCON->RconPass($_Server_Info[0]['rcon']);
            $_RCON->Command($command);
            $_RCON->Disconnect();
        } else {
            return "error";
        }
        return "success";
    }
    // Установка скидки
    public function changeDiscount($post)
    {
        $discount = $this->getDiscount();
        $discount['discount'] = $post['value'];
        $this->setDiscount($discount);
        return array("success" => $this->Translate->get_translate_module_phrase('module_page_store', '_discount_installed'));
    }
    public function changeWebhook($post)
    {
        $discount = $this->getDiscount();
        $discount['webhook'] = $post['value'];
        $this->setDiscount($discount);
        return array("success" => 'Webhook добавлен!');
    }
    public function changeWebhookColor($post)
    {
        $discount = $this->getDiscount();
        $discount['webhookcolor'] = $post['value'];
        $this->setDiscount($discount);
        return array("success" => 'Цвет Webhook изменен!');
    }
    // Добавление логов
    protected function addLog($steam, $shop, $sid, $id, $price, $status)
    {
        $logs = $this->getLogs();
        date_default_timezone_set('Europe/Moscow');
        $arr = array(
            'date' => date("d.m.Y H:i:s"),
            'steam' => con_steam32to64($steam),
            'title' => $shop[$sid][$id]['title'],
            'price' => $price,
            'status' => $status
        );
        $logs[] = $arr;
        $this->setLogs($logs);
        if ($status == 'Успех!') {
            $ds = "{$this->getDiscount()['webhook']}";
            $steam64 = con_steam32to64($steam);
            $json = json_encode([
                "username" => $this->General->checkName($steam64),
                "avatar_url" => "{$this->General->getAvatar($steam64, 1)}",
                "file" => "content",
                "embeds" =>
                [
                    [
                        "title" => "",
                        "color"    => hexdec("6080ff"),
                        "description" => "",
                        "timestamp" => null,
                        "fields" =>
                        [
                            [
                                "name" => ":wrench: Действие",
                                "value" => "```Покупка товара```",
                                "inline" => true,
                            ],
                            [
                                "name" => ":pencil: SteamID",
                                "value" => "```" . $steam64 . "```",
                                "inline" => true,
                            ],
                            [
                                "name" => ":star: Товар",
                                "value" => "```" . $shop[$sid][$id]['title'] . "```",
                                "inline" => true,
                            ],
                            [
                                "name" => ":money_with_wings: Цена",
                                "value" => "```" . $price . "```",
                                "inline" => false,
                            ],
                            [
                                "name" => ":man_detective: Покупатель",
                                "value" => "[" . $this->General->checkName($steam64) . "](http:" . $this->General->arr_general['site'] . "/profiles/" . $steam64 . "/?search=1)",
                                "inline" => true,
                            ],
                        ],
                    ],
                ],
            ]);
            $cl = curl_init($ds);
            curl_setopt($cl, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($cl, CURLOPT_POST, 1);
            curl_setopt($cl, CURLOPT_POSTFIELDS, $json);
            curl_exec($cl);
        }
    }
    // Распределитель
    public function shopDistributor($post)
    {
        $cart = $this->getCart();
        if (!empty($post['steam'])) {
            if (preg_match('/^STEAM_1:[0-1]:\d+$/', $post['steam'])){
                $name = "Unknown";
                $steam = $post['steam'];
            } else if (preg_match('/^(7656119)([0-9]{10})$/', $post['steam'])) {
                $name = "Unknown";
                $steam = con_steam64to32($post['steam']);
            } else if (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $post['steam'])) {
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $post['steam']), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
                $name = "Unknown";
                $steam = con_steam64to32($getsearch);
            } else if (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $post['steam'])) {
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $post['steam']), "/");
                $name = "Unknown";
                $steam = con_steam64to32($search_steam);
            } else if (preg_match('/^\[U:(.*)\:(.*)\]$/', $post['steam'])) {
                $name = "Unknown";
                $steam = con_steam3to32_int(str_replace(Array('[U:1:', '[U:0:', ']'), '', $post['steam']));           
            } 
            else {return array('error' => $this->Translate->get_translate_module_phrase('module_page_store', '_SteamErrorSosi'));}
        } else {
            $name = empty($this->General->checkName($_SESSION['steamid64'])) ? 'Unknown' : $this->General->checkName($_SESSION['steamid64']);
            $steam = $_SESSION['steamid32'];
        }
        $sum_price = 0;
        $balance = $this->getBalance();
        $discount = $this->getDiscount()['discount'];
        if (empty($_SESSION['steamid32']))  return array('error' => $this->Translate->get_translate_module_phrase('module_page_store', '_auth'));
        if (!isset($cart[$_SESSION['steamid32']]) || empty($_SESSION['steamid32']))
            return array('error' => $this->Translate->get_translate_module_phrase('module_page_store', '_error_cart_is_empty'));
        foreach ($cart[$_SESSION['steamid32']] as $product) {
            $sum_price += $product['price'];
        }
        if ($sum_price - ($sum_price * $discount / 100) > $balance) {
            return array('noBalance' => $this->Translate->get_translate_module_phrase('module_page_store', '_noBalance1') . $balance . $this->Translate->get_translate_module_phrase('module_page_store', '_noBalance2'));
        }
        $flag = "success";
        $output_string = "";
        foreach ($cart[$_SESSION['steamid32']] as $product) {
            $price_promo_discount = ceil($product['price'] * (1 - $discount / 100));
            $result = $this->shopHandler($product['server'], $product['product'], $steam, $price_promo_discount, $name);
            if ($result['type'] == 'error')
                $flag = "error";
            $output_string .= $result['result'];
        }
        $this->emptyBasket();
        return array($flag => $output_string);
    }
    // Обработчик типов продуктов
    public function shopHandler($sid, $id, $steam, $price, $name)
    {
        $shop = $this->getCache();
        $steam3 = con_steam32to3_int($steam);
        $new_time = $shop[$sid][$id]['time'] != 0 ? time() + $shop[$sid][$id]['time'] * 24 * 60 * 60 : 0;
        if ($shop[$sid][$id]['type'] == 0) {
            $result = $this->changeVipGroup($shop, $sid, $id, $name, $new_time, $steam3);
            if ($result['type'] == 'success')
                $this->sendNotifications($steam, '_successNot', $shop[$sid][$id]['group_name'], 'notifications');
        } else if ($shop[$sid][$id]['type'] == 1) { //FIX
            $result = $this->changeIksAdmin($shop, $sid, $id, con_steam32to64($steam), $name, $new_time);
            if ($result['type'] == 'success')
                $this->sendNotifications($steam, '_successNot', $shop[$sid][$id]['group_name'], 'notifications');
        } else if ($shop[$sid][$id]['type'] == 2) { // FIX
            $result = $this->buyShopCredits($shop[$sid]['id'], $shop[$sid][$id]['amount'], $steam);
            if ($result['type'] == 'success')
                $this->sendNotifications($steam, '_successCred', $shop[$sid][$id]['amount'], 'notifications');
        } else if ($shop[$sid][$id]['type'] == 3) {
            $result = $this->buyLrExp($shop[$sid]['id'], $steam, $shop[$sid][$id]['amount']);
            if ($result['type'] == 'success')
                $this->sendNotifications($steam, '_successExp', $shop[$sid][$id]['amount'], 'notifications');
        } else if ($shop[$sid][$id]['type'] == 4) {
            $result = $this->sendRconCommand($shop[$sid]['id'], $shop[$sid][$id]['group_name'], $steam, $name, $new_time);
            if ($result['type'] == 'success')
                $this->sendNotifications($steam, '_successCommand', "", 'notifications');
        }
        if ($result['type'] == 'success') {
            $this->updateBalance($_SESSION['steamid32'], $price);
        }
        $status = $result['type'] == 'success' ? $this->Translate->get_translate_module_phrase('module_page_store', '_successB') : $this->Translate->get_translate_module_phrase('module_page_store', '_errorB');
        $this->addLog($steam, $shop, $sid, $id, $price, $status);
        return $result;
    }
    // Добавление нового сервера
    public function addServer($post)
    {
        if ($post['add_server'] != 'all') {
            $server_lr = $this->Db->queryAll(
                'Core',
                $this->Db->db_data['Core'][0]['USER_ID'],
                $this->Db->db_data['Core'][0]['DB_num'],
                "SELECT `name` FROM `lvl_web_servers` WHERE id = :server_lr_id",
                ['server_lr_id' => $post['add_server']]
            )[0];
            $server_name = !empty($post['shop_custom_name_server']) ? $post['shop_custom_name_server'] : $server_lr['name'];
            $all_servers = 0;
        } else {
            $server_name = !empty($post['shop_custom_name_server']) ? $post['shop_custom_name_server'] : $this->Translate->get_translate_module_phrase('module_page_store', '_allServers');
            $all_servers = 1;
        }
        $cache = $this->getCache();
        foreach ($cache as $server) {
            if ($server['id'] == $post['add_server']) {
                return array('error' => $this->Translate->get_translate_module_phrase('module_page_store', '_errorServerIsCreated'));
            }
        }
        $arr = array(
            "id" => $post['add_server'],
            "name" => $server_name,
            "sb_id" => $this->getIksServerId($post['add_server']),
            "all_servers" => $all_servers
        );
        $cache[] = $arr;
        $this->setCache($cache);
        $this->setCart(array());
        return array('success' => $this->Translate->get_translate_module_phrase('module_page_store', '_successServerCreate'));
    }
    // Удаление сервера
    public function deleteServer($post)
    {
        $cache = $this->getCache();
        if (empty($cache[$post['param']])) {
            return array('error' => $this->Translate->get_translate_module_phrase('module_page_store', '_errorAll'));
        }
        unset($cache[$post['param']]);
        $this->setCache($cache);
        $this->setCart(array());
        return array('success' => $this->Translate->get_translate_module_phrase('module_page_store', '_successDeletedServer'));
    }
    // Добавление товара
    public function addProduct($post)
    {
        if (!isset($post['web-group']))      $post['web-group'] = -1;
        $cache = $this->getCache();
        $group_name = empty($post['group_card']) ? $post['rcon'] : $post['group_card'];
        $arr = array(
            "type" => $post['type_card'],
            "title" => $post['title_card'] ?? "",
            "description" => $post['description_card'] ?? "",
            "image" => $post['image_path'] ?? "storage/cache/img/global/bar-logo.jpg",
            "price" => $post['price_card'] ?? "0",
            "value" => $post['value_card'] ?? "руб.",
            "value_type" => "",
            "time" => $post['time_card'],
            "group_name" => $group_name ?? "",
            'amount' => $post['amount_card'] ?? "",
            "info" => "",
            "active_info" => 0
        );
        $cache[$post['param']][] = $arr;
        $this->setCache($cache);
        $this->setCart(array());
        return array('success' => $this->Translate->get_translate_module_phrase('module_page_store', '_successCreatedPrivilage'));
    }
    // Удаление товара
    public function deleteProduct($post_delete)
    {
        $cache = $this->getCache();
        $post = explode(" ", $post_delete['param']);
        unset($cache[$post[0]][$post[1]]);
        $this->setCache($cache);
        $this->setCart(array());
        return array('success' => $this->Translate->get_translate_module_phrase('module_page_store', '_successDeletedPrivilage'));
    }
    // Получение данных о продукте
    public function editAjaxProduct($post)
    {
        $cache = $this->getCache();
        $param = explode(" ", $post['param']);
        $result['edit'] = $cache[$param[0]][$param[1]];
        return $result;
    }
    // Изменение данных о продукте
    public function editProduct($post)
    {
        $cache = $this->getCache();
        $param = explode(" ", $post['param']);
        $group_name = empty($post['group_edit_card']) ? $post['rcon_edit_command'] : $post['group_edit_card'];
        $cache[$param[0]][$param[1]]['type'] = $post['type_edit_card'];
        $cache[$param[0]][$param[1]]['title'] = $post['title_edit_card'];
        $cache[$param[0]][$param[1]]['description'] = $post['description_edit_card'];
        $cache[$param[0]][$param[1]]['image'] = $post['image_edit_path'] ?? "storage/cache/img/global/bar-logo.jpg";
        $cache[$param[0]][$param[1]]['price'] = $post['price_edit_card'] ?? "0";
        $cache[$param[0]][$param[1]]['value'] = $post['value_edit_card'] ?? "руб.";
        $cache[$param[0]][$param[1]]['time'] = $post['time_edit_card'];
        $cache[$param[0]][$param[1]]['group_name'] = $group_name;
        $this->setCache($cache);
        return array('success' => $this->Translate->get_translate_module_phrase('module_page_store', '_successChangedPrivilage'));
    }
    // Удаление товара из корзины
    public function cleanBasket($post)
    {
        $cart = $this->getCart();
        unset($cart[$_SESSION['steamid32']][$post['param']]);
        $this->setCart($cart);
        return array('clean' => 1);
    }
    // Очистка корзины
    public function emptyBasket()
    {
        $this->setCart(array());
        return array('clean' => 1);
    }
    // Добавление товара в корзину
    public function addProductInCart($post)
    {
        if (empty($_SESSION['steamid32']))
            return array('error' => $this->Translate->get_translate_module_phrase('module_page_shop', '_auth'));
        $cart = $this->getCart();
        $cache = $this->getCache();
        $sid = explode(" ", $post['param'])[0];
        $id = explode(" ", $post['param'])[1];
        $discount = $this->getDiscount()['discount'];
        if (isset($cart[$_SESSION['steamid32']]))
            foreach ($cart[$_SESSION['steamid32']] as $product)
                if ($product['server'] == $sid && $product['product'] == $id)
                    return array('error' => $this->Translate->get_translate_module_phrase('module_page_shop', '_addedCartNow'));
        $arr = array(
            'server' => $sid,
            'product' => $id,
            'title' => $cache[$sid][$id]['title'],
            'description' => $cache[$sid][$id]['description'],
            'price' => $cache[$sid][$id]['price'],
            'value' => $cache[$sid][$id]['value'],
            'count' => 1
        );
        $cartState = !isset($cart[$_SESSION['steamid32']]) || empty($cart[$_SESSION['steamid32']]) ? 0 : 1;
        $cart[$_SESSION['steamid32']][] = $arr;
        $this->setCart($cart);
        $arr['translate'] = $this->Translate->get_translate_module_phrase('module_page_shop', '_addProductInCart');
        end($cart[$_SESSION['steamid32']]);
        $key = key($cart[$_SESSION['steamid32']]);
        $arr['key'] = $key;
        $arr['cartState'] = $cartState;
        $arr['price'] -= $arr['price'] * $discount / 100;
        return array('addProductCart' => $arr);
    }
}
