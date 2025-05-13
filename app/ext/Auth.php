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

class Auth {
    /**
     * @since 0.2
     * @var object
     */
    public    $General;

    /**
     * @since 0.2
     * @var object
     */
    public    $Db;

    /**
     * Длина токена
     * @var int 
     */
    protected $token_length = 32;

    /**
     * Время жизни куки
     * @var int
     */
    protected $cookie_days = 30;

    /**
     * Организация работы вэб-приложения с авторизацией.
     *
     * @param object $General
     * @param object $Db
     *
     * @since 0.2
     */
    function __construct( $General, $Db ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Импорт основного класса.
        $this->General = $General;

        // Импорт класса отвечающего за работу с базой данных.
        $this->Db = $Db;

        !isset( $_SESSION["steamid"] ) && $this->authByCookie();

        // Работа с авторизованным пользователем.
        if( isset( $_SESSION['steamid'] ) ):
            // Проверка авторизованного пользователя.
            ! isset( $_SESSION['user_admin'] ) && $this->check_session_admin();
        endif;

        // Работа со Steam авторизацией.
        if(isset( $_GET["auth"] ))
        {
            if($_GET["auth"] == 'login') 
                require 'app/includes/auth/steam.php';
        }

        // Выход пользователя из аккаунта.
        isset( $_GET["auth"] ) && $_GET["auth"] == 'logout' && require 'app/includes/auth/steam.php';
    }

    /**
     * Просто возвращает true/false, включены ли токены
     */
    protected function cookieEnabled() : bool
    {
        return (bool) $this->General->arr_general['auth_cock'];
    }

    /**
     * Получить пользователя по текущему токену
     */
    public function getUserToken( string $token )
    {
        if( $this->cookieEnabled() )
            return $this->Db->query("Core", 0, 0, "SELECT * FROM `lr_web_cookie_tokens` WHERE `cookie_token` = :token", [
                "token" => $token
            ]);

        return [];
    }

    /**
     * Авторизация пользователя по кукам
     */
    public function authByCookie()
    {
        $this->clearOldTokens();

        if( isset( $_COOKIE["cookie_token"] ) )
        {
            if( !empty( $user = $this->getUserToken( htmlentities($_COOKIE["cookie_token"]) ) ) )
            {
                if( $user["cookie_expire"] > time() )
                {
                    $steam32 = con_steam64to32( $user["steam"] );

                    $_SESSION = [
                        "steamid"           => $user["steam"],
                        "steamid64"         => $user["steam"],
                        "steamid32"         => $steam32,
                        "steamid32_short"   => substr( $steam32, 8 ),
                        "USER_AGENT"        => $_SERVER['HTTP_USER_AGENT'],
                        "REMOTE_ADDR"       => $this->General->get_client_ip_cdn()
                    ];

                    if (!empty($this->Db->db_data['lk'])) {
                        $param = ['auth' => '%' . $steam32 . '%'];
                        $player = $this->Db->query('lk', $this->Db->db_data['lk'][0]['USER_ID'], $this->Db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk WHERE auth LIKE :auth LIMIT 1", $param);
                        if (empty($player)) {
                            $params = [
                                'auth' => $steam32,
                                'name' => $this->General->checkName($user["steam"])
                            ];
                            $this->Db->query('lk', $this->Db->db_data['lk'][0]['USER_ID'], $this->Db->db_data['lk'][0]['DB_num'], "INSERT INTO lk(auth, name, cash, all_cash) VALUES (:auth,:name,0,0)", $params);
                        }
                    }

                    header('Location: ' . $this->General->arr_general['site'] );
                }
            }
        }
    }

    /**
     * Почистить старые токены
     */
    public function clearOldTokens()
    {
        $this->Db->query("Core", 0, 0, "DELETE FROM `lr_web_cookie_tokens` WHERE `cookie_expire` < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL ".$this->cookie_days." DAY))");
    }

    /**
     * функция, которая генерирует токен для авторизации по куки
     */
    public function generateToken()
    {
        if( $this->cookieEnabled() )
        {
            $token = bin2hex(random_bytes( $this->token_length ));
            $this->setUserToken($token, $_SESSION["steamid64"]);
            
            setcookie("cookie_token", $token, strtotime("+".$this->cookie_days." days"), "/", ".".$_SERVER['HTTP_HOST']);
        }
    }
    
    /**
     * Записать данные токена в пользователя
     */
    protected function setUserToken( string $token, int $steamid64 )
    {
        if( $this->cookieEnabled() )
        {
            if( !empty( $this->Db->query("Core", 0, 0, "SELECT * FROM `lr_web_cookie_tokens` WHERE `steam` = :steam", ["steam" => $steamid64]) ) )
            {
                $this->Db->query("Core", 0, 0, "UPDATE `lr_web_cookie_tokens` SET `cookie_token` = :token, `cookie_expire` = :expire WHERE `steam` = :steam", [
                    "steam" => $steamid64,
                    "token" => $token,
                    "expire"=> strtotime("+".$this->cookie_days." days")
                ]);
            }
            else
            {
                $this->Db->query("Core", 0, 0, "INSERT INTO `lr_web_cookie_tokens`(`steam`, `cookie_token`, `cookie_expire`) VALUES (:steam, :token, :expire)", [
                    "steam" => $steamid64,
                    "token" => $token,
                    "expire"=> strtotime("+".$this->cookie_days." days")
                ]);
            }
        }
    }

    /**
     * Удалить определенный токен при разлогине
     */
    public function delToken( string $steam )
    {
        $this->Db->query("Core", 0, 0, "DELETE FROM `lr_web_cookie_tokens` WHERE `steam` = :steam", [
            "steam" => (int) $steam
        ]);
    }

    /**
     * Проверка авторизованного пользователя на принадлежность ко списку администраторов.
     *
     * @since 0.2.120
     */
    public function check_session_admin() {
        $result = $this->Db->query( 'Core', 0, 0,"SELECT `steamid`, `group`, `flags`, `access` FROM `lvl_web_admins` WHERE `steamid`= :steamid LIMIT 1", [
            "steamid" => $_SESSION["steamid64"]
        ]);
        if( ! empty( $result ) ):
            $_SESSION['user_admin'] = 1;
            $_SESSION['user_group'] = $result['group'];
            $_SESSION['user_access'] = $result['access'];
            $_SESSION['user_flags'] = $result['flags'];
        endif;
    }
}