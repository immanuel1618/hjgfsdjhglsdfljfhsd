<?php
namespace app\modules\module_page_store\ext\Repositories;

class ProductRepository extends Repository
{
    private $tableName = 'lvl_web_shop_products';
    private $mode = 'Core';
    private $userId = 0;
    private $dbId = 0;

    public function __construct($Db, $Translate)
    {
        parent::__construct($Db, $Translate, $this->tableName, $this->mode, $this->userId, $this->dbId);
    }

    public function getAll(): array
    {
        return $this->select(['*'], [], ['server_id ASC, sort ASC']);
    }

    public function getById(int $id): array
    {
        return $this->select([], ['id' => $id]);
    }

    public function findByIds(array $ids): array
    {
        return $this->select([], ['id' => $ids]);
    }

    public function create(array $fields): ?array
    {
        return $this->insert($fields);
    }

    public function updateById(int $id, array $fields): bool
    {
        return $this->update($fields, ['id' => $id]) === 1;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete(['id' => $id]) === 1;
    }
}
