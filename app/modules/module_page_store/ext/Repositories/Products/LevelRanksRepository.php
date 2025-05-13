<?php
namespace app\modules\module_page_store\ext\Repositories\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ext\Services\WebServerService;

class LevelRanksRepository extends Repository
{
    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);

        $lrInfo = $webServerService->getLevelsRanksMetaById($serverService->getById($serverId)['web_server_id']);

        if (empty($lrInfo)) {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные LR таблицы'));
        }

        parent::__construct(
            $Db,
            $Translate,
            $lrInfo[3],
            $lrInfo[0],
            $lrInfo[1],
            $lrInfo[2]
        );
    }

    public function getBySteam(string $steam): ?array
    {
        return $this->select([], ['steam' => $steam])[0] ?? null;
    }
}
