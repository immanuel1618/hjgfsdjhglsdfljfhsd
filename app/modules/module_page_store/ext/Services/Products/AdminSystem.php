<?php
namespace app\modules\module_page_store\ext\Services\Products;

use app\modules\module_page_store\ext\Tools;
use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\Products\AdminSystemRepository;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\WebServerService;


class AdminSystem
{
    private $rep;
    private $ASInfo;

    public function __construct($Db, $Translate, int $serverId)
    {
        $this->rep = new AdminSystemRepository($Db, $Translate, $serverId);
        $serverService = new ServerService($Db, $Translate);
        $webServerService = new WebServerService($Db, $Translate);
        $this->ASInfo = $webServerService->getASMetaById($serverService->getById($serverId)['web_server_id']);
    }

    public function setGroup(string $steam, string $info, int $days): bool
    {
        if (empty($this->ASInfo[1][0]) || $this->ASInfo[1][0] != 'AdminSystem') {
            ErrorLog::add(new \Exception('Необходимо передобавить сервер в админ-панели и указать данные AdminSystem таблицы'));
            return false;
        }
        $current = $this->getBySteam($steam);
        $p_info = explode(";", $info);
        $comment = isset($p_info[2]) ? $p_info[2] : '';
        $result = false;
        if ($current) {
            $result = $current['flags'] === $p_info[0]
                ? $this->updateBySteam($steam, [
                    'end' => $current['end'] - time() > 0 && $days !== 0
                        ? Tools::timestampByDays($days) + $current['end'] - time()
                        : Tools::timestampByDays($days)
                    ])
                : $this->updateBySteam($steam, [
                        'end' => Tools::timestampByDays($days),
                        'flags' => $p_info[0],
                        'immunity' => $p_info[1],
                        'comment' => $comment,
                    ]);
        } else {
            $result = $this->create([
                'steamid' => $steam,
                'name' => Tools::getNicknameBySteam($steam),
                'end' => Tools::timestampByDays($days),
                'flags' => $p_info[0],
                'immunity' => $p_info[1],
                'comment' => $comment,
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
            'steamid' => $fields['steamid'],
            'name' => $fields['name'],
            'flags' => $fields['flags'],
            'immunity' => $fields['immunity'],
            'end' => $fields['end'],
            'comment' => $fields['comment'],
        ];

        if (!empty($this->rep->create($fields))) {
            return true;
        }

        return false;
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        if (!$this->rep->updateBySteam($steam, $fields)) {
            ErrorLog::add(new \Exception("Не удалось обновить права AdminSystem"));

            return false;
        }

        return true;
    }
}
