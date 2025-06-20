<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\ext;

class General {

    /**
     * @since 0.2
     * @var array
     */
    public $arr_general = [];

    /**
     * @since 0.2
     * @var array
     */
    public $notes = [];

    /**
     * @since 0.2
     * @var array
     */
    public $server_list = [];

    /**
     * @since 0.2
     * @var int
     */
    public $server_list_count = 0;

    /**
     * Массив с буффером аватарок и прочего
     * @var array 
     */
    protected static $json_buff = [];

    public $Host;
    public $Version;

    /**
     * Инициализация основных настроек.
     *
     * @param object $Db
     *
     * @since 0.2
     */
    function __construct( $Db ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        $this->Db = $Db;

        // Получение настроек вэб-интерфейса.
        $this->arr_general = $this->get_default_options();

        // Получение списка игровых серверов.
        $this->server_list = $this->get_server_list();

        // Общее количество игровых серверов.
        $this->server_list_count = get_arr_size( $this->server_list );

        // Получение языка страницы.
        $this->get_default_url_section('language', $this->arr_general['language'], array( 'RU', 'EN', 'UA', 'LT', 'DE', 'CH','PT', 'RS', 'BA', 'CRO' ) );
    }

    /**
     * Получает и задает название подраздела из URL по умолчанию, сохраняя результат по умолчанию в сессию.
     *
     * @since 0.2
     *
     * @param string|bool       $section       Название подраздела.
     * @param string            $default       Значние по умолчанию.
     * @param array|null        $arr_true      Белый список.
     *
     */
    public function get_default_url_section( $section, $default, $arr_true ) {
        ! isset( $_SESSION[ $section ] ) && $_SESSION[ $section ] = $default;
        isset ( $_GET[ $section ] ) && in_array( $_GET[ $section ], $arr_true ) && $_SESSION[ $section ] = $_GET[ $section ];
    }

    /**
     * Получает определенного аватара.
     *
     * @since 0.2
     *
     * @param  string      $profile    Steam ID игрока
     * @param  int         $type       Тип/Размер аватара.
     *
     * @return string                  Выводит ссылку на аватар если он существует.
     */
    public function getAvatar($profile, $type) {
        if ($type == 1) {
            $avatarType = "avatar";
        } elseif ($type == 2) {
            $avatarType = "slim";
        } elseif ($type == 3) {
            $avatarType = "animated";
        } else {
            $avatarType = "avatar";
        }
        $profile = con_steam64($profile);
        $url = sprintf("%simg/avatars/%s.json", CACHE, $profile);
        if (file_exists($url)) {
            $avatar = json_decode(file_get_contents($url), true);
            self::$json_buff[$profile] = $avatar;
            if ($type == 3 && empty($avatar['animated'])) {
                return htmlentities($avatar['avatar']);
            }

            return htmlentities($avatar[$avatarType]);
        }
        return $this->arr_general['site'] . 'storage/cache/img/avatars/1_avatar.jpg';
    }

    public function getFrame($profile) 
    {
        $profile = con_steam64($profile);
        $url = sprintf("%simg/avatars/%s.json", CACHE, $profile);
        if(file_exists($url))
        {
            $frame = json_decode(file_get_contents($url), true);
            self::$json_buff[$profile] = $frame;
            if ($frame['frame']) {
                return htmlentities($frame['frame']);
            }
        }
        return $this->arr_general['site'] . 'storage/cache/img/avatars/1_frame.png';
    }

