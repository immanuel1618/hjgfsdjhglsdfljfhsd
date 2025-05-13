<?php /**
    * @author SeverskiY (@severskteam)
**/
if(!isset($_SESSION['steamid'])) 
{
    get_iframe("404", "Авторизуйтесь, чтобы поставить скин!");
}

use app\modules\module_page_skins\system\FunctionCore;
$Function = new FunctionCore ($Db, $General, $Translate);

if ($Function->Settings('work') == "1" AND !isset($_SESSION['user_admin'])) {
    get_iframe("404", "Технические работы");
}

if ($Function->Settings('type') == "2") {
    // Маршруты для других страниц
    $Router->map('GET|POST', 'skins/[weapons|agents|coins|music|collections|adminpanel:page]/', 'weapons');
    $Router->map('GET|POST', 'skins/collections/[i:id]/', 'collections'); 
} else {
    $Router->map('GET|POST', 'skins/[weapons|agents|coins|music|collections|adminpanel:page]/', 'weapons');
    $Router->map('GET|POST', 'skins/collections/[i:id]/', 'collections');
}


$Map = $Router->match(); 

$page = $Map['params']['page'] ?? 'weapons';

if ($Map['target'] === 'collections') {
    $collectionID = $Map['params']['id'];
    error_log("Коллекция с ID: " . $collectionID);
    $Function->Collections()->InterfaceDetailsCollection($collectionID);
    $page = 'collections';
}

if (!isset($_SESSION['user_admin'])) {
    if ($page == 'adminpanel') {
        get_iframe("404", "Доступ для Администратора");
    }
}

