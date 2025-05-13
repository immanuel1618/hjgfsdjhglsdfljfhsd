<?php
namespace app\modules\module_page_store\ext\Repositories\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\WebServerService;

class AdminSystemGroupRepository extends Repository
{
    private $tablePrefix;

    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);

        $IksInfo = $webServerService->getIksMetaById($serverService->getById($serverId)['web_server_id']);

        if (empty($IksInfo[1][0])) {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные AdminSystem таблицы'));
        }

        $this->tablePrefix = $IksInfo[1][3];


        parent::__construct(
            $Db,
            $Translate,
            $this->tablePrefix . 'groups',
            $IksInfo[1][0],
            $IksInfo[1][1],
            $IksInfo[1][2]
        );
    }

    public function getByName(string $name): ?array
    {
        return $this->select([], ['name' => $name])[0] ?? null;
    }
}
