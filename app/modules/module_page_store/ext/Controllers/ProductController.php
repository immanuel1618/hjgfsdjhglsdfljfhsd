<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Services\ProductService;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\WebServerService;
use app\modules\module_page_store\ext\Controllers\ProductPropertyController;
use app\modules\module_page_store\ext\Controllers\OptionPriceController;
use app\modules\module_page_store\ext\Controllers\DiscountController;

class ProductController
{
    private $Db;
    private $Translate;

    private $service;

    public function __construct($Db, $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->service = new ProductService($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->service->getAll();
    }

    public function getById(int $id): array
    {
        $result = $this->service->getById($id);

        if (empty($result)) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorProductFind')
            ];
        }

        return $result;
    }

    public function create(array $fields): array
    {
        if (
            empty($fields['title']) ||
            empty($fields['color'])
        ) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        if (!$this->checkMods($fields['type'], $fields['params'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorMode')
            ];
        }

        $fields = [
            'status' => isset($fields['status']) ? 1 : 0,
            'type' => $fields['type'],
            'sort' => $fields['sort'],
            'title' => $fields['title'],
            'title_show' => isset($fields['title_show']) ? 1 : 0,
            'badge' => $fields['badge'],
            'category' => $fields['category'],
            'server_id' => $fields['params'],
            'img' => $fields['img'],
            'color' => $fields['color'],
            'discount' => isset($fields['discount']) ? $fields['discount'] : 0,
            'table_status' => isset($fields['table_status']) ? 1 : 0,
        ];

        if (!empty($this->service->create($fields))) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successProductCreate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorInsert')
        ];
    }

    public function updateById(int $id, array $fields): array
    {
        if (
            empty($fields['title']) ||
            empty($fields['color'])
        ) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        if (!$this->checkMods($fields['type'], $fields['server_id'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorMode')
            ];
        }

        $fields = [
            'status' => isset($fields['status']) ? 1 : 0,
            'type' => $fields['type'],
            'sort' => $fields['sort'],
            'title' => $fields['title'],
            'title_show' => isset($fields['title_show']) ? 1 : 0,
            'badge' => $fields['badge'],
            'category' => $fields['category'],
            'img' => $fields['img'],
            'color' => $fields['color'],
            'discount' => isset($fields['discount']) ? $fields['discount'] : 0,
            'table_status' => isset($fields['table_status']) ? 1 : 0,
        ];

        if ($this->service->updateById($id, $fields)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successProductUpdate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorProductUpdate')
        ];
    }

    public function CopyById(int $id, array $fields): array
    {
        if (
            empty($fields['server_id']) ||
            empty($fields['shop_server_id'])
        ) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $Product = $this->getById($id);

        $product_fields = [
            'status' => $Product['status'],
            'type' => $Product['type'],
            'sort' => $Product['sort'],
            'title' => $Product['title'],
            'title_show' => $Product['title_show'],
            'badge' => $Product['badge'],
            'category' => $Product['category'],
            'server_id' => $fields['shop_server_id'],
            'img' => $Product['img'],
            'color' => $Product['color'],
            'discount' => $Product['discount'],
            'table_status' => $Product['table_status'],
        ];

        $new_product = $this->service->create($product_fields);

        $OptionPrice = new OptionPriceController($this->Db, $this->Translate);
        $OptionPrices = $OptionPrice->GetByProductId($id);

        foreach($OptionPrices as $optprice){
            $optprice_fields = [
                'params' =>  $new_product['id'],
                'price' =>  $optprice['price'],
                'amount' =>  isset($optprice['options']['amount']) ? $optprice['options']['amount'] : '',
                'group' =>  isset($optprice['options']['group']) ? $optprice['options']['group'] : '',
                'amount_value' => isset($optprice['options']['amount_value']) ? $optprice['options']['amount_value'] : '', 
                'rcon' =>  isset($optprice['options']['rcon']) ? $optprice['options']['rcon'] : '',
                'all_servers' =>  isset($optprice['options']['all_servers']) ? $optprice['options']['all_servers'] : '',
                'title' =>  isset($optprice['options']['title']) ? $optprice['options']['title'] : '',
                'web_group_id' =>  isset($optprice['options']['web_group_id']) ? $optprice['options']['web_group_id'] : '',
                'time' =>  isset($optprice['options']['time']) ? $optprice['options']['time'] : '',
                'time_value' =>  isset($optprice['options']['time_value']) ? $optprice['options']['time_value'] : '',
            ];

            $OptionPrice->create($optprice_fields);
        }

        $CardProperty = new ProductPropertyController($this->Db, $this->Translate, 'card');
        $CardPropertys = $CardProperty->GetByProductId($id)[0];

        foreach($CardPropertys as $cardprop){

            if(!empty($cardprop['active'])){
                $cardprop_fields = [
                    'params' => $new_product['id'],
                    'title' => $cardprop['title'],
                    'active' => $cardprop['active'],
                    'sort' => $cardprop['sort']
                ];
            } else {
                $cardprop_fields = [
                    'params' => $new_product['id'],
                    'title' => $cardprop['title'],
                    'sort' => $cardprop['sort']
                ];
            }

            $CardProperty->create($cardprop_fields);
        }

        $TableProperty = new ProductPropertyController($this->Db, $this->Translate, 'table');
        $TablePropertys = $TableProperty->GetByProductId($id)[0];

        foreach($TablePropertys as $tableprop){
            if(!empty($tableprop['active'])){
                $tableprop_fields = [
                    'params' => $new_product['id'],
                    'title' => $tableprop['title'],
                    'active' => $tableprop['active'],
                    'sort' => $tableprop['sort']
                ];
            } else {
                $tableprop_fields = [
                    'params' => $new_product['id'],
                    'title' => $tableprop['title'],
                    'sort' => $tableprop['sort']
                ];
            }

            $TableProperty->create($tableprop_fields);
        }

        return [
            'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successCopyProduct')
        ];
    }

    public function CopyPropertyByProductId(int $id, array $fields)
    {
        $CardProperty = new ProductPropertyController($this->Db, $this->Translate, 'card');
        $CardPropertys = $CardProperty->GetByProductId($id)[0];
        $TableProperty = new ProductPropertyController($this->Db, $this->Translate, 'table');
        $TablePropertys = $TableProperty->GetByProductId($id)[0];

        $CardPropertys_diff = array_udiff($CardPropertys, $TablePropertys, function($a, $b) {
            return ($a['title'] === $b['title'] && $a['active'] === $b['active']) ? 0 : 1;
        });

        $TablePropertys_diff = array_udiff($TablePropertys, $CardPropertys, function($a, $b) {
            return ($a['title'] === $b['title'] && $a['active'] === $b['active']) ? 0 : 1;
        });
        
        if($fields['shop_properties_copy'] == 1){
            foreach($CardPropertys_diff as $cardprop){

                if(!empty($cardprop['active'])){
                    $cardprop_fields = [
                        'params' => $id,
                        'title' => $cardprop['title'],
                        'active' => $cardprop['active'],
                        'sort' => $cardprop['sort']
                    ];
                } else {
                    $cardprop_fields = [
                        'params' => $id,
                        'title' => $cardprop['title'],
                        'sort' => $cardprop['sort']
                    ];
                }
    
                $TableProperty->create($cardprop_fields);
            }
        } else {
            foreach($TablePropertys_diff as $tableprop){
                if(!empty($tableprop['active'])){
                    $tableprop_fields = [
                        'params' => $id,
                        'title' => $tableprop['title'],
                        'active' => $tableprop['active'],
                        'sort' => $tableprop['sort']
                    ];
                } else {
                    $tableprop_fields = [
                        'params' => $id,
                        'title' => $tableprop['title'],
                        'sort' => $tableprop['sort']
                    ];
                }
    
                $CardProperty->create($tableprop_fields);
            }
        }

        return [
            'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successCopyProductProperty')
        ];
    }

    public function deleteById(int $id): array
    {
        if ($this->service->deleteById($id)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successProductDelete')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorProductDelete')
        ];
    }

    private function checkMods(string $type, int $serverId): bool
    {
        $serverService = new ServerService($this->Db, $this->Translate);
        $webServerService = new WebServerService($this->Db, $this->Translate);

        if ($type === 'vip_riko') {
            if (empty ($this->Db->db_data['Vips'])) {
                ErrorLog::add(new \Exception('Не добавлен мод Vips'));

                return false;
            }

            $vipInfo = $webServerService->getVipsMetaById($serverService->getById($serverId)['web_server_id']);
            if (empty($vipInfo)) {
                ErrorLog::add(
                    new \Exception('Необходимо передобавить сервер в админ-панели и указать данные VIP таблицы')
                );

                return false;
            }
        } else if ($type === 'ma') {
            if (empty ($this->Db->db_data['SourceBans'])) {
                ErrorLog::add(new \Exception('Не добавлен мод SourceBans'));

                return false;
            }

            $maInfo = $webServerService->getMaterialAdminMetaById($serverService->getById($serverId)['web_server_id']);
            if (empty($maInfo)) {
                ErrorLog::add(
                    new \Exception('Необходимо передобавить сервер в админ-панели и указать данные MA таблицы')
                );

                return false;
            }
        } else if ($type === 'iks') {
            if (empty ($this->Db->db_data['IksAdmin'])) {
                ErrorLog::add(new \Exception('Не добавлен мод IksAdmin'));

                return false;
            }

            $IksInfo = $webServerService->getIksMetaById($serverService->getById($serverId)['web_server_id']);
            if (empty($IksInfo)) {
                ErrorLog::add(
                    new \Exception('Необходимо передобавить сервер в админ-панели и указать данные IksAdmin таблицы')
                );

                return false;
            }
        } else if ($type === 'iks_vip') {
            if (empty ($this->Db->db_data['IksAdmin'])) {
                ErrorLog::add(new \Exception('Не добавлен мод IksAdmin'));

                return false;
            }
            if (empty ($this->Db->db_data['Vips'])) {
                ErrorLog::add(new \Exception('Не добавлен мод Vips'));

                return false;
            }

            $IksInfo = $webServerService->getIksMetaById($serverService->getById($serverId)['web_server_id']);
            if (empty($IksInfo)) {
                ErrorLog::add(
                    new \Exception('Необходимо передобавить сервер в админ-панели и указать данные IksAdmin таблицы')
                );

                return false;
            }
            $vipInfo = $webServerService->getVipsMetaById($serverService->getById($serverId)['web_server_id']);
            if (empty($vipInfo)) {
                ErrorLog::add(
                    new \Exception('Необходимо передобавить сервер в админ-панели и указать данные VIP таблицы')
                );

                return false;
            }
        }

        return true;
    }
}
