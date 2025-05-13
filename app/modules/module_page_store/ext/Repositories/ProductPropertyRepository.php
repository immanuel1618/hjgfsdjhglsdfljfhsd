<?php
namespace app\modules\module_page_store\ext\Repositories;

class ProductPropertyRepository extends Repository
{
    private $tableName;
    private $mode = 'Core';
    private $userId = 0;
    private $dbId = 0;

    public function __construct($Db, $Translate, $type)
    {
        $this->tableName = $type === 'table' ? 'lvl_web_shop_table_properties' : 'lvl_web_shop_card_properties';
        parent::__construct($Db, $Translate, $this->tableName, $this->mode, $this->userId, $this->dbId);
    }

    public function getAll(): array
    {
        return $this->select([], [], ['CAST(sort AS UNSIGNED) ASC']);
    }

    public function getById(int $id): array
    {
        return $this->select([], ['id' => $id]);
    }

    public function findByProductIds(array $productIds): array
    {
        return $this->select([], ['product_id' => $productIds], ['CAST(sort AS UNSIGNED) ASC']);
    }

    public function GetByProductId(int $productId): array
    {
        return $this->select([], ['product_id' => $productId]);
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

    public function deleteByProductId(int $id): bool
    {
        return $this->delete(['product_id' => $id]) === 1;
    }
}
