<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\CategoryRepository;

class CategoryService
{
    private $rep;
    private $Translate;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->rep = new CategoryRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->rep->getAll();
    }

    public function getAllSorted(): array
    {
        return $this->rep->getAllSorted();
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

    public function create(array $fields): ?array
    {
        if (empty($fields['name']) || empty($fields['sort'])) {
            return null;
        }

        $fields = [
            'name' => $fields['name'],
            'sort' => $fields['sort'],
        ];

        if ($this->isExists($fields['name'])) {
            ErrorLog::add(
                new \Exception('Не удалось добавить категорию, так как она уже существует NAME: ' . $fields['name'])
            );

            return null;
        }

        if (empty($result = $this->rep->create($fields))) {
            ErrorLog::add(new \Exception('Не удалось добавить категорию NAME: ' . $fields['name']));
        }

        return $result;
    }

    public function updateById(int $id, array $fields): bool
    {
        if (empty($fields['name']) || empty($fields['sort'])) {
            return false;
        }

        $fields = [
            'name' => $fields['name'],
            'sort' => $fields['sort']
        ];

        if ($this->rep->updateById($id, $fields)) {
            return true;
        }

        ErrorLog::add(new \Exception("Не удалось обновить категорию ID: $id NAME: " . $fields['name']));

        return false;
    }

    public function deleteById(int $id): bool
    {
        if ($this->rep->deleteById($id)) {
            return true;
        }

        ErrorLog::add(new \Exception("Не удалось удалить категорию ID: $id"));
        return false;
    }

    public function isExists(string $name): bool
    {
        return $this->rep->isExists($name);
    }
}
