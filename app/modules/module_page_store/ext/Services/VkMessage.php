<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\Tools;
use app\modules\module_page_store\ext\Dictionary;

class VkMessage
{
    private $Db;
    private $General;
    private $Translate;

    public function __construct($Db, $Translate, $General)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
    }
    
    public function sendVkMessage(array $product, array $priceOption, string $steam, ?string $promo): bool
    {
        $options = (new ShopOptionService($this->Db, $this->Translate))->getAll();

        $access_token = $options['vk_apikey'];
        $peer_id = $options['vk_peer_id'];
        if (empty($access_token && $peer_id)) {
            return false;
        }

        $types = Dictionary::get('types');
        $title = '';
        $option = $priceOption['options'];
        $price = $priceOption['price'];
        if ($types[$product['type']] === 1) {
            $title = $product['title'].' '.$option['time_value'];
        } else if ($types[$product['type']] === 2) {
            $title = $option['amount']. ' '. $option['amount_value'];
        } else if ($types[$product['type']] === 3) {
            $title = $option['title'];
        }

        $name = Tools::getNicknameBySteam($steam);
        $steam64 = con_steam32to64($steam);	
        $VKmsg = [
            'message' => 'Куплена привилегия!'.'
        
            '.'Пользователь: '.$name.'
            '.'SteamID: '.$steam64.'
        
            '.'Товар: '.$title.'
            '.'Стоимость: '.$price.''.$options['amount_value'].'
        
            '.'Дата: '.date("d.m.Y, H:i").'
            '.'https://steamcommunity.com/profiles/'.$steam64,
            'access_token' => $access_token,
            'peer_id' => $peer_id,
            'random_id' => rand(1, 999999),
            'v' => '5.90',
        ];
        file_get_contents('https://api.vk.com/method/messages.send?'.http_build_query($VKmsg));

        return true;
    } 
}