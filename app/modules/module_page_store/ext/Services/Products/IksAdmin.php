<?php
namespace app\modules\module_page_store\ext\Services\Products;

use app\modules\module_page_store\ext\Tools;
use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\WebServerService;
use app\modules\module_page_store\ext\Repositories\Products\IksRepository;
use app\modules\module_page_store\ext\Repositories\Products\IksGroupRepository;


class IksAdmin
{
    private $rep;

    private $IksId;

    private $IksGroups;

    private $IksInfo;

    public function __construct($Db, $Translate, int $serverId)
    {
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);
        $this->rep = new IksRepository($Db, $Translate, $serverId);
        $this->IksId = $serverService->getById($serverId)['iks_id'];
        $this->IksGroups = new IksGroupRepository($Db, $Translate, $serverId);
        $this->IksInfo = $webServerService->getASMetaById($serverService->getById($serverId)['web_server_id']);
        
    }

    public function setGroup(string $steam, string $group, int $days): bool
    {
        if (empty($this->IksInfo[1][0]) || $this->IksInfo[1][0] != 'IksAdmin') {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные Iks таблицы'));
            return false;
        }

        $group_id = $this->IksGroups->getByName($group)['id'];

        if (empty($group_id)) {
            ErrorLog::add(new \Exception('Группа Iks Admin не найдена'));
            return false;
        }

        $current = $this->getBySteam($steam);

        $result = false;
        if ($current) {
            $current_servers = explode(";", $current['server_id']);
            if($current['group_id'] === $group_id){
                $end = $current['end'] - time() > 0 && $days !== 0 ? Tools::timestampByDays($days) + $current['end'] - time() : Tools::timestampByDays($days);
                $current_servers[] = $this->IksId;
                sort($current_servers);
                $sid = !empty($this->IksId) ? implode(";", $current_servers) : '';
            } else {
                $end = Tools::timestampByDays($days);
                $sid = !empty($this->IksId) ? $this->IksId : '';
            }
            $result = $this->updateBySteam($steam, [
                'end' => $end,
                'group_id' => $group_id,
                'server_id' => $sid,
            ]);
        } else {
            $result = $this->create([
                'sid' => $steam,
                'name' => Tools::getNicknameBySteam($steam),
                'end' => Tools::timestampByDays($days),
                'group_id' => $group_id,
                'server_id' => $this->IksId,
            ]);
        }

        return $result;
    }

    public function getBySteam(string $steam): ?array
    {
        return $this->rep->getBySteam($steam);
    }

    public function create(array $fields): bool
    {
        $fields = [
            'sid' => $fields['sid'],
            'name' => $fields['name'],
            'flags' => '',
            'immunity' => -1,
            'group_id' => $fields['group_id'],
            'end' => $fields['end'],
            'server_id' => $fields['server_id'],
        ];
        if (!empty($this->rep->create($fields))) {
            return true;
        }

        return false;
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        if (!$this->rep->updateBySteam($steam, $fields)) {
            ErrorLog::add(new \Exception("Не удалось обновить Iks группу"));

            return false;
        }

        return true;
    }
}
