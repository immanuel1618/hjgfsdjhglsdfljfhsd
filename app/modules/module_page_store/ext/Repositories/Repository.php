<?php
namespace app\modules\module_page_store\ext\Repositories;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ParameterObjects\Pagination;

class Repository
{
    private $Db;
    private $tableName;
    private $mode;
    private $userId;
    private $dbId;

    public function __construct($Db, $Translate, $tableName, $mode, $userId, $dbId)
    {
        $this->Db = $Db;
        $this->mode = $mode;
        $this->dbId = $dbId;
        $this->userId = $userId;
        $this->tableName = $tableName;
    }

    /**
     * $fields - массив полей выборки
     * $conditions - ключи проверяемые поля. Если значение массив, то должны быть ключи condition(условие)
     * (например: >=, =, <=) и value - значение проверки. Если значение строка - то значение проверки
     * $sortFields - массив полей для сортировки (можно указывать вместе с направлением. Например: id DESC)
     * $pgn - объект пагинации
     * 
     * Возвращает массив объектов или null, если ошибка БД
     */
    protected function select(
        array $fields = ['*'],
        array $conditions = [],
        array $sortFields = [],
        Pagination $pgn = null
    ): array
    {
        $fieldsString = empty($fields) ? '*' : implode(",", $fields);
        $sortString = !empty($sortFields) ? " ORDER BY " . implode(",", $sortFields) : '';

        $minLimit = isset($pgn) ? ($pgn->page - 1) * $pgn->perPage : 0;
        $limitString = isset($pgn) ? "LIMIT {$minLimit}, {$pgn->perPage}" : '';

        $params = [];
        $whereString = $this->getWhereString($conditions, $params);

        $sql = "SELECT {$fieldsString} FROM {$this->tableName} {$whereString} {$sortString} {$limitString}";
        try {
            return $this->Db->queryAll($this->mode, $this->userId, $this->dbId, $sql, $params);
        } catch (\Exception $e) {
            ErrorLog::add($e);
            return [];
        }
    }

    /**
     * $fields - массив полей для обновления. Ключи массива - столбцы, значения массива - значения столбцов
     * $conditions - ключи проверяемые поля. Если значение массив, то должны быть ключи condition(условие)
     * (например: >=, =, <=) и value - значение проверки. Если значение строка - то значение проверки
     * 
     * Возвращает количество обновленных записей или null, если ошибка БД
     */
    protected function update(array $fields, array $conditions = []): int
    {
        if (empty($fields)) {
            return null;
        }

        $params = [];
        $setString = 'SET ';
        foreach ($fields as $key => $value) {
            $setString .= "`{$key}`=:{$key}";
            $setString .= $key != array_keys($fields)[count($fields)-1] ? ' , ' : '';
            $params[$key] = $value;
        }

        $whereString = $this->getWhereString($conditions, $params);

        $sql = "UPDATE {$this->tableName} {$setString} {$whereString}";
        try {
            return $this->Db->inquiry($this->mode, $this->userId, $this->dbId, $sql, $params)->rowCount();
        } catch (\Exception $e) {
            ErrorLog::add($e);
            return 0;
        }
    }

     /**
     * $fields - массив полей для вставки. Ключи массива - столбцы, значения массива - значения столбцов
     * 
     * Возвращает добавленный элемент или null, если ошибка БД
     */
    protected function insert(array $fields): ?array
    {
        if (empty($fields)) {
            return null;
        }

        $params = [];
        $columns = $values = '';
        foreach ($fields as $column => $value) {
            $columns .= "`{$column}`";
            $values .= ":{$column}";

            if ($column !=array_keys($fields)[count($fields)-1]) {
                $columns .= ' , ';
                $values .= ' , ';
            }
           
            $params[$column] = $value;
        }

        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$values})";
        try {
            if ($this->Db->inquiry($this->mode, $this->userId, $this->dbId, $sql, $params)->rowCount() === 1) {
                if($this->tableName == 'vip_users'){
                    $item = $this->select(['*'], [], ['account_id DESC'], new Pagination(1, 1));
                } else {
                    $item = $this->select(['*'], [], ['id DESC'], new Pagination(1, 1));
                }
                if (!isset($item[0])) {
                    return [
                        'success' => false,
                    ];
                }
                return $item[0];
            }

            throw new \Exception("Failed to insert of object");
        } catch (\Exception $e) {
            ErrorLog::add($e);
            return null;
        }
    }

    protected function delete(array $conditions = []): int
    {
        $params = [];
        $whereString = $this->getWhereString($conditions, $params);

        $sql = "DELETE FROM {$this->tableName} {$whereString}";
        try {
            return $this->Db->inquiry($this->mode, $this->userId, $this->dbId, $sql, $params)->rowCount();
        } catch (\Exception $e) {
            ErrorLog::add($e);
            return 0;
        }
    }

    protected function setTable(string $table): void
    {
        $this->tableName = $table;
    }

    private function getWhereString(array $conditions, array &$params): string
    {
        $whereString = !empty($conditions) ? 'WHERE ' : '';
        foreach ($conditions as $key => $value) {
            $inString = '';
            $condition = '';
            if (is_array($value)) {
                if (isset($value['condition'])) {
                    $condition = $value['condition'];
                    $inString = ":{$key}";
                    $params[$key] = $value['value'];
                } else {
                    $inString = '(:' . implode(', :', $value) . ')';
                    foreach ($value as $item) {
                        $params[$item] = $item;
                    }
                    $condition = ' IN ';
                }
            } else {
                $condition = "=";
                $inString = ":{$key}";
                $params[$key] = $value;
            }
            
            $whereString .= "`{$key}` {$condition} {$inString}";
            $whereString .= $key != array_keys($conditions)[count($conditions)-1] ? ' AND ' : '';   
        }

        return $whereString;
    }
}
