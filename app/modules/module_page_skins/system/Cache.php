<?php /**
    * @author SeverskiY (@severskteam)
**/

namespace app\modules\module_page_skins\system;

use app\modules\module_page_skins\system\FunctionCore;

class Cache extends FunctionCore
{    
    protected $Db, $General, $Translate, $languages, $skins;

    public function __construct($Db, $General, $Translate)
    {
        $this->Db            = $Db;
        $this->General       = $General;
        $this->Translate     = $Translate;
        $this->languages     = strtolower($_SESSION['language']);
    }

    public function CacheSkins()
    {
        $languages = ['ru', 'uk', 'en', 'de'];
        function createSkinStructure($skinInfo) {
            return [
                "id_skin" => $skinInfo['paint_index'],
                "name" => $skinInfo["name"],
                "image" => $skinInfo["image"],
                "id_rarity" => $skinInfo["rarity"]['id'],
                "rarity" => $skinInfo["rarity"]['name']
            ];
        }
        
        foreach ($languages as $language) {
        
            if ($language == "uk") {
                $cacheFilePath = MODULES . "module_page_skins/cache/skins-ua.json";
            } else {
                $cacheFilePath = MODULES . "module_page_skins/cache/skins-{$language}.json";
            }
        
            $SkinsCache = $this->get_cache(MODULES . "module_page_skins/cache/standard.json");
        
            $SkinsData = $this->get_cache("https://raw.githubusercontent.com/ByMykel/CSGO-API/refs/heads/main/public/api/{$language}/skins.json");
        
            foreach ($SkinsCache as &$cacheEntry) {
                $idName = $cacheEntry["id_name"];
                if (!isset($cacheEntry["skins"])) {
                    $cacheEntry["skins"] = [];
                }
                $selected_skins = array_filter($SkinsData, function($skin) use ($idName) {
                    return $skin['weapon']['id'] == $idName;
                });
                foreach ($selected_skins as $Skin) {
                    $paintIndex = $Skin['paint_index'];
                    if (!isset($cacheEntry["skins"][$paintIndex])) {
                        $cacheEntry["skins"][$paintIndex] = createSkinStructure($Skin);
                    }
                }
            }
            
            $this->put_cache($cacheFilePath, $SkinsCache);
        }

        return ['status' => 'success', 'text' => $this->Translate('_yspex_ccc')]; # ПЕРЕВОД
    }

    public function CacheKeychains()
    {
        $languages = ['ru', 'uk', 'en', 'de'];
    
        $languages_text = [
            "ru" => "Брелок | Не выбран",
            "uk" => "Брелків | Не вибран",
            "en" => "Keychain | Not selected",
            "de" => "Schlüsselanhänger | Nicht ausgewählt"
        ];
    
        foreach ($languages as $language) {
    
            if ($language == "uk") {
                $cacheFilePath = MODULES . "module_page_skins/cache/keychains-ua.json";
            } else {
                $cacheFilePath = MODULES . "module_page_skins/cache/keychains-{$language}.json";
            }
    
            $KeychainsData = $this->get_cache("https://bymykel.github.io/CSGO-API/api/{$language}/keychains.json");
    
            $newFormat = [];
            foreach ($KeychainsData as $cacheEntry) {
                $id = explode('-', $cacheEntry['id']);
                $newFormat[$id[1]] = [
                    "name" => $cacheEntry["name"],
                    "image" => $cacheEntry["image"],
                    "id_rarity" => $cacheEntry["rarity"]['id'],
                    "rarity" => $cacheEntry["rarity"]['name'],
                ];
            }
    
            $customKeychain = [
                0 => [
                    "name" => $languages_text[$language],
                    "image" => "/app/modules/module_page_skins/assets/img/sticker0.png",
                    "id_rarity" => "rarity_default",
                    "rarity" => "Пустой"
                ]
            ];
    
            $Keychains = $customKeychain + $newFormat;
    
            $this->put_cache($cacheFilePath, $Keychains);
        }
    
        return ['status' => 'success', 'text' => $this->Translate('_yspex_ccc')]; # ПЕРЕВОД
    }

    public function CacheStickers()
    {
        $languages = ['ru', 'uk', 'en', 'de'];
    
        $languages_text = [
            "ru" => "Наклейка | Не выбрано",
            "uk" => "Наліпка | Не вибрано",
            "en" => "Sticker | Not selected",
            "de" => "Aufkleber | Nicht ausgewählt"
        ];
    
        foreach ($languages as $language) {
    
            if ($language == "uk") {
                $cacheFilePath = MODULES . "module_page_skins/cache/stickers-ua.json";
            } else {
                $cacheFilePath = MODULES . "module_page_skins/cache/stickers-{$language}.json";
            }
    
            $StickersData = $this->get_cache("https://bymykel.github.io/CSGO-API/api/{$language}/stickers.json");
    
            $newFormat = [];
            foreach ($StickersData as $cacheEntry) {
                $id = explode('-', $cacheEntry['id']);
                $newFormat[$id[1]] = [
                    "name" => $cacheEntry["name"],
                    "image" => $cacheEntry["image"],
                    "id_rarity" => $cacheEntry["rarity"]['id'],
                    "rarity" => $cacheEntry["rarity"]['name'],
                ];
            }
    
            $customSticker = [
                "0" => [
                    "name" => $languages_text[$language],
                    "image" => "/app/modules/module_page_skins/assets/img/sticker0.png",
                    "id_rarity" => "rarity_default",
                    "rarity" => "Пустой"
                ]
            ];
    
            $Stickers = $customSticker + $newFormat;
    
            $this->put_cache($cacheFilePath, $Stickers);
        }
    
        return ['status' => 'success', 'text' => $this->Translate('_yspex_ccc')]; # ПЕРЕВОД
    }

