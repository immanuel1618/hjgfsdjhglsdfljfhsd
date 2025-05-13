<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Services\ProductPropertyService;
use app\modules\module_page_store\ext\Controllers\ProductController;

class ProductPropertyController
{
    private $Db;
    private $Translate;
    private $service;
    private $type;

    public function __construct($Db, $Translate, $type)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->type = $type;
        $this->service = new ProductPropertyService($Db, $Translate, $type);
    }

    public function getAll(): array
    {
        return $this->service->getAll();
    }

    public function findByProductIds(array $productIds): array
    {
        return $this->service->findByProductIds($productIds);
    }

    public function GetByProductId(int $productId): array
    {
        return $this->service->GetByProductId($productId);
    }

    public function create(array $fields): array
    {
        if (empty($fields['title']) || empty($fields['params'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $Product = new ProductController($this->Db, $this->Translate);
        $Product_info = $Product->getById($fields['params']);
        
        $fields = [
            'title' => $fields['title'],
            'active' => isset($fields['active']) ? 1 : 0,
            'sort' => $fields['sort'],
            'product_id' => $fields['params']
        ];
        
        if (!empty($result = $this->service->create($fields))) {
            return $result;
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorInsert')
        ];
    }

    public function updateById(int $id, array $fields): array
    {
        if (empty($fields['title'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields = [
            'title' => $fields['title'],
            'sort' => $fields['sort'],
            'active' => isset($fields['active']) ? 1 : 0
        ];

        $this->service->updateById($id, $fields);

        return $this->service->getById($id);
    }

    public function deleteById(int $id): array
    {
        if ($this->service->deleteById($id)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successPropertyDelete')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorPropertyDelete')
        ];
    }
}
