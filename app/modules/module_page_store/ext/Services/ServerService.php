<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\ServerRepository;

class ServerService
{
    private $Translate;
    private $rep;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->rep = new ServerRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        $data = $this->rep->getAll();
        
        $result = [];
        foreach ($data as $item) {
            $result[$item['id']] = $item;
        }

        return $result;
    }

    public function getById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден SHOP сервер по переданному ID. ID: $id"));
        }

        return $result[0] ?? [];
    }

    public function get_IksID(int $id): array
    {
        $result = $this->rep->get_IksID($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден IksAdmin id, передобавьте сервер"));
        }

        return $result[0] ?? [];
    }

    public function create(array $fields): ?array
    {
        if (empty($fields['name']) || !isset($fields['web_server_id'])) {
            ErrorLog::add(new \Exception('Произошла ошибка при создании SHOP сервера'));
            return null;
        }

        $fields = [
            'web_server_id' => $fields['web_server_id'],
            'name' => $fields['name'],
            'iks_id' => $fields['iks_id']
        ];

        if ($this->isExists($fields['web_server_id'])) {
            ErrorLog::add(new \Exception('Сервер с указанным WEB_ID уже создан. WEB_ID: ' . $fields['web_server_id']));
            return null;
        }

        if (empty($result = $this->rep->create($fields))) {
            ErrorLog::add(new \Exception('Произошла ошибка при создании SHOP сервера'));
        }

        return $result;
    }

    public function deleteById(int $id): bool
    {
        if ($this->rep->deleteById($id)) {
            return true;
        }

        ErrorLog::add(new \Exception("Не удалось удалить сервер с ID: $id"));
        return false;
    }

    public function updateById(int $id, array $fields): bool
    {
        if (empty($fields['name']) || !isset($fields['web_server_id'])) {
            return false;
        }

        $fields = [
            'web_server_id' => $fields['web_server_id'],
            'name' => $fields['name'],
            'iks_id' => $fields['iks_id']
        ];

        if ($this->rep->updateById($id, $fields)) {
            return true;
        }

        ErrorLog::add(new \Exception("Не удалось обновить сервер с ID: $id NAME:" . $fields['name']));

        return false;
    }

    public function isExists(int $webServerId): bool
    {
        return $this->rep->isExists($webServerId);
    }
}
