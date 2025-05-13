<?php
namespace app\modules\module_page_store\ext\Repositories\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ext\Services\WebServerService;

class VipWsRepository extends Repository
{
    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);

        $vipInfo = $webServerService->getVipsMetaById($serverService->getById($serverId)['web_server_id']);

        if (empty($vipInfo)) {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные VIP таблицы'));
        }

        parent::__construct(
            $Db,
            $Translate,
            $vipInfo['db_info'][3],
            $vipInfo['db_info'][0],
            $vipInfo['db_info'][1],
            $vipInfo['db_info'][2]
        );
    }

    public function getBySteam(string $steam): ?array
    {
        return $this->select([], ['steamid' => $steam])[0] ?? null;
    }

    public function create(array $fields): ?array
    {
        return $this->insert($fields);
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        return $this->update($fields, ['steamid' => $steam]) === 1;
    }
}
