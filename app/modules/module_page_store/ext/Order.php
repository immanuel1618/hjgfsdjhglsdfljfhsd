<?php

namespace app\modules\module_page_store\ext;

use app\ext\Db;
use app\ext\General;
use app\ext\Translate;
use app\ext\Notifications;
use app\modules\module_page_store\ext\OrderLog;
use app\modules\module_page_store\ext\Services\LkService;
use app\modules\module_page_store\ext\Services\BasketService;
use app\modules\module_page_store\ext\Services\ServerService;
use app\modules\module_page_store\ext\Services\ProductService;
use app\modules\module_page_store\ext\Services\DiscountService;
use app\modules\module_page_store\ext\Services\PromocodeService;
use app\modules\module_page_store\ext\Services\WebServerService;
use app\modules\module_page_store\ext\Services\OptionPriceService;
use app\modules\module_page_store\ext\Services\Products\Vip;
use app\modules\module_page_store\ext\Services\Products\MaterialAdmin;
use app\modules\module_page_store\ext\Services\Products\IksAdmin;
use app\modules\module_page_store\ext\Services\Products\AdminSystem;
use app\modules\module_page_store\ext\Repositories\Products\LevelRanksRepository;
use app\modules\module_page_store\ext\Services\Webhook;
use app\modules\module_page_store\ext\Services\VkMessage;

class Order
{
    private $Db;

    private $steam;

    private $promo;

    private $promoId;

    private $prices;

    private $balance;

    private $products;

    private $priceIds;

    private $Translate;

    private $totalPrice;

    private $General;

    private $Notifications;

    private $globalDiscount;

    private $translateSuccessCode = null;

    private $translationErrorCode;

