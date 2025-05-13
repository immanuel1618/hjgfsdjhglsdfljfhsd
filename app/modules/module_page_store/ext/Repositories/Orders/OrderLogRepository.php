<?php
namespace app\modules\module_page_store\ext\Repositories\Orders;

use app\modules\module_page_store\ext\Repositories\Repository;
use app\modules\module_page_store\ParameterObjects\Pagination;

class OrderLogRepository extends Repository
{
    private $tableName = 'lvl_web_shop_logs';
    private $mode = 'Core';
    private $userId = 0;
    private $dbId = 0;

    public function __construct($Db, $Translate)
    {
        parent::__construct($Db, $Translate, $this->tableName, $this->mode, $this->userId, $this->dbId);
    }

    public function getAll(): array
    {
        return $this->select();
    }

    public function getAllPagination($page, $on_page): array
    {
        return $this->select(['*'], [], ['id DESC'], new Pagination($page, $on_page));
    }

    public function create(array $fields): ?array
    {
        return $this->insert($fields);
    }
}
