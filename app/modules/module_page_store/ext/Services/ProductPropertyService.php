<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\ProductPropertyRepository;

class ProductPropertyService
{
    private $Translate;
    private $rep;

    public function __construct($Db, $Translate, $type)
    {
        $this->Translate = $Translate;
        $this->rep = new ProductPropertyRepository($Db, $Translate, $type);
    }

    public function getAll(): array
    {
        $result = [];
        $properties = $this->rep->getAll();
        foreach ($properties as $item) {
            $result[$item['product_id']][] = $item;
        }

        return $result;
    }

    public function getById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найдено свойство продукта по переданному ID: $id"));
        }

        return $result[0] ?? [];
    }

    public function findByProductIds(array $productIds): array
    {
        $result = [];
        $properties = $this->rep->findByProductIds($productIds);
        foreach ($properties as $item) {
            $result[$item['product_id']][] = $item;
        }

        return $result;
    }

    public function GetByProductId(int $productId): array
    {
        $result = [];
        $properties = $this->rep->GetByProductId($productId);
        $result[] = $properties;

        return $result;
    }

    public function create(array $fields): ?array
    {
        if (empty($fields['title']) || !isset($fields['product_id']) || !isset($fields['active'])) {
            ErrorLog::add(new \Exception('При попытке создания свойства продукта было передано пустое поле'));
            return null;
        }

        $fields = [
            'title' => $fields['title'],
            'active' => $fields['active'],
            'sort' => $fields['sort'],
            'product_id' => $fields['product_id']
        ];

        if (empty($result = $this->rep->create($fields))) {
            ErrorLog::add(new \Exception('Не удалось создать свойство для продукта'));
        }

        return $result;
    }

    public function updateById(int $id, array $fields): bool
    {
        if (empty($fields['title']) || !isset($fields['active'])) {
            return false;
        }

        $fields = [
            'title' => $fields['title'],
            'sort' => $fields['sort'],
            'active' => $fields['active']
        ];

        return $this->rep->updateById($id, $fields);
    }

    public function deleteById(int $id): bool
    {
        if ($this->rep->deleteById($id)) {
            return true;
        }

        ErrorLog::add(new \Exception("Произошла ошибка при удалении свойства. ID: $id"));
        return false;
    }
}
