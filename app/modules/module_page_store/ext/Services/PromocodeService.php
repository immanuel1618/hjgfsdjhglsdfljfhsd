<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\PromocodeRepository;

class PromocodeService
{
    private $rep;
    private $Translate;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->rep = new PromocodeRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->rep->getAll();
    }

    public function getById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найден промокод по переданному ID. ID: $id"));
        }

        return $result[0] ?? [];
    }

    public function getByName(string $name): array
    {
        return $this->rep->getByName($name)[0] ?? [];
    }

    public function decrementById(int $id): bool
    {
        $promo = $this->getById($id);

        return $this->rep->updateById($id, ['amount' => $promo['amount'] - 1]);
    }

    public function create(array $fields): ?array
    {
        if (empty($fields['name']) || empty($fields['percent']) || empty($fields['amount'])) {
            return null;
        }

        $fields = [
            'name' => $fields['name'],
            'percent' => $fields['percent'],
            'amount' => $fields['amount']
        ];

        if ($this->isExists($fields['name'])) {
            ErrorLog::add(
                new \Exception('Не удалось добавить промокод, так как он уже существует NAME: ' . $fields['name'])
            );

            return null;
        }

        if (empty($result = $this->rep->create($fields))) {
            ErrorLog::add(new \Exception('Не удалось добавить промокод NAME: ' . $fields['name']));
        }

        return $result;
    }

    public function updateById(int $id, array $fields): bool
    {
        if (empty($fields['name']) || empty($fields['percent']) || empty($fields['amount'])) {
            return false;
        }

        $fields = [
            'name' => $fields['name'],
            'percent' => $fields['percent'],
            'amount' => $fields['amount']
        ];

        if ($this->rep->updateById($id, $fields)) {
            return true;
        }

        ErrorLog::add(new \Exception("Не удалось обновить промокод ID: $id NAME: " . $fields['name']));

        return false;
    }

    public function deleteById(int $id): bool
    {
        if ($this->rep->deleteById($id)) {
            return true;
        }

        ErrorLog::add(new \Exception("Не удалось удалить промокод ID: $id"));
        return false;
    }

    public function isExists(string $name): bool
    {
        return $this->rep->isExists($name);
    }
}
