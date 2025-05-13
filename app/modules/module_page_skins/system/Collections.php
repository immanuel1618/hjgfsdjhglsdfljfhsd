<?php
 /**
    * @author SeverskiY (@severskteam)
**/

namespace app\modules\module_page_skins\system;

use app\modules\module_page_skins\system\FunctionCore;

define('APP', '../../../../app/');
define('MODULE_CACHE', APP . 'modules/module_page_skins/cache/');

class Collections extends FunctionCore
{
    protected $Db, $General, $skins, $Translate, $languages;

    public function __construct($Db, $General, $Translate)
    {
        $this->Db        = $Db;
        $this->General   = $General;
        $this->Translate = $Translate;
        $this->languages = strtolower($_SESSION['language']);
        $keychains_file = realpath($_SERVER['DOCUMENT_ROOT'] . "/app/modules/module_page_skins/cache/keychains-{$this->languages}.json");
        $stickers_file = realpath($_SERVER['DOCUMENT_ROOT'] . "/app/modules/module_page_skins/cache/stickers-{$this->languages}.json");
        $file_exists   = realpath($_SERVER['DOCUMENT_ROOT'] . "/app/modules/module_page_skins/cache/skins-{$this->languages}.json");
        $keychainsFile  = MODULES . "module_page_skins/cache/keychains-{$this->languages}.json";
        $stickersFile  = MODULES . "module_page_skins/cache/stickers-{$this->languages}.json";
        $skinsFile     = MODULES . "module_page_skins/cache/skins-{$this->languages}.json";
    
        $this->skins    = file_exists($file_exists) ? $skinsFile : MODULES . "module_page_skins/cache/skins-en.json";
        $this->stickers = file_exists($stickers_file) ? $stickersFile : MODULES . "module_page_skins/cache/stickers-en.json";
        $this->keychains = file_exists($keychains_file) ? $keychainsFile : MODULES . "module_page_skins/cache/keychains-en.json";
    }

    // ...

    public function CollectionCreate($POST)
    {
        $this->checkAndCreateTables();
    
        if (isset($_SESSION['last_request_time'])) {
            $lastRequestTime = $_SESSION['last_request_time'];
            $currentTime = time();
            $timeDiff = $currentTime - $lastRequestTime;
    
            if ($timeDiff < 2) {
                $response = [
                    'status' => 'error',
                    'message' => 'Пожалуйста, подождите перед отправкой следующего запроса.'
                ];
                return $response;
            }
        }
    
        $_SESSION['last_request_time'] = time();
    
        $name = $POST['c_name'];
        $owner_id = $_SESSION['steamid64'];
    
        $collectionCountResult = $this->Db->queryAll('Skins', 0, 0, 
            "SELECT COUNT(*) as count FROM wp_collections_list WHERE owner_id = :owner_id", 
            [
                'owner_id' => $owner_id
            ]
        );
    
        $collectionCount = $collectionCountResult[0]['count'];
    
        if ($collectionCount >= 2) {
            $response = [
                'status' => 'error',
                'message' => 'Нельзя создать более двух коллекций'
            ];
            return $response;
        }
    
        $this->Db->query('Skins', 0, 0, 
            "INSERT INTO wp_collections_list (name, owner_id) VALUES (:name, :owner_id)", 
            [
                'name' => $name, 
                'owner_id' => $owner_id
            ]
        );
    
        $result = $this->Db->queryAll('Skins', 0, 0, 
            "SELECT id FROM wp_collections_list WHERE name = :name AND owner_id = :owner_id ORDER BY creation_date DESC LIMIT 1", 
            [
                'name' => $name, 
                'owner_id' => $owner_id
            ]
        );
    
        if ($result && isset($result[0]['id'])) {
            $collectionId = $result[0]['id'];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Не удалось создать коллекцию'
            ];
            return $response;
        }
    
        $response = [
            'id' => $collectionId,
            'status' => 'success',
            'message' => "Коллекция создана"
        ];
        return $response;
    }

    private function checkAndCreateTables()
    {
        $this->Db->query('Skins', 0, 0, 
            "CREATE TABLE IF NOT EXISTS `wp_collections_list` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `public` int(1) NOT NULL DEFAULT '0',
            `description` text,
            `owner_id` bigint(20) NOT NULL,
            `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
            `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `used` int(10) DEFAULT '0',
            `knife` varchar(64) DEFAULT NULL,
            `glove` int(12) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;"
        );
    
        $this->Db->query('Skins', 0, 0, 
            "CREATE TABLE IF NOT EXISTS `wp_collections_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `collection_id` int(11) NOT NULL,
            `weapon_defindex` int(6) NOT NULL,
            `weapon_paint_id` int(6) NOT NULL,
            `weapon_wear` float NOT NULL DEFAULT '0.000001',
            `weapon_seed` int(16) NOT NULL DEFAULT '0',
            `weapon_nametag` varchar(128) DEFAULT NULL,
            `weapon_stattrak` tinyint(1) NOT NULL DEFAULT '0',
            `weapon_stattrak_count` int(10) NOT NULL DEFAULT '0',
            `weapon_sticker_0` varchar(128) NOT NULL DEFAULT '0;0;0;0;0;0;0' COMMENT 'id;schema;x;y;wear;scale;rotation',
            `weapon_sticker_1` varchar(128) NOT NULL DEFAULT '0;0;0;0;0;0;0' COMMENT 'id;schema;x;y;wear;scale;rotation',
            `weapon_sticker_2` varchar(128) NOT NULL DEFAULT '0;0;0;0;0;0;0' COMMENT 'id;schema;x;y;wear;scale;rotation',
            `weapon_sticker_3` varchar(128) NOT NULL DEFAULT '0;0;0;0;0;0;0' COMMENT 'id;schema;x;y;wear;scale;rotation',
            `weapon_sticker_4` varchar(128) NOT NULL DEFAULT '0;0;0;0;0;0;0' COMMENT 'id;schema;x;y;wear;scale;rotation',
            `weapon_keychain` varchar(128) NOT NULL DEFAULT '0;0;0;0;0' COMMENT 'id;x;y;z;seed',
            PRIMARY KEY (`id`),
            KEY `collection_id` (`collection_id`),
            CONSTRAINT `wp_collections_items_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `wp_collections_list` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;"
        );
    
        $this->Db->query('Skins', 0, 0, 
            "CREATE TABLE IF NOT EXISTS `wp_collections_applied` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `steamid` BIGINT NOT NULL,
            `collection_id` INT NOT NULL,
            `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        );
    }
    

    public function CollectionDelete($POST)
    {
        if (!isset($POST['collectionID'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID коллекции не указан'
            ]);
            return;
        }
    
        $collectionID = (int)$POST['collectionID'];
        $ownerId = $_SESSION['steamid64'];
    
        $isAdmin = isset($_SESSION['user_admin']) && $_SESSION['user_admin'] === true;
    
        if (!$isAdmin) {
            $collection = $this->Db->queryAll('Skins', 0, 0, 
                "SELECT id FROM wp_collections_list WHERE id = :id AND owner_id = :owner_id", 
                [
                    'id' => $collectionID,
                    'owner_id' => $ownerId
                ]
            );
    
        }
    
        $this->Db->query('Skins', 0, 0, 
            "DELETE FROM wp_collections_items WHERE collection_id = :collection_id", 
            [
                'collection_id' => $collectionID
            ]
        );
    
        $this->Db->query('Skins', 0, 0, 
            "DELETE FROM wp_collections_list WHERE id = :id", 
            [
                'id' => $collectionID
            ]
        );
    
        $response = [
            'status' => 'success',
            'message' => 'Коллекция и связанные элементы успешно удалены'
        ];
        return $response;
    }

