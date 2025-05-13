<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\Query;
use app\modules\module_page_store\ext\Tools;
use app\modules\module_page_store\ext\Dictionary;
use app\modules\module_page_store\ext\Controllers\ServerController;

class Webhook
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
    
    public function sendDiscordWebhook(array $product, array $priceOption, string $steam, ?string $promo): bool
    {
        $options = (new ShopOptionService($this->Db, $this->Translate))->getAll();
        $server = (new ServerController($this->Db, $this->Translate))->getById($product['server_id']);

        $webhookUrl = $options['discord_webhook'];
        if (empty($webhookUrl)) {
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

        $gift = '-';

        if($steam != $_SESSION['steamid32']){
            $gift = $_SESSION['steamid32'];
        }

        $name = Tools::getNicknameBySteam($steam);
        $steam64 = con_steam32to64($steam);	
        $data = [
            "file" => "content",
            'embeds' => [
                0 => [
                    "author" => 
                    [
                        "name" => $this->Translate->get_translate_module_phrase('module_page_store', '_Open_profile')." ".$name,
                        "url" => "https://steamcommunity.com/profiles/".$steam64,
                        "icon_url" =>  $this->General->getAvatar($steam64, 1 )
                    ],
                    "title" => $this->General->arr_general['full_name'],
                    "type" => "content",
                    "url" => 'https:'.$this->General->arr_general['site'],
                    "color" => hexdec(preg_replace('/#/', '', $options['hexcolor_wehbook'])),
                    "fields" => 
                    [
                        [
                            "name" => ':gift: '.$this->Translate->get_translate_module_phrase('module_page_store', '_Gift'),
                            "value" => '**```'.$gift.'```**',
                        ],
                        [
                            "name" => ':desktop: '.$this->Translate->get_translate_module_phrase('module_page_store', '_server'),
                            "value" => '**```'.$server['name'].'```**',
                        ],
                        [
                            "name" => ':star: '.$this->Translate->get_translate_module_phrase('module_page_store', '_shopProduct'),
                            "value" => "```".$title."```",
                            "inline" => true
                        ],
                        [
                            "name" => ':money_with_wings: '.$this->Translate->get_translate_module_phrase('module_page_store', '_shopCost'),
                            "value" => "```".$price.''.$options['amount_value']."```",
                            "inline" => true,
                        ]
                    ],
                    "image" => 
                    [
                        "url" => 'https:'.$this->General->arr_general['site'].'app/modules/module_page_store/assets/img/'.$options['img_webhook']
                    ]
                ],
            ],
        ];

        $result = Query::post($webhookUrl, $data);

        return (bool)$result;
    } 
}