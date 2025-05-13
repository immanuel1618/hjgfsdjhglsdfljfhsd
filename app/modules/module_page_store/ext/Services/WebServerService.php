<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\WebServerRepository;

class WebServerService
{
    private $Translate;
    private $rep;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->rep = new WebServerRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->rep->getAll();
    }

    public function getVipsMetaById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден WEB сервер по указанному ID: $id"));
        }

        if (empty($result[0]['server_vip'])) {
            ErrorLog::add(new \Exception('В поле server_vip в таблице lvl_web_servers не указаны данные'));
        }

        return [
            'db_info' => explode(';', $result[0]['server_vip'] ?? []),
            'server_vip_id' => $result[0]['server_vip_id'] ?? null
        ];
    }

    public function getMaterialAdminMetaById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден WEB сервер по указанному ID: $id"));
        }

        if (empty($result[0]['server_sb'])) {
            ErrorLog::add(new \Exception('В поле server_sb в таблице lvl_web_servers не указаны данные'));
        }

        return [$result[0] ?? [], explode(';', $result[0]['server_sb'] ?? [])];
    }

    public function getIksMetaById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден WEB сервер по указанному ID: $id"));
        }

        if (empty($result[0]['server_sb'])) {
            ErrorLog::add(new \Exception('В поле server_sb в таблице lvl_web_servers не указаны данные'));
        }

        return [$result[0] ?? [], explode(';', $result[0]['server_sb'] ?? [])];
    }

    public function getASMetaById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден WEB сервер по указанному ID: $id"));
        }

        if (empty($result[0]['server_sb'])) {
            ErrorLog::add(new \Exception('В поле server_sb в таблице lvl_web_servers не указаны данные'));
        }

        return [$result[0] ?? [], explode(';', $result[0]['server_sb'] ?? [])];
    }

    public function getLevelsRanksMetaById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден WEB сервер по указанному ID: $id"));
        }

        if (empty($result[0]['server_stats'])) {
            ErrorLog::add(new \Exception('В поле server_stats в таблице lvl_web_servers не указаны данные'));
        }

        return explode(';', $result[0]['server_stats']) ?? [];
    }

    public function getRconById(?int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден WEB сервер по указанному ID: $id"));
        }

        if (empty($result[0]['rcon'])) {
            ErrorLog::add(new \Exception('Не указан RCON пароль для сервера'));
        }

        return ['rcon' => $result[0]['rcon'] ?? null, 'ip' => $result[0]['ip'] ?? null];
    }
}
