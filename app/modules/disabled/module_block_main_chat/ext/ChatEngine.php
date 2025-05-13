<?php namespace app\modules\module_block_main_chat\ext;

class ChatEngine
{
    protected $chat, $bans, $roles, $General, $Translate;
	private $extension, $bot = [];

    public function __construct($General, $Translate)
    {
        $this->General      = $General;
        $this->Translate    = $Translate;
        $this->extension    = extension_loaded('msgpack') ? 'cache' : 'json';
        $this->chat         = MODULES . "module_block_main_chat/temp/messages.{$this->extension}";
        $this->bans         = MODULES . "module_block_main_chat/temp/bans.{$this->extension}";
        $this->roles        = MODULES . "module_block_main_chat/temp/roles.{$this->extension}";
    }

    # Кэш чата вывести
    private function get_cache($id)
    {
        $packed_data = file_get_contents($id);
        return $this->extension === 'cache' ? msgpack_unpack($packed_data) : json_decode($packed_data, true);
    }

    # Кэш чата сохранить
    private function put_cache($id, $arr)
    {
        $packed_data = $this->extension === 'cache' ?
            msgpack_pack(array('data' => $arr, 'timestamp' => time())) :
            json_encode(array('data' => $arr, 'timestamp' => time()));
        
        file_put_contents($id, $packed_data);
        return;
    }

    # Интересная функция для времени
    public function FormatDateTime($datetime) {
        $currentDate = date("Y-m-d");
        $yesterdayDate = date("Y-m-d", strtotime("-1 day"));
        if ($datetime >= strtotime($currentDate)) {
            $formattedDateTime = $this->Translate('_chat_date_today') . date("H:i", $datetime);
        } elseif ($datetime >= strtotime($yesterdayDate)) {
            $formattedDateTime = $this->Translate('_chat_yesterday') . date("H:i", $datetime);
        } else {
            $formattedDateTime = date("d.m.Y, ", $datetime) . $this->Translate('_chat_preposition_b') . date(" H:i", $datetime);
        }    
        return $formattedDateTime;
    }


    # Уникальный ID
    public function assignUserIdByIP($ip) {
        $ipAddress = $ip;
        $ipInteger = crc32($ipAddress);
        $userId = $ipInteger % 1000;
        return $userId;
    }

    # Узнать ID последнего сообщения
    public static function array_key_last($array)
    {
        if (!is_array($array) || empty($array)) {
            return NULL;
        }
        return array_keys($array)[count($array) - 1];
    }

    # Проверка на обновление (true/false)
    public function update_check($time) {
        $time_chat = $this->get_cache($this->chat)['timestamp'];
        if ($time_chat == $time) {
            return "false";
        } return "true";
    }

    # Количество сообщений общее
    public function count_msg() {
        return count($this->get_cache($this->chat)['data']);
    }