if (!empty($Db->db_data['Skins'])) {
    switch(true) {
        case(isset($_POST['SkinChangerUpdate'])):
            exit(json_encode($Function->Weapons()->SkinChangerUpdate($_POST), true));
        case(isset($_POST['SkinChangerSettingModal'])):
            exit(json_encode($Function->Weapons()->SkinChangerSettingModal($_POST), true));
        case(isset($_POST['SkinChangerSetting'])):
            exit(json_encode($Function->Weapons()->SkinChangerSetting($_POST), true));
        case(isset($_POST['SkinChangerAddKnife'])):
            exit(json_encode($Function->Weapons()->SkinChangerAddKnife($_POST), true));
        case(isset($_POST['SkinChangerAddGlove'])):
            exit(json_encode($Function->Weapons()->SkinChangerAddGlove($_POST), true));
        case(isset($_POST['SkinChangerNoSkin'])):
            exit(json_encode($Function->Weapons()->SkinChangerNoSkin($_POST), true));
        case(isset($_POST['SkinChangerStickers'])):
            exit(json_encode($Function->Weapons()->SkinChangerStickers($_POST), true));
        case(isset($_POST['StickerUpdate'])):
            exit(json_encode($Function->Weapons()->StickerUpdate($_POST), true));   
        case(isset($_POST['id_name'])): 
            exit(json_encode($Function->Weapons()->ModalWP($_POST), true));
        /////////////////////////////////////////////////////////////////////////////////////
        case(isset($_POST['html_collections'])):
            exit(json_encode($Function->Collections()->InterfaceCollections($_POST), true));
        case(isset($_POST['PlayerCollections'])):
            exit(json_encode($Function->Collections()->InterfaceCollections($_POST), true));
        case(isset($_POST['html_collectiondeteils'])):
            exit(json_encode($Function->Collections()->InterfaceDetailsCollection($_POST['collectionID']), true));
        case(isset($_POST['id_namessss'])):
            exit(json_encode($Function->Collections()->CollectionModalWeapon($_POST), true));
        case(isset($_POST['CollectionSkinChangerUpdate'])):
            exit(json_encode($Function->Collections()->CollectionSkinChangerUpdate($_POST), true));
        case(isset($_POST['CollectionsSkinChangerSettingModal'])):
            exit(json_encode($Function->Collections()->CollectionsSkinChangerSettingModal($_POST), true));
        case(isset($_POST['CollectionsStickerUpdate'])):
            exit(json_encode($Function->Collections()->CollectionsStickerUpdate($_POST), true));
        case(isset($_POST['CollectionsStickersKeychainHtml'])):
            exit(json_encode($Function->Collections()->CollectionsStickersKeychainHtml($_POST), true));
        case(isset($_POST['CollectionsSkinChangerStickers'])):
            exit(json_encode($Function->Collections()->CollectionsSkinChangerStickers($_POST), true));
        case(isset($_POST['CollectionsSkinChangerSetting'])):
            exit(json_encode($Function->Collections()->CollectionsSkinChangerSetting($_POST), true));
        case(isset($_POST['CollectionsSkinChangerNoSkin'])):
            exit(json_encode($Function->Collections()->CollectionsSkinChangerNoSkin($_POST), true));
        case(isset($_POST['id_name_knife'])):
            exit(json_encode($Function->Collections()->ModalWPCollectionKnife($_POST), true));
        case(isset($_POST['CollectionsSkinChangerAddKnife'])):
            exit(json_encode($Function->Collections()->CollectionsSkinChangerAddKnife($_POST), true));
        case(isset($_POST['id_name_gloves'])):
            exit(json_encode($Function->Collections()->ModalWPCollectionGloves($_POST), true));
        case(isset($_POST['CollectionsSkinChangerAddGlove'])):
            exit(json_encode($Function->Collections()->CollectionsSkinChangerAddGlove($_POST), true));
        case(isset($_POST['CollectionCreate'])):
            exit(json_encode($Function->Collections()->CollectionCreate($_POST), true));
        case(isset($_POST['CollectionDelete'])):
            exit(json_encode($Function->Collections()->CollectionDelete($_POST), true));
        case(isset($_POST['CollectionPublicToggle'])):
            exit(json_encode($Function->Collections()->CollectionPublicToggle($_POST), true));
        case(isset($_POST['CollectionApply'])):
            exit(json_encode($Function->Collections()->CollectionApply($_POST), true));
        //////////////////////////////////////////////////////
        case(isset($_POST['StickersKeychainHtml'])): 
            exit(json_encode($Function->Weapons()->StickersKeychainHtml($_POST), true));
        # СКИНЫ #
        case(isset($_POST['html_weapons'])):
            $search_text = (string) htmlentities( $_POST['search_text'] ); # Ну наверное защита (sql-инъекции)
            exit(json_encode($Function->Weapons()->IntefaceWP($_POST['id_sort'], $_POST['id_server'], $_POST['id_team'], $search_text ), true));
        # АГЕНТЫ #
        case(isset($_POST['html_agents'])):
            $search_text = (string) htmlentities( $_POST['search_text'] ); # Ну наверное защита (sql-инъекции)
            exit(json_encode($Function->Agents()->IntefaceAgents($_POST['id_server'], $_POST['id_team'], $search_text), true));
        case(isset($_POST['set_agent'])): 
            exit(json_encode($Function->Agents()->SCSkinChangerAgents($_POST['type_agent'], $_POST['id_server'], $_POST['id_team'], $_POST['id_agent']), true));
        # МОНЕТЫ #
        case(isset($_POST['html_coins'])):
            $search_text = (string) htmlentities( $_POST['search_text'] ); # Ну наверное защита (sql-инъекции)
            exit(json_encode($Function->Coins()->IntefaceCoins($_POST['id_server'], $_POST['id_team'], $search_text), true));
        case(isset($_POST['set_coins'])): 
            exit(json_encode($Function->Coins()->SCSkinChangerCoins($_POST['type_coins'], $_POST['id_server'], $_POST['id_team'], $_POST['id_coins']), true));
        # МУЗЫКА #
        case(isset($_POST['html_music'])):
            $search_text = (string) htmlentities( $_POST['search_text'] ); # Ну наверное защита (sql-инъекции)
            exit(json_encode($Function->Music()->IntefaceMusic($_POST['id_server'], $_POST['id_team'], $search_text), true));
        case(isset($_POST['set_music'])): 
            exit(json_encode($Function->Music()->SCSkinChangerMusic($_POST['type_music'], $_POST['id_server'], $_POST['id_team'], $_POST['id_music']), true));
        ##########
        case(isset($_POST['UpdateCache'])): 
            exit(json_encode($Function->Cache()->UpdateCache(), true));
        case(isset($_POST['CacheSkins'])): 
            exit(json_encode($Function->Cache()->CacheSkins(), true));
        case(isset($_POST['CacheStickers'])): 
            exit(json_encode($Function->Cache()->CacheStickers(), true));
        case(isset($_POST['CacheKeychains'])): 
            exit(json_encode($Function->Cache()->CacheKeychains(), true));
        case(isset($_POST['CacheAgents'])): 
            exit(json_encode($Function->Cache()->CacheAgents(), true));
        case(isset($_POST['CacheMoney'])): 
            exit(json_encode($Function->Cache()->CacheMoney(), true));
        case(isset($_POST['CacheMusic'])): 
            exit(json_encode($Function->Cache()->CacheMusic(), true));
        case(isset($_POST['add_servers_sk'])): 
            exit(json_encode($Function->SettingsModule($_POST, 1), true));
        case(isset($_POST['save_settings_sk'])): 
            exit(json_encode($Function->SettingsModule($_POST, 2), true));
        case(isset($_POST['server_delete'])): 
            exit(json_encode($Function->SettingsModule($_POST, 3), true));
    }
} else {
    if(isset($_POST['save_db'])) {
        exit(json_encode($Function->AddDBSkins($_POST), true));
    }
}

# Установка заголовка страницы
$Modules->set_page_title( "{$Function->Translate('_set_page_title')} | {$General->arr_general['short_name']}" );

# Установка описание страницы
$Modules->set_page_description( $Function->Translate('_set_page_description') );