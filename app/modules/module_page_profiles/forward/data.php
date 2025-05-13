<?php
use app\modules\module_page_profiles\ext\Player;
use app\modules\module_page_profiles\ext\UpdateRole;

$Router->map('GET|POST', 'profiles/[:id]/', 'profiles');
$Router->map('GET|POST', 'profiles/[:id]/[i:sid]/', 'profiles');
$Router->map('GET|POST', 'profiles/[:id]/[:page]/', 'profiles');
$Router->map('GET|POST', 'profiles/[:id]/[:page]/[i:sid]/', 'profiles');

$Map = $Router->match();
$server_id = $Map['params']['sid'] ?? 0;
$page = $Map['params']['page'] ?? 'info';
$profile = $Map['params']['id'];
$search = intval($_GET['search'] ?? 0);

if(!preg_match('^(STEAM_[0-1]:[0-1]:(\d+))|(7656119[0-9]{10})^', $Map['params']['id'])) {
  get_iframe('P1', 'Данная страница не существует') && die();
}

if (isset($_SESSION['steamid'])){
  if (empty($Map['params']['id'])) {
    header('Location: '.$General->arr_general['site'].'profiles/'.$_SESSION['steamid32'].'/?search=1/');
  }
} else {
  empty($Map) && get_iframe("P1", "Данная страница не существует") && die();
}

// Проверка поля 'profile' на пустоту.
empty($profile) && get_iframe('P1', 'Данная страница не существует') && die();

// Создаём экземпляр класса с импортом подкласса Db и указанием Steam ID игрока.
$Player = new Player($General, $Db, $Translate, $Modules, $profile, $server_id, $search);
$UpdateRole = new UpdateRole($Db, $General, $_SESSION['steamid64']);

$server_page = $Player->found[$Player->server_group]['server_group'];

// Задаём заголовок страницы.
$Modules->set_page_title($Translate->get_translate_phrase('_Profile') . ': ' .  action_text_clear(action_text_trim($General->checkName($Player->get_steam_64())), 20) . ' | ' . $General->arr_general['short_name']);

$Db->query('Core', 0, 0, "CREATE TABLE IF NOT EXISTS `lvl_web_profiles` (
  `auth` varchar(20) NOT NULL,
  `vk` text,
  `discord` text,
  `tg` text,
  `twitch` text,
  `status` text(255),
  `background` varchar(10) NOT NULL DEFAULT '1',
  UNIQUE INDEX `auth`(`auth`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_profiles` ADD COLUMN `tg` text");
$Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_profiles` ADD COLUMN `twitch` text");
$Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_profiles` ADD COLUMN `status` text");

$Db->query('Core', 0, 0, "INSERT INTO `lvl_web_profiles` (`auth`) VALUES ('{$_SESSION['steamid64']}')");

$Admins = $Player->get_db_Admins();
$Groups = $Player->get_db_Groups();
$Vips = $Player->get_db_Vips();
$Bans = $Player->get_db_Bans();
$Settings = $Player->settings;
$Info = $Player->get_info();
$back = empty($Info['background']) ? $Settings['backs']['1'] : $Settings['backs'][$Info['background']];

if (isset($_GET['code'])) {
  $code = $_GET['code'];
  $UpdateRole->handle_discord_oauth($code);
}

switch($page){
  case 'info':
    $Access = $Db->queryAll('Core', 0, 0, "SELECT `id`, `steamid_access`, `add_admin_access`, `add_ban_access`, `add_mute_access`, `add_vip_access`, `add_warn_access`, `add_timecheck_access`, `add_access` FROM `lvl_web_managersystem_access`");
  break;
  case 'stats':
  break;
  case 'admin':
    if (empty($Admins)) :
      get_iframe("P3", "Кажется, это не админ") && die();
    endif;
    $Warns = $Player->get_db_Warns();
    $WarnCount = $Player->get_db_WarnsCount();
    $RepCount = $Player->get_db_RepCount();
  break;
  case 'block':
    $Comms = $Player->get_db_Comms();
  break;
  case 'friends':
    $friends = $Player->get_friends();
  break;
  case 'transaction':
    if(isset($_SESSION["steamid64"]) && (($Player->get_steam_64() == $_SESSION['steamid64']) || isset($_SESSION['user_admin']))){
      $lk = $Player->get_db_lk();
      $web_shop = $Player->get_db_shop();
    } else {
      get_iframe("P4", "Кажется, эта страница не доступна") && die();
    }
  break;
  case 'settings':
    if (isset($_SESSION["steamid64"]) && ($Player->get_steam_64() == $_SESSION['steamid64'])){
      $discordUserId = $UpdateRole->get_discord_id();
      if (isset($_POST['edit_info'])) :
        $Player->edit_info();
        echo "<meta http-equiv='refresh' content='0'>";
      endif;

      if (isset($_POST['update_roles'])) {
        $UpdateRole->update_discord_roles();
      }
    } else {
      get_iframe("P4", "Кажется, эта страница не доступна") && die();
    }
  break;
  default:
    get_iframe("P4", "Кажется, эта страница не доступна") && die();
  break;
}