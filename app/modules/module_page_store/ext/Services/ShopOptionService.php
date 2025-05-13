<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\ShopOptionRepository;

class ShopOptionService
{
    private $rep;

    public function __construct($Db, $Translate)
    {
        $this->rep = new ShopOptionRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        $result = $this->rep->getAll();

        if (empty($result[0])) {
            ErrorLog::add(new \Exception('Не найдены настройки магазина'));
        }

        return $result[0] ?? [];
    }

    public function update(array $fields): bool
    {
        if (!$this->rep->updateOptions($fields)) {
            ErrorLog::add(new \Exception('Не удалось обновить настройки магазина'));

            return false;
        }

        return true;
    }

}