public function CollectionPublicToggle($POST)
{
    if (!isset($POST['collectionID'])) {
        return [
            'status' => 'error',
            'message' => 'ID коллекции не указан'
        ];
    }

    $collectionID = (int)$POST['collectionID'];
    $ownerId = $_SESSION['steamid64'];

    $collection = $this->Db->queryAll('Skins', 0, 0, 
        "SELECT id, public FROM wp_collections_list WHERE id = :id AND owner_id = :owner_id", 
        [
            'id' => $collectionID,
            'owner_id' => $ownerId
        ]
    );

    if (empty($collection)) {
        return [
            'status' => 'error',
            'message' => 'Коллекция не найдена или вы не являетесь её владельцем'
        ];
    }

    $itemCountResult = $this->Db->queryAll('Skins', 0, 0, 
        "SELECT COUNT(*) as count FROM wp_collections_items WHERE collection_id = :collection_id", 
        [
            'collection_id' => $collectionID
        ]
    );

    $itemCount = $itemCountResult[0]['count'];

    if ($itemCount < 3) {
        return [
            'status' => 'error',
            'message' => 'Нельзя изменить видимость коллекции: должно быть не менее 3 скинов'
        ];
    }

    $currentPublicValue = $collection[0]['public'];

    $newPublicValue = $currentPublicValue ? 0 : 1;

    $this->Db->query('Skins', 0, 0, 
        "UPDATE wp_collections_list SET public = :public WHERE id = :id", 
        [
            'public' => $newPublicValue,
            'id' => $collectionID
        ]
    );

    $response = [
        'status' => 'success',
        'message' => 'Видимость коллекции успешно изменена',
        'newPublicValue' => $newPublicValue
    ];
    return $response;
}
    

    public function InterfaceCollections($POST)
    {
        $searchText = isset($POST['search_text']) ? trim($POST['search_text']) : '';
        $more = isset($POST['more']) ? (int)$POST['more'] : 0;
        $limit = 4;
        $offset = $more * $limit;
        $isActive = isset($POST['isActive']) ? (bool)$POST['isActive'] : false; 

        $query = "SELECT id, name, description, owner_id, creation_date, update_date, used
                FROM wp_collections_list";
        
        if (isset($POST['PlayerCollections']) && $POST['PlayerCollections']) {
            $playerID = $_SESSION['steamid64'];
            $query .= " WHERE owner_id = :owner_id";
			$query .= " ORDER BY used DESC";
            $collections = $this->Db->queryAll('Skins', 0, 0, $query, ['owner_id' => $playerID]);
        } elseif (!empty($searchText)) {
            $query .= " WHERE name LIKE :text AND public = 1";
			$query .= " ORDER BY used DESC";
            $query .= " LIMIT {$limit} OFFSET {$offset}";
            $searchText = "%{$searchText}%";
            $collections = $this->Db->queryAll('Skins', 0, 0, $query, ['text' => $searchText]);
        } else {
            $query .= " WHERE public = 1";
			$query .= " ORDER BY used DESC";
            $query .= " LIMIT {$limit} OFFSET {$offset}";
            $collections = $this->Db->queryAll('Skins', 0, 0, $query);
        }
    
        $myCollectionCheckClass = $isActive ? 'active' : '';
        $myCollectionCheckHTML = '
            <div class="collections__items-search-info-params-item" data-type="MyCollection">
                <div class="collections__items-search-info-params-item-text">Только мои коллекции</div>
                <div class="collections__items-search-info-params-item-check ' . $myCollectionCheckClass . '"></div>
            </div>';
        
        $Skins = $this->get_cache($this->skins);
    
        $collectionsHTML = '';
    
        if (!empty($collections)) {
            foreach ($collections as $collection) {
                $steamID = con_steam64($collection['owner_id']);
                $frameSrc = $this->General->getFrame($steamID);
                $avatarSrc = $this->General->getAvatar($steamID, 3);
                $Name = $this->General->checkName($steamID);
    
                $skinsHTML = '';
    
                $collectionSkins = $this->Db->queryAll('Skins', 0, 0, "
                    SELECT `weapon_defindex`, `weapon_paint_id`, `weapon_wear`, `weapon_nametag`
                    FROM `wp_collections_items`
                    WHERE `collection_id` = :collection_id LIMIT 11", 
                    [
                    'collection_id' => $collection['id'],
                ]);
    
                foreach ($collectionSkins as $skinData) {
                    $weaponDefindex = $skinData['weapon_defindex'];
                    $weaponPaintId = $skinData['weapon_paint_id'];
    
                    $Skin = array_filter($Skins, function ($s) use ($weaponDefindex) {
                        return $s['id'] == $weaponDefindex;
                    });
    
                    if (!empty($Skin)) {
                        $Skin = reset($Skin);
                        $name = $Skin['name'];
                        $img = $Skin['img'];
    
                        if (!empty($skinData['weapon_nametag'])) { 
                            $name = "<s>{$name}</s> {$skinData['weapon_nametag']}"; 
                        }
    
                        $color = "";
                        if (!empty($Skin['skins'][$weaponPaintId]['id_rarity'])) {
                            $color = " " . $Skin['skins'][$weaponPaintId]['id_rarity'];
                        }
    
                        if (!empty($Skin['skins'][$weaponPaintId]['image'])) {
                            $img = $Skin['skins'][$weaponPaintId]['image'];
                        }
    
                        $skinsHTML .= <<<HTML
                            <div class="collection__body-list-skin{$color}">
                                <div class="block-skin-img">
                                    <img class="loader_img_weapon" src="{$img}" loading="lazy" alt="{$name}">
                                </div>
                            </div>
                        HTML;
                    }
                }
    
                $collectionsHTML .= '
                    <div class="collections__items-list-collection collection" data-id="' . $collection['id'] . '">
                        <div class="collection__header">
                            <div class="collection__header-text">
                                <div class="collection__header-name">' . htmlspecialchars($collection['name']) . '</div>
                                <div class="collection__header-point"></div>
                                <div class="collection__header-author">
                                    <div class="collection__header-author-avatar">
                                        <img class="avatar_frame_smalll" src="' . $frameSrc . '" id="frame" frameid="' . $steamID . '">
                                        <img class="player_avatar" src="' . $avatarSrc . '" id="avatar" avatarid="' . $steamID . '">
                                    </div>
                                    <div class="collection__header-author-name">' . $Name . '</div>
                                </div>
                            </div>
                            <div class="collection__header-info">
                                <div class="collection__header-value">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
                                        <g id="_01_align_center" data-name="01 align center">
                                            <path d="M12.032,19a2.991,2.991,0,0,0,2.122-.878L18.073,14.2,16.659,12.79l-3.633,3.634L13,0,11,0l.026,16.408-3.62-3.62L5.992,14.2l3.919,3.919A2.992,2.992,0,0,0,12.032,19Z"></path>
                                            <path d="M22,16v5a1,1,0,0,1-1,1H3a1,1,0,0,1-1-1V16H0v5a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V16Z"></path>
                                        </g>
                                    </svg>
                                    ' . $collection['used'] . '
                                </div>
                            </div>
                        </div>
                        <div class="collection__body">
                            <div class="collection__body-list">
                                ' . $skinsHTML . '
                                <div class="collection__body-list-skin collection__body-list-add">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.00002 0C4.03769 0 0 4.03769 0 9.00002C0 13.9624 4.03769 18 9.00002 18C13.9623 18 18 13.9624 18 9.00002C18 4.03769 13.9623 0 9.00002 0ZM9.00002 16.2C5.03016 16.2 1.79997 12.9699 1.79997 9.00002C1.79997 5.03016 5.03016 1.79997 9.00002 1.79997C12.9699 1.79997 16.2001 5.03016 16.2001 9.00002C16.2001 12.9699 12.9699 16.2 9.00002 16.2ZM11.4363 8.3637C11.52 8.44725 11.5863 8.54645 11.6315 8.65563C11.6767 8.76481 11.7001 8.88184 11.7001 9.00002C11.7001 9.1182 11.6767 9.23523 11.6315 9.34441C11.5863 9.4536 11.52 9.55279 11.4363 9.63633L8.73634 12.3363C8.65285 12.4203 8.55364 12.4869 8.44437 12.5323C8.3351 12.5778 8.21792 12.6013 8.09957 12.6015C7.9812 12.6016 7.86398 12.5784 7.7546 12.5332C7.64521 12.4879 7.54584 12.4216 7.46214 12.3379C7.37844 12.2542 7.31208 12.1549 7.26684 12.0454C7.22162 11.9361 7.19841 11.8189 7.19855 11.7005C7.1987 11.5821 7.22219 11.465 7.26768 11.3557C7.31316 11.2464 7.37977 11.1472 7.46366 11.0637L9.52736 9.00002L7.46366 6.93632C7.37977 6.85283 7.31316 6.75361 7.26768 6.64434C7.22219 6.53508 7.1987 6.41791 7.19855 6.29954C7.19841 6.18117 7.22162 6.06395 7.26684 5.95457C7.31208 5.8452 7.37844 5.74581 7.46214 5.66212C7.54584 5.57842 7.64521 5.51207 7.7546 5.46684C7.86398 5.42162 7.9812 5.39841 8.09957 5.39856C8.21792 5.39869 8.3351 5.4222 8.44437 5.46769C8.55364 5.51319 8.65285 5.5798 8.73634 5.66369L11.4363 8.3637Z" fill="white" fill-opacity="0.5"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            $collectionsHTML = '<div class="collections__items-list-empty">Коллекций нет</div>';
        }
    
        $showMoreButton = count($collections) >= $limit;
        
            $html = '
            <div class="collections">
                <div class="collections__items">
                    <div class="collections__items-search">
                        <div class="collections__items-search-create" id="CollectionCreate">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="512" height="512" style="width: 20px; height: 20px;">
                                <path d="M17,11H13V7a1,1,0,0,0-1-1h0a1,1,0,0,0-1,1v4H7a1,1,0,0,0-1,1H6a1,1,0,0,0,1,1h4v4a1,1,0,0,0,1,1h0a1,1,0,0,0,1-1V13h4a1,1,0,0,0,1,1h0A1,1,0,0,0,17,11Z"></path>
                            </svg>
                            Создать коллекцию
                        </div>
                        <div class="collections__items-search-info">
                            ' . $myCollectionCheckHTML . '
                        </div>
                    </div>
                    <div class="collections__items-list">
                        ' . $collectionsHTML . '
                        ' . ($showMoreButton ? '<div class="collections__items-list-more">Показать ещё</div>' : '') . '
                    </div>
                </div>
            </div>';
        
            return ['html' => $html, 'moreCheck' => $showMoreButton, 'collections_html' => $collectionsHTML, 'isActive' => $isActive];
        
    }
    


    public function InterfaceDetailsCollection($collectionID)
    {
        if ($collectionID == 0) {
            return ['html' => 'Коллекция не найдена'];
        }
    
        $query = "SELECT id, name, public, description, owner_id, creation_date, update_date, used, knife, glove 
                  FROM wp_collections_list 
                  WHERE id = :id";
        
        $collection = $this->Db->query('Skins', 0, 0, $query, ['id' => $collectionID]);
        
    
        if (empty($collection)) {
            return ['html' => 'Коллекция не найдена'];
        }
    
        error_log("Коллекция получена: " . print_r($collection, true));
    
        $Skins = $this->get_cache($this->skins);
    
        $menuFile = MODULE_CACHE . 'menu.json';
    
        if (file_exists($menuFile)) {
            $menu_json = file_get_contents($menuFile);
            
            $menu_items = json_decode($menu_json, true);
        
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("Ошибка при декодировании JSON: " . json_last_error_msg());
                $menu_items = [];
            }
        } else {
            error_log("Файл menu.json не найден");
            $menu_items = [];
        }
        
        $itemsHTML = '';
        $isPublic = $collection['public'];

        if ($isPublic == 1) {
            $Buttonsss = '
                <div class="collections__items-search-info-buttons-button" id="CollectionPublic" collection-toggle-id="0">
                    Скрыть
                </div>';
        } else {
            $Buttonsss = '
                <div class="collections__items-search-info-buttons-button" id="CollectionPublic" collection-toggle-id="1">
                    Опубликовать
                </div>';
        }

        $isOwner = (isset($_SESSION['steamid64']) && $_SESSION['steamid64'] == $collection['owner_id']) || isset($_SESSION['user_admin']);
        if ($isOwner) {
        foreach ($menu_items as $item) {
            $id_id = $item['data_weaponindex'];
            $id_namessss = $item['id_name'];
            $namessssss = $item['name'];
            $image_url = $item['image'];
        
            $Skin = array_filter($Skins, function ($s) use ($id_id) {
                return $s['id'] == $id_id;
            });
        
            if (!empty($Skin)) {
                $Skin = reset($Skin);
        
                $isKnife = $id_id === 'knife';
                $isGlove = $id_id === 'glove';
        
                if ($isKnife && !empty($collection['knife'])) {
                    $knifeName = $collection['knife'];
                    $knifeSkin = array_filter($Skins, function ($s) use ($knifeName) {
                        return $s['id_name'] === $knifeName;
                    });
        
                    if (!empty($knifeSkin)) {
                        $knifeSkin = reset($knifeSkin);
                        $itemsHTML .= $this->renderSkinItem($knifeSkin, $id_namessss, $collectionID);
                        continue;
                    }
                }
        
                if ($isGlove && !empty($collection['glove'])) {
                    $gloveDefIndex = $collection['glove'];
                    $gloveSkin = array_filter($Skins, function ($s) use ($gloveDefIndex) {
                        return $s['id'] == $gloveDefIndex;
                    });
        
                    if (!empty($gloveSkin)) {
                        $gloveSkin = reset($gloveSkin);
                        $itemsHTML .= $this->renderSkinItem($gloveSkin, $id_namessss, $collectionID);
                        continue;
                    }
                    }
                    $skinData = $this->Db->query('Skins', 0, 0, "
                        SELECT `weapon_paint_id`, `weapon_wear`, `weapon_nametag`
                        FROM `wp_collections_items`
                        WHERE `weapon_defindex` = :weapon_defindex AND `collection_id` = :collection_id", [
                            'weapon_defindex' => $id_id,
                            'collection_id' => $collectionID,
                    ]);
        
                    $weaponPaintId = $skinData['weapon_paint_id'];
        
                    if (!empty($skinData)) {
                        $skinData = reset($skinData);
                        if (!empty($skinData['weapon_nametag'])) {
                            $name = "<s>{$Skin['name']}</s> {$skinData['weapon_nametag']}";
                        } else {
                            $name = $Skin['name'];
                        }
        
                        $color = "";
                        if (!empty($Skin['skins'][$weaponPaintId]['id_rarity'])) {
                            $color = " " . $Skin['skins'][$weaponPaintId]['id_rarity'];
                        }
        
                        if (!empty($Skin['skins'][$weaponPaintId]['image'])) {
                            $img = $Skin['skins'][$weaponPaintId]['image'];
                        } else {
                            $img = $Skin['img'];
                        }
        
                        $itemsHTML .= <<<HTML
                            <div class="collections__items-details-body-list-item collections__items-details-body-list-weapons{$color}" data-weaponindex="{$id_id}" data-name="{$id_namessss}" id="CollectionModalWeapon">
                                <div class="collections__items-details-body-list-weapon-image">
                                    <img src="{$img}" alt="{$name}">
                                </div>
                                <div class="block-skin-info">
                                        <b class="data-name">{$name}</b>
                                    </div>
                            </div>
                        HTML;
                    } else {
                        $itemsHTML .= <<<HTML
                            <div class="collections__items-details-body-list-item collections__items-details-body-list-weapon" data-weaponindex="{$id_id}" data-name="{$id_namessss}" id="CollectionModalWeapon">
                                <div class="collections__items-details-body-list-weapon-image">
                                    <img src="{$image_url}" alt="{$namessssss}">
                                </div>
                                <div class="collections__items-details-body-list-weapon-name">{$namessssss}</div>
                            </div>
                        HTML;
                    }
                }
            }
        
        
        $html_collectiondeteils = '
            <div class="collection-detail">
                <div class="collections__items">
                    <div class="collections__items-search">
                        <div class="collections__items-search-back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none"><g id="Frame" clip-path="url(#clip0_28297_6798)"><path id="Vector" d="M18.7979 7.55615C18.716 7.54249 18.6332 7.53619 18.5504 7.53729H4.44077L4.74844 7.3901C5.04916 7.2437 5.32275 7.04444 5.55695 6.80135L9.51363 2.73161C10.0347 2.21996 10.1223 1.39686 9.72112 0.781384C9.25422 0.125525 8.35882 -0.0168786 7.72114 0.463366C7.66962 0.502187 7.62065 0.544503 7.57464 0.59004L0.419694 7.94941C-0.139465 8.52391 -0.139958 9.45583 0.418576 10.031L0.419694 10.0321L7.57464 17.3915C8.13425 17.9655 9.04029 17.9642 9.59838 17.3886C9.64229 17.3433 9.68329 17.2951 9.72112 17.2443C10.1223 16.6289 10.0347 15.8057 9.51363 15.294L5.5641 11.217C5.35415 11.0008 5.11276 10.8195 4.8486 10.6797L4.41931 10.481H18.4716C19.2026 10.509 19.844 9.98372 19.9814 9.24467C20.1079 8.44227 19.578 7.68632 18.7979 7.55615Z"></path></g><defs><clipPath id="clip0_28297_6798"><rect width="20" height="18" fill="white"></rect></clipPath></defs></svg>
                            Назад к коллекциям
                        </div>
                        <div class="collections__items-search-info">
                            <div class="collections__items-search-info-stats">
                                <div class="collections__items-search-info-stats-item">
                                    <div class="collections__items-search-info-stats-item-desc">
                                        <svg id="Layer_1" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m18 9.064a3.049 3.049 0 0 0 -.9-2.164 3.139 3.139 0 0 0 -4.334 0l-11.866 11.869a3.064 3.064 0 0 0 4.33 4.331l11.87-11.869a3.047 3.047 0 0 0 .9-2.167zm-14.184 12.624a1.087 1.087 0 0 1 -1.5 0 1.062 1.062 0 0 1 0-1.5l7.769-7.77 1.505 1.505zm11.872-11.872-2.688 2.689-1.5-1.505 2.689-2.688a1.063 1.063 0 1 1 1.5 1.5zm-10.825-6.961 1.55-.442.442-1.55a1.191 1.191 0 0 1 2.29 0l.442 1.55 1.55.442a1.191 1.191 0 0 1 0 2.29l-1.55.442-.442 1.55a1.191 1.191 0 0 1 -2.29 0l-.442-1.55-1.55-.442a1.191 1.191 0 0 1 0-2.29zm18.274 14.29-1.55.442-.442 1.55a1.191 1.191 0 0 1 -2.29 0l-.442-1.55-1.55-.442a1.191 1.191 0 0 1 0-2.29l1.55-.442.442-1.55a1.191 1.191 0 0 1 2.29 0l.442 1.55 1.55.442a1.191 1.191 0 0 1 0 2.29zm-5.382-14.645 1.356-.387.389-1.358a1.042 1.042 0 0 1 2 0l.387 1.356 1.356.387a1.042 1.042 0 0 1 0 2l-1.356.387-.387 1.359a1.042 1.042 0 0 1 -2 0l-.387-1.355-1.358-.389a1.042 1.042 0 0 1 0-2z"></path></svg>
                                        Создана:
                                    </div>
                                    <div class="collections__items-search-info-stats-item-value">' . htmlspecialchars($collection['creation_date']) . '</div>
                                </div>
                                <div class="collections__items-search-info-stats-item">
                                    <div class="collections__items-search-info-stats-item-desc">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512"><g id="_01_align_center" data-name="01 align center"><path d="M12.032,19a2.991,2.991,0,0,0,2.122-.878L18.073,14.2,16.659,12.79l-3.633,3.634L13,0,11,0l.026,16.408-3.62-3.62L5.992,14.2l3.919,3.919A2.992,2.992,0,0,0,12.032,19Z"></path><path d="M22,16v5a1,1,0,0,1-1,1H3a1,1,0,0,1-1-1V16H0v5a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V16Z"></path></g></svg>
                                        Установок:
                                    </div>
                                    <div class="collections__items-search-info-stats-item-value">' . htmlspecialchars($collection['used']) . '</div>
                                </div>
                            </div>
                            <div class="collections__items-search-info-buttons">
                                ' . $Buttonsss . '
                                <div class="collections__items-search-info-buttons-button" id="CollectionDelete">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512" height="512"><g><path fill="currentColor" d="M448,85.333h-66.133C371.66,35.703,328.002,0.064,277.333,0h-42.667c-50.669,0.064-94.327,35.703-104.533,85.333H64   c-11.782,0-21.333,9.551-21.333,21.333S52.218,128,64,128h21.333v277.333C85.404,464.214,133.119,511.93,192,512h128   c58.881-0.07,106.596-47.786,106.667-106.667V128H448c11.782,0,21.333-9.551,21.333-21.333S459.782,85.333,448,85.333z    M234.667,362.667c0,11.782-9.551,21.333-21.333,21.333C201.551,384,192,374.449,192,362.667v-128   c0-11.782,9.551-21.333,21.333-21.333c11.782,0,21.333,9.551,21.333,21.333V362.667z M320,362.667   c0,11.782-9.551,21.333-21.333,21.333c-11.782,0-21.333-9.551-21.333-21.333v-128c0-11.782,9.551-21.333,21.333-21.333   c11.782,0,21.333,9.551,21.333,21.333V362.667z M174.315,85.333c9.074-25.551,33.238-42.634,60.352-42.667h42.667   c27.114,0.033,51.278,17.116,60.352,42.667H174.315z"></path></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collections__items-details">
                        <div class="collections__items-details-header">
                            <div class="collections__items-details-header-name">
                                <div class="collections__items-details-header-name-value">
                                    Коллекция: 
                                    <div class="collections__items-details-header-name-value-text" contenteditable="false" aria-valuemax="20">' . htmlspecialchars($collection['name']) . '</div>
                                </div>
                                
                            </div>
                            <div class="collections__items-details-header-button" id="CollectionApply">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M15.5515 11.9887L7.15398 17.127C6.7743 17.36 6.33944 17.4876 5.8941 17.4968C5.44875 17.506 5.00899 17.3964 4.62002 17.1794C4.23104 16.9623 3.90689 16.6456 3.68087 16.2617C3.45485 15.8779 3.33512 15.4408 3.33398 14.9954V5.00537C3.33512 4.55993 3.45485 4.12283 3.68087 3.739C3.90689 3.35516 4.23104 3.03844 4.62002 2.82138C5.00899 2.60432 5.44875 2.49476 5.8941 2.50395C6.33944 2.51315 6.7743 2.64077 7.15398 2.8737L15.5515 8.01204C15.8914 8.22076 16.1721 8.51313 16.3668 8.86122C16.5615 9.20932 16.6638 9.60151 16.6638 10.0004C16.6638 10.3992 16.5615 10.7914 16.3668 11.1395C16.1721 11.4876 15.8914 11.78 15.5515 11.9887Z"></path>
                                </svg>
                                Поставить коллекцию
                            </div>
                        </div>
                        <div class="collections__items-details-body">
                            <div class="collections__items-details-body-list">
                                ' . $itemsHTML . '
                                <div class="collections__items-details-body-list-show">
                                    <div class="collections__items-details-body-list-show-image">
                                        <img src="https://cloud.cybershoke.net/img/weapons_new/union.svg" alt="">
                                    </div>
                                    <div class="collections__items-details-body-list-show-name">Показать остальное оружие</div>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>';
        } else {
            foreach ($menu_items as $item) {
                $id_id = $item['data_weaponindex'];
                $id_namessss = $item['id_name'];
                $namessssss = $item['name'];
                $image_url = $item['image'];
            
                $Skin = array_filter($Skins, function ($s) use ($id_id) {
                    return $s['id'] == $id_id;
                });
            
                if (!empty($Skin)) {
                    $Skin = reset($Skin);
            
                    $isKnife = $id_id === 'knife';
                    $isGlove = $id_id === 'glove';
            
                    if ($isKnife && !empty($collection['knife'])) {
                        $knifeName = $collection['knife'];
                        $knifeSkin = array_filter($Skins, function ($s) use ($knifeName) {
                            return $s['id_name'] === $knifeName;
                        });
            
                        if (!empty($knifeSkin)) {
                            $knifeSkin = reset($knifeSkin);
                            $itemsHTML .= $this->renderSkinItem($knifeSkin, $id_namessss, $collectionID);
                            continue;
                        }
                    }
            
                    if ($isGlove && !empty($collection['glove'])) {
                        $gloveDefIndex = $collection['glove'];
                        $gloveSkin = array_filter($Skins, function ($s) use ($gloveDefIndex) {
                            return $s['id'] == $gloveDefIndex;
                        });
            
                        if (!empty($gloveSkin)) {
                            $gloveSkin = reset($gloveSkin);
                            $itemsHTML .= $this->renderSkinItem($gloveSkin, $id_namessss, $collectionID);
                            continue;
                        }
                    }
                        $skinData = $this->Db->query('Skins', 0, 0, "
                            SELECT `weapon_paint_id`, `weapon_wear`, `weapon_nametag`
                            FROM `wp_collections_items`
                            WHERE `weapon_defindex` = :weapon_defindex AND `collection_id` = :collection_id", [
                                'weapon_defindex' => $id_id,
                                'collection_id' => $collectionID,
                        ]);
            
                        $weaponPaintId = $skinData['weapon_paint_id'];
            
                        if (!empty($skinData)) {
                            $skinData = reset($skinData);
                            if (!empty($skinData['weapon_nametag'])) {
                                $name = "<s>{$Skin['name']}</s> {$skinData['weapon_nametag']}";
                            } else {
                                $name = $Skin['name'];
                            }
            
                            $color = "";
                            if (!empty($Skin['skins'][$weaponPaintId]['id_rarity'])) {
                                $color = " " . $Skin['skins'][$weaponPaintId]['id_rarity'];
                            }
            
                            if (!empty($Skin['skins'][$weaponPaintId]['image'])) {
                                $img = $Skin['skins'][$weaponPaintId]['image'];
                            } else {
                                $img = $Skin['img'];
                            }
            
                            $itemsHTML .= <<<HTML
                                <div class="collections__items-details-body-list-items collections__items-details-body-list-weapons{$color}">
                                    <div class="collections__items-details-body-list-weapon-image">
                                        <img src="{$img}" alt="{$name}">
                                    </div>
                                    <div class="block-skin-info">
                                            <b class="data-name">{$name}</b>
                                        </div>
                                </div>
                            HTML;
                        }
                    }
                }
            
            
            $html_collectiondeteils = '
                <div class="collection-detail">
                    <div class="collections__items">
                        <div class="collections__items-search">
                            <div class="collections__items-search-back">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none"><g id="Frame" clip-path="url(#clip0_28297_6798)"><path id="Vector" d="M18.7979 7.55615C18.716 7.54249 18.6332 7.53619 18.5504 7.53729H4.44077L4.74844 7.3901C5.04916 7.2437 5.32275 7.04444 5.55695 6.80135L9.51363 2.73161C10.0347 2.21996 10.1223 1.39686 9.72112 0.781384C9.25422 0.125525 8.35882 -0.0168786 7.72114 0.463366C7.66962 0.502187 7.62065 0.544503 7.57464 0.59004L0.419694 7.94941C-0.139465 8.52391 -0.139958 9.45583 0.418576 10.031L0.419694 10.0321L7.57464 17.3915C8.13425 17.9655 9.04029 17.9642 9.59838 17.3886C9.64229 17.3433 9.68329 17.2951 9.72112 17.2443C10.1223 16.6289 10.0347 15.8057 9.51363 15.294L5.5641 11.217C5.35415 11.0008 5.11276 10.8195 4.8486 10.6797L4.41931 10.481H18.4716C19.2026 10.509 19.844 9.98372 19.9814 9.24467C20.1079 8.44227 19.578 7.68632 18.7979 7.55615Z"></path></g><defs><clipPath id="clip0_28297_6798"><rect width="20" height="18" fill="white"></rect></clipPath></defs></svg>
                                Назад к коллекциям
                            </div>
                            <div class="collections__items-search-info">
                                <div class="collections__items-search-info-stats">
                                    <div class="collections__items-search-info-stats-item">
                                        <div class="collections__items-search-info-stats-item-desc">
                                            <svg id="Layer_1" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m18 9.064a3.049 3.049 0 0 0 -.9-2.164 3.139 3.139 0 0 0 -4.334 0l-11.866 11.869a3.064 3.064 0 0 0 4.33 4.331l11.87-11.869a3.047 3.047 0 0 0 .9-2.167zm-14.184 12.624a1.087 1.087 0 0 1 -1.5 0 1.062 1.062 0 0 1 0-1.5l7.769-7.77 1.505 1.505zm11.872-11.872-2.688 2.689-1.5-1.505 2.689-2.688a1.063 1.063 0 1 1 1.5 1.5zm-10.825-6.961 1.55-.442.442-1.55a1.191 1.191 0 0 1 2.29 0l.442 1.55 1.55.442a1.191 1.191 0 0 1 0 2.29l-1.55.442-.442 1.55a1.191 1.191 0 0 1 -2.29 0l-.442-1.55-1.55-.442a1.191 1.191 0 0 1 0-2.29zm18.274 14.29-1.55.442-.442 1.55a1.191 1.191 0 0 1 -2.29 0l-.442-1.55-1.55-.442a1.191 1.191 0 0 1 0-2.29l1.55-.442.442-1.55a1.191 1.191 0 0 1 2.29 0l.442 1.55 1.55.442a1.191 1.191 0 0 1 0 2.29zm-5.382-14.645 1.356-.387.389-1.358a1.042 1.042 0 0 1 2 0l.387 1.356 1.356.387a1.042 1.042 0 0 1 0 2l-1.356.387-.387 1.359a1.042 1.042 0 0 1 -2 0l-.387-1.355-1.358-.389a1.042 1.042 0 0 1 0-2z"></path></svg>
                                            Создана:
                                        </div>
                                        <div class="collections__items-search-info-stats-item-value">' . htmlspecialchars($collection['creation_date']) . '</div>
                                    </div>
                                    <div class="collections__items-search-info-stats-item">
                                        <div class="collections__items-search-info-stats-item-desc">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512"><g id="_01_align_center" data-name="01 align center"><path d="M12.032,19a2.991,2.991,0,0,0,2.122-.878L18.073,14.2,16.659,12.79l-3.633,3.634L13,0,11,0l.026,16.408-3.62-3.62L5.992,14.2l3.919,3.919A2.992,2.992,0,0,0,12.032,19Z"></path><path d="M22,16v5a1,1,0,0,1-1,1H3a1,1,0,0,1-1-1V16H0v5a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V16Z"></path></g></svg>
                                            Установок:
                                        </div>
                                        <div class="collections__items-search-info-stats-item-value">' . htmlspecialchars($collection['used']) . '</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collections__items-details">
                            <div class="collections__items-details-header">
                                <div class="collections__items-details-header-name">
                                    <div class="collections__items-details-header-name-value">
                                        Коллекция: 
                                        <div class="collections__items-details-header-name-value-text" contenteditable="false" aria-valuemax="20">' . htmlspecialchars($collection['name']) . '</div>
                                    </div>
                                    
                                </div>
                                <div class="collections__items-details-header-button" id="CollectionApply">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M15.5515 11.9887L7.15398 17.127C6.7743 17.36 6.33944 17.4876 5.8941 17.4968C5.44875 17.506 5.00899 17.3964 4.62002 17.1794C4.23104 16.9623 3.90689 16.6456 3.68087 16.2617C3.45485 15.8779 3.33512 15.4408 3.33398 14.9954V5.00537C3.33512 4.55993 3.45485 4.12283 3.68087 3.739C3.90689 3.35516 4.23104 3.03844 4.62002 2.82138C5.00899 2.60432 5.44875 2.49476 5.8941 2.50395C6.33944 2.51315 6.7743 2.64077 7.15398 2.8737L15.5515 8.01204C15.8914 8.22076 16.1721 8.51313 16.3668 8.86122C16.5615 9.20932 16.6638 9.60151 16.6638 10.0004C16.6638 10.3992 16.5615 10.7914 16.3668 11.1395C16.1721 11.4876 15.8914 11.78 15.5515 11.9887Z"></path>
                                    </svg>
                                    Поставить коллекцию
                                </div>
                            </div>
                            <div class="collections__items-details-body">
                                <div class="collections__items-details-body-list">
                                    ' . $itemsHTML . '
                                </div>
                             </div>
                        </div>
                    </div>
                </div>';
        }
    
        error_log("HTML коллекции: " . $html_collectiondeteils);
    
        return ['html' => $html_collectiondeteils];
    }
    
    private function renderSkinItem($skin, $id_namessss, $collectionID)
    {

        $query = "SELECT id, name, description, owner_id, creation_date, update_date, used, knife, glove 
        FROM wp_collections_list 
        WHERE id = :id";

        $collection = $this->Db->query('Skins', 0, 0, $query, ['id' => $collectionID]);
        
        $isOwner = (isset($_SESSION['steamid64']) && $_SESSION['steamid64'] == $collection['owner_id']) || isset($_SESSION['user_admin']);


        $skinData = $this->Db->query('Skins', 0, 0, "
            SELECT `weapon_paint_id`, `weapon_wear`, `weapon_nametag`
            FROM `wp_collections_items`
            WHERE `weapon_defindex` = :weapon_defindex AND `collection_id` = :collection_id", [
                'weapon_defindex' => $skin['id'],
                'collection_id' => $collectionID,
        ]);
    
        $weaponPaintId = $skinData['weapon_paint_id'];
        
        if ($isOwner) {
            if (!empty($skinData)) {
                $skinData = reset($skinData);
                if (!empty($skinData['weapon_nametag'])) {
                    $name = "<s>{$skin['name']}</s> {$skinData['weapon_nametag']}";
                } else {
                    $name = $skin['name'];
                }
        
                $color = "";
                if (!empty($skin['skins'][$weaponPaintId]['id_rarity'])) {
                    $color = " " . $skin['skins'][$weaponPaintId]['id_rarity'];
                }
        
                $img = !empty($skin['skins'][$weaponPaintId]['image']) ? $skin['skins'][$weaponPaintId]['image'] : $skin['img'];
        
                return <<<HTML
                    <div class="collections__items-details-body-list-item collections__items-details-body-list-weapons{$color}" data-weaponindex="{$skin['id']}" data-name="{$id_namessss}" id="CollectionModalWeapon">
                        <div class="collections__items-details-body-list-weapon-image">
                            <img src="{$img}" alt="{$name}">
                        </div>
                        <div class="block-skin-info">
                                <b class="data-name">{$name}</b>
                            </div>
                    </div>
                HTML;
            } else {
                return <<<HTML
                    <div class="collections__items-details-body-list-item collections__items-details-body-list-weapon" data-weaponindex="{$skin['id']}" data-name="{$id_namessss}" id="CollectionModalWeapon">
                        <div class="collections__items-details-body-list-weapon-image">
                            <img src="{$skin['img']}" alt="{$skin['name']}">
                        </div>
                        <div class="collections__items-details-body-list-weapon-name">{$skin['name']}</div>
                    </div>
                HTML;
            }
        } else {
            if (!empty($skinData)) {
                $skinData = reset($skinData);
                if (!empty($skinData['weapon_nametag'])) {
                    $name = "<s>{$skin['name']}</s> {$skinData['weapon_nametag']}";
                } else {
                    $name = $skin['name'];
                }
        
                $color = "";
                if (!empty($skin['skins'][$weaponPaintId]['id_rarity'])) {
                    $color = " " . $skin['skins'][$weaponPaintId]['id_rarity'];
                }
        
                $img = !empty($skin['skins'][$weaponPaintId]['image']) ? $skin['skins'][$weaponPaintId]['image'] : $skin['img'];
        
                return <<<HTML
                    <div class="collections__items-details-body-list-item collections__items-details-body-list-weapons{$color}">
                        <div class="collections__items-details-body-list-weapon-image">
                            <img src="{$img}" alt="{$name}">
                        </div>
                        <div class="block-skin-info">
                                <b class="data-name">{$name}</b>
                            </div>
                    </div>
                HTML;
            } else {
                return <<<HTML
                    <div class="collections__items-details-body-list-item collections__items-details-body-list-weapon">
                        <div class="collections__items-details-body-list-weapon-image">
                            <img src="{$skin['img']}" alt="{$skin['name']}">
                        </div>
                        <div class="collections__items-details-body-list-weapon-name">{$skin['name']}</div>
                    </div>
                HTML;
            }
        }
    }
    
    public function CollectionModalWeapon($POST)
    {

        $query = "SELECT id, owner_id FROM wp_collections_list WHERE id = :id";

        $collection = $this->Db->query('Skins', 0, 0, $query, ['id' => $POST['collectionID']]);

        if ($collection['owner_id'] != $_SESSION['steamid64'] && !isset($_SESSION['user_admin'])) {
        return ['error' => $this->Translate('_no_permission')];
        }

 
        $ModalSkins = "";

        $skinsData = $this->get_cache($this->skins);

        $selected_skins = array_filter($skinsData, function ($skin) use ($POST) {
            return $skin['id_name'] == $POST['id_namessss'];
        });
        
        $skinsToIterate = reset($selected_skins);
        $skinsToIterateAll = $skinsToIterate['skins'];
        
        $rarityOrder = [
            'rarity_common_weapon' => 1,
            'rarity_uncommon_weapon' => 2,
            'rarity_rare_weapon' => 3,
            'rarity_mythical_weapon' => 4,
            'rarity_legendary_weapon' => 5,
            'rarity_ancient_weapon' => 6,
            'rarity_contraband_weapon' => 7,
        ];
        
        usort($skinsToIterateAll, function ($a, $b) use ($rarityOrder) {
            $aOrder = $rarityOrder[$a['id_rarity']];
            $bOrder = $rarityOrder[$b['id_rarity']];
        
            return $aOrder - $bOrder;
        });
        

        $id = $skinsToIterate['id'];

        if ($this->Settings('type') == 1) {
            $skin_active = $this->Db->query('Skins', 0, 0, "SELECT `weapon_paint_id` AS skin FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                'weapon_defindex' => $id,
            ]);
            $skin = $skin_active['skin'];
        } else if ($this->Settings('type') == 2) {
            $skin_active = $this->Db->query('Skins', 0, 0, "SELECT `weapon_paint_id` AS skin FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                'weapon_defindex' => $id,
            ]);
            $skin = $skin_active['skin'];
        }

        foreach ($skinsToIterateAll as $selectedSkin) {

            $id_skin = $selectedSkin['id_skin'];
            $color = " " . $selectedSkin['id_rarity'];
            $img = $selectedSkin['image'];
            $skinName = trim(explode('|', $selectedSkin['name'])[1]);
            $rarity = $selectedSkin['rarity'];
            $choose_weapon = $this->Translate('_choose_weapon'); 

            switch (true) {
                case ($skin == $id_skin):
                    $choose_weapon = $this->Translate('_choose_default'); 
                    $choice = ' choice_active';
                    break;
                default:
                    $choice = '';
                    break;
            } # проверка на выбранный скин

            $ModalSkins .= <<<HTML
                            <div class="block-skin-fon{$choice}{$color}" id="CollectionSkinChangerUpdate" id_skin="{$id_skin}">
                                <div class="block-skin-img">
                                    <img class="loader_img_skin" src="{$img}" loading="lazy" alt="{$skinName}">
                                </div>
                                <div class="block-skin-info">
                                    <b class="data-name">{$skinName}</b>
                                    <span>{$rarity}</span>
                                </div>
                                <b class='button-skin'>{$choose_weapon}</b>
                            </div>  
            HTML;
        }

        $buttons = <<<HTML
                        <a class="modal_deff" id="CollectionsSkinChangerSettingModal" weapon_index="{$id}">{$this->Translate('_settings')}</a>
                        <a class="modal_deff" id="CollectionsSkinChangerNoSkin" weapon_index="{$id}">{$this->Translate('_selection_stand')}</a>  
                    HTML;

        return ['html' => "<div class='skin-modal-js scroll'>{$ModalSkins}</div>" ?: $this->Translate('_skins_no'), 'buttons' => $buttons, 'id' => $id]; 
    }

    public function CollectionsSkinChangerSetting($POST)
    {
        if (!is_numeric($POST['weapon_index']) || intval($POST['weapon_index']) != $POST['weapon_index'] || $POST['weapon_index'] < 0) return ['html' => $this->Translate('_nonono')];

        if (!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];

        $skinsData = $this->get_cache($this->skins);
        $skinsData = array_filter($skinsData, function ($skin) use ($POST) {
            return $skin['id'] == $POST['weapon_index'];
        }); 
        $skinsData = reset($skinsData);

        if (empty($skinsData['name'])) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

        $stattrack_count = isset($_POST['stattrack_count']) ? round($_POST['stattrack_count']) : null;

        if ($_POST['float'] !== '' && (filter_var($_POST['float'], FILTER_VALIDATE_FLOAT) === false || $_POST['float'] < 0 || $_POST['float'] > 0.9999)) {
            return ['status' => 'error', 'text' => $this->Translate('_fl_0_999')];
        }
        
        if ($_POST['pattern'] !== '' && (filter_var($_POST['pattern'], FILTER_VALIDATE_INT) === false || $_POST['pattern'] < 0 || $_POST['pattern'] > 999)) {
            return ['status' => 'error', 'text' => $this->Translate('_pt_0_999')];
        }
        
        $stattrack_count_number = ($stattrack_count !== null && $stattrack_count !== '') ? $stattrack_count : null;
        if ($stattrack_count_number !== null && (filter_var($stattrack_count_number, FILTER_VALIDATE_INT) === false || $stattrack_count_number < 0 || $stattrack_count_number > 999999)) {
            return ['status' => 'error', 'text' => $this->Translate('_st_0_999999')];
        }
        
        if (mb_strlen($_POST['nametag']) > 20) return ['status' => 'error', 'text' => $this->Translate('_name_0_20')];

            $skin_active = $this->Db->query('Skins', 0, 0, "SELECT * FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                "weapon_defindex" => $POST['weapon_index'],
            ]);

            $weapon_seed = !empty($POST['pattern']) ? $POST['pattern'] : 0;
            $weapon_wear = !empty($POST['float']) ? $POST['float'] : 0.0;

            if (!empty($skin_active['weapon_defindex'])) {
                $this->Db->query('Skins', 0, 0, "UPDATE `wp_collections_items` SET `weapon_nametag` = :weapon_nametag, `weapon_stattrak` = :weapon_stattrak, `weapon_stattrak_count` = '{$stattrack_count}', `weapon_seed` = '{$weapon_seed}', `weapon_wear` = '{$weapon_wear}' WHERE `weapon_defindex` = '{$skin_active['weapon_defindex']}' AND `collection_id` = '{$skin_active['collection_id']}' LIMIT 1", [
                    'weapon_nametag' => $POST['nametag'],
                    'weapon_stattrak' => $POST['stattrack'],
                ]);
            } else {
                $this->Db->query('Skins', 0, 0, "INSERT INTO `wp_collections_items`(`collection_id`, `weapon_defindex`, `weapon_paint_id`, `weapon_wear`, `weapon_seed`) 
                    VALUES (:collection_id, '{$POST['weapon_index']}', 0, '{$weapon_wear}', '{$weapon_seed}')", [
                    'collection_id' => $POST['collectionID'],
                    "weapon_defindex" => $POST['weapon_index'],
                ]);
            }
            return ['status' => 'success', 'text' => $this->Translate('_save_md_set')];
 
    }

    public function CollectionsSkinChangerSettingModal($POST)
    {
        $query = "SELECT id, owner_id FROM wp_collections_list WHERE id = :id";

        $collection = $this->Db->query('Skins', 0, 0, $query, ['id' => $POST['collectionID']]);

        if ($collection['owner_id'] != $_SESSION['steamid64'] && !isset($_SESSION['user_admin'])) {
        return ['error' => $this->Translate('_no_permission')];
        }

        $ModalSettings = "";
        $count_stickers = 0;

        $skinsData = $this->get_cache($this->skins);

        $selected_skins = array_filter($skinsData, function ($skin) use ($POST) {
            return $skin['id'] == $POST['weapon_index'];
        }); # сортировка скинов для оружия

        $skinsToIterate = reset($selected_skins);

            $skin_active = $this->Db->query('Skins', 0, 0, "SELECT * FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                'weapon_defindex' => $POST['weapon_index'],
            ]);
            
            $skin = $skin_active['weapon_paint_id'];
            $float = $skin_active['weapon_wear'];
            $pattern =  $skin_active['weapon_seed'];

            $stickers_data = [
                explode(';', $skin_active['weapon_sticker_0'])[0],
                explode(';', $skin_active['weapon_sticker_1'])[0],
                explode(';', $skin_active['weapon_sticker_2'])[0],
                explode(';', $skin_active['weapon_sticker_3'])[0]
            ];
            $keychain_data = explode(';', $skin_active['weapon_keychain']);

            $skin_stattrack = $skin_active['weapon_stattrak'];
            $skin_stattrack_count = $skin_active['weapon_stattrak_count'];
            $skin_tag = $skin_active['weapon_nametag'];


        if ($skinsToIterate['type'] == "Knife" || $skinsToIterate['type'] == "Gloves") {
            $class = "sk-modal-settings-type-1";
        } else {
            $class = "sk-modal-settings-type-2";
            $Sticker_html = $this->CollectionsSticker($stickers_data, $keychain_data);
            $count_stickers = count($this->get_cache($this->stickers));
            $Sticker_table = <<<HTML
                                <div class="sk-modal-block">
                                    <div class="search-skin-input">
                                        <svg viewBox="0 0 512 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path class="fa-primary" d="M330.7 376L457.4 502.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L376 330.7C363.3 348 348 363.3 330.7 376z"></path><path class="fa-secondary" d="M208 64a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 352A208 208 0 1 0 208 0a208 208 0 1 0 0 416z"></path></svg>
                                        <input type="text" id="search_js_stickers2" placeholder="{$this->Translate('_search')}"> <!-- #ПЕРЕВОД -->
                                    </div>    
                                    <div class="stickers-modal-js scroll">{$this->CollectionsSkinChangerStickers(null, $this->get_cache($this->stickers))['html']}</div>
                                    <div id="stickers-pagination"></div> 
                                </div>
                            HTML;
        }

        if ($skinsToIterate['type'] != "Gloves") {
            if ($skin_stattrack == 1) {
                $stattrack = " on";
                $stattrack_text = "StatTrak ON";
            } else {
                $stattrack = " off";
                $stattrack_text = "StatTrak OFF";
            }
            $StatTrak = <<<HTML
                            <div class="sk-modal-setting-2">
                                <div class="sk-modal-setting-form">
                                    <div class="sk-modal_name">StatTrak</div>
                                    <input name="stattrack_count" class="sk-modal-input" placeholder="0" min="0" max="999999" type="number" value="{$skin_stattrack_count}">
                                </div>
                                <div class="sk-modal-setting-form">
                                    <a class="sk-modal-StatTrak-button{$stattrack}">{$stattrack_text}</a>
                                </div>
                            </div>
                        HTML;
        }

        $NameTag = <<<HTML
                        <div class="sk-modal-setting-1">
                            <div class="sk-modal-setting-form">
                                <div class="sk-modal_name">NameTag</div>
                                <input name="nametag" class="sk-modal-input" placeholder="{$this->Translate('_name')}" type="text" value="{$skin_tag}">
                            </div>
                        </div>
                    HTML;

        $img = $skinsToIterate['img'];
        if (!empty($skin)) {
            $img = $skinsToIterate['skins'][$skin]['image'] ?: $img;
        } # изменение скинов если есть

        $ModalSettings = <<<HTML
                            <div class="{$class}">
                                <div class="sk-modal-block">
                                    <div class="sk-modal-weapons">
                                        <img class="sk-modal-weapon-img" src="{$img}" alt="weapon">
                                        {$Sticker_html}
                                    </div>
                                    <form id="SkinChangerSettingForm">
                                        {$StatTrak}
                                        <div class="sk-modal-setting-2">
                                            <div class="sk-modal-setting-form">
                                                <div class="sk-modal_name">Float</div>
                                                <input name="float" class="sk-modal-input" placeholder="0" min="0" max="0.9999" step="0.0001" type="number" value="{$float}">
                                            </div>
                                            <div class="sk-modal-setting-form">
                                                <div class="sk-modal-setting-buttons">
                                                    <div class="sk-modal-setting-button" data-value="0.0001">FN</div>
                                                    <div class="sk-modal-setting-button" data-value="0.07">MW</div>
                                                    <div class="sk-modal-setting-button" data-value="0.15">FT</div>
                                                    <div class="sk-modal-setting-button" data-value="0.38">WW</div>
                                                    <div class="sk-modal-setting-button" data-value="0.45">BS</div>
                                                </div>
                                                <input name="float-range" class="range-1" type="range" min="0.0001" max="0.9999" step="0.0001" value="{$float}">
                                            </div>
                                        </div>
                                        <div class="sk-modal-setting-2">
                                            <div class="sk-modal-setting-form">
                                                <div class="sk-modal_name">{$this->Translate('_pattern')}</div> <!-- #ПЕРЕВОД -->
                                                <input name="pattern" class="sk-modal-input" placeholder="1" min="0" max="999" step="0" type="number" value="{$pattern}">
                                            </div>
                                            <div class="sk-modal-setting-form">           
                                                <input name="pattern-range" class="range-2" type="range" min="0" max="999" step="0" value="{$pattern}">
                                            </div>
                                        </div>
                                        {$NameTag}   
                                    </form>
                                    <button class="sk-modal-button" id="CollectionsSkinChangerSetting">{$this->Translate('_stats_save_settings')}</button> <!-- #ПЕРЕВОД -->
                                </div>
                                {$Sticker_table}
                            </div>
                    HTML;

        return ['html' => (!empty($ModalSettings) ? $ModalSettings : $this->Translate('_error')), 'count_stickers' => $count_stickers]; 
    }

    public function CollectionsSkinChangerStickers($POST = null, $stickersToIterate = null)
    {
        $ModalStickers = "";

        if ($POST['id'] > 4) {
            $stickersToIterate = $this->get_cache($this->keychains);
        } else {
            $stickersToIterate = $this->get_cache($this->stickers);
        }

        $count_stickers = count($stickersToIterate);
    
        $currentPage = isset($POST['page_stickers']) ? intval($POST['page_stickers']) : 1;
        $itemsPerPage = 12;
        $startIndex = ($currentPage - 1) * $itemsPerPage;
    
        if (!empty($POST['text_stickers'])) {
            $searchTerm = strtolower($POST['text_stickers']);
            $stickersToIterate = array_filter($stickersToIterate, function ($st) use ($searchTerm) {
                return strpos(strtolower($st['name']), $searchTerm) !== false;
            });
            $count_stickers = count($stickersToIterate);
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
    
        uasort($stickersToIterate, function ($a, $b) use ($rarityOrder) {
            $aOrder = $rarityOrder[$a['id_rarity']];
            $bOrder = $rarityOrder[$b['id_rarity']];
        
            return $aOrder - $bOrder;
        });
    
        function array_slice_assoc($array, $offset, $length = null, $preserve_keys = false)
        {
            $keys = array_slice(array_keys($array), $offset, $length, $preserve_keys);
            $values = array_slice($array, $offset, $length, $preserve_keys);
            return array_combine($keys, $values);
        }
        
        $limitedStickers = array_slice_assoc($stickersToIterate, $startIndex, $itemsPerPage, true);
    
        foreach ($limitedStickers as $key => $stickers) {
            $name = trim(explode('|', $stickers['name'])[1]);
            $rarity = ' ' . $stickers['id_rarity'];
            $img = '<img class="loader_img_sticker" src="' . $stickers['image'] . '" loading="lazy" alt="">';
            if ($key == 0) {
                $img = '';
            }
            $ModalStickers .= <<<HTML
                <div class="sticker-modal-fon{$rarity}" id="CollectionsStickerUpdate" id_sticker="{$key}">
                    <div class="sticker-modal-img">{$img}</div>
                    <div class="stickers-modal-info">
                        <b class="sticker-name">{$name}</b>
                    </div>
                </div>
            HTML;
        }
    
        return ['html' => !empty($ModalStickers) ? $ModalStickers : $this->Translate('_nono'), 'count_stickers' => $count_stickers];
    }

    public function CollectionsStickerUpdate($POST)
    {
        if (!is_numeric($POST['weapon_index']) || intval($POST['weapon_index']) != $POST['weapon_index'] || $POST['weapon_index'] < 0) return ['html' => $this->Translate('_nonono')];

        if (empty($POST['id_slot'])) return ['status' => 'error', 'text' => $this->Translate('_no_slot')];
        if (!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];

        $query = "SELECT id, owner_id FROM wp_collections_list WHERE id = :id";

        $collection = $this->Db->query('Skins', 0, 0, $query, ['id' => $POST['collectionID']]);

        if ($collection['owner_id'] != $_SESSION['steamid64'] && !isset($_SESSION['user_admin'])) {
        return ['error' => $this->Translate('_no_permission')];
        }

        if ($POST['id_slot'] > 4) {
            return $this->CollectionKeychainsUpdate($POST);
        } else {
            $stickersCache = $this->get_cache($this->stickers);
        }

        $stickersData = $stickersCache[$POST['id_sticker']];
        if (!isset($stickersData)) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

            $stickers = $this->Db->query('Skins', 0, 0, "SELECT * FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                'weapon_defindex' => $POST['weapon_index'],
            ]);

            if ($stickers['weapon_paint_id'] == 0) return ['status' => 'error', 'text' => $this->Translate('_no_stickers_gg')];

            switch ($POST['id_slot']) {
                case (4):
                    $query = "`weapon_sticker_0` = '{$POST['id_sticker']};1;0;0;0;1;0'";
                    break;
                case (3):
                    $query = "`weapon_sticker_1` = '{$POST['id_sticker']};2;0;0;0;1;0'";
                    break;
                case (2):
                    $query = "`weapon_sticker_2` = '{$POST['id_sticker']};3;0;0;0;1;0'";
                    break;
                case (1):
                    $query = "`weapon_sticker_3` = '{$POST['id_sticker']};4;0;0;0;1;0'";
                    break;
            }
            if (!empty($stickers['weapon_defindex'])) {
                $this->Db->query('Skins', 0, 0, "UPDATE `wp_collections_items` SET {$query} WHERE `weapon_defindex` = '{$stickers['weapon_defindex']}' AND `collection_id` = '{$stickers['collection_id']}' LIMIT 1");
            } else {
                $this->Db->query('Skins', 0, 0, "INSERT INTO `wp_collections_items`(`collection_id`, `weapon_defindex`, `weapon_paint_id`, `weapon_wear`, `weapon_seed`) VALUES (:collection_id, :weapon_defindex, 0, 0, 0)", [
                    'collection_id' => $POST['collectionID'],
                    'weapon_defindex' => $POST['weapon_index'],
                ]);
            }

        return ['status' => 'success', 'text' => "{$this->Translate('_st_yoyo')} {$stickersData['name']}"];
    }


    public function CollectionKeychainsUpdate($POST)
    {

        $keychainsCache = $this->get_cache($this->keychains);
        $keychainsData = $keychainsCache[$POST['id_sticker']];
        if (!isset($keychainsData)) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

        $keychains_positions = [
            1 => [8.0, 0.0, 3.0],
            2 => [10.0, 0.0, 9.2],
            3 => [8.0, 0.0, 1.0],
            4 => [5.7, 0.0, 2.2],
            7 => [6.0, 0.0, 2.0],
            8 => [6.7, 5.0, 3.2],
            9 => [10.0, 0.0, 8.0],
            10 => [7.0, 0.0, 3.0],
            11 => [20.0, 0.0, 5.6],
            13 => [8.5, 1.0, 3.0],
            14 => [4.2, 0.0, 4.8],
            16 => [18.6, 7.0, 12.4],
            17 => [9.0, 0.0, 5.6],
            19 => [8.7, 0.0, 5.9],
            23 => [5.5, 0.0, 3.7],
            24 => [9.0, 0.0, 3.8],
            25 => [4.5, 0.0, 3.7],
            26 => [2.4, 0.0, 2.7],
            27 => [3.8, 0.0, 8.7],
            28 => [1.2, 0.0, 3.8],
            29 => [5.2, 0.0, 0.8],
            30 => [10.1, 5.0, 7.0],
            31 => [5.9, 5.0, 5.1],
            32 => [9.0, 0.0, 2.5],
            33 => [-3.0, 0.0, 2.5],
            34 => [9.0, 0.0, 5.6],
            35 => [6.5, 0.0, 3.7],
            36 => [8.0, 0.0, 1.0],
            38 => [20.0, 0.0, 12.2],
            39 => [7.5, 0.0, 4.0],
            40 => [10.0, 5.0, 3.8],
            60 => [6.0, 0.0, 4.5],
            61 => [7.0, 0.0, 4.0],
            63 => [6.8, 0.0, 4.7],
            64 => [9.0, 0.0, 4.0],
        ];

        $keychain = $_POST['id_sticker'];
        $keychain_x = $keychains_positions[$POST['weapon_index']][0];
        $keychain_y = $keychains_positions[$POST['weapon_index']][1];
        $keychain_z = $keychains_positions[$POST['weapon_index']][2];

            $keychains = $this->Db->query('Skins', 0, 0, "SELECT * FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                'weapon_defindex' => $POST['weapon_index'],
            ]);

            if ($keychains['weapon_paint_id'] == 0) return ['status' => 'error', 'text' => $this->Translate('_no_stickers_gg')];

            $keychain = "{$keychain};{$keychain_x};{$keychain_y};{$keychain_z};0";

            if (!empty($keychains['weapon_defindex'])) {
                $this->Db->query('Skins', 0, 0, "UPDATE `wp_collections_items` SET `weapon_keychain` = '{$keychain}' WHERE `weapon_defindex` = '{$keychains['weapon_defindex']}' AND `collection_id` = '{$keychains['collection_id']}' LIMIT 1");
            } else {
                $this->Db->query('Skins', 0, 0, "INSERT INTO `wp_collections_items`(`collection_id`, `weapon_defindex`, `weapon_paint_id`, `weapon_wear`, `weapon_seed`) 
                    VALUES (:collection_id, :weapon_defindex, 0, 0, 0)", [
                        'collection_id' => $POST['collectionID'],
                        'weapon_defindex' => $POST['weapon_index'],
                    ]);
            }

        return ['status' => 'success', 'text' => "{$this->Translate('_st_yoyo')} {$keychainsData['name']}"];
    }

    public function CollectionsSkinChangerNoSkin($POST)
    {
        // if (!is_numeric(0) || intval(0) != 0 || 0 < 0 || $this->Settings('type') == 1 && 0 >= $this->Db->table_count['Skins']) return ['status' => 'error', 'text' => $this->Translate('_nonono')];
        // if (!is_numeric($POST['id_team']) || intval($POST['id_team']) != $POST['id_team'] || $POST['id_team'] > 2 || $POST['id_team'] < 0) return ['status' => 'error', 'text' => $this->Translate('_nonono')];
        if (!is_numeric($POST['weapon_index']) || intval($POST['weapon_index']) != $POST['weapon_index'] || $POST['weapon_index'] < 0) return ['html' => $this->Translate('_nonono')];

        if (!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];
        // if ($this->TableSearch()) return ['status' => 'error', 'text' => $this->Translate('_adm_table_no')];
        // if ($this->TableSearchServer()) return ['status' => 'error', 'text' => $this->Translate('_adm_no_serv')];
        // if (!isset(0)) return ['status' => 'error', 'text' => $this->Translate('_serv_right')];
        // if (!isset($POST['id_team'])) return ['status' => 'error', 'text' => $this->Translate('_command_left')];

        $query = "SELECT id, owner_id FROM wp_collections_list WHERE id = :id";

        $collection = $this->Db->query('Skins', 0, 0, $query, ['id' => $POST['collectionID']]);

        if ($collection['owner_id'] != $_SESSION['steamid64'] && !isset($_SESSION['user_admin'])) {
        return ['error' => $this->Translate('_no_permission')];
        }

        $skinsData = $this->get_cache($this->skins);
        $skinsData = array_filter($skinsData, function ($skin) use ($POST) {
            return $skin['id'] == $POST['weapon_index'];
        }); 
        $skinsData = reset($skinsData);

        if (empty($skinsData['name'])) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

        if ($this->Settings('type') == 1) {
            $this->Db->query('Skins', 0, 0, "UPDATE `wp_collections_items` SET `weapon_paint_id` = '0', `weapon_sticker_0` = '0;0;0;0;0;0;0', `weapon_sticker_1` = '0;0;0;0;0;0;0',  `weapon_sticker_2` = '0;0;0;0;0;0;0',  `weapon_sticker_3` = '0;0;0;0;0;0;0',  `weapon_sticker_4` = '0;0;0;0;0;0;0', `weapon_keychain` = '0;0;0;0;0' WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                "weapon_defindex" => $POST['weapon_index'],
            ]);
            return ['status' => 'success', 'text' => $this->Translate('_lolstok')];
        } else if ($this->Settings('type') == 2) {
            $this->Db->query('Skins', 0, 0, "DELETE FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex", [
                'collection_id' => $POST['collectionID'],
                "weapon_defindex" => $POST['weapon_index'],
            ]);
            return ['status' => 'success', 'text' => $this->Translate('_lolstok')];
        } else {
            return ['status' => 'error', 'text' => $this->Translate('_errorizmen')];
        }
    }

    public function CollectionSkinChangerUpdate($POST)
    {
         if (!is_numeric($POST['weapon_index']) || intval($POST['weapon_index']) != $POST['weapon_index'] || $POST['weapon_index'] < 0) return ['html' => $this->Translate('_nonono')];

         if (!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];

         $query = "SELECT id, owner_id FROM wp_collections_list WHERE id = :id";

         $collection = $this->Db->query('Skins', 0, 0, $query, ['id' => $POST['collectionID']]);
 
         if ($collection['owner_id'] != $_SESSION['steamid64'] && !isset($_SESSION['user_admin'])) {
         return ['error' => $this->Translate('_no_permission')];
         }

        $skinsData = $this->get_cache($this->skins);
        $skinsData = array_filter($skinsData, function ($skin) use ($POST) {
            return $skin['id'] == $POST['weapon_index'];
        }); 
        $skinsData = reset($skinsData);

        if (empty($skinsData['name'])) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

        if (empty($skinsData['skins'][$POST['id_skin']])) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

            $SkinDb = $this->Db->query('Skins', 0, 0, "SELECT * FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                'weapon_defindex' => $POST['weapon_index'],
            ]);
            $weapon_wear = !empty($SkinDb['weapon_wear']) ? $SkinDb['weapon_wear'] : 0;
            $weapon_seed = !empty($SkinDb['weapon_seed']) ? $SkinDb['weapon_seed'] : 0;

            if (empty($SkinDb['weapon_defindex'])) {
                $query = "INSERT INTO `wp_collections_items` (`collection_id`, `weapon_defindex`, `weapon_paint_id`, `weapon_wear`, `weapon_seed`) 
                      VALUES(:collection_id, :weapon_defindex, :weapon_paint_id, :weapon_wear, :weapon_seed)";
                $params = [
                    'collection_id' => $POST['collectionID'],
                    'weapon_defindex' => $POST['weapon_index'],
                    'weapon_paint_id' => $POST['id_skin'],
                    'weapon_wear' => $weapon_wear,
                    'weapon_seed' => $weapon_seed,
                ];
            } else {
                $query = "UPDATE `wp_collections_items` SET `weapon_paint_id` = :weapon_paint_id WHERE `collection_id` = '{$SkinDb['collection_id']}' AND `weapon_defindex` = '{$SkinDb['weapon_defindex']}' LIMIT 1";
                $params = [
                    'weapon_paint_id' => $POST['id_skin'],
                ];
            }
    
            $this->Db->query('Skins', 0, 0, $query, $params);

            return ['status' => 'success', 'text' => "{$this->Translate('_skins_yoyo')} {$skinsData['skins'][$POST['id_skin']]['name']}"];
    }
    

    public function CollectionsSticker($stickers_data, $keychain_data)
    {

        $stickers_get_cache = $this->get_cache($this->stickers);
        $keychains_get_cache = $this->get_cache($this->keychains);
    
        $svg_image = [
            1 => '<svg class="img-slot" viewBox="0 -10 512.00005 512"><path d="m436.960938 75.007812c-85.984376-85.984374-216.566407-97.453124-314.546876-37.441406-3.535156 2.167969-4.648437 6.789063-2.480468 10.324219 2.164062 3.539063 6.789062 4.648437 10.324218 2.480469 37.734376-23.113282 81.195313-35.328125 125.683594-35.328125 132.878906 0 240.984375 108.105469 240.984375 240.980469 0 50.964843-15.589843 99.367187-45.140625 140.433593-24.300781-14.980469-51.148437-24.828125-79.167968-29.070312 1.1875-7.277344.140624-4.433594-14.433594-92.210938-.574219-3.234375.515625-6.664062 2.933594-9.019531l60.910156-59.378906c14.847656-14.457032 6.90625-39.96875-13.960938-43.003906l-84.195312-12.234376c-3.324219-.480468-6.1875-2.5625-7.667969-5.574218l-37.660156-76.285156c-9.238281-18.738282-35.972657-18.726563-45.203125 0l-37.660156 76.285156c-1.480469 3.011718-4.34375 5.09375-7.667969 5.574218l-84.191407 12.234376c-20.855468 3.035156-28.820312 28.539062-13.964843 43.003906l19.027343 18.546875c2.964844 2.894531 7.71875 2.832031 10.613282-.128907 2.890625-2.972656 2.832031-7.730468-.132813-10.621093l-19.027343-18.550781c-6.125-5.976563-2.636719-16.1875 5.644531-17.386719l84.183593-12.230469c8.21875-1.191406 15.316407-6.359375 18.992188-13.796875l37.644531-76.285156c3.734375-7.59375 14.546875-7.59375 18.28125 0l37.644531 76.285156c3.675782 7.4375 10.773438 12.605469 18.992188 13.796875l84.183594 12.230469c8.265625 1.195312 11.777344 11.402343 5.644531 17.386719l-60.910156 59.382812c-4.84375 4.714844-7.617188 11.289062-7.617188 18.046875 0 8.324219 15.824219 87.273437 14.644531 92.203125-9.269531-.753906-18.734374-.902344-28.109374-.390625l-61.882813-32.542969c-7.335937-3.851562-16.113281-3.859375-23.460937 0l-75.296876 39.589844c-7.09375 3.707031-14.957031-1.726562-14.957031-8.898438 0-3.949218 14.90625-84.363281 14.90625-89.960937 0-6.757813-2.773437-13.332031-7.605469-18.046875l-20.390624-19.871094c-2.972657-2.894531-7.730469-2.832031-10.621094.128906-2.894532 2.972657-2.832032 7.726563.140625 10.621094l20.390625 19.871094c2.375 2.324219 3.5 5.722656 2.921875 9.027344-14.804688 87.0625-14.753907 84.238281-14.753907 88.230468 0 18.65625 19.929688 31.09375 36.957032 22.191407l75.292968-39.589844c2.925782-1.53125 6.566407-1.53125 9.492188 0l42.421875 22.300781c-21.851563 3.925782-43.042969 11.253906-62.59375 21.753906-3.652344 1.960938-5.023437 6.507813-3.0625 10.160157 1.960937 3.652343 6.507813 5.023437 10.160156 3.0625 56.734375-30.441407 127.332031-31.886719 186.925781.507812-66.542968 17.527344-196.628906 51.796875-261.308593 68.890625 13.191406-20.832031 30.238281-39.25 49.988281-53.902344 3.324219-2.472656 4.023438-7.179687 1.550781-10.5-2.472656-3.335937-7.175781-4.027343-10.5-1.5625-24.347656 18.070313-44.871093 41.472657-59.699219 67.984376-162.230468-75.238282-189.214843-295.917969-48.164062-407.675782 3.253906-2.574218 3.800781-7.296875 1.226562-10.546875-2.578124-3.253906-7.300781-3.800781-10.546874-1.222656-151.703126 120.195313-120.484376 359.375 57.808593 436.035156 3.984375 1.726563-14.550781 5.519531 300.554688-77.480469 1.628906-.398437 3.300781-1.578124 4.191406-2.738281 77.03125-100.992187 68.730469-244.664062-22.679687-336.074219zm0 0"></path></svg>',
            2 => '<svg class="img-slot" viewBox="0 -10 512.00005 512"><path d="m436.960938 75.007812c-85.984376-85.984374-216.566407-97.453124-314.546876-37.441406-3.535156 2.167969-4.648437 6.789063-2.480468 10.324219 2.164062 3.539063 6.789062 4.648437 10.324218 2.480469 37.734376-23.113282 81.195313-35.328125 125.683594-35.328125 132.878906 0 240.984375 108.105469 240.984375 240.980469 0 50.964843-15.589843 99.367187-45.140625 140.433593-24.300781-14.980469-51.148437-24.828125-79.167968-29.070312 1.1875-7.277344.140624-4.433594-14.433594-92.210938-.574219-3.234375.515625-6.664062 2.933594-9.019531l60.910156-59.378906c14.847656-14.457032 6.90625-39.96875-13.960938-43.003906l-84.195312-12.234376c-3.324219-.480468-6.1875-2.5625-7.667969-5.574218l-37.660156-76.285156c-9.238281-18.738282-35.972657-18.726563-45.203125 0l-37.660156 76.285156c-1.480469 3.011718-4.34375 5.09375-7.667969 5.574218l-84.191407 12.234376c-20.855468 3.035156-28.820312 28.539062-13.964843 43.003906l19.027343 18.546875c2.964844 2.894531 7.71875 2.832031 10.613282-.128907 2.890625-2.972656 2.832031-7.730468-.132813-10.621093l-19.027343-18.550781c-6.125-5.976563-2.636719-16.1875 5.644531-17.386719l84.183593-12.230469c8.21875-1.191406 15.316407-6.359375 18.992188-13.796875l37.644531-76.285156c3.734375-7.59375 14.546875-7.59375 18.28125 0l37.644531 76.285156c3.675782 7.4375 10.773438 12.605469 18.992188 13.796875l84.183594 12.230469c8.265625 1.195312 11.777344 11.402343 5.644531 17.386719l-60.910156 59.382812c-4.84375 4.714844-7.617188 11.289062-7.617188 18.046875 0 8.324219 15.824219 87.273437 14.644531 92.203125-9.269531-.753906-18.734374-.902344-28.109374-.390625l-61.882813-32.542969c-7.335937-3.851562-16.113281-3.859375-23.460937 0l-75.296876 39.589844c-7.09375 3.707031-14.957031-1.726562-14.957031-8.898438 0-3.949218 14.90625-84.363281 14.90625-89.960937 0-6.757813-2.773437-13.332031-7.605469-18.046875l-20.390624-19.871094c-2.972657-2.894531-7.730469-2.832031-10.621094.128906-2.894532 2.972657-2.832032 7.726563.140625 10.621094l20.390625 19.871094c2.375 2.324219 3.5 5.722656 2.921875 9.027344-14.804688 87.0625-14.753907 84.238281-14.753907 88.230468 0 18.65625 19.929688 31.09375 36.957032 22.191407l75.292968-39.589844c2.925782-1.53125 6.566407-1.53125 9.492188 0l42.421875 22.300781c-21.851563 3.925782-43.042969 11.253906-62.59375 21.753906-3.652344 1.960938-5.023437 6.507813-3.0625 10.160157 1.960937 3.652343 6.507813 5.023437 10.160156 3.0625 56.734375-30.441407 127.332031-31.886719 186.925781.507812-66.542968 17.527344-196.628906 51.796875-261.308593 68.890625 13.191406-20.832031 30.238281-39.25 49.988281-53.902344 3.324219-2.472656 4.023438-7.179687 1.550781-10.5-2.472656-3.335937-7.175781-4.027343-10.5-1.5625-24.347656 18.070313-44.871093 41.472657-59.699219 67.984376-162.230468-75.238282-189.214843-295.917969-48.164062-407.675782 3.253906-2.574218 3.800781-7.296875 1.226562-10.546875-2.578124-3.253906-7.300781-3.800781-10.546874-1.222656-151.703126 120.195313-120.484376 359.375 57.808593 436.035156 3.984375 1.726563-14.550781 5.519531 300.554688-77.480469 1.628906-.398437 3.300781-1.578124 4.191406-2.738281 77.03125-100.992187 68.730469-244.664062-22.679687-336.074219zm0 0"></path></svg>',
            3 => '<svg class="img-slot" viewBox="0 -10 512.00005 512"><path d="m436.960938 75.007812c-85.984376-85.984374-216.566407-97.453124-314.546876-37.441406-3.535156 2.167969-4.648437 6.789063-2.480468 10.324219 2.164062 3.539063 6.789062 4.648437 10.324218 2.480469 37.734376-23.113282 81.195313-35.328125 125.683594-35.328125 132.878906 0 240.984375 108.105469 240.984375 240.980469 0 50.964843-15.589843 99.367187-45.140625 140.433593-24.300781-14.980469-51.148437-24.828125-79.167968-29.070312 1.1875-7.277344.140624-4.433594-14.433594-92.210938-.574219-3.234375.515625-6.664062 2.933594-9.019531l60.910156-59.378906c14.847656-14.457032 6.90625-39.96875-13.960938-43.003906l-84.195312-12.234376c-3.324219-.480468-6.1875-2.5625-7.667969-5.574218l-37.660156-76.285156c-9.238281-18.738282-35.972657-18.726563-45.203125 0l-37.660156 76.285156c-1.480469 3.011718-4.34375 5.09375-7.667969 5.574218l-84.191407 12.234376c-20.855468 3.035156-28.820312 28.539062-13.964843 43.003906l19.027343 18.546875c2.964844 2.894531 7.71875 2.832031 10.613282-.128907 2.890625-2.972656 2.832031-7.730468-.132813-10.621093l-19.027343-18.550781c-6.125-5.976563-2.636719-16.1875 5.644531-17.386719l84.183593-12.230469c8.21875-1.191406 15.316407-6.359375 18.992188-13.796875l37.644531-76.285156c3.734375-7.59375 14.546875-7.59375 18.28125 0l37.644531 76.285156c3.675782 7.4375 10.773438 12.605469 18.992188 13.796875l84.183594 12.230469c8.265625 1.195312 11.777344 11.402343 5.644531 17.386719l-60.910156 59.382812c-4.84375 4.714844-7.617188 11.289062-7.617188 18.046875 0 8.324219 15.824219 87.273437 14.644531 92.203125-9.269531-.753906-18.734374-.902344-28.109374-.390625l-61.882813-32.542969c-7.335937-3.851562-16.113281-3.859375-23.460937 0l-75.296876 39.589844c-7.09375 3.707031-14.957031-1.726562-14.957031-8.898438 0-3.949218 14.90625-84.363281 14.90625-89.960937 0-6.757813-2.773437-13.332031-7.605469-18.046875l-20.390624-19.871094c-2.972657-2.894531-7.730469-2.832031-10.621094.128906-2.894532 2.972657-2.832032 7.726563.140625 10.621094l20.390625 19.871094c2.375 2.324219 3.5 5.722656 2.921875 9.027344-14.804688 87.0625-14.753907 84.238281-14.753907 88.230468 0 18.65625 19.929688 31.09375 36.957032 22.191407l75.292968-39.589844c2.925782-1.53125 6.566407-1.53125 9.492188 0l42.421875 22.300781c-21.851563 3.925782-43.042969 11.253906-62.59375 21.753906-3.652344 1.960938-5.023437 6.507813-3.0625 10.160157 1.960937 3.652343 6.507813 5.023437 10.160156 3.0625 56.734375-30.441407 127.332031-31.886719 186.925781.507812-66.542968 17.527344-196.628906 51.796875-261.308593 68.890625 13.191406-20.832031 30.238281-39.25 49.988281-53.902344 3.324219-2.472656 4.023438-7.179687 1.550781-10.5-2.472656-3.335937-7.175781-4.027343-10.5-1.5625-24.347656 18.070313-44.871093 41.472657-59.699219 67.984376-162.230468-75.238282-189.214843-295.917969-48.164062-407.675782 3.253906-2.574218 3.800781-7.296875 1.226562-10.546875-2.578124-3.253906-7.300781-3.800781-10.546874-1.222656-151.703126 120.195313-120.484376 359.375 57.808593 436.035156 3.984375 1.726563-14.550781 5.519531 300.554688-77.480469 1.628906-.398437 3.300781-1.578124 4.191406-2.738281 77.03125-100.992187 68.730469-244.664062-22.679687-336.074219zm0 0"></path></svg>',
            4 => '<svg class="img-slot" viewBox="0 -10 512.00005 512"><path d="m436.960938 75.007812c-85.984376-85.984374-216.566407-97.453124-314.546876-37.441406-3.535156 2.167969-4.648437 6.789063-2.480468 10.324219 2.164062 3.539063 6.789062 4.648437 10.324218 2.480469 37.734376-23.113282 81.195313-35.328125 125.683594-35.328125 132.878906 0 240.984375 108.105469 240.984375 240.980469 0 50.964843-15.589843 99.367187-45.140625 140.433593-24.300781-14.980469-51.148437-24.828125-79.167968-29.070312 1.1875-7.277344.140624-4.433594-14.433594-92.210938-.574219-3.234375.515625-6.664062 2.933594-9.019531l60.910156-59.378906c14.847656-14.457032 6.90625-39.96875-13.960938-43.003906l-84.195312-12.234376c-3.324219-.480468-6.1875-2.5625-7.667969-5.574218l-37.660156-76.285156c-9.238281-18.738282-35.972657-18.726563-45.203125 0l-37.660156 76.285156c-1.480469 3.011718-4.34375 5.09375-7.667969 5.574218l-84.191407 12.234376c-20.855468 3.035156-28.820312 28.539062-13.964843 43.003906l19.027343 18.546875c2.964844 2.894531 7.71875 2.832031 10.613282-.128907 2.890625-2.972656 2.832031-7.730468-.132813-10.621093l-19.027343-18.550781c-6.125-5.976563-2.636719-16.1875 5.644531-17.386719l84.183593-12.230469c8.21875-1.191406 15.316407-6.359375 18.992188-13.796875l37.644531-76.285156c3.734375-7.59375 14.546875-7.59375 18.28125 0l37.644531 76.285156c3.675782 7.4375 10.773438 12.605469 18.992188 13.796875l84.183594 12.230469c8.265625 1.195312 11.777344 11.402343 5.644531 17.386719l-60.910156 59.382812c-4.84375 4.714844-7.617188 11.289062-7.617188 18.046875 0 8.324219 15.824219 87.273437 14.644531 92.203125-9.269531-.753906-18.734374-.902344-28.109374-.390625l-61.882813-32.542969c-7.335937-3.851562-16.113281-3.859375-23.460937 0l-75.296876 39.589844c-7.09375 3.707031-14.957031-1.726562-14.957031-8.898438 0-3.949218 14.90625-84.363281 14.90625-89.960937 0-6.757813-2.773437-13.332031-7.605469-18.046875l-20.390624-19.871094c-2.972657-2.894531-7.730469-2.832031-10.621094.128906-2.894532 2.972657-2.832032 7.726563.140625 10.621094l20.390625 19.871094c2.375 2.324219 3.5 5.722656 2.921875 9.027344-14.804688 87.0625-14.753907 84.238281-14.753907 88.230468 0 18.65625 19.929688 31.09375 36.957032 22.191407l75.292968-39.589844c2.925782-1.53125 6.566407-1.53125 9.492188 0l42.421875 22.300781c-21.851563 3.925782-43.042969 11.253906-62.59375 21.753906-3.652344 1.960938-5.023437 6.507813-3.0625 10.160157 1.960937 3.652343 6.507813 5.023437 10.160156 3.0625 56.734375-30.441407 127.332031-31.886719 186.925781.507812-66.542968 17.527344-196.628906 51.796875-261.308593 68.890625 13.191406-20.832031 30.238281-39.25 49.988281-53.902344 3.324219-2.472656 4.023438-7.179687 1.550781-10.5-2.472656-3.335937-7.175781-4.027343-10.5-1.5625-24.347656 18.070313-44.871093 41.472657-59.699219 67.984376-162.230468-75.238282-189.214843-295.917969-48.164062-407.675782 3.253906-2.574218 3.800781-7.296875 1.226562-10.546875-2.578124-3.253906-7.300781-3.800781-10.546874-1.222656-151.703126 120.195313-120.484376 359.375 57.808593 436.035156 3.984375 1.726563-14.550781 5.519531 300.554688-77.480469 1.628906-.398437 3.300781-1.578124 4.191406-2.738281 77.03125-100.992187 68.730469-244.664062-22.679687-336.074219zm0 0"></path></svg>',
            5 => '<svg class="img-slot" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve"><g><g><path d="M321.645,34.956c-3.883-3.927-10.213-3.964-14.142-0.081l-0.297,0.296c-3.905,3.905-3.905,10.237,0,14.143 c1.952,1.953,4.511,2.929,7.071,2.929c2.559,0,5.119-0.976,7.071-2.929l0.216-0.216C325.491,45.215,325.527,38.884,321.645,34.956 z"></path></g></g><g><g><path d="M476.873,35.172c-36.359-36.358-91.758-45.528-137.857-22.818c-4.954,2.441-6.992,8.436-4.551,13.39 c2.441,4.954,8.436,6.989,13.39,4.551c38.411-18.923,84.577-11.28,114.877,19.021c38.979,38.979,38.979,102.404,0,141.383 c-36.592,36.593-94.728,38.831-133.959,6.719l14.241-14.241c14.371,11.169,31.692,16.776,49.027,16.776 c20.482,0,40.963-7.796,56.557-23.389c31.185-31.185,31.185-81.927,0-113.113c-31.186-31.185-81.927-31.185-113.113,0 c-28.789,28.789-30.978,74.233-6.613,105.584l-14.231,14.231c-25.086-30.596-29.936-73.166-11.563-108.933 c2.523-4.913,0.587-10.94-4.326-13.464c-4.913-2.523-10.94-0.587-13.464,4.326c-19.335,37.638-17.252,81.556,3.846,116.557 c-5.816,1.432-11.325,4.413-15.86,8.948l-10.131,10.131l-45.514-45.514c-8.686-8.686-20.234-13.469-32.517-13.469 s-23.831,4.784-32.517,13.469L13.492,294.418c-17.929,17.93-17.929,47.103,0,65.034l139.103,139.103 c8.965,8.965,20.741,13.447,32.516,13.447s23.552-4.482,32.517-13.447l38.292-38.293c3.906-3.905,3.906-10.237,0-14.143 c-3.904-3.905-10.237-3.905-14.142,0l-38.292,38.293c-10.132,10.132-26.617,10.133-36.749,0L27.634,345.31 c-10.132-10.132-10.132-26.618,0-36.749l139.103-139.104c4.908-4.908,11.434-7.611,18.375-7.611s13.467,2.703,18.375,7.611 l139.103,139.103c4.908,4.908,7.611,11.434,7.611,18.375s-2.703,13.467-7.611,18.375l-50.145,50.144 c-3.906,3.905-3.906,10.237,0,14.143c3.906,3.905,10.238,3.905,14.142,0l50.145-50.144c17.93-17.93,17.93-47.104,0-65.034 l-45.514-45.514l10.131-10.131c4.543-4.543,7.528-10.063,8.956-15.89c18.926,11.355,40.329,17.039,61.736,17.039 c30.722,0,61.445-11.694,84.833-35.082C523.65,158.063,523.65,81.949,476.873,35.172z M349.626,77.592 c11.329-11.33,26.392-17.569,42.414-17.569s31.085,6.24,42.414,17.569c11.33,11.329,17.569,26.392,17.569,42.414 s-6.24,31.085-17.569,42.414c-11.329,11.33-26.392,17.569-42.414,17.569s-31.085-6.24-42.414-17.569 c-11.33-11.329-17.569-26.392-17.569-42.414C332.057,103.985,338.296,88.921,349.626,77.592z M307.206,224.63l-10.131,10.131 l-19.791-19.791l10.131-10.131c5.455-5.457,14.334-5.458,19.791,0C312.663,210.297,312.663,219.174,307.206,224.63z"></path></g></g><g><g><path d="M242.226,269.819c-31.493-31.491-82.735-31.492-114.229,0c-31.492,31.493-31.492,82.735,0,114.229 c15.747,15.747,36.43,23.62,57.114,23.62c20.685,0,41.368-7.873,57.115-23.62C273.718,352.555,273.718,301.313,242.226,269.819z M228.083,369.906c-11.479,11.479-26.739,17.8-42.972,17.8s-31.494-6.321-42.972-17.8c-11.479-11.479-17.8-26.739-17.8-42.972 c0-16.233,6.321-31.493,17.8-42.972c11.848-11.848,27.409-17.772,42.972-17.772s31.124,5.924,42.972,17.772 C251.779,307.656,251.779,346.212,228.083,369.906z"></path></g></g><g><g><path d="M281.916,420.124c-1.859-1.87-4.439-2.93-7.07-2.93c-2.63,0-5.21,1.06-7.07,2.93c-1.86,1.86-2.93,4.43-2.93,7.07 c0,2.63,1.07,5.21,2.93,7.07s4.44,2.93,7.07,2.93s5.21-1.07,7.07-2.93c1.87-1.86,2.93-4.44,2.93-7.07 C284.846,424.554,283.786,421.984,281.916,420.124z"></path></g></g></svg>',
        ];

        $svg = '<svg class="plus-slot" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path></svg>';
    
        $stickersToIterate = '<div class="sk-modal-weapon-stickers">
                            <button class="collections-sk-modal-weapon-sticker" id="4">' .
                                (!empty($stickers_data[0]) ? '<img src="' . $stickers_get_cache[$stickers_data[0]]['image'] . '" alt="sticker">' : $svg . $svg_image[4]) .
                            '</button>
                            <button class="collections-sk-modal-weapon-sticker" id="3">' .
                                (!empty($stickers_data[1]) ? '<img src="' . $stickers_get_cache[$stickers_data[1]]['image'] . '" alt="sticker">' : $svg . $svg_image[3]) .
                            '</button>
                            <button class="collections-sk-modal-weapon-sticker" id="2">' .
                                (!empty($stickers_data[2]) ? '<img src="' . $stickers_get_cache[$stickers_data[2]]['image'] . '" alt="sticker">' : $svg . $svg_image[2]) .
                            '</button>
                            <button class="collections-sk-modal-weapon-sticker" id="1">' .
                                (!empty($stickers_data[3]) ? '<img src="' . $stickers_get_cache[$stickers_data[3]]['image'] . '" alt="sticker">' : $svg . $svg_image[1]) .
                            '</button>
                            <button class="collections-sk-modal-weapon-sticker" id="5">' .
                                (!empty($keychain_data[0]) ? '<img src="' . $keychains_get_cache[$keychain_data[0]]['image'] . '" alt="keychain">' : $svg . $svg_image[5]) .
                            '</button> 
                        </div>'; 
        return $stickersToIterate;
    }

    public function CollectionsStickersKeychainHtml($POST)
    {

        $table = '';

        if ($POST['id'] > 4) {
            $data = $this->get_cache($this->keychains);
            $count = count($data);
        } else {
            $data = $this->get_cache($this->stickers);
            $count = count($data);
        }

        $table = <<<HTML
                <div class="search-skin-input">
                    <svg viewBox="0 0 512 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path class="fa-primary" d="M330.7 376L457.4 502.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L376 330.7C363.3 348 348 363.3 330.7 376z"></path><path class="fa-secondary" d="M208 64a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 352A208 208 0 1 0 208 0a208 208 0 1 0 0 416z"></path></svg>
                    <input type="text" id="search_js_stickers2" placeholder="{$this->Translate('_search')}"> <!-- #ПЕРЕВОД -->
                </div>    
                <div class="stickers-modal-js scroll">{$this->CollectionsSkinChangerStickers($POST)['html']}</div>
                <div id="stickers-pagination"></div>
        HTML;

        return ['html' => (!empty($table) ? $table : $this->Translate('_error')), 'count' => $count]; 
    }
    

    public function ModalWPCollectionKnife($POST)
    {
        $weapons = "";
        $Skins = $this->get_cache($this->skins);

        $selected_skins = array_filter($Skins, function ($s) {
            if ($s['type'] !== "Knife") return false;
            return true;
        });
        
        if (!empty($selected_skins)) {
            $skinsToIterate = $selected_skins;
        } else {
            $skinsToIterate = $Skins;
        } # проверка сортировки на наличие

        if (!empty($skin)) {
            $skinsToIterate = array_filter($Skins, function ($wp) use ($skin) {
                return strpos(strtolower($wp['name']), strtolower($skin)) !== false;
            });
        } # найти скин/оружие/агентов/музыки и т.д. по названию

        if ($this->Settings('type') == 1) {
            $DBQuery = "SELECT 
                (SELECT `knife` FROM `wp_collections_list` WHERE `id` = :collection_id LIMIT 1) AS `knife`";
            $result = $this->Db->query('Skins', 0, 0, $DBQuery, [
                'collection_id' => $POST['collectionID'],
            ]);
        }# шаблон запроса к бд

        $weapons .= <<<HTML
            <div class="skin-modal-js scroll">
        HTML;

        foreach ($skinsToIterate as $Skin) {

            if ($Skin['id'] !=0 ) {
                $id = $Skin['id'];
                $id_name = $Skin['id_name'];
                $name = $Skin['name'];
        
                $color = "";
                $range = "";
                $stattrack = "";

                $button = "";
                $Sticker_html = "";
                $range_html = "";
                $desc = $this->Translate('_skins_none');
                $img = $Skin['img'];
                $choose_weapon = $this->Translate('_choose_weapon');

                if ($id_name != 'weapon_taser') {
                    if ($this->Settings('type') == 1) {
                        $skin_active = $this->Db->query('Skins', 0, 0, "SELECT `weapon_paint_id` AS skin, `weapon_wear` AS `range`, `weapon_nametag` AS `tag`, `weapon_stattrak` AS `stattrack`, `weapon_sticker_0`, `weapon_sticker_1`, `weapon_sticker_2`, `weapon_sticker_3`, `weapon_keychain` FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                            'collection_id' => $POST['collectionID'],
                            'weapon_defindex' => $id,
                        ]);
                        
                        $skin = $skin_active['skin'];
                        $float = $skin_active['range'];
                        switch (true) {
                            case ($Skin['type'] == "Knife" && $result['knife'] == $id_name || $Skin['type'] == "Gloves" && $result['glove'] == $id):
                                $choice = ' choice_active';
                                $choose_weapon = $this->Translate('_choose_default');
                                break;
                            default:
                                $choice = '';
                                break;
                        } # проверка выбранных ножей и перчаток
                        $stickers_data = [
                            explode(';', $skin_active['weapon_sticker_0'])[0],
                            explode(';', $skin_active['weapon_sticker_1'])[0],
                            explode(';', $skin_active['weapon_sticker_2'])[0],
                            explode(';', $skin_active['weapon_sticker_3'])[0]
                        ];
                        $keychain_data = explode(';', $skin_active['weapon_keychain']);
                    }

                    if (!empty($skin_active['tag'])) { 
                        $name = "<s>{$name}</s> {$skin_active['tag']}"; 
                    }

                    if ($skin_active['stattrack'] == 1) { 
                        $stattrack = " / StatTrak™"; 
                    } 

                    if ($Skin['type'] == "Knife" && $result['knife'] == $id_name) { 
                        if (!empty($skin_active['tag'])) { 
                            $name = "<s>{$name}</s> {$skin_active['tag']}"; 
                        }

                        $Sticker_html = $this->StickerHtmlCollection($stickers_data, $keychain_data);

                        if (!empty($skin)) {  
                            $color = " " . $Skin['skins'][$skin]['id_rarity'] ?: '';
                            $img = $Skin['skins'][$skin]['image'] ?: $img;
                            if ($float >= 0.45) {
                                $float_name = 'BS';
                            } else if ($float >= 0.3800) {
                                $float_name = 'WW';
                            } else if ($float >= 0.1500) {
                                $float_name = 'FT';
                            } else if ($float >= 0.0700) {
                                $float_name = 'MW';
                            } else if ($float >= 0.0001) {
                                $float_name = 'FN';
                            } else {
                                $float_name = 'FN';
                            }
                            $range = "<div class='info-float-range'>{$float_name} / {$float}{$stattrack}<input name='float-range' class='range-1' type='range' min='0.0001' max='0.9999' step='0.0001' value='{$float}' disabled=''></div>";
                            $desc = trim(explode('|', $Skin['skins'][$skin]['name'])[1]) ?: $desc;
                        } # изменение скинов если есть
                    }
                    $range_html = !empty($range) ? $range : (!empty($stattrack) ? "<div class='info-float-range'>StatTrak™</div>" : "");

                    $add_id = "";
                    if ($Skin['type'] == "Knife" && $id_name != 'weapon_taser') {
                        $add_id = "id='CollectionsSkinChangerAddKnife' id_knife='{$id}'";
                    }

                    $button = ($id_name != 'weapon_knife')
                        ? (($Skin['type'] == "Knife") ? '<b class="button-skin" id="CollectionModalWeapon" data-name="' . $id_name . '">' . $this->Translate('_skins_check') . '</b>'
                        : '<b class="button-skin">' . $this->Translate('_skins_check') . '</b>') : '<b class="button-skin">' . $choose_weapon . '</b>';

                    $weapons .= <<<HTML
                                        <div class="block-skin-fon{$choice}{$color}" {$add_id}>
                                            {$range_html}{$Sticker_html}{$button}
                                            <div class="block-skin-img">
                                                <img class="loader_img_weapon" src="{$img}" loading="lazy" alt="{$name}">
                                            </div>
                                            <div class="block-skin-info">
                                                <b class="data-name">{$name}</b>
                                                <span>{$desc}</span>
                                            </div>
                                        </div>
                                HTML;
                }
            }
        }

        $weapons .= <<<HTML
            </div>
        HTML;
    
        return ['html' => $weapons ?: $this->Translate('_skins_no')];
    }



