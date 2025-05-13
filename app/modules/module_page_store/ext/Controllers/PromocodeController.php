<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Services\PromocodeService;

class PromocodeController
{
    private $Translate;
    private $service;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->service = new PromocodeService($Db, $Translate);
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
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPromoFind')
            ];
        }

        return $result;
    }

    public function create(array $fields): array
    {
        if (empty($fields['name']) || empty($fields['percent']) || empty($fields['amount'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields = [
            'name' => $fields['name'],
            'percent' => $fields['percent'],
            'amount' => $fields['amount']
        ];

        if ($this->service->isExists($fields['name'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPromoIsCreated')
            ];
        }

        if ($fields['percent'] < 0 || $fields['percent'] > 100) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPromoCreate')
            ];
        }

        if (!empty($result = $this->service->create($fields))) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successPromoCreate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPromoCreate')
        ];
    }

    public function updateById(int $id, array $fields): array
    {
        if (empty($fields['name']) || empty($fields['percent']) || empty($fields['amount'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields = [
            'name' => $fields['name'],
            'percent' => $fields['percent'],
            'amount' => $fields['amount']
        ];

        if ($fields['percent'] < 0 || $fields['percent'] > 100) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPromoUpdate')
            ];
        }

        if ($this->service->updateById($id, $fields)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successPromoUpdate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPromoUpdate')
        ];
    }

    public function deleteById(int $id): array
    {
        if ($this->service->deleteById($id)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successPromoDelete')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPromoDelete')
        ];
    }
}