    # Вывод всех сообщений
    public function get_html_msgs($CountMessages = 0, $TypeMessages = 0)
    {
        $html = "";
        $msgs = $this->get_cache($this->chat)['data'];
        $time_cache = $this->get_cache($this->chat)['timestamp'];
        $role = $this->get_cache($this->roles)['data'];
        $steam = isset($_SESSION['steamid64']) ? $_SESSION['steamid64'] : null;
        $support = isset($_SESSION['sb_support']) || isset($_SESSION['user_admin']);

        if (sizeof($msgs) >= 1) {

            $count_last = $this->count_msg() - $CountMessages;

            switch(true) {
                case($TypeMessages == 1):
                    $msgs = array_slice($msgs, -1, 1);
                    break;
                case($CountMessages > 0 AND $count_last < 10):
                    $msgs = array_slice($msgs, 0, $count_last);
                    break;
                case($CountMessages > 0):
                    $msgs = array_slice($msgs, -$CountMessages - 10, 10);
                    break;
                default:
                    $msgs = array_slice($msgs, -10);
                    break;  
            }

            $patterns = [
                "#\w{1,}:\/\/\S{1,}#" => '<a target="_blank" class="a-text-href" href="$0">$0</a>',
                "#[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]{1,5}#" => '<a class="a-text-href" href="steam://connect/$0">$0</a>',
                "#\s(www\.\S+\.severskyray\.ru)#" => '<a target="_blank" class="a-text-href" href="https://$1">$1</a>',
                "#\[(id|club)(\d+)\|([^\]]+)\]#" => '<a target="_blank" class="a-text-href" href="https://vk.com/$1$2">$3</a>',
                "/[\x{1F000}-\x{1FFFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u" => "<emoji>$0</emoji>",
            ];
            
            foreach ($msgs as $val) {

                $textchat = $val['msg']; # выделение ссылок от $patterns

                foreach ($patterns as $pattern => $replacement) {
                    $textchat = preg_replace($pattern, $replacement, $textchat);
                }

                $time = $val['time']; # время сообщения
                $ip = $val['ip']; # ip пользователя
                $id_msg = $val['id']-1;
                $steamid = ($val['steam'] == 'no_steam') ? $ip : $val['steam']; # steam id пользователя
                $myclass = ($steam == $steamid) ? "_my" : ""; # проверка на мои сообщения
                $avatar = ($steamid == 'bot_steam') ? '/' . MODULES . "module_block_main_chat/assets/img/bot.webp" : $this->General->getAvatar($steamid, 1); # вывод аватарки
                $nickname = ($steamid == 'bot_steam') ? "Assistant" : (($steamid == $ip) ? "Player #{$this->assignUserIdByIP($ip)}" : htmlspecialchars(action_text_trim($this->General->checkName($steamid), 20))); # вывод никнейма
                $urllink = ($steamid == 'bot_steam') ? "" : (($steamid == $ip) ? "" : "target='_blank' href='/profiles/{$steamid}/?search=1'");
                $mentionjs = ($steamid == 'bot_steam') ? "" : (($steamid == $ip) ? (($support) ? "<a class='mention_chat' data-tooltip-js='srv-{$steamid}' data-mention='{$steamid}'>IP</a>" : "") : "<a class='mention_chat' data-tooltip-js='srv-{$steamid}' data-mention='{$steamid}'>{$this->Translate('_chat_mention')}</a>"); # вывод js упоминания
                $chatrole = array_key_exists($steamid, $role) ? "<b class='chat_role' style='color: {$role[$steamid]['color']}'>{$role[$steamid]['title']}</b>" : ''; # массив для вывода роли
                $nicknamechatrole = ($steam == $steamid) ? "<div>{$chatrole}</div><a {$urllink} class='chat_nickname'>{$nickname}</a>" : "<a {$urllink} class='chat_nickname'>{$nickname}</a>{$chatrole}"; # вывод никнейма и роли
                $deletebutton = ($steamid == $steam || $support) ? "<a class='del_chat' id_del_chat='" . $id_msg . "'>{$this->Translate('_chat_delete')}</a>" : ''; # вывод управления сообщением
                
                $html .= <<<HTML
                    <div class="chat_message{$myclass}">
                        <div class="padding">
                            <a $urllink>
                                <img src="{$avatar}">
                            </a>
                            <div class="chat_info">
                                {$nicknamechatrole}
                            </div>
                            <div class="chat_message_content">{$textchat}</div>
                            <div class="chat_message_date">
                                <stats>{$this->FormatDateTime($time)}</stats>{$mentionjs}{$deletebutton} 
                            </div>
                        </div>
                    </div>         
                HTML;
            }
            return json_encode(["html" => $html, "count" => $this->count_msg(), "timestamp" => $time_cache]);
        }
        return json_encode(["html" => '<a class="chat_no_msg">'. $this->Translate('_chat_no_msg') . '</a>', "timestamp" => $time_cache]);
    }