    public function __construct(Notifications $Notifications, Translate $Translate, Db $Db, General $General)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->General = $General;
        $this->Notifications = $Notifications;
    }

    public function paymentProcessing(string $steam, string $promo): array
    {
        $basketService = new BasketService($this->Db, $this->Translate);
        $this->priceIds = array_keys($basketService->findBySteam($_SESSION['steamid32']));

        if (
            !$this->steamValidation($steam) ||
            !$this->promoValidation($promo) ||
            !$this->pricesAndProductsValidation() ||
            !$this->setTotalPrice()
        ) {
            return $this->error();
        }

        if (!$this->checkBalance()) {
            return $this->error();
        }

        $status = $this->handler($this->priceIds, $this->steam);

        if (
            !$status ||
            $this->promo !== null && !$this->promoDecrement() ||
            !$this->decreaseBalance() ||
            !$this->cleanBasket()
        ) {
            return $this->error();
        }
        return $this->success();
    }

    public function handler(array $priceIds, string $steam): bool
    {
        if (empty($this->prices) || empty($this->products)) {
            $this->setPricesAndProducts($priceIds);
        }

        $this->steam = $steam;

        foreach ($this->prices as $price) {
            $product = $this->products[$price['product_id']];

            if ($product['status'] == 0) {
                if (!$this->translationErrorCode) {
                    $this->translationErrorCode = '_errorOffProduct';
                }
                return false;
            }

            if (!$this->checkMods($product['type'])) {
                return false;
            }

            switch ($product['type']) {
                case 'vip_riko':
                    $result = $this->vipAction($price, $product, Vip::RIKO);
                    break;
                case 'ma':
                    $result = $this->materialAdminAction($price, $product);
                    break;
                case 'iks':
                    $result = $this->IksAdminAction($price, $product);
                    break;
                case 'iks_vip':
                    $result = $this->IksAdmin_Vip_Action($price, $product);
                    break;
                case 'adminsystem':
                    $result = $this->AdminSystemAction($price, $product);
                    break;
                case 'vip_ws':
                    $result = $this->vipAction($price, $product, Vip::WS);
                    break;
                case 'shop_credits':
                    $result = $this->shopCreditsAction($price, $product);
                    break;
                case 'lr_exp':
                    $result = $this->lrExpirienceAction($price, $product);
                    break;
                case 'rcon':
                    $result = $this->rconAction($price, $product);
                    break;
                case 'wcs_level':
                    $result = $this->wcsLevelAction($price, $product);
                    break;
                case 'wcs_gold':
                    $result = $this->wcsGoldAction($price, $product);
                    break;
                case 'wcs_race':
                    $result = $this->wcsRaceAction($price, $product);
                    break;
                case 'vip_wcs':
                    $result = $this->vipWcsAction($price, $product);
                    break;
            }

            if (!$result) {
                if (!$this->translationErrorCode) {
                    $this->translationErrorCode = '_errorGiveProduct';
                }

                return false;
            }
            $Discount = new DiscountService($this->Db, $this->Translate);

            $globalDiscount = $Discount->getByProductId(-1)['value'];

            $discount = 100 - $this->promo - ($product['discount'] ?? 0) - $globalDiscount;
            $PriceDiscount = round($price['price'] / 100 * $discount);

            $price['price'] = $PriceDiscount;

            $logService = new OrderLog($this->Db, $this->Translate);
            $logService->create($this->steam, $price, $product, $this->promo, true);

            $webhook = new Webhook($this->Db, $this->Translate, $this->General);
            $webhook->sendDiscordWebhook($product, $price, $this->steam, $this->promo);

            $vkmessage = new VkMessage($this->Db, $this->Translate, $this->General);
            $vkmessage->sendVkMessage($product, $price, $this->steam, $this->promo);

            $this->sendNotification('_successProductBuy', $product['title']);
        }

        return true;
    }

    private function materialAdminAction(array $priceOption, array $product): bool
    {
        $options = $priceOption['options'];
        $ma = new MaterialAdmin($this->Db, $this->Translate, $product['server_id']);
        $result = $ma->setGroup($this->steam, $options['group'], $options['time'], $options['web_group_id'] ?? -1);
        if (!$result) {
            $this->translationErrorCode = '_errorSetMa';

            return false;
        }

        if (!$this->sendRcon($product['server_id'], 'sm_reloadadmins')) {
            $this->translateSuccessCode = '_successWithoutRcon';
        };

        return true;
    }

    private function IksAdminAction(array $priceOption, array $product): bool
    {
        $options = $priceOption['options'];
        $iks = new IksAdmin($this->Db, $this->Translate, $product['server_id']);
        $result = $iks->setGroup(con_steam32to64($this->steam), $options['group'], $options['time']);
        if (!$result) {
            $this->translationErrorCode = '_errorSetIks';
            return false;
        }

        if (!$this->sendRcon($product['server_id'], 'css_reload_admins')) {
            $this->translateSuccessCode = '_successWithoutRcon';
        };

        return true;
    }

    private function IksAdmin_Vip_Action(array $priceOption, array $product): bool
    {
        $steam3 = con_steam32to3_int($this->steam);
        $steam64 = con_steam32to64($this->steam);
        $options = $priceOption['options'];
        $iks = new IksAdmin($this->Db, $this->Translate, $product['server_id']);
        $vipService = new Vip($this->Db, $this->Translate, Vip::RIKO, $product['server_id']);

        $group = explode(";", $options['group']);

        if (!isset($group[1])) {
            $this->translationErrorCode = '_errorGroup';
            return false;
        }

        $result_iks = $iks->setGroup($steam64, $group[0], $options['time']);
        $result_vip = $vipService->setGroup($this->steam, $group[1], $options['time']);

        if (!$result_vip) {
            $this->translationErrorCode = '_errorSetVip';
            return false;
        }

        if (!$result_iks) {
            $this->translationErrorCode = '_errorSetIks';
            return false;
        }

        $result_iks = $this->sendRcon($product['server_id'], 'css_reload_admins');

        $result_vip = $this->sendRcon($product['server_id'], 'sm_refresh_vips;mm_reload_vip ' . $steam64 . ';css_reload_vip_player ' . $steam3);

        if (!$result_iks && $result_vip) {
            $this->translateSuccessCode = '_successWithoutRcon';
        };

        return true;
    }

    private function AdminSystemAction(array $priceOption, array $product): bool
    {
        $options = $priceOption['options'];
        $AS = new AdminSystem($this->Db, $this->Translate, $product['server_id']);
        $result = $AS->setGroup(con_steam32to64($this->steam), $options['group'], $options['time']);
        if (!$result) {
            $this->translationErrorCode = '_errorSetAS';

            return false;
        }
        return true;
    }

    private function rconAction(array $priceOption, array $product): bool
    {
        $command = $priceOption['options']['rcon'];

        $steam3 = con_steam32to3_int($this->steam);
        $steam64 = con_steam32to64($this->steam);
        $steam32_0 = $this->steam;
        $steam32_0[6] = 0;

        $codes = ['%n', '%s0', '%s1', '%s3', '%s64'];
        $params = [Tools::getNicknameBySteam($this->steam), $steam32_0, $this->steam, $steam3, $steam64];

        if ($priceOption['options']['all_servers'] == 0) {
            return $this->sendRcon($product['server_id'], str_replace($codes, $params, $command));
        } else {
            return $this->sendRconAll(str_replace($codes, $params, $command));
        }
    }

    private function lrExpirienceAction(array $priceOption, array $product): bool
    {
        $rep = new LevelRanksRepository($this->Db, $this->Translate, $product['server_id']);
        if (!$rep->getBySteam($this->steam)) {
            $this->translationErrorCode = '_errorFindProfileInLR';
            return false;
        }

        return $this->sendRcon(
            $product['server_id'],
            'lr_giveexp "' . $this->steam . '" ' . $priceOption['options']['amount']
        );
    }

    private function wcsRaceAction(array $priceOption, array $product): bool
    {
        $options = $priceOption['options'];
        $time = $options['time'] * 24;

        return $this->sendRcon(
            $product['server_id'],
            'wcs_giveprivate "' . $this->steam . '" ' . $options['group'] . ' ' . $time
        );
    }

    private function vipWcsAction(array $priceOption, array $product): bool
    {
        $options = $priceOption['options'];
        $time = $options['time'] * 24 * 60;
        $name = Tools::getNicknameBySteam($this->steam) ?? 'Unknown';

        return $this->sendRcon(
            $product['server_id'],
            'wcs_givevip "' . $this->steam . '" ' . $name . ' ' . $options['group'] . ' ' . $time
        );
    }

    private function wcsGoldAction(array $priceOption, array $product): bool
    {
        return $this->sendRcon(
            $product['server_id'],
            'wcs_setgold + ' . $priceOption['options']['amount'] . ' "' . $this->steam . '"'
        );
    }

    private function wcsLevelAction(array $priceOption, array $product): bool
    {
        return $this->sendRcon(
            $product['server_id'],
            'wcs_setlblvl + ' . $priceOption['options']['amount'] . ' "' . $this->steam . '"'
        );
    }

    private function shopCreditsAction(array $priceOption, array $product): bool
    {
        $steam32_0 = $this->steam;
        $steam32_0[6] = 0;
        return $this->sendRcon(
            $product['server_id'],
            'css_add_credits #'.$steam32_0.' ' . $priceOption['options']['amount'].';sm_shop_givecredits "' . $this->steam . '" ' . $priceOption['options']['amount']
        );
    }

    private function vipAction(array $priceOption, array $product, string $type): bool
    {
        $steam3 = con_steam32to3_int($this->steam);
        $steam64 = con_steam32to64($this->steam);
        $priceOption = $priceOption['options'];
        $vipService = new Vip($this->Db, $this->Translate, $type, $product['server_id']);
        $result = $vipService->setGroup($this->steam, $priceOption['group'], $priceOption['time']);
        if (!$result) {
            $this->translationErrorCode = '_errorSetVip';
            return false;
        }

        if($type === Vip::RIKO){
            $result = $this->sendRcon($product['server_id'], 'sm_refresh_vips;mm_reload_vip ' . $steam64 . ';css_reload_vip_player ' . $steam3);
        } else {
            $result = $this->sendRcon($product['server_id'], 'sm_vipadminreload');
        } 

        if (!$result) {
            $this->translateSuccessCode = '_successWithoutRcon';
        };

        return true;
    }

    private function sendRcon(int $serverId, string $command): bool
    {
        $serverService = new ServerService($this->Db, $this->Translate);
        $webServerService = new WebServerService($this->Db, $this->Translate);
        $webServerId = $serverService->getById($serverId)['web_server_id'] ?? null;

        $rcon_status = false;

        $rconData = $webServerService->getRconById($webServerId);
        if (empty($rconData['ip']) || empty($rconData['rcon'])) {
            ErrorLog::add(new \Exception('Не найден IP или Rcon пароль для сервера'));
            $this->translationErrorCode = '_notFoundRconData';

            $rcon_status = false;
        }

        $ip = explode(':', $rconData['ip'])[0];
        $port = explode(':', $rconData['ip'])[1];

        $rcon = new Rcon($ip, $port);
        if ($rcon->Connect()) {
            if ($rcon->RconPass($rconData['rcon']) === false) {
                ErrorLog::add(new \Exception('RCON пароль от сервера неверный'));
                $this->translationErrorCode = '_rconPasswordFailed';
                $rcon_status = false;
            }
            $rcon->Command($command);
            $rcon->Disconnect();
            $rcon_status = true;
        } else {
            ErrorLog::add(new \Exception('Ошибка при попытке соединения с сервером. Возможно IP адрес сайта заблокирован, либо не добавлен в разрешенные'));
            $this->translationErrorCode = '_rconConnectFailed';
            $rcon_status = false;
        }
        return $rcon_status;
    }

    private function sendRconAll(string $command): bool
    {
        $webServerService = new WebServerService($this->Db, $this->Translate);
        $webServers = $webServerService->getAll() ?? null;
        $server_count = sizeof($webServers);
        foreach ($webServers as $server) {
            --$server_count;
            $ip = explode(':', $server['ip'])[0];
            $port = explode(':', $server['ip'])[1];

            $rcon = new Rcon($ip, $port);
            if ($rcon->Connect()) {
                if ($rcon->RconPass($server['rcon']) === false) {
                    ErrorLog::add(new \Exception('RCON пароль от сервера неверный'));
                }
                $rcon->Command($command);
                $rcon->Disconnect();
            } else {
                ErrorLog::add(new \Exception('Ошибка при попытке соединения с сервером. Возможно IP адрес сайта заблокирован, либо не добавлен в разрешенные'));
            }
            if(!$server_count){
                return true;
            }
        }
    }

    private function checkMods(string $type): bool
    {
        if ($type === 'vip_riko' && empty($this->Db->db_data['Vips'])) {
            $this->translationErrorCode = '_errorNoVips';
            return false;
        } else if ($type === 'ma' && empty($this->Db->db_data['SourceBans'])) {
            $this->translationErrorCode = '_errorNoSb';
            return false;
        } else if ($type === 'iks' && empty($this->Db->db_data['IksAdmin'])) {
            $this->translationErrorCode = '_errorNoIks';
            return false;
        } else if ($type === 'iks_vip' && empty($this->Db->db_data['IksAdmin']) && empty($this->Db->db_data['Vips'])) {
            $this->translationErrorCode = '_errorNoIks';
            $this->translationErrorCode = '_errorNoVips';
            return false;
        }

        return true;
    }

    public function cleanBasket(): bool
    {
        $basketService = new BasketService($this->Db, $this->Translate);

        $status = $basketService->cleanBySteam($_SESSION['steamid32']);

        if (!$status) {
            $this->translationErrorCode = '_basketNotCleaned';
        }

        return $status;
    }

    private function setPricesAndProducts(array $priceIds): bool
    {
        $OptionPrice = new OptionPriceService($this->Db, $this->Translate);
        $Product = new ProductService($this->Db, $this->Translate);

        $this->prices = $OptionPrice->findByIds($priceIds);

        $productIds = [];
        foreach ($this->prices as $price) {
            $productIds[] = $price['product_id'];
        }

        $this->products = $Product->findByIds($productIds);

        return true;
    }

    private function decreaseBalance(): bool
    {
        $Lk = new LkService($this->Db, $this->Translate);

        if (!$Lk->updateBalanceByCurrentUser($this->totalPrice)) {
            $this->translationErrorCode = '_errorBalanceUpdate';

            return false;
        }

        return true;
    }

    private function promoDecrement(): bool
    {
        $Promo = new PromocodeService($this->Db, $this->Translate);

        if (!$Promo->decrementById($this->promoId)) {
            ErrorLog::add(new \Exception('При уменьшении кол-ва промокодов произошла ошибка'));
            $this->translationErrorCode = '_errorPromoUpdate';

            return false;
        }

        return true;
    }

    private function steamValidation(string $steam): bool
    {
        if ($steam) {
            if (preg_match('/^STEAM_1:[0-1]:\d+$/', $steam)) {
                $steam = $steam;
            } else if (preg_match('/^(7656119)([0-9]{10})$/', $steam)) {
                $steam = con_steam64to32($steam);
            } else if (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/', $steam)) {
                $search_id = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(id)\/(\S{1,})/", '$3', $steam), "/");
                $getsearch = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key={$this->General->arr_general['web_key']}&vanityurl={$search_id}"), true)['response']['steamid'];
                $steam = con_steam64to32($getsearch);
            } else if (preg_match('/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/', $steam)) {
                $search_steam = rtrim(preg_replace("/^\w{1,}:\/\/(steamcommunity.com)\/(profiles)\/(7656119[0-9]{10})(\/|)/", '$3', $steam), "/");
                $steam = con_steam64to32($search_steam);
            } else if (preg_match('/^\[U:(.*)\:(.*)\]$/', $steam)) {
                $steam = con_steam3to32_int(str_replace(array('[U:1:', '[U:0:', ']'), '', $steam));
            }
        }
        if (!empty($steam)) {
            if (!Tools::getNicknameBySteam($steam)) {
                $this->translationErrorCode = '_steamIdNotExists';

                return false;
            }
        }

        $this->steam = empty($steam) ? $_SESSION['steamid32'] : $steam;
        return true;
    }

    private function promoValidation(string $promoName): bool
    {
        $Promo = new PromocodeService($this->Db, $this->Translate);

        if ($promoName === '') {
            $this->promoId = null;
            $this->promo = null;

            return true;
        }

        if (empty($promo = $Promo->getByName($promoName))) {
            $this->translationErrorCode = '_errorPromoFind';

            return false;
        }

        if ($promo['amount'] <= 0) {
            $this->translationErrorCode = '_errorPromoIsEnded';

            return false;
        }

        $this->promo = $promo['percent'];
        $this->promoId = $promo['id'];

        return true;
    }

    private function pricesAndProductsValidation(): bool
    {
        $OptionPrice = new OptionPriceService($this->Db, $this->Translate);

        $this->prices = $OptionPrice->findByIds($this->priceIds);

        if (count($this->prices) !== count($this->priceIds) || empty($this->priceIds)) {
            $this->translationErrorCode = '_errorOptionPriceFind';

            return false;
        }

        $productIds = [];
        foreach ($this->prices as $price) {
            $productIds[$price['product_id']] = $price['product_id'];
        }

        $Product = new ProductService($this->Db, $this->Translate);

        $this->products = $Product->findByIds($productIds);
        if (count($this->products) !== count($productIds)) {
            $this->translationErrorCode = '_errorProductFind';

            return false;
        }

        return true;
    }

    private function setTotalPrice(): bool
    {
        $Discount = new DiscountService($this->Db, $this->Translate);

        $this->totalPrice = 0;
        $this->globalDiscount = $Discount->getByProductId(-1)['value'];
        foreach ($this->prices as $price) {
            $discount = 100 - $this->promo - ($this->products[$price['product_id']]['discount'] ?? 0) - $this->globalDiscount;
            $this->totalPrice += round($price['price'] / 100 * $discount);
        }

        return true;
    }

    private function checkBalance(): bool
    {
        $Lk = new LkService($this->Db, $this->Translate);

        $this->balance = $Lk->getBalanceForCurrentUser();
        if ($this->totalPrice > $this->balance) {
            $this->translationErrorCode = '_noBalance';

            return false;
        }

        return true;
    }

    private function success(): array
    {
        $msg = $this->Translate
            ->get_translate_module_phrase('module_page_store', $this->translateSuccessCode ?? '_successCommand');

        return ['success' => $msg];
    }

    private function error(): array
    {
        $msg = $this->Translate
            ->get_translate_module_phrase('module_page_store', $this->translationErrorCode ?? '_errorAll');

        ErrorLog::add(new \Exception($msg));

        return ['error' => $msg];
    }

    private function sendNotification(string $translateCode, string $param)
    {
        if($this->General->arr_general['theme'] == 'neo'){
            $this->Notifications->SendNotification(
                $this->steam,
                '_SHOP',
                $translateCode,
                [
                    'param' => $param,
                    'module_translation' => 'module_page_store'
                ],
                '',
                'store',
                ''
            );
        } else {
            $this->Notifications->SendNotification(
                $this->steam,
                $translateCode,
                [
                    'param' => $param,
                    'module_translation' => 'module_page_store'
                ],
                Tools::SHOP_URL,
                'notifications fix-notic'
            );
        }
    }
}
