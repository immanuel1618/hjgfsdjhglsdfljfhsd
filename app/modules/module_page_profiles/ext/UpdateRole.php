<?php

namespace app\modules\module_page_profiles\ext;
define('STORAGE', '../../../../storage/');
define('MODULE_CACHE', STORAGE . 'modules_cache/module_page_profiles/');

class UpdateRole
{
    protected $Db, $General;
    protected $steamId;

    public function __construct($Db, $General, $steamId)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->steamId = $steamId;
    }

    public function get_steam_64()
    {
        return $this->steamId;
    }

    public function get_account_id()
    {
        return $this->steamId - 76561197960265728;
    }

    public function get_discord_id()
    {
        $result = $this->Db->query('Core', 0, 0, "SELECT discord FROM lvl_web_profiles WHERE auth = :auth", [
            'auth' => $this->get_steam_64()
        ]);
        
        return $result['discord'] ?? null;
    }

    public function update_discord_roles() {
        $role = file_exists(MODULE_CACHE . 'role.php') ? require MODULE_CACHE . 'role.php' : null;
    
        $botToken = $role['botToken'] ?? '';
        $guildId = $role['guildId'] ?? '';
        $adminRoles = $role['adminRoles'] ?? [];
        $vipRoles = $role['vipRoles'] ?? [];
    
        $discordUserId = $this->get_discord_id();
    
        if (!$discordUserId) {
            return "Discord аккаунт не привязан.";
        }
    
        $adminRolesFromDb = $this->Db->queryAll('AdminSystem', 0, 0, "SELECT a.id, s.group_id FROM `as_admins` a JOIN `as_admins_servers` s ON a.id = s.admin_id WHERE a.steamid = '" . $this->get_steam_64() . "'");
    
        $vipRolesFromDb = $this->Db->queryAll('Vips', 0, 0, "SELECT `group`, `sid` FROM `vip_users` WHERE `account_id` LIKE '%" . $this->get_account_id() . "%'");
    
        $rolesToAdd = [];
    
        foreach ($adminRolesFromDb as $adminRole) {
            if (isset($adminRoles[$adminRole['group_id']])) {
                $rolesToAdd = array_merge($rolesToAdd, (array)$adminRoles[$adminRole['group_id']]);
            }
        }
    
        foreach ($vipRolesFromDb as $vipRole) {
            if (isset($vipRoles[$vipRole['group']])) {
                $rolesToAdd = array_merge($rolesToAdd, (array)$vipRoles[$vipRole['group']]);
            }
        }
    
        $rolesToAdd = array_unique(array_filter($rolesToAdd));
    
        $url = "https://discord.com/api/v10/guilds/$guildId/members/$discordUserId";
        $options = [
            'http' => [
                'header' => "Authorization: Bot $botToken\r\n",
                'method' => 'GET'
            ]
        ];
    
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $userRoles = [];
    
        if ($result !== FALSE) {
            $userData = json_decode($result, true);
            $userRoles = $userData['roles'] ?? [];
        }
    
        $allManagedRoles = array_merge(
            array_reduce($adminRoles, 'array_merge', []),
            array_reduce($vipRoles, 'array_merge', [])
        );
        $allManagedRoles = array_unique(array_filter($allManagedRoles));
    
        foreach ($userRoles as $roleId) {
            if (in_array($roleId, $allManagedRoles)) {
                if (!in_array($roleId, $rolesToAdd)) {
                    $url = "https://discord.com/api/v10/guilds/$guildId/members/$discordUserId/roles/$roleId";
                    $options = [
                        'http' => [
                            'header' => "Authorization: Bot $botToken\r\n",
                            'method' => 'DELETE'
                        ]
                    ];
    
                    $context = stream_context_create($options);
                    $result = file_get_contents($url, false, $context);
    
                    if ($result === FALSE) {
                        return "Ошибка при снятии роли.";
                    }
                }
            }
        }
    
        foreach ($rolesToAdd as $roleId) {
            if (!empty($roleId)) { 
                if (!in_array($roleId, $userRoles)) {
                    $url = "https://discord.com/api/v10/guilds/$guildId/members/$discordUserId/roles/$roleId";
                    $options = [
                        'http' => [
                            'header' => "Authorization: Bot $botToken\r\n",
                            'method' => 'PUT'
                        ]
                    ];
    
                    $context = stream_context_create($options);
                    $result = file_get_contents($url, false, $context);
    
                    if ($result === FALSE) {
                        return "Ошибка при обновлении ролей.";
                    }
                }
            }
        }
    
        return "Роли успешно обновлены.";
    }

    public function handle_discord_oauth($code) {
        $role = file_exists(MODULE_CACHE . 'role.php') ? require MODULE_CACHE . 'role.php' : null;
    
        $client_id = $role['client_id'] ?? '';
        $client_secret = $role['client_secret'] ?? '';
        $redirect_uri = $role['redirect_uri'] ?? '';
    
        $url = 'https://discord.com/api/oauth2/token';
        $data = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
            'scope' => 'identify'
        ];
    
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
                'timeout' => 5
            ]
        ];
    
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result, true);
    
        if (isset($response['access_token'])) {
            $access_token = $response['access_token'];
    
            $user_url = 'https://discord.com/api/users/@me';
            $options = [
                'http' => [
                    'header' => "Authorization: Bearer $access_token\r\n",
                    'timeout' => 5
                ]
            ];
    
            $context = stream_context_create($options);
            $user_result = file_get_contents($user_url, false, $context);
            $user_info = json_decode($user_result, true);
    
            if (isset($user_info['id'])) {
                $discord_id = $user_info['id'];
                $steamid64 = $_SESSION['steamid64'];
                $steamid32 = $_SESSION['steamid32'];
                $name = $this->General->checkName($steamid64);
    
                $this->Db->query('Core', 0, 0, "UPDATE `lvl_web_profiles` SET `discord` = :discord_id WHERE `auth` = :steamid64", 
                [
                    'discord_id' => $discord_id,
                    'steamid64' => $steamid64
                ]);
    
                $this->Db->query('lk', 0, 0, "INSERT INTO `lk` (`auth`, `name`, `cash`) VALUES (:auth, :name, 20) ON DUPLICATE KEY UPDATE `cash` = `cash` + 20 ", 
                [
                    'auth' => $steamid32,
                    'name' => $name
                ]);
    
                $this->update_discord_roles();
    
                header('Location: /profiles/' . $_SESSION['steamid64'] . '/settings/');
                exit();
            }
        }
    }
}