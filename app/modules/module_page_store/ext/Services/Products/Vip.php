<?php
namespace app\modules\module_page_store\ext\Services\Products;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Tools;
use app\modules\module_page_store\ext\Repositories\Products\VipRikoRepository;
use app\modules\module_page_store\ext\Repositories\Products\VipWsRepository;

class Vip
{
    private $type;
    private $repWs;
    private $repRiko;
    private $Translate;

    public const WS = 'vip_ws';
    public const RIKO = 'vip_riko';

    public function __construct($Db, $Translate, string $type, int $serverId)
    {
        $this->type = $type;
        $this->Translate = $Translate;
        $this->repRiko = new VipRikoRepository($Db, $Translate, $serverId);
        $this->repWs = new VipWsRepository($Db, $Translate, $serverId);
    }

    public function setGroup(string $steam, string $group, int $days): bool
    {
        $current = $this->getBySteam($steam);

        $result = false;
        if ($current) {
            $groupField = $this->type === self::RIKO ? 'group' : 'group_name';
            $expiresField = $this->type === self::RIKO ? 'expires' : 'time';
            $result = $current[$groupField] === $group
                ? $this->updateBySteam($steam, [
                    $expiresField => $current[$expiresField] - time() > 0  && $days !== 0
                        ? Tools::timestampByDays($days) + $current[$expiresField] - time()
                        : Tools::timestampByDays($days)
                    ])
                : $this->updateBySteam($steam, [
                        $expiresField => Tools::timestampByDays($days),
                        $groupField => $group,
                    ]);
        } else {
            $result = $this->create([
                'steam' => $steam,
                'name' => Tools::getNicknameBySteam($steam),
                'group' => $group,
                'expires' => Tools::timestampByDays($days),
            ]);
        }

        return $result;
    }

    public function getBySteam(string $steam): ?array
    {
        $steam3 = con_steam32to3_int($steam);

        return $this->type === self::RIKO 
            ? $this->repRiko->getBySteam($steam3)
            : $this->repRiko->getBySteam($steam);
    }

    public function create(array $fields): bool
    {
        $steam3 = con_steam32to3_int($fields['steam']);

        $fields = $this->type === self::RIKO
        ? [
            'account_id' => $steam3,
            'name' => $fields['name'] ?? 'Unknown',
            'lastvisit' => time(),
            'group' => $fields['group'],
            'expires' => $fields['expires'],
        ]
        : [
            'name' => $fields['name'] ?? 'Unknown',
            'steamid' => $fields['steam'],
            'group_name' => $fields['group'],
            'time' => $fields['expires'],
            'holiday' => 0,
            'holiday_last' => 0,
            'vip_test' => 0,
        ];

        if (!empty($this->repRiko->create($fields))) {
            return true;
        }

        return false;
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        $steam3 = con_steam32to3_int($steam);

        $result = $this->type === self::RIKO
            ? $this->repRiko->updateBySteam($steam3, $fields)
            : $this->repWs->updateBySteam($steam, $fields);

        if (!$result) {
            ErrorLog::add(new \Exception("Не удалось обновить VIP группу"));
        }

        return $result;
    }
}
