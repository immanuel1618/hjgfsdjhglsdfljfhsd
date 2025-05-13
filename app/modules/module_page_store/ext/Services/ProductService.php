<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\ProductRepository;
use app\modules\module_page_store\ext\Repositories\ProductPropertyRepository;
use app\modules\module_page_store\ext\Repositories\DiscountRepository;
use app\modules\module_page_store\ext\Repositories\OptionPriceRepository;
use app\modules\module_page_store\ext\Repositories\BasketRepository;

class ProductService
{
    private $Db;
    private $Translate;
    private $rep;

    public function __construct($Db, $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->rep = new ProductRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->rep->getAll();
    }

    public function getById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не удалось найти товар по переданному ID: $id"));
            return [];
        }

        $Discount = new DiscountService($this->Db, $this->Translate);

        $discount = $Discount->getByProductId($id);

        $result[0]['discount'] = !empty($discount) ? $discount['value'] : 0;

        return $result[0];
    }

    public function findByIds(array $ids): array
    {
        $products = $this->rep->findByIds($ids);

        $Discount = new DiscountService($this->Db, $this->Translate);

        $discounts = $Discount->findByProductIds($ids);

        $result = [];
        foreach ($products as $product) {
            $product['discount'] = $discounts[$product['id']] ?? 0;
            $result[$product['id']] = $product;
        }

        return $result;
    }

    public function create(array $fields): ?array
    {
        if (
            empty($fields['title']) ||
            !isset($fields['title_show']) ||
            empty($fields['color']) ||
            !isset($fields['table_status'])
        ) {
            ErrorLog::add(new \Exception('Не удалось создать товар, так как неправильно указаны поля'));
            return null;
        }

        $discount = isset($fields['discount']) ? $fields['discount'] : 0;

        $fields = [
            'status' => $fields['status'],
            'type' => $fields['type'],
            'sort' => $fields['sort'],
            'title' => $fields['title'],
            'title_show' => $fields['title_show'],
            'badge' => $fields['badge'],
            'category' => $fields['category'],
            'server_id' => $fields['server_id'],
            'img' => $fields['img'],
            'color' => $fields['color'],
            'table_status' => $fields['table_status']
        ];

        if (empty($result = $this->rep->create($fields))) {
            ErrorLog::add(new \Exception(
                'Произошла ошибка при создании товара. Возможно была изменена только скидка (не является ошибкой)'
            ));
        }

        if (isset($result['id'])) {
            $Discount = new DiscountService($this->Db, $this->Translate);
            if (!$Discount->updateOrCreate($result['id'], $discount)) {
                ErrorLog::add(new \Exception('Произошла ошибка при добавлении скидки для товара'));
            }
        }

        return $result;
    }

    public function updateById(int $id, array $fields): bool
    {
        if (
            empty($fields['title']) ||
            !isset($fields['title_show']) ||
            empty($fields['color']) ||
            !isset($fields['table_status'])
        ) {
            ErrorLog::add(new \Exception('Не удалось обновить товар, так как неправильно указаны поля'));

            return false;
        }

        $discount = isset($fields['discount']) ? $fields['discount'] : 0;

        $fields = [
            'status' => $fields['status'],
            'type' => $fields['type'],
            'sort' => $fields['sort'],
            'title' => $fields['title'],
            'title_show' => $fields['title_show'],
            'badge' => $fields['badge'],
            'category' => $fields['category'],
            'img' => $fields['img'],
            'color' => $fields['color'],
            'table_status' => $fields['table_status']
        ];

        $Discount = new DiscountService($this->Db, $this->Translate);
        if (!$Discount->updateOrCreate($id, $discount)) {
            ErrorLog::add(new \Exception('Произошла ошибка при добавлении скидки для товара'));
        }

        $this->rep->updateById($id, $fields);

        return true;
    }

    public function deleteById(int $id): bool
    {
        $PPR_card = new ProductPropertyRepository($this->Db, $this->Translate, 'card');
        $PPR_table = new ProductPropertyRepository($this->Db, $this->Translate, 'table');
        $DR = new DiscountRepository($this->Db, $this->Translate);
        $OPR = new OptionPriceRepository($this->Db, $this->Translate);
        $BR = new BasketRepository($this->Db, $this->Translate);

        $PPR_card->deleteByProductId($id);
        $PPR_table->deleteByProductId($id);
        $DR->deleteByProductId($id);
        $OPR->deleteByProductId($id);
        $BR->clean();

        return $this->rep->deleteById($id);
    }
}
