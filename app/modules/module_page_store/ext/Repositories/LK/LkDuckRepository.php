<?php
namespace app\modules\module_page_store\ext\Repositories\LK;

use app\modules\module_page_store\ext\Repositories\Repository;

class LkDuckRepository extends Repository
{
    private $tableName = 'lk_system';
    private $mode = 'lk';
    private $userId = 0;
    private $dbId = 0;

    public function __construct($Db, $Translate)
    {
        $this->userId = $Db->db_data[$this->mode][0]['USER_ID'];
        $this->dbId = $Db->db_data[$this->mode][0]['DB_num'];

        parent::__construct($Db, $Translate, $this->tableName, $this->mode, $this->userId, $this->dbId);
    }

    public function getBalanceByAuth(string $steam): int
    {
        return $this->select(
            ['money'],
            [
                'auth' => [
                    'condition' => 'LIKE',
                    'value' => $steam
                ]
            ]
        )[0]['money'] ?? 0;
    }

    public function updateBalanceByAuth(string $steam, int $value): bool
    {
        return $this->update(
            ['money' => $value],
            [ 
                'auth' => [
                    'condition' => 'LIKE',
                    'value' => $steam
                ]
            ]
        ) === 1;
    }
}
