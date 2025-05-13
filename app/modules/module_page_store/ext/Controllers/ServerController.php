<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Services\ServerService;

class ServerController
{
    private $Translate;
    private $service;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->service = new ServerService($Db, $Translate);
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
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorServerFind')
            ];
        }

        return $result;
    }

    public function get_IksID(int $id): array
    {
        $result = $this->service->get_IksID($id);

        if (empty($result)) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorIksIDFind')
            ];
        }

        return $result;
    }

    public function create(array $fields): array
    {
        if (empty($fields['name']) || !isset($fields['web_server_id'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields = [
            'web_server_id' => $fields['web_server_id'],
            'name' => $fields['name'],
            'iks_id' => $fields['iks_id']
        ];

        if ($this->service->isExists($fields['web_server_id'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorServerIsCreated')
            ];
        }

        if (!empty($result = $this->service->create($fields))) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successServerCreate')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorInsert')
        ];
    }

    public function deleteById(int $id): array
    {
        if ($this->service->deleteById($id)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successDeleteServer')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDeleteServer')
        ];
    }

    public function updateById(int $id, array $fields): array
    {
        if (empty($fields['name']) || !isset($fields['web_server_id'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorDataIsEmpty')
            ];
        }

        $fields = [
            'web_server_id' => $fields['web_server_id'],
            'name' => $fields['name'],
            'iks_id' => $fields['iks_id']
        ];

        if ($this->service->updateById($id, $fields)) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successUpdateServer')
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorUpdateServer')
        ];
    }
}
