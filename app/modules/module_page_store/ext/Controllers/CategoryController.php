<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Services\CategoryService;

class CategoryController
{
    private $Translate;
    private $service;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->service = new CategoryService($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->service->getAll();
    }

    public function getAllSorted(): array
    {
        return $this->service->getAllSorted();
    }

    public function getById(int $id): array
    {
        $result = $this->service->getById($id);

        if (empty($result)) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorCategoryFind')
            ];
        }

        return $result;
    }

    public function create(array $fields): array
    {
        if (empty($fields['name']) || empty($fields['sort'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields = [
            'name' => $fields['name'],
            'sort' => $fields['sort']
        ];

        if ($this->service->isExists($fields['name'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorCategoryIsCreated')
            ];
        }

        if ($fields['sort'] < 0) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorCategoryCreate')
            ];
        }

        if (!empty($result = $this->service->create($fields))) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successCategoryCreate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorCategoryCreate')
        ];
    }

    public function updateById(int $id, array $fields): array
    {
        if (empty($fields['name']) || empty($fields['sort'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields = [
            'name' => $fields['name'],
            'sort' => $fields['sort']
        ];

        if ($fields['sort'] < 0) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorCategoryUpdate')
            ];
        }

        if ($this->service->updateById($id, $fields)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successCategoryUpdate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorCategoryUpdate')
        ];
    }

    public function deleteById(int $id): array
    {
        if ($this->service->deleteById($id)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successCategoryDelete')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorCategoryDelete')
        ];
    }
}
