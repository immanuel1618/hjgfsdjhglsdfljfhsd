<?php
namespace app\modules\module_page_store\ext\Services\Products;
use app\modules\module_page_store\ext\Tools;
use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\Products\MaterialAdminRepository;

class MaterialAdmin
{
    private $rep;

    public function __construct($Db, $Translate, int $serverId)
    {
        $this->rep = new MaterialAdminRepository($Db, $Translate, $serverId);
    }

    public function setGroup(string $steam, string $group, int $days, int $webGroupId): bool
    {
        $current = $this->getBySteam($steam);

        $result = false;
        if ($current) {
            $result = $current['srv_group'] === $group && $current['gid'] == $webGroupId
                ? $this->updateBySteam($steam, [
                    'expired' => $current['expired'] - time() > 0 && $days !== 0
                        ? Tools::timestampByDays($days) + $current['expired'] - time()
                        : Tools::timestampByDays($days)
                    ])
                : $this->updateBySteam($steam, [
                        'expired' => Tools::timestampByDays($days),
                        'srv_group' => $group,
                        'gid' => $webGroupId,
                    ]);
        } else {
            $result = $this->create([
                'authid' => $steam,
                'user' => Tools::getNicknameBySteam($steam),
                'gid' => $webGroupId,
                'expired' => Tools::timestampByDays($days),
                'srv_group' => $group,
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
        $seed = '';
        
        for ($i = 1; $i <= 50; $i++){
            $seed .= substr('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', rand(0,15), 1);
        }
        
        
        $fields = [
            'authid' => $fields['authid'],
            'user' => $fields['user'],
            'expired' => $fields['expired'],
            'srv_group' => $fields['srv_group'],
            'password' => sha1('password' . rand(1000, 10000) . $seed),
            'email' => rand(1000, 10000) . 'solt' . rand(10000, 100000) . '@yandex.ru',
            'gid' => $fields['gid'],
            'extraflags' => 0,
            'immunity' => 0,
            'lastvisit' => time(),
        ];

        if (!empty($this->rep->create($fields))) {
            return true;
        }

        return false;
    }

    public function updateBySteam(string $steam, array $fields): bool
    {
        if (!$this->rep->updateBySteam($steam, $fields)) {
            ErrorLog::add(new \Exception("Не удалось обновить MA группу"));

            return false;
        }

        return true;
    }
}
