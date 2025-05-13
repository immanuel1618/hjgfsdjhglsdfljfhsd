<?php
namespace app\modules\module_page_store\ext\Repositories;

class BasketRepository extends Repository
{
    private $tableName = 'lvl_web_shop_basket';
    private $mode = 'Core';
    private $userId = 0;
    private $dbId = 0;

    public function __construct($Db, $Translate)
    {
        parent::__construct($Db, $Translate, $this->tableName, $this->mode, $this->userId, $this->dbId);
    }

    public function findBySteam(string $steam): array
    {
        return $this->select([], ['steam' => $steam]);
    }

    public function deleteById(int $id): bool
    {
        return $this->delete(['id' => $id]) === 1;
    }
    
    public function clean(): int
    {
        return $this->delete();
    }

    public function cleanBySteam(string $steam): int
    {
        return $this->delete(['steam' => $steam]);
    }

    public function create(array $fields): ?array
    {
        return $this->insert($fields);
    }
}
