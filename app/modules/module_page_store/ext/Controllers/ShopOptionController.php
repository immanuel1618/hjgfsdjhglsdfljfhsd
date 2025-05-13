<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Services\ShopOptionService;

class ShopOptionController
{
    private $Translate;
    private $service;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->service = new ShopOptionService($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->service->getAll();
    }

    public function update(array $fields): array
    {
        $fields = $this->prepareFields($fields);
        if (empty($fields)) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorOptionsSet')
            ];
        }
        $this->service->update($fields);
        return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successOptionsSet')
        ];
    }

    private function prepareFields(array $fields)
    {
        if (isset($fields['amount_value'])) {
            return [
                'amount_value' => $fields['amount_value'],
            ];
        }

        if (isset($fields['discord_webhook'])) {
            return [
                'discord_webhook' => $fields['discord_webhook'],
                'hexcolor_wehbook' => $fields['hexcolor_wehbook'],
                'img_webhook' => $fields['img_webhook'],
            ];
        }

        if (isset($fields['vk_apikey'])) {
            return [
                'vk_apikey' => $fields['vk_apikey'],
                'vk_peer_id' => $fields['vk_peer_id']
            ];
        }

        if (isset($fields['button']) && $fields['button'] === 'extend-cards') {
            return [
                'extend_cards' => (int)isset($fields['extend_cards'])
            ];
        }

        if (isset($fields['button']) && $fields['button'] === 'only-admin') {
            return [
                'only_for_admin' => (int)isset($fields['only_for_admin'])
            ];
        }

        if (isset($fields['button']) && $fields['button'] === 'use-server-accept') {
            return [
                'use_server_accept' => (int)isset($fields['use_server_accept'])
            ];
        }

        if (isset($fields['button']) && $fields['button'] === 'change-column-count') {
            return [
                'column_count' => $fields['column_count']
            ];
        }
    }
}
