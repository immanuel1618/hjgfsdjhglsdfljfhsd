<?php

namespace app\modules\module_page_store\ext;

use app\ext\Db;
use app\ext\Translate;
use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\Orders\OrderLogRepository;
use app\modules\module_page_store\ext\Services\ShopOptionService;
use app\modules\module_page_store\ext\Services\ServerService;

class OrderLog
{
    private $Db;
    private $Translate;
    private $rep;

    public function __construct(Db $Db, Translate $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->rep = new OrderLogRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->rep->getAll();
    }

    public function getAllPagination($page, $on_page): array
    {
        $list = $this->rep->getAllPagination($page, $on_page);
        $pages = ceil(count($this->rep->getAll()) / $on_page);

        return [$list, $pages];
    }

    public function create(
        string $steam,
        array $priceOption,
        array $product,
        ?string $promo,
        bool $status
    ): bool {
        $types = Dictionary::get('types');
        $shopOptionsService = new ShopOptionService($this->Db, $this->Translate);
        $serverService = new ServerService($this->Db, $this->Translate);

        $price = $priceOption['price'];
        $option = $priceOption['options'];
        $options = $shopOptionsService->getAll();
        

        $server = $serverService->getById($product['server_id'])['name'] ?? '';

        $title = '';
        if ($types[$product['type']] === 1) {
            $title = $product['title'].' '.$option['time_value'].' - '.$price.' '.$options['amount_value'];
        } else if ($types[$product['type']] === 2) {
            $title = $option['amount']. ' '. $option['amount_value']. ' - '. $price. ' '. $options['amount_value'];
        } else if ($types[$product['type']] === 3) {
            $title = $option['title']. ' - ' . $price . ' ' . $options['amount_value'];
        }

        $gift = null;

        if($steam != $_SESSION['steamid32']){
            $gift = $_SESSION['steamid32'];
        }
        
        $fields = [
            'steam' => $steam,
            'title' => $title,
            'server' => $server,
            'promo' => $promo,
            'gift' => $gift,
            'status' => $status,
            'date' => date('Y-m-d H:i:s'),
        ];

        if (!$this->rep->create($fields)) {
            ErrorLog::add(new \Exception('Не удалось выполнить сохранение информации об оформлении заказе'));

            return false;
        }

        return true;
    }
}
