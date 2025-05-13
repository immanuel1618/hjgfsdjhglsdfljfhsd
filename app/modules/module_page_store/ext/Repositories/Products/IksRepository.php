<?php
namespace app\modules\module_page_store\ext\Repositories\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\WebServerService;
use app\modules\module_page_store\ParameterObjects\Pagination;

class IksRepository extends Repository
{
    private $tablePrefix;
    
    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);

        $IksInfo = $webServerService->getIksMetaById($serverService->getById($serverId)['web_server_id']);

        if (empty($IksInfo[1][0])) {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные Iks таблицы'));
        }

        if ($IksInfo[1][0] != "IksAdmin") {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные Iks таблицы'));
        }

        $this->tablePrefix = $IksInfo[1][3];

        parent::__construct(
            $Db,
            $Translate,
            $this->tablePrefix . 'admins',
            $IksInfo[1][0],
            $IksInfo[1][1],
            $IksInfo[1][2]
        );
    }

    public function getBySteam(string $steam): ?array
    {
        return $this->select([], ['sid' => $steam])[0] ?? null;
    }

    public function getLast(): ?array
    {
        return $this->select(['*'], [], ['id DESC'], new Pagination(1, 1))[0];
    }

    public function create(array $fields): ?array
    {

        $this->setTable($this->tablePrefix . 'admins');

        $this->insert($fields);

        $admin = $this->getLast();

        return $admin;
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        return $this->update($fields, ['sid' => $steam]) === 1;
    }
}
