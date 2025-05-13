<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\DiscountRepository;

class DiscountService
{
    private $Translate;
    private $rep;

    public function __construct($Db, $Translate)
    {
        $this->Translate = $Translate;
        $this->rep = new DiscountRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        $result = [];
        $discounts = $this->rep->getAll();
        foreach ($discounts as $discount) {
            $result[$discount['product_id']] = $discount['value'];
        }

        $result[-1] = !isset($result[-1]) ? 0 : $result[-1];

        return $result;
    }

    public function getByProductId(int $productId): array
    {
        $result = $this->rep->getByProductId($productId);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не найдена скидка по переданному ID продукта. PRODUCT_ID: $productId"));
        }

        return $result[0] ?? [];
    }

    public function findByProductIds(array $ids): array
    {
        $discounts = $this->rep->findByProductIds($ids);

        $result = [];
        foreach ($discounts as $discount) {
            $result[$discount['product_id']] = $discount['value'];
        }

        return $result;
    }

    public function updateOrCreate(string $productId, int $value): bool
    {
        $fields = [
            'product_id' => $productId,
            'value' => $value,
        ];

        $isExists = !empty($this->getByProductId($productId));

        if($isExists){
            $get_value = $this->getByProductId($productId)['value'];
            if($get_value == $value){
                return true; 
            }
        }

        $result = $isExists && $this->rep->updateByProductId($productId, $fields) || !$isExists && $this->rep->create($fields);

        if (!$result) {
            ErrorLog::add(
                new \Exception("Не удалось обновить скидку по продукту. PRODUCT_ID: $productId VALUE: $value")
            );
        }

        return $result;    
    }
}
