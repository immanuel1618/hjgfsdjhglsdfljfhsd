<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Services\DiscountService;

class DiscountController
{
    private $Translate;
    private $service;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->service = new DiscountService($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->service->getAll();
    }

    public function getByProductId(int $productId): array
    {
        $result = $this->service->getByProductId($productId);

        if (empty($result)) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDiscountFind')
            ];
        }

        return $result;
    }

    public function updateOrCreate(string $productId, array $fields): array
    {
        if (empty($productId) || !isset($fields['value'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        if ($fields['value'] < 0 || $fields['value'] > 100) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDiscountSet')
            ];
        }

        if ($this->service->updateOrCreate($productId, $fields['value'])) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successDiscountSet')
            ];
        } else {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDiscountSet')
            ];
        }
    }
}
