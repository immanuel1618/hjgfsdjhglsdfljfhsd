<?php
namespace app\modules\module_page_store\ext\Repositories\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ext\Services\WebServerService;

class VipRikoRepository extends Repository
{
    private $vipServerId;

    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);

        $vipInfo = $webServerService->getVipsMetaById($serverService->getById($serverId)['web_server_id']);
        $this->vipServerId = $vipInfo['server_vip_id'];

        if (empty($vipInfo)) {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные VIP таблицы'));
        }

        parent::__construct(
            $Db,
            $Translate,
            $vipInfo['db_info'][3] . 'users',
            $vipInfo['db_info'][0],
            $vipInfo['db_info'][1],
            $vipInfo['db_info'][2]
        );
    }

    public function getBySteam(string $steam): ?array
    {
        return $this->select([], ['account_id' => $steam, 'sid' => $this->vipServerId])[0] ?? null;
    }

    public function create(array $fields): ?array
    {
        $fields['sid'] = $this->vipServerId;

        return $this->insert($fields);
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        return $this->update($fields, ['account_id' => (int)$steam, 'sid' => (int)$this->vipServerId]) === 1;
    }
}
