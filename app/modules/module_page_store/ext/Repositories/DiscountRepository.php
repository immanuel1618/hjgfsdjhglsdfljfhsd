<?php
namespace app\modules\module_page_store\ext\Repositories;

class DiscountRepository extends Repository
{
    private $tableName = 'lvl_web_shop_discounts';
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

    public function getByProductId(int $productId): array
    {
        return $this->select([], ['product_id' => $productId]);
    }

    public function findByProductIds(array $ids): array
    {
        return $this->select([], ['product_id' => $ids]);
    }

    public function deleteByProductId(int $id): bool
    {
        return $this->delete(['product_id' => $id]);
    }

    public function create(array $fields): ?array
    {
        return $this->insert($fields);
    }

    public function updateByProductId(int $productId, array $fields): bool
    {
        return $this->update($fields, ['product_id' => $productId]) === 1;
    }
}