    # Проверка текста
    public function send_msg($msg)
    {
        # Проверка на мут в чате
        $cache = $this->get_cache($this->bans)['data'];
        $steam = $_SESSION['steamid64'] ?? $this->General->get_client_ip_cdn();
        if (isset($cache[$steam]) && $cache[$steam]['time_end'] >= time()) {
            $text = $this->Translate('_chat_mute_1') . date("d.m.Y (H:i)", $cache[$steam]['time_end']) . $this->Translate('_chat_mute_2') . $cache[$steam]['reason'];
            return json_encode(array('status' => "error", 'text' => $text));
        }
        # Проверка на доступ к командами
        if(isset($_SESSION['sb_support']) || isset($_SESSION['user_admin'])) {
            $this->commands($msg);
            if($this->commands($msg) == "false") {
                return json_encode(array('status' => "error", 'text' => $this->Translate('_chat_error_command')));
            }
        }
        # Проверка на пустоту
        if (!trim($msg)) {
            return json_encode(array('status' => "error", 'text' => $this->Translate('_chat_error_emput')));
        }
        # Проверка на ограничение букв
        if (mb_strlen($msg) > 500) {
            return json_encode(array('status' => "error", 'text' => $this->Translate('_chat_error_500')));
        }
        # Выполнение отправки сообщения
        $msgs = $this->get_cache($this->chat)['data'];
        $msg = htmlentities($msg);
        $id = (empty($msgs)) ? 1 : $msgs[$this->array_key_last($msgs)]['id'] + 1;
        $msg = $this->get_mentions($msg);
        $newMessage = [
            "ip"    => $this->General->get_client_ip_cdn(),
            "time"  => time(),
            "msg"   => $msg,
            "id"    => $id,
        ];
        if (!empty($this->bot)) {
            $newMessage["steam"] = 'bot_steam';
            $newMessage["msg"] = $this->bot['text'];
        } else if ($steam == $_SESSION['steamid64']) {
            $newMessage["steam"] = $_SESSION['steamid64'];
        } else if ($steam == $this->General->get_client_ip_cdn()) {
            $newMessage["steam"] = 'no_steam';
        }
        $msgs[] = $newMessage;
        $this->put_cache($this->chat, $msgs);
        return true;     
    }    

    # Функция для выделения в чата
    private function get_mentions(string $msg)
    {
        if (preg_match_all('/@(\d+)|@(STEAM_[0-9]:[0-1]:\d+)|@\[U:1:(\d+)\]|@(https?:\/\/steamcommunity\.com\/(?:id|profiles)\/\w+)/', $msg, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $number = null;
                if (!empty($match[1])) {
                    $number = $match[1];
                } elseif (!empty($match[2])) {
                    $number = $match[2];
                } elseif (!empty($match[3])) {
                    $number = $match[3];
                } elseif (!empty($match[4])) {
                    $number = $match[4];
                }
                $steam = $this->DefineSteam64($number);
                if (!empty($steam)) {
                    $msg = str_replace("@" . $number, "<a id_time='". time() ."' id_steam='" . $steam . "' target='_blank' href='/profiles/" . $steam . "/?search=1'>" . htmlspecialchars($this->General->checkName($steam)) . "</a>", $msg);
                }
            }
        }
        return $msg;        
    }

    # Команды для бота...
    private function commands(string $msg)
    {
        $args = preg_split('/\s+(?=(?:(?:[^"]*"){2})*[^"]*$)/', $msg);
        foreach ($args as &$arg) {
            $arg = trim($arg, '"');
        }
        $command = strtolower($args[0]);
        $commandMap = [
            '!role' => function ($args) {
                if (count($args) >= 4) {
                    $steamId = $args[1];
                    $text = $args[2];
                    $color = $args[3];
                    $roles = $this->get_cache($this->roles)['data'];
                    $roles[$steamId] = array(
                        "title" => $text,
                        "color" => $color
                    );
                    $this->bot = ["text" => "<a id_time='". time() ."' id_steam='" . $steamId . "' target='_blank' href='/profiles/" . $steamId . "/?search=1'>" . htmlspecialchars($this->General->checkName($steamId)) . "</a>, " . $this->Translate('_chat_add_role') . " <a style='color: ". $color ."'>". $text ."</a>"];
                    $this->put_cache($this->roles, $roles);
                } else {
                    return "false";
                }
            },
            '!-role' => function ($args) {
                if (count($args) === 2) {
                    $steamId = $args[1];
                    $roles = $this->get_cache($this->roles)['data'];
                    if (isset($roles[$steamId])) {
                        unset($roles[$steamId]);
                        $this->put_cache($this->roles, $roles);
                    }
                    $this->bot = ["text" => "<a id_time='". time() ."' id_steam='" . $steamId . "' target='_blank' href='/profiles/" . $steamId . "/?search=1'>" . htmlspecialchars($this->General->checkName($steamId)) . "</a>, " . $this->Translate('_chat_del_role')];
                } else {
                    return "false";
                }
            },
            '!mute' => function ($args) {
                if (count($args) >= 4) {
                    $steamId = $args[1];
                    $time = $args[2];
                    $reason = $args[3];
                    $bans = $this->get_cache($this->bans)['data'];
                    $bans[$steamId] = array(
                        "reason" => $reason,
                        "time_start" => time(),
                        "time_end" => time() + $time
                    );
                    $this->bot = ["text" => "<a id_time='". time() ."' id_steam='" . $steamId . "' target='_blank' href='/profiles/" . $steamId . "/?search=1'>" . htmlspecialchars($this->General->checkName($steamId)) . "</a>, " . $this->Translate('_chat_add_mute') . date("d.m.Y (H:i)", time() + $time) . $this->Translate('_chat_mute_2') . $reason];
                    $this->put_cache($this->bans, $bans);
                } else {
                    return "false";
                }
            },
            '!-mute' => function ($args) {
                if (count($args) === 2) {
                    $steamId = $args[1];
                    $bans = $this->get_cache($this->bans)['data'];
                    if (isset($bans[$steamId])) {
                        unset($bans[$steamId]);
                        $this->put_cache($this->bans, $bans);
                    }
                    $this->bot = ["text" => "<a id_time='". time() ."' id_steam='" . $steamId . "' target='_blank' href='/profiles/" .$steamId . "/?search=1'>" . htmlspecialchars($this->General->checkName($steamId)) . "</a>, " . $this->Translate('_chat_del_mute')];
                } else {
                    return "false";
                }
            },
        ]; 
        if (isset($commandMap[$command])) {
            $callback = $commandMap[$command];
            $callback($args);
        }
    }
    
