<?php
namespace app\modules\module_page_store\ext\Repositories;

class ShopOptionRepository extends Repository
{
    private $tableName = 'lvl_web_shop_options';
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

    public function updateOptions(array $fields): bool
    {
        return $this->update($fields) === 1;
    }
}