    public function CacheAgents()
    {
        $languages = ['ru', 'uk', 'en', 'de'];

        function createAgentStructure($AgentInfo) {
            preg_match('/customplayer_(.*?)_png.png/', $AgentInfo["image"], $matches);
            $lastUnder = strrpos($matches[1], '_');
            $NameGame = substr($matches[1], 0, $lastUnder);
            return [
                "id" => explode('-', $AgentInfo['id'])[1],
                "name" => $AgentInfo["name"],
                "image" => $AgentInfo["image"],
                "model" => "{$NameGame}/{$matches[1]}",
                "team"  => ($AgentInfo["team"]['id'] == 'terrorists') ? 0 : 1,
                "id_rarity" => $AgentInfo["rarity"]['id'],
                "rarity" => $AgentInfo["rarity"]['name']
            ];
        }

        foreach ($languages as $language) {

            if ($language == "uk") {
                $cacheFilePath = MODULES . "module_page_skins/cache/agents-ua.json";
            } else {
                $cacheFilePath = MODULES . "module_page_skins/cache/agents-{$language}.json";
            }

            $AgentsData = $this->get_cache("https://bymykel.github.io/CSGO-API/api/{$language}/agents.json");

            foreach ($AgentsData as &$cacheEntry) {
                $cacheEntry = createAgentStructure($cacheEntry);
            }
            
            $this->put_cache($cacheFilePath, $AgentsData);
        }

        return ['status' => 'success', 'text' => $this->Translate('_yspex_ccc')]; # ПЕРЕВОД
    }

    public function CacheMusic()
    {
        $languages = ['ru', 'uk', 'en', 'de'];

        function createMusicStructure($MusicInfo) {
            return [
                "id" => explode('-', $MusicInfo['id'])[1],
                "name" => $MusicInfo["name"],
                "image" => $MusicInfo["image"],
                "id_rarity" => $MusicInfo["rarity"]['id'],
                "rarity" => $MusicInfo["rarity"]['name']
            ];
        }

        foreach ($languages as $language) {
            if ($language == "uk") {
                $cacheFilePath = MODULES . "module_page_skins/cache/music-ua.json";
            } else {
                $cacheFilePath = MODULES . "module_page_skins/cache/music-{$language}.json";
            }
            $MusicData = $this->get_cache("https://bymykel.github.io/CSGO-API/api/{$language}/music_kits.json");
            foreach ($MusicData as $key => &$cacheEntry) {
                $cacheEntryID = explode('-', $cacheEntry['id'])[1];
                if (stripos($cacheEntryID, "_st") !== false) {
                    unset($MusicData[$key]);
                } else {
                    $cacheEntry = createMusicStructure($cacheEntry);
                }
            }
            $this->put_cache($cacheFilePath, $MusicData);
        }        

        return ['status' => 'success', 'text' => $this->Translate('_yspex_ccc')]; # ПЕРЕВОД
    }

    public function CacheMoney()
    {
        $languages = ['ru', 'uk', 'en', 'de'];

        function createMoneyStructure($MoneyInfo) {
            return [
                "id" => explode('-', $MoneyInfo['id'])[1],
                "name" => $MoneyInfo["name"],
                "image" => $MoneyInfo["image"],
                "type" => $MoneyInfo["type"],
                "id_rarity" => $MoneyInfo["rarity"]['id'],
                "rarity" => $MoneyInfo["rarity"]['name']
            ];
        }

        foreach ($languages as $language) {
            if ($language == "uk") {
                $cacheFilePath = MODULES . "module_page_skins/cache/collectibles-ua.json";
            } else {
                $cacheFilePath = MODULES . "module_page_skins/cache/collectibles-{$language}.json";
            }
            $MoneyData = $this->get_cache("https://bymykel.github.io/CSGO-API/api/{$language}/collectibles.json");
            foreach ($MoneyData as $key => &$cacheEntry) {
                if (stripos($cacheEntry["type"], "Pass") !== false || stripos($cacheEntry["type"], "Stars for Operation") !== false) {
                    unset($MoneyData[$key]);
                } else {
                    $cacheEntry = createMoneyStructure($cacheEntry);
                }
            }
            $this->put_cache($cacheFilePath, $MoneyData);
        }

        return ['status' => 'success', 'text' => $this->Translate('_yspex_ccc')]; # ПЕРЕВОД
    } 
}