    # Фунция для удаление сообщения
    public function delete_msg($id)
    {
        $cache = $this->get_cache($this->chat)['data'];
        $Admin = isset($_SESSION['sb_support']) || isset($_SESSION['user_admin']);
        if($Admin && !empty($cache[$id])) {
            unset($cache[$id]);
        }
        elseif($cache[$id]["steam"] == $_SESSION['steamid64']) {
            unset($cache[$id]);
        }
        else {
            return json_encode(array('status' => 'error', 'text' => $this->Translate('_chat_error')));
        }
        $this->put_cache($this->chat, $cache);
        return json_encode(array('status' => 'info', 'text' => $this->Translate('_chat_delete_msg') . $id));
    }

    # Функция для вывода онлайна
    public function get_onlines(array $post = [])
    {
        if(!empty($post))
        {
            if(!empty($post['prev']) && !empty($post['count']))
            {
                $check = $this->General->Db->query("Core", 0, 0, "SELECT `user` FROM `lr_web_online` WHERE `user` = :steam LIMIT 1", ['steam' => con_steam64to32($post['prev'])]);
                if(!empty($check))
                {
                    if($post['count'] == $this->General->Db->queryNum("Core", 0, 0, "SELECT COUNT(*) FROM `lr_web_online` WHERE `user` != 'guest' LIMIT 1")[0])
                    return;
                }
            }
        }
        $html = '';
        $query = $this->General->Db->queryAll("Core", 0, 0, "SELECT `user` FROM `lr_web_online` WHERE `user` != 'guest' GROUP BY `user` LIMIT 10");
        foreach ($query as $row) {
            $steamID = con_steam32to64($row['user']);
            $avatar = $this->General->getAvatar($steamID, 1);
            $name = $this->General->checkName($steamID);
            $html .= "<img class='ava' data-tippy-content='" . htmlspecialchars($name) . "' data-tooltip-js='srv-" . htmlspecialchars($steamID) . "' data-mention='" . htmlspecialchars($steamID) . "' src='" . htmlspecialchars($avatar) . "'>";
        }
        return $html;
    }
     
    public function DefineSteam64($steam)
    {
        switch(true):

            case (preg_match('/^(7656119)([0-9]{10})/', $steam)):
                return $steam;
                break;

            case (preg_match('/^STEAM_[01]:[01]:[0-9]{2,12}$/', $steam)):
                return con_steam32to64($steam);
                break;

            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam)):
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=".$this->General->arr_general['web_key']."&vanityurl=".$search_id), true)['response']['steamid'];
                return $getsearch;
                break;

            case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam)):
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam), "/");
                return $search_steam;
                break;

            case (preg_match('/^\[U:(.*)\:(.*)\]/', $steam)):
                return con_steam3to64_int(str_replace(Array('[U:1:', '[U:0:', ']'), '', $steam));
                break;

            default:
                return false;
                break;

        endswitch;
    }
	
	# Функция для проверки на существование функции translate
	public function Translate($text) {
        if (function_exists($this->Translate->translate)) {
            return $this->Translate->translate('module_block_main_chat', $text);
        } else {
            return $this->Translate->get_translate_module_phrase('module_block_main_chat', $text);
        }
    }
}