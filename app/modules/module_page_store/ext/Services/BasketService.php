<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\Repositories\BasketRepository;

class BasketService
{
    private $rep;

    public function __construct($Db, $Translate)
    {
        $this->rep = new BasketRepository($Db, $Translate);
    }

    public function findBySteam(string $steam): array
    {
        $data = $this->rep->findBySteam($steam);

        $result = [];
        foreach ($data as $item) {
            $result[$item['price_id']] = $item['id'];
        }

        return $result;
    }

    public function clean(): int
    {
        return $this->rep->clean();
    }

    public function cleanBySteam(string $steam): int
    {
        return $this->rep->cleanBySteam($steam);
    }

    public function deleteById(int $id): bool
    {
        return $this->rep->deleteById($id);
    }

    public function create(int $priceId, string $steam): ?array
    {
        $fields = [
            'price_id' => $priceId,
            'steam' => $steam,
        ];

        return $this->rep->create($fields);    
    }
}
