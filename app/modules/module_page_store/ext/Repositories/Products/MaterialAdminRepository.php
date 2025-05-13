<?php
namespace app\modules\module_page_store\ext\Repositories\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\WebServerService;
use app\modules\module_page_store\ParameterObjects\Pagination;

class MaterialAdminRepository extends Repository
{
    private $tablePrefix;

    private $ip;

    private $port;

    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);

        $maInfo = $webServerService->getMaterialAdminMetaById($serverService->getById($serverId)['web_server_id']);

        if (empty($maInfo)) {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные MA таблицы'));
        }

        $this->ip = explode(':', $maInfo[0]['ip'])[0];
        $this->port = explode(':', $maInfo[0]['ip'])[1];

        $this->tablePrefix = $maInfo[1][3];

        parent::__construct(
            $Db,
            $Translate,
            $this->tablePrefix . 'admins',
            $maInfo[1][0],
            $maInfo[1][1],
            $maInfo[1][2]
        );
    }

    public function getBySteam(string $steam): ?array
    {
        return $this->select([], ['authid' => $steam])[0] ?? null;
    }

    public function getLast(): ?array
    {
        return $this->select(['*'], [], ['aid DESC'], new Pagination(1, 1))[0];
    }

    public function create(array $fields): ?array
    {
        $sid = $this->getServerId();

        $this->setTable($this->tablePrefix . 'admins');

        $this->insert($fields);

        $admin = $this->getLast();

        $result = $this->setServerByAdminId($admin['aid'], $fields['gid'], $sid);
        if (empty($result)) {
            return null;
        }

        return $admin;
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        return $this->update($fields, ['authid' => $steam]) === 1;
    }

    public function setServerByAdminId(int $adminId, int $gid, int $sid): ?array
    {
        $this->setTable($this->tablePrefix . 'admins_servers_groups');

        $params = [
            'admin_id' => $adminId,
            'group_id' => $gid,
            'server_id' => $sid,
            'srv_group_id' => -1,
        ];

        return $this->insert($params);
    }

    public function getServerId(): int
    {
        $this->setTable($this->tablePrefix . 'servers');

        $result = $this->select(['sid'], ['ip' => $this->ip, 'port' => $this->port]);

        if (empty($result[0])) {
            ErrorLog::add(
                new \Exception('Не найден сервер в MaterialAdmin, ip-port которого совпадает с указанным в сервере LR')
            );
        }

        return $result[0]['sid'];
    }
}
