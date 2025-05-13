<?php

/**
 * @author -r8 (@r8.dev)
 **/

namespace app\modules\module_page_punishment\ext;

use app\modules\module_page_punishment\ext\Punishment;

class Search extends Punishment
{
  protected $Db, $General, $Translate, $Modules, $server_id;

  public function __construct($Db, $General, $Modules, $Translate, $server_id)
  {
    $this->Db = $Db;
    $this->General = $General;
    $this->Translate = $Translate;
    $this->Modules = $Modules;
    $this->server_id = $server_id;
  }

  public function Steam64_Search($steam64)
  {
    switch (true):
      case (preg_match('/^(7656119)([0-9]{10})/', $steam64)):
        return $steam64;
      case (preg_match('/^STEAM_[01]:[01]:[0-9]{2,12}$/', $steam64)):
        return con_steam32to64($steam64);
      case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam64)):
        $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam64), "/");
        $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
        return $getsearch;
      case (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam64)):
        $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam64), "/");
        return $search_steam;
      case (preg_match('/^\[U:(.*)\:(.*)\]/', $steam64)):
        return con_steam3to64_int(str_replace(array('[U:1:', '[U:0:', ']'), '', $steam64));
      default:
        return $steam64;
    endswitch;
  }

  public function getAdminFromAdminSystem($id)
  {
    return $this->Db->query('AdminSystem', 0, 0, "SELECT * FROM `as_admins` WHERE `id` = :id", ['id' => $id]);
  }

  public function SearchPost($search_ban = "", $search_mute = "")
  {
    if (!empty($search_ban)) {
      $result = $this->Steam64_Search($search_ban);
      if (!empty($this->Db->db_data['AdminSystem'])) {
        $query = "SELECT *, 
          (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, 
          (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` 
        FROM `as_punishments`
        WHERE `steamid` LIKE :result 
          OR `name` LIKE :result 
          OR (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) LIKE :result
          OR (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) LIKE :result
          OR `ip` LIKE :result 
          AND `punish_type` = 0 
        LIMIT 20";
        $params = ["result" => "%{$result}%"];
        $search = $this->Db->queryAll('AdminSystem', 0, 0, $query, $params);
      }
    } elseif (!empty($search_mute)) {
      $result = $this->Steam64_Search($search_mute);
      if (!empty($this->Db->db_data['AdminSystem'])) {
        $query = "SELECT *, 
          (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_name`, 
          (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) AS `admin_steamid` 
        FROM `as_punishments`
        WHERE `steamid` LIKE :result 
          OR `name` LIKE :result 
          OR (SELECT `steamid` FROM `as_admins` WHERE `id` = `admin_id`) LIKE :result
          OR (SELECT `name` FROM `as_admins` WHERE `id` = `admin_id`) LIKE :result
          OR `ip` LIKE :result 
          AND `punish_type` != 0 
        LIMIT 20";
        $params = ["result" => "%{$result}%"];
        $search = $this->Db->queryAll('AdminSystem', 0, 0, $query, $params);
      }
    }
    if ($search) {
      if (!empty($search_ban)) {
        if (!empty($this->Db->db_data['AdminSystem'])) {
          foreach ($search as $key => $row) {
            $idban = $row['id'];
            $steam_player = $row['steamid'];
            $steam_admin = $row['admin_steamid'];
            $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
            $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
            if (!empty($row['unpunish_admin_id'])) {
              $end_ban = 'Разбанен';
              $style_ban = 'remove_punish';
            } elseif ($row['expired'] == '0') {
              $end_ban = $this->Translate->get_translate_phrase('_Forever');
              $style_ban = 'permanent_punish';
            } elseif (time() > $row['expired']) {
              $end_ban = $this->Modules->action_time_exchange_exact($row['expired'] - $row['created']);
              $style_ban = 'expired_punish';
            } else {
              $end_ban = $this->Modules->action_time_exchange_exact($row['expired'] - time());
              $style_ban = 'current_punish';
            }
            $reason_ban = action_text_clear($row['reason']);
            $JSONSearch[$key]["sid"] = $steam_player;
            $JSONSearch[$key]["check_getavatar"] = $this->General->checkAvatar($steam_player) ?? 0;
            $JSONSearch[$key]["search_html"] = <<<HTML
              <li class="modal_open" page="bans" id="{$idban}">
                  <span>
                      <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                          <g>
                              <path d="M6 7.5a5.25 5.25 0 1 1 5.25 5.25A5.26 5.26 0 0 1 6 7.5zM21.92 17a4.68 4.68 0 0 1-1.47 3.42h-.05a4.7 4.7 0 0 1-3.22 1.28 4.73 4.73 0 0 1-3.51-7.92s0-.07.07-.1a4.7 4.7 0 0 1 3.4-1.46A4.75 4.75 0 0 1 21.92 17zm-3.16 2.82-4.41-4.4a3.22 3.22 0 0 0 2.82 4.83 3.18 3.18 0 0 0 1.59-.43zM20.42 17a3.25 3.25 0 0 0-5.06-2.7l4.51 4.51a3.22 3.22 0 0 0 .55-1.81zm-8.37-3.48a.71.71 0 0 0-.57-.27H8.87a6.92 6.92 0 0 0-6.62 5 2.76 2.76 0 0 0 2.65 3.5h7.22a.76.76 0 0 0 .56-.24 1.3 1.3 0 0 0 .1-.15 6.22 6.22 0 0 1-.73-7.84z"></path>
                          </g>
                      </svg>
                  </span>
                  <span class="none_span">
                    <img style="position: absolute; transform: scale(1.17);" src="{$this->General->getFrame($steam_player)}" id="frame" frameid="{$steam_player}">
                    <img class="avatar_img" src="{$this->General->getAvatar($steam_player, 3)}" id="avatar" avatarid="{$steam_player}">
                  </span>
                  <span>{$name_player}</span>
                  <span>{$reason_ban}</span>
                  <span class="{$style_ban} none_span">{$end_ban}</span>
                  <span class="none_span">{$name_admin}</span>
              </li>
            HTML;
          }
        }
      } elseif (!empty($search_mute)) {
        if (!empty($this->Db->db_data['AdminSystem'])) {
          foreach ($search as $key => $row) {
            $idban = $row['id'];
            $steam_player = $row['steamid'];
            $steam_admin = $row['admin_steamid'];
            $name_player = empty($this->General->checkName($steam_player)) ? action_text_clear($row['name']) : action_text_clear($this->General->checkName($steam_player));
            $name_admin = empty($this->General->checkName($steam_admin)) ? action_text_clear($row['admin_name']) : action_text_clear($this->General->checkName($steam_admin));
            if (!empty($row['unpunish_admin_id'])) {
              $end_ban = 'Размучен';
              $style_ban = 'remove_punish';
            } elseif ($row['expires'] == '0') {
              $end_ban = $this->Translate->get_translate_phrase('_Forever');
              $style_ban = 'permanent_punish';
            } elseif (time() > $row['expires']) {
              $end_ban = $this->Modules->action_time_exchange_exact($row['expires'] - $row['created']);
              $style_ban = 'expired_punish';
            } else {
              $end_ban = $this->Modules->action_time_exchange_exact($row['expires'] - time());
              $style_ban = 'current_punish';
            }
            $reason_ban = action_text_clear($row['reason']);
            if ($row['punish_type'] = 3) {
              $punishmentType = '<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve"><g><path d="M8.5 11a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 8.5 11zm7-3a1.5 1.5 0 1 0 .001 3.001A1.5 1.5 0 0 0 15.5 8zM12 0C5.383 0 0 5.383 0 12s5.383 12 12 12c2.388 0 4.61-.709 6.482-1.917-.104-.085-.215-.16-.311-.256-.3-.3-.58-.698-.863-1.367A9.927 9.927 0 0 1 12 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10c0 .995-.151 1.955-.423 2.863.817.361 1.37.624 1.799.928A11.93 11.93 0 0 0 24 11.999C24 5.383 18.617 0 12 0zM6 18h2v-4H6zm5-4H9v4h2zm1 4h2v-4h-2zm3 0h2v-4h-2zm3.75-2a.75.75 0 0 0-.75.75c0 .088.609 2.674 1.587 3.665.387.392.902.585 1.414.585s1.024-.195 1.414-.585c.78-.78.78-2.048 0-2.828C21.599 16.876 19.327 16 18.75 16z"></path></g></svg>';
            } elseif ($row['punish_type'] = 2) {
              $punishmentType = '<svg x="0" y="0" viewBox="0 0 100 100" xml:space="preserve" fill-rule="evenodd"><g><path d="m19.665 18.164 56.25 56.25a3.126 3.126 0 0 0 4.42 0 3.127 3.127 0 0 0 0-4.419l-56.25-56.25a3.126 3.126 0 0 0-4.42 0 3.127 3.127 0 0 0 0 4.419zM52.635 87.5v-6.395a33.153 33.153 0 0 0 18.212-7.596l-4.441-4.44A26.932 26.932 0 0 1 49.51 75c-14.931 0-27.053-12.122-27.053-27.053a3.126 3.126 0 0 0-6.25 0c0 17.327 13.261 31.582 30.178 33.158V87.5H35.447a3.126 3.126 0 0 0 0 6.25h28.125a3.126 3.126 0 0 0 0-6.25zm21.4-28.127 4.645 4.645a33.13 33.13 0 0 0 4.133-16.071 3.126 3.126 0 0 0-6.25 0 26.94 26.94 0 0 1-2.528 11.426z"></path><path d="M28.117 30.78v18.64c0 12.073 9.802 21.875 21.875 21.875a21.785 21.785 0 0 0 13.764-4.877zm3.23-14.094 39.464 39.463a21.828 21.828 0 0 0 1.056-6.729V28.125c0-12.073-9.802-21.875-21.875-21.875-7.881 0-14.795 4.177-18.645 10.436z"></path></g></svg>';
            } elseif ($row['punish_type'] = 1) {
              $punishmentType = '<svg x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M18.753 9.833a4.992 4.992 0 0 0-6.92 6.92zM13.247 18.167a4.992 4.992 0 0 0 6.92-6.92z"></path><path d="M23 3H9a5.006 5.006 0 0 0-5 5v12a5.006 5.006 0 0 0 5 5h1.219l.811 3.242a1 1 0 0 0 1.6.539L17.351 25H23a5.006 5.006 0 0 0 5-5V8a5.006 5.006 0 0 0-5-5zm-7 18a6.979 6.979 0 0 1-4.934-2.041s-.011 0-.015-.01-.006-.01-.01-.015a7 7 0 0 1 9.893-9.893s.011 0 .015.01.006.01.01.015A7 7 0 0 1 16 21z"></path></g></svg>';
            }
            $JSONSearch[$key]["sid"] = $steam_player;
            $JSONSearch[$key]["check_getavatar"] = $this->General->checkAvatar($steam_player) ?? 0;
            $JSONSearch[$key]["search_html"] = <<<HTML
              <li class="modal_open" page="comms" id="{$idban}">
                  <span>
                      {$punishmentType}
                  </span>
                  <span class="none_span">
                    <img style="position: absolute; transform: scale(1.17);" src="{$this->General->getFrame($steam_player)}" id="frame" frameid="{$steam_player}">
                    <img class="avatar_img" src="{$this->General->getAvatar($steam_player, 3)}" id="avatar" avatarid="{$steam_player}">
                  </span>
                  <span>{$name_player}</span>
                  <span>{$reason_ban}</span>
                  <span class="{$style_ban} none_span">{$end_ban}</span>
                  <span class="none_span">{$name_admin}</span>
              </li>
            HTML;
          }
        }
      }
    }
    return $JSONSearch;
  }
}