    /**
     * Проверка на существование определеноого аватара и его актуальность.
     *
     * @since 0.2
     *
     * @param  string       $profile    Steam ID игрока
     * @param  int          $type       Тип/Размер аватара.
     *
     * @return int                      Выводит итог проверки.
     */
    public function checkAvatar($profile) {
        $profile = con_steam64($profile);
        $url = CACHE . 'img/avatars/' . $profile . '.json';
        if (file_exists($url)) {
            $cacheTime = $this->arr_general['avatars_cache_time'];
            if (time() >= filemtime($url) + $cacheTime) {
                unlink($url);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }

    /**
     * Получение никнейма игрока.
     *
     * @since 0.2
     *
     * @param  string       $profile    Steam ID игрока
     *
     * @return string                   Выводит итог проверки.
     */
    public function checkName($profile) 
    {
        $profile = con_steam64($profile);
        !isset(self::$json_buff[$profile]) && $this->getAvatar($profile, 1);
        return htmlentities(self::$json_buff[$profile]["name"]) ?? "Unnamed";
    }

    /**
     * Получение настроек по умолчанию для вэб-интерфейса.
     *
     * @since 0.2
     *
     * @return array                 Массив с настройками.
     */
    public function get_default_options() {
        $options = file_exists( SESSIONS . '/options.php' ) ? require SESSIONS . '/options.php' : null;
        return !isset( $options['full_name'] ) ? exit(require 'app/page/custom/install/index.php') : $options;
    }

    public function get_neo_options() {
        return file_exists( MODULESCACHE . 'template_neo/settings_neo.php' ) ? require MODULESCACHE . 'template_neo/settings_neo.php' : null;
    }

    public function get_neo_menu() {
        return file_exists(MODULESCACHE . 'template_neo/menu_point.php') ? require MODULESCACHE . 'template_neo/menu_point.php' : null;
    }

    public function get_neo_menu_categories() {
        return file_exists(MODULESCACHE . 'template_neo/menu_categories.php') ? require MODULESCACHE . 'template_neo/menu_categories.php' : null;
    }

    /**
     * Получение списка серверов.
     *
     * @return array                 Массив со списком серверов.
     */
    public function get_server_list() {
        return $this->Db->queryAll('Core', 0, 0,'SELECT * FROM `lvl_web_servers`');
    }

    /**
     * Получение иконок и работа с ними.
     *
     * @since 0.2
     *
     * @param  string $group     Название папки из которой будет читаться иконка.
     * @param  string $name      Название иконки.
     * @param  string $category  Дополнительное название под-категории, если она имеется. По умолчанию нету.
     *
     * @return string|false      Выводит содержимое SVG файла.
     */
    function get_icon( $group, $name, $category = null ) {
        return print $category == null ? $name : '<img src="' . $this->arr_general['site'] . CACHE . 'img/icons/' . $group . '/' . $category . '/' . $name . '.svg" class=svg>';
    }
    
    /**
     * Вывод JS скрипта на проверку актуальности аватара.
     *
     * @since 0.2
     * 
     * @param  string   $id      Steam ID - 64.
     *
     * @return string            Скрипт.
     */
    function get_js_relevance_avatar($id)
    {
        $steam = is_numeric($id) ? $id : con_steam64($id);
        $check = $this->checkAvatar($steam);
        echo "<script>CheckAvatar = {$check}; if (CheckAvatar == 1) { avatar.push(\"{$steam}\"); }</script>";
    }   

    /**
     * Получает IP клиента с поддержкой CDN.
     * Поддерживает: CloudFlare - (другие CDN по запросу).
     *
     * @return string            IP.
     */
    public function get_client_ip_cdn()
    {
        return isset($_SERVER["HTTP_DDG_CONNECTING_IP"]) ? $_SERVER["HTTP_DDG_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'];
    }

    /**
    * Счетчик посещений
    */
    public function online_stats()
    {
        if(isset($_SESSION['steamid64']))
            $User = $_SESSION['steamid64'];
        else 
            $User = 'guest';
    
        $client_ip = $this->get_client_ip_cdn();
    
        $param['ip'] = $client_ip;
        $Online = $this->Db->queryOneColumn('Core', 0, 0, "SELECT `user` FROM `lr_web_online` WHERE `ip` = :ip", $param);
    
        if(empty($Online)) {
            $params = [
                'user'  => $User,
                'ip'    => $client_ip
            ];
            $this->Db->query('Core', 0, 0, "INSERT INTO `lr_web_online`(`id`, `user`, `ip`, `time`) VALUES (NULL, :user, :ip, NOW())", $params);
            
            $_Param['date'] = date('m.Y');
            $_Attendance_ID = $this->Db->queryOneColumn('Core', 0, 0, 'SELECT `id` FROM `lr_web_attendance` WHERE `date` = :date', $_Param);
            
            if($_Attendance_ID) {   
                $_ParamU['id'] = $_Attendance_ID;
                $this->Db->query('Core', 0, 0, "UPDATE `lr_web_attendance` SET `visits` = `visits` + 1 WHERE `id` = :id", $_ParamU);
            } else {
                $this->Db->query('Core', 0, 0, "INSERT INTO `lr_web_attendance`(`id`, `date`, `visits`) VALUES (NULL, :date, 1)", $_Param);
            }
        }
        else {
            if($Online != $User) {
                $params = [
                    'user'  => $User,
                    'ip'    => $client_ip
                ];
                $this->Db->query('Core', 0, 0, 'UPDATE `lr_web_online` SET `time` = NOW(), `user` = :user WHERE `ip` = :ip', $params);
            } else {
                $this->Db->query('Core', 0, 0, "UPDATE `lr_web_online` SET `time` = NOW() WHERE  `ip` = :ip", $param);
            }
        }
        $this->Db->query('Core', 0, 0, "DELETE FROM `lr_web_online` WHERE `time` < SUBTIME(NOW(), '0 0:05:0')");
    }
    
    public function check_vpn( string $ip )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://blackbox.ipinfo.app/lookup/$ip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output == "Y" ? true : false;
    }

    public function user_online($steamid)
    {
        if (empty($this->Db->query('Core', 0, 0, 'SELECT * FROM `lr_web_online` WHERE `user` LIKE "%' . $steamid . '%"'))) :
            return 0;
        else :
            return 1;
        endif;
    }
}