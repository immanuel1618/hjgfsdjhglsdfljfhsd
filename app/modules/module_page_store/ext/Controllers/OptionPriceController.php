<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Dictionary;
use app\modules\module_page_store\ext\Services\OptionPriceService;

class OptionPriceController
{
    private $Translate;
    private $service;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->service = new OptionPriceService($Db, $Translate);
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
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorOptionPriceFind')
            ];
        }

        return $result;
    }

    public function GetByProductId(int $Id): array
    {
        return $this->service->GetByProductId($Id);
    }

    public function create(array $fields): array
    {
        if ($this->service->prepareFields($fields)) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields['product_id'] = $fields['params'];
        if (!empty($this->service->create($fields))) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successOptionPriceCreate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorInsert')
        ];
    }

    public function updateById(int $id, array $fields): array
    {
        if (empty($this->service->prepareFields($fields))) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        if ($this->service->updateById($id, $fields)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successOptionPriceUpdate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorOptionPriceUpdate')
        ];
    }

    public function deleteById(int $id): array
    {
        if ($this->service->deleteById($id)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successOptionPriceDelete')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorOptionPriceDelete')
        ];
    }

    public function prepareOptionsToTitle(string $type, string $title, array $options): string
    {
        if (empty($options)) {
            return '';
        }

        $dictionaryType = Dictionary::get('types')[$type] ?? null;
        
        switch ($dictionaryType) {
            case 1:
                return $options['time_value'] ?? '';
            case 2:
                return $options['amount'] . ' ' . $options['amount_value'] ?? '';
            case 3:
                return $options['title'] ?? '';
        }

        return '';
    }
}