public function CollectionsSkinChangerAddKnife($POST)
{
    if (!is_numeric($POST['id_knife']) || intval($POST['id_knife']) != $POST['id_knife'] || $POST['id_knife'] < 0) return ['html' => $this->Translate('_nonono')];

    if (!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];

    $skinsData = $this->get_cache($this->skins);
    $skinsData = array_filter($skinsData, function ($skin) use ($POST) {
        return $skin['id'] == $POST['id_knife'] && $skin['type'] == "Knife";
    });
    $skinsData = reset($skinsData);
    if (empty($skinsData['name'])) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

        $currentKnife = $this->Db->query('Skins', 0, 0, "SELECT `knife` FROM `wp_collections_list` WHERE `id` = :collection_id LIMIT 1", [
            'collection_id' => $POST['collectionID'],
        ]);

        if (!empty($currentKnife['knife'])) {
            $currentKnifeData = array_filter($this->get_cache($this->skins), function ($skin) use ($currentKnife) {
                return $skin['id_name'] == $currentKnife['knife'] && $skin['type'] == "Knife";
            });
            $currentKnifeData = reset($currentKnifeData);

            if (!empty($currentKnifeData['id'])) {
                // Удаляем старые записи для текущего ножа в wp_collections_items
                $this->Db->query('Skins', 0, 0, "DELETE FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex", [
                    'collection_id' => $POST['collectionID'],
                    'weapon_defindex' => $currentKnifeData['id'],
                ]);
            }
        }

        $Knife = $this->get_cache($this->skins);
        $Knife = array_filter($Knife, function ($knife) use ($POST) {
            return $knife['id'] == $POST['id_knife'];
        });
        $Knife = reset($Knife);

        $this->Db->query('Skins', 0, 0, "UPDATE `wp_collections_list` SET `knife` = :knife WHERE `id` = :collection_id LIMIT 1", [
            'collection_id' => $POST['collectionID'],
            "knife" => $Knife['id_name'],
        ]);

        return ['status' => 'success', 'text' => "{$this->Translate('_knife_yoyo')} {$skinsData['name']}"];

}

    

    public function StickerHtmlCollection($stickers_data, $keychain_data)
    {

        $stickers_get_cache = $this->get_cache($this->stickers);
        $keychains_get_cache = $this->get_cache($this->keychains);
    
        $stickersToIterate = '<div class="weapon-stickers">' .
            (!empty($stickers_data[0]) ? '<img src="' . $stickers_get_cache[$stickers_data[0]]['image'] . '" data-tippy-content="' . $stickers_get_cache[$stickers_data[0]]['name'] . '" data-tippy-placement="left" alt="sticker">' : '') .
            (!empty($stickers_data[1]) ? '<img src="' . $stickers_get_cache[$stickers_data[1]]['image'] . '" data-tippy-content="' . $stickers_get_cache[$stickers_data[1]]['name'] . '" data-tippy-placement="left" alt="sticker">' : '') .
            (!empty($stickers_data[2]) ? '<img src="' . $stickers_get_cache[$stickers_data[2]]['image'] . '" data-tippy-content="' . $stickers_get_cache[$stickers_data[2]]['name'] . '" data-tippy-placement="left" alt="sticker">' : '') .
            (!empty($stickers_data[3]) ? '<img src="' . $stickers_get_cache[$stickers_data[3]]['image'] . '" data-tippy-content="' . $stickers_get_cache[$stickers_data[3]]['name'] . '" data-tippy-placement="left" alt="sticker">' : '') .  
            (!empty($keychain_data[0]) ? '<img src="' . $keychains_get_cache[$keychain_data[0]]['image'] . '" data-tippy-content="' . $keychains_get_cache[$keychain_data[0]]['name'] . '" data-tippy-placement="left" alt="keychain">' : '') .  
        '</div>';
        return $stickersToIterate;
    }




    public function ModalWPCollectionGloves($POST)
    {
        $weapons = "";
        $Skins = $this->get_cache($this->skins);

        $selected_skins = array_filter($Skins, function ($s) {
            if ($s['type'] !== "Gloves") return false;
            return true;
        });
        
        if (!empty($selected_skins)) {
            $skinsToIterate = $selected_skins;
        } else {
            $skinsToIterate = $Skins;
        } # проверка сортировки на наличие

        if (!empty($skin)) {
            $skinsToIterate = array_filter($Skins, function ($wp) use ($skin) {
                return strpos(strtolower($wp['name']), strtolower($skin)) !== false;
            });
        } # найти скин/оружие/агентов/музыки и т.д. по названию

        if ($this->Settings('type') == 1) {
            $DBQuery = "SELECT 
                (SELECT `glove` FROM `wp_collections_list` WHERE `id` = :collection_id LIMIT 1) AS `glove`";
            $result = $this->Db->query('Skins', 0, 0, $DBQuery, [
                'collection_id' => $POST['collectionID'],
            ]);
        }# шаблон запроса к бд

        $weapons .= <<<HTML
            <div class="skin-modal-js scroll">
        HTML;

        foreach ($skinsToIterate as $Skin) {

            if ($Skin['id'] !=0 ) {
                $id = $Skin['id'];
                $id_name = $Skin['id_name'];
                $name = $Skin['name'];
        
                $color = "";
                $range = "";
                $stattrack = "";

                $button = "";
                $Sticker_html = "";
                $range_html = "";
                $desc = $this->Translate('_skins_none');
                $img = $Skin['img'];
                $choose_weapon = $this->Translate('_choose_weapon');

                if ($id_name != 'weapon_taser') {
                    if ($this->Settings('type') == 1) {
                        $skin_active = $this->Db->query('Skins', 0, 0, "SELECT `weapon_paint_id` AS skin, `weapon_wear` AS `range`, `weapon_nametag` AS `tag`, `weapon_stattrak` AS `stattrack`, `weapon_sticker_0`, `weapon_sticker_1`, `weapon_sticker_2`, `weapon_sticker_3`, `weapon_keychain` FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex LIMIT 1", [
                            'collection_id' => $POST['collectionID'],
                            'weapon_defindex' => $id,
                        ]);
                        
                        $skin = $skin_active['skin'];
                        $float = $skin_active['range'];
                        switch (true) {
                            case ($Skin['type'] == "Gloves" && $result['glove'] == $id):
                                $choice = ' choice_active';
                                $choose_weapon = $this->Translate('_choose_default');
                                break;
                            default:
                                $choice = '';
                                break;
                        } # проверка выбранных ножей и перчаток
                        $stickers_data = [
                            explode(';', $skin_active['weapon_sticker_0'])[0],
                            explode(';', $skin_active['weapon_sticker_1'])[0],
                            explode(';', $skin_active['weapon_sticker_2'])[0],
                            explode(';', $skin_active['weapon_sticker_3'])[0]
                        ];
                        $keychain_data = explode(';', $skin_active['weapon_keychain']);
                    }

                    if (!empty($skin_active['tag'])) { 
                        $name = "<s>{$name}</s> {$skin_active['tag']}"; 
                    }

                    if ($skin_active['stattrack'] == 1) { 
                        $stattrack = " / StatTrak™"; 
                    } 

                    if ($Skin['type'] == "Gloves" && $result['glove'] == $id) { 
                        if (!empty($skin_active['tag'])) { 
                            $name = "<s>{$name}</s> {$skin_active['tag']}"; 
                        }

                        $Sticker_html = $this->StickerHtmlCollection($stickers_data, $keychain_data);

                        if (!empty($skin)) {  
                            $color = " " . $Skin['skins'][$skin]['id_rarity'] ?: '';
                            $img = $Skin['skins'][$skin]['image'] ?: $img;
                            if ($float >= 0.45) {
                                $float_name = 'BS';
                            } else if ($float >= 0.3800) {
                                $float_name = 'WW';
                            } else if ($float >= 0.1500) {
                                $float_name = 'FT';
                            } else if ($float >= 0.0700) {
                                $float_name = 'MW';
                            } else if ($float >= 0.0001) {
                                $float_name = 'FN';
                            } else {
                                $float_name = 'FN';
                            }
                            $range = "<div class='info-float-range'>{$float_name} / {$float}{$stattrack}<input name='float-range' class='range-1' type='range' min='0.0001' max='0.9999' step='0.0001' value='{$float}' disabled=''></div>";
                            $desc = trim(explode('|', $Skin['skins'][$skin]['name'])[1]) ?: $desc;
                        }
                    }
                    $range_html = !empty($range) ? $range : (!empty($stattrack) ? "<div class='info-float-range'>StatTrak™</div>" : "");

                    $add_id = "";
                    if ($Skin['type'] == "Gloves" && $id_name != 'weapon_taser') {
                        $add_id = "id='CollectionsSkinChangerAddGlove' id_glove='{$id}'";
                    }

                    $button = ($id_name != 'glove_ct' && $id_name != 'glove_t')
                        ? (($Skin['type'] == "Gloves") ? '<b class="button-skin" id="CollectionModalWeapon" data-name="' . $id_name . '">' . $this->Translate('_skins_check') . '</b>'
                        : '<b class="button-skin">' . $this->Translate('_skins_check') . '</b>') : '<b class="button-skin">' . $choose_weapon . '</b>';

                    $weapons .= <<<HTML
                                        <div class="block-skin-fon{$choice}{$color}" {$add_id}>
                                            {$range_html}{$Sticker_html}{$button}
                                            <div class="block-skin-img">
                                                <img class="loader_img_weapon" src="{$img}" loading="lazy" alt="{$name}">
                                            </div>
                                            <div class="block-skin-info">
                                                <b class="data-name">{$name}</b>
                                                <span>{$desc}</span>
                                            </div>
                                        </div>
                                HTML;
                }
            }
        }

        $weapons .= <<<HTML
            </div>
        HTML;
    
        return ['html' => $weapons ?: $this->Translate('_skins_no')];
    }

    public function CollectionsSkinChangerAddGlove($POST)
    {
        if (!is_numeric($POST['id_glove']) || intval($POST['id_glove']) != $POST['id_glove'] || $POST['id_glove'] < 0) return ['html' => $this->Translate('_nonono')];

        if (!isset($_SESSION['steamid64'])) return ['status' => 'error', 'text' => $this->Translate('_no_auth')];

        $skinsData = $this->get_cache($this->skins);
        $skinsData = array_filter($skinsData, function ($skin) use ($POST) {
            return $skin['id'] == $POST['id_glove'] && $skin['type'] == "Gloves";
        }); 
        $skinsData = reset($skinsData);
        if (empty($skinsData['name'])) return ['status' => 'error', 'text' => $this->Translate('_nonono')];

            $currentGlove = $this->Db->query('Skins', 0, 0, "SELECT `glove` FROM `wp_collections_list` WHERE `id` = :collection_id LIMIT 1", [
                'collection_id' => $POST['collectionID'],
            ]);

            if (!empty($currentGlove['glove'])) {
                $this->Db->query('Skins', 0, 0, "DELETE FROM `wp_collections_items` WHERE `collection_id` = :collection_id AND `weapon_defindex` = :weapon_defindex", [
                    'collection_id' => $POST['collectionID'],
                    'weapon_defindex' => $currentGlove['glove'],
                ]);
            }

            $this->Db->query('Skins', 0, 0, "UPDATE `wp_collections_list` SET `glove` = :glove WHERE `id` = :collection_id LIMIT 1", [
                'collection_id' => $POST['collectionID'],
                "glove" => $POST['id_glove'],
            ]);

            return ['status' => 'success', 'text' => "{$this->Translate('_gl_yoyo')} {$skinsData['name']}"];
    }

	 public function CollectionApply($POST)
	{
        if (isset($_SESSION['last_apply_time'])) {
            $lastApplyTime = $_SESSION['last_apply_time'];
            $currentTime = time();
            $timeDiff = $currentTime - $lastApplyTime;

            if ($timeDiff < 2) {
                return [
                    'status' => 'error',
                    'message' => 'Пожалуйста, подождите перед отправкой следующего запроса.'
                ];
            }
        }

        $_SESSION['last_apply_time'] = time();


		if (!isset($POST['collectionID'])) {
			return [
				'status' => 'error',
				'message' => 'ID коллекции не указан'
			];
		}

		$collectionID = (int)$POST['collectionID'];
		$steamid64 = $_SESSION['steamid64'];

		$collection = $this->Db->queryAll('Skins', 0, 0, 
			"SELECT id, knife, glove FROM wp_collections_list WHERE id = :id", 
			[
				'id' => $collectionID
			]
		);

		if (empty($collection)) {
			return [
				'status' => 'error',
				'message' => 'Коллекция не найдена'
			];
		}


		if ($this->Settings('type') == 1) {

			$this->Db->query('Skins', 0, 0, 
				"DELETE FROM wp_player_skins WHERE steamid = :steamid", 
				[
					'steamid' => $steamid64
				]
			);

			$this->Db->query('Skins', 0, 0, 
				"DELETE FROM wp_player_knife WHERE steamid = :steamid", 
				[
					'steamid' => $steamid64
				]
			);

			$this->Db->query('Skins', 0, 0, 
				"DELETE FROM wp_player_gloves WHERE steamid = :steamid", 
				[
					'steamid' => $steamid64
				]
			);

			$collectionItems = $this->Db->queryAll('Skins', 0, 0, 
				"SELECT 
					weapon_defindex, 
					weapon_paint_id, 
					weapon_wear, 
					weapon_seed, 
					weapon_nametag, 
					weapon_stattrak, 
					weapon_stattrak_count, 
					weapon_sticker_0, 
					weapon_sticker_1, 
					weapon_sticker_2, 
					weapon_sticker_3, 
					weapon_sticker_4, 
					weapon_keychain 
				FROM wp_collections_items 
				WHERE collection_id = :collection_id", 
				[
					'collection_id' => $collectionID
				]
			);

			foreach ($collectionItems as $item) {
				$this->Db->query('Skins', 0, 0, 
					"INSERT INTO wp_player_skins (
						steamid, 
						weapon_team, 
						weapon_defindex, 
						weapon_paint_id, 
						weapon_wear, 
						weapon_seed, 
						weapon_nametag, 
						weapon_stattrak, 
						weapon_stattrak_count, 
						weapon_sticker_0, 
						weapon_sticker_1, 
						weapon_sticker_2, 
						weapon_sticker_3, 
						weapon_sticker_4, 
						weapon_keychain
					) VALUES (
						:steamid, 
						:weapon_team, 
						:weapon_defindex, 
						:weapon_paint_id, 
						:weapon_wear, 
						:weapon_seed, 
						:weapon_nametag, 
						:weapon_stattrak, 
						:weapon_stattrak_count, 
						:weapon_sticker_0, 
						:weapon_sticker_1, 
						:weapon_sticker_2, 
						:weapon_sticker_3, 
						:weapon_sticker_4, 
						:weapon_keychain
					)", 
					[
						'steamid' => $steamid64,
						'weapon_team' => 2,
						'weapon_defindex' => $item['weapon_defindex'],
						'weapon_paint_id' => $item['weapon_paint_id'],
						'weapon_wear' => $item['weapon_wear'],
						'weapon_seed' => $item['weapon_seed'],
						'weapon_nametag' => $item['weapon_nametag'],
						'weapon_stattrak' => $item['weapon_stattrak'],
						'weapon_stattrak_count' => $item['weapon_stattrak_count'],
						'weapon_sticker_0' => $item['weapon_sticker_0'],
						'weapon_sticker_1' => $item['weapon_sticker_1'],
						'weapon_sticker_2' => $item['weapon_sticker_2'],
						'weapon_sticker_3' => $item['weapon_sticker_3'],
						'weapon_sticker_4' => $item['weapon_sticker_4'],
						'weapon_keychain' => $item['weapon_keychain']
					]
				);

				$this->Db->query('Skins', 0, 0, 
					"INSERT INTO wp_player_skins (
						steamid, 
						weapon_team, 
						weapon_defindex, 
						weapon_paint_id, 
						weapon_wear, 
						weapon_seed, 
						weapon_nametag, 
						weapon_stattrak, 
						weapon_stattrak_count, 
						weapon_sticker_0, 
						weapon_sticker_1, 
						weapon_sticker_2, 
						weapon_sticker_3, 
						weapon_sticker_4, 
						weapon_keychain
					) VALUES (
						:steamid, 
						:weapon_team, 
						:weapon_defindex, 
						:weapon_paint_id, 
						:weapon_wear, 
						:weapon_seed, 
						:weapon_nametag, 
						:weapon_stattrak, 
						:weapon_stattrak_count, 
						:weapon_sticker_0, 
						:weapon_sticker_1, 
						:weapon_sticker_2, 
						:weapon_sticker_3, 
						:weapon_sticker_4, 
						:weapon_keychain
					)", 
					[
						'steamid' => $steamid64,
						'weapon_team' => 3,
						'weapon_defindex' => $item['weapon_defindex'],
						'weapon_paint_id' => $item['weapon_paint_id'],
						'weapon_wear' => $item['weapon_wear'],
						'weapon_seed' => $item['weapon_seed'],
						'weapon_nametag' => $item['weapon_nametag'],
						'weapon_stattrak' => $item['weapon_stattrak'],
						'weapon_stattrak_count' => $item['weapon_stattrak_count'],
						'weapon_sticker_0' => $item['weapon_sticker_0'],
						'weapon_sticker_1' => $item['weapon_sticker_1'],
						'weapon_sticker_2' => $item['weapon_sticker_2'],
						'weapon_sticker_3' => $item['weapon_sticker_3'],
						'weapon_sticker_4' => $item['weapon_sticker_4'],
						'weapon_keychain' => $item['weapon_keychain']
					]
				);
			}

			if (!empty($collection[0]['knife'])) {
				$this->Db->query('Skins', 0, 0, 
					"INSERT INTO wp_player_knife (steamid, weapon_team, knife) VALUES (:steamid, :weapon_team, :knife)", 
					[
						'steamid' => $steamid64,
						'weapon_team' => 2,
						'knife' => $collection[0]['knife']
					]
				);

				// Добавляем нож с weapon_team = 3
				$this->Db->query('Skins', 0, 0, 
					"INSERT INTO wp_player_knife (steamid, weapon_team, knife) VALUES (:steamid, :weapon_team, :knife)", 
					[
						'steamid' => $steamid64,
						'weapon_team' => 3,
						'knife' => $collection[0]['knife']
					]
				);
			}

			if (!empty($collection[0]['glove'])) {
				$this->Db->query('Skins', 0, 0, 
					"INSERT INTO wp_player_gloves (steamid, weapon_team, weapon_defindex) VALUES (:steamid, :weapon_team, :weapon_defindex)", 
					[
						'steamid' => $steamid64,
						'weapon_team' => 2,
						'weapon_defindex' => $collection[0]['glove']
					]
				);

				$this->Db->query('Skins', 0, 0, 
					"INSERT INTO wp_player_gloves (steamid, weapon_team, weapon_defindex) VALUES (:steamid, :weapon_team, :weapon_defindex)", 
					[
						'steamid' => $steamid64,
						'weapon_team' => 3,
						'weapon_defindex' => $collection[0]['glove']
					]
				);
			}
    }else if ($this->Settings('type') == 2) {
        $serverID = $POST['id_server'];
        $id_team = $POST['id_team'];

        if (!$serverID || !isset($id_team)) {
            return [
                'status' => 'error',
                'message' => 'ID сервера или ID команды не указан'
            ];
        }

        $player = $this->Db->query('Skins', 0, 0, 
            "SELECT id FROM sc_player WHERE steamid = :steamid", 
            [
                'steamid' => $steamid64
            ]
        );

        if (empty($player)) {
            return [
                'status' => 'error',
                'message' => 'Игрок не найден в таблице sc_player'
            ];
        }

        $playerID = $player['id'];

        $this->Db->query('Skins', 0, 0, 
            "DELETE FROM sc_skins WHERE player_id = :player_id AND server_id = :server_id AND team = :team", 
            [
                'player_id' => $playerID,
                'server_id' => $serverID,
                'team' => $id_team
            ]
        );

        $collectionItems = $this->Db->queryAll('Skins', 0, 0, 
            "SELECT 
                weapon_defindex, 
                weapon_paint_id, 
                weapon_wear, 
                weapon_seed, 
                weapon_nametag, 
                weapon_stattrak, 
                weapon_stattrak_count, 
                weapon_sticker_0, 
                weapon_sticker_1, 
                weapon_sticker_2, 
                weapon_sticker_3,
                weapon_keychain 
            FROM wp_collections_items 
            WHERE collection_id = :collection_id", 
            [
                'collection_id' => $collectionID
            ]
        );

        if (empty($collectionItems)) {
            return [
                'status' => 'error',
                'message' => 'Коллекция пуста или не найдена'
            ];
        }

        foreach ($collectionItems as $item) {
            $sticker0 = !empty($item['weapon_sticker_0']) ? explode(';', $item['weapon_sticker_0'])[0] : '';
            $sticker1 = !empty($item['weapon_sticker_1']) ? explode(';', $item['weapon_sticker_1'])[0] : '';
            $sticker2 = !empty($item['weapon_sticker_2']) ? explode(';', $item['weapon_sticker_2'])[0] : '';
            $sticker3 = !empty($item['weapon_sticker_3']) ? explode(';', $item['weapon_sticker_3'])[0] : '';

            $data = [
                'player_id' => $playerID,
                'server_id' => $serverID,
                'team' => $id_team,
                'weapon_index' => $item['weapon_defindex'],
                'stattrack' => $item['weapon_stattrak'],
                'stattrack_count' => $item['weapon_stattrak_count'],
                'stickers' => implode(';', [$sticker0, $sticker1, $sticker2, $sticker3]),
                'skin' => "{$item['weapon_paint_id']};{$item['weapon_seed']};{$item['weapon_wear']}",
                'tag' => $item['weapon_nametag'],
                'keychain' => $item['weapon_keychain'],
                'stickers_data' => null
            ];

            $this->Db->query('Skins', 0, 0, 
                "INSERT INTO sc_skins (
                    player_id, 
                    server_id, 
                    team, 
                    weapon_index, 
                    stattrack, 
                    stattrack_count, 
                    stickers, 
                    skin, 
                    tag, 
                    keychain,
                    stickers_data
                ) VALUES (
                    :player_id, 
                    :server_id, 
                    :team, 
                    :weapon_index, 
                    :stattrack, 
                    :stattrack_count, 
                    :stickers, 
                    :skin, 
                    :tag, 
                    :keychain,
                    :stickers_data
                )", 
                $data
            );
        }

        if (!empty($collection[0]['knife']) || !empty($collection[0]['glove'])) {
            $skinsCache = $this->get_cache($this->skins);
        
            $knifeWeaponIndex = 0;
            if (!empty($collection[0]['knife'])) {
                $knifeData = array_filter($skinsCache, function ($skin) use ($collection) {
                    return $skin['id_name'] == $collection[0]['knife'] && $skin['type'] == "Knife";
                });
                $knifeData = reset($knifeData);
                $knifeWeaponIndex = $knifeData['id'] ?? 0;
            }
        
            $gloveWeaponIndex = !empty($collection[0]['glove']) ? $collection[0]['glove'] : 0;
        
            $existingRecord = $this->Db->query('Skins', 0, 0, 
                "SELECT id FROM sc_items WHERE 
                    player_id = :player_id AND 
                    server_id = :server_id AND 
                    team = :team", 
                [
                    'player_id' => $playerID,
                    'server_id' => $serverID,
                    'team' => $id_team
                ]
            );
        
            if ($existingRecord) {
                $this->Db->query('Skins', 0, 0, 
                    "UPDATE sc_items SET 
                        knife = :knife, 
                        glove = :glove 
                    WHERE 
                        player_id = :player_id AND 
                        server_id = :server_id AND 
                        team = :team", 
                    [
                        'player_id' => $playerID,
                        'server_id' => $serverID,
                        'team' => $id_team,
                        'knife' => $knifeWeaponIndex,
                        'glove' => $gloveWeaponIndex
                    ]
                );
            } else {
                $this->Db->query('Skins', 0, 0, 
                    "INSERT INTO sc_items 
                        (player_id, server_id, team, knife, glove) 
                    VALUES 
                        (:player_id, :server_id, :team, :knife, :glove)", 
                    [
                        'player_id' => $playerID,
                        'server_id' => $serverID,
                        'team' => $id_team,
                        'knife' => $knifeWeaponIndex,
                        'glove' => $gloveWeaponIndex
                    ]
                );
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Неизвестный тип системы'
            ];
        }
    }

    $applied = $this->Db->query('Skins', 0, 0, 
    "SELECT id FROM wp_collections_applied WHERE steamid = :steamid AND collection_id = :collection_id", 
    [
        'steamid' => $steamid64,
        'collection_id' => $collectionID
    ]
    );

    $this->Db->query('Skins', 0, 0, 
    "INSERT INTO wp_collections_applied (steamid, collection_id) VALUES (:steamid, :collection_id)", 
    [
        'steamid' => $steamid64,
        'collection_id' => $collectionID
    ]
    );

    if (!$applied) {
    $this->Db->query('Skins', 0, 0, 
        "UPDATE wp_collections_list SET used = used + 1 WHERE id = :id", 
        [
            'id' => $collectionID
        ]
    );
    }

    return [
        'status' => 'success',
        'message' => 'Коллекция успешно применена'
    ];
}
}
