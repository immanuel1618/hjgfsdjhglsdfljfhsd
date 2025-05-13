<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Dictionary;
use app\modules\module_page_store\ext\Services\BasketService;
use app\modules\module_page_store\ext\Services\DiscountService;
use app\modules\module_page_store\ext\Services\OptionPriceService;
use app\modules\module_page_store\ext\Services\ProductService;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\ShopOptionService;

class BasketController
{
    private $Db;
    private $service;
    private $Translate;

    public function __construct($Db, $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->service = new BasketService($Db, $Translate);
    }

    public function findBySteam(string $steamId): array
    {
        $data = $this->service->findBySteam($steamId);
        if (empty($data)) {
            return [];
        }

        $serverService = new ServerService($this->Db, $this->Translate);
        $productService = new ProductService($this->Db, $this->Translate);
        $discountService = new DiscountService($this->Db, $this->Translate);
        $priceService = new OptionPriceService($this->Db, $this->Translate);
        $shopOptionsService = new ShopOptionService($this->Db, $this->Translate);

        $prices = $priceService->findByIds(array_keys($data));
        $productIds = $newPrices = [];
        foreach ($prices as $price) {
            $newPrices[$price['id']] = $price;
            $productIds[$price['id']] = $price['product_id'];
        }

        $servers = $serverService->getAll();
        $products = $productService->findByIds($productIds);

        $globalDiscount = $discountService->getAll()[-1];
        $options = $shopOptionsService->getAll();
        $types = Dictionary::get('types');

        $result = [];
        $totalPrice = 0;
        foreach ($data as $priceId => $basketId) {
            $product = $products[$newPrices[$priceId]['product_id']];
            $percent = $product['discount'] + $globalDiscount;
            $price = round($newPrices[$priceId]['price'] - ($newPrices[$priceId]['price'] / 100 * $percent));
            $option = $newPrices[$priceId]['options'];
            $totalPrice += $price;

            $title = '';
            if ($types[$product['type']] === 1) {
                $title = $product['title'].' '.$option['time_value'].' - '.$price.' '.$options['amount_value'];
            } else if ($types[$product['type']] === 2) {
                $title = $option['amount']. ' '. $option['amount_value']. ' - '. $price. ' '. $options['amount_value'];
            } else if ($types[$product['type']] === 3) {
                $title = $option['title']. ' - ' . $price . ' ' . $options['amount_value'];
            }

            $result[] = [
                'id' => $basketId,
                'title' => $title,
                'server_name' => $servers[$product['server_id']]['name'],
            ];
        }

        return ['basket' => $result, 'total_price' => $totalPrice];
    }

    public function deleteById(int $id): array
    {
        if ($this->service->deleteById($id)) {
            $translateCode = '_successBasketItemDelete';
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', $translateCode)
            ];
        }

        return [
            'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorBasketItemDelete')
        ];
    }

    public function create(int $priceId): array
    {
        if (!isset($_SESSION['steamid32'])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_noAuth')
            ];
        }

        if (!empty($this->service->findBySteam($_SESSION['steamid32'])[$priceId])) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorNoEmptyBasketItem')
            ];
        }

        $priceOptionService = new OptionPriceService($this->Db, $this->Translate);
        if (empty($priceOptionService->getById($priceId))) {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorBasketSet')
            ];
        }

        if ($this->service->create($priceId, $_SESSION['steamid32'])) {
            return [
                'success' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_successBasketSet')
            ];
        } else {
            return [
                'error' => $this->Translate->get_translate_module_phrase( 'module_page_store', '_errorBasketSet')
            ];
        }
    }
}
