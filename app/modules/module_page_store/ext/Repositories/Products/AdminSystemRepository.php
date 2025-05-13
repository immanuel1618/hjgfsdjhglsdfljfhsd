<?php
namespace app\modules\module_page_store\ext\Repositories\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\WebServerService;
use app\modules\module_page_store\ParameterObjects\Pagination;

class AdminSystemRepository extends Repository
{
    private $tablePrefix;

    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);

        $ASInfo = $webServerService->getASMetaById($serverService->getById($serverId)['web_server_id']);

        if (empty($ASInfo[1][0])) {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные AdminSystem таблицы'));
        }

        if ($ASInfo[1][0] != "AdminSystem") {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные AdminSystem таблицы'));
        }

        $this->tablePrefix = $ASInfo[1][3];

        parent::__construct(
            $Db,
            $Translate,
            $this->tablePrefix . 'admins',
            $ASInfo[1][0],
            $ASInfo[1][1],
            $ASInfo[1][2]
        );
    }

    public function getBySteam(string $steam): ?array
    {
        return $this->select([], ['steamid' => $steam])[0] ?? null;
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
        return $this->update($fields, ['steamid' => $steam]) === 1;
    }
}
