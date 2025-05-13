<?php
use app\modules\module_page_store\ext\Order;
use app\modules\module_page_store\ext\Controllers\BasketController;
use app\modules\module_page_store\ext\Controllers\ServerController;
use app\modules\module_page_store\ext\Controllers\ProductController;
use app\modules\module_page_store\ext\Controllers\DiscountController;
use app\modules\module_page_store\ext\Controllers\PromocodeController;
use app\modules\module_page_store\ext\Controllers\CategoryController;
use app\modules\module_page_store\ext\Controllers\WebServerController;
use app\modules\module_page_store\ext\Controllers\OptionPriceController;
use app\modules\module_page_store\ext\Controllers\ProductPropertyController;
use app\modules\module_page_store\ext\Controllers\ShopOptionController;

if( IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }

$Basket = new BasketController($Db, $Translate);
$Server = new ServerController($Db, $Translate);
$Product = new ProductController($Db, $Translate);
$Discount = new DiscountController($Db, $Translate);
$WebServer = new WebServerController($Db, $Translate);
$ShopOptions = new ShopOptionController($Db, $Translate);
$OptionPrice = new OptionPriceController($Db, $Translate);
$Order = new Order($Notifications, $Translate, $Db, $General);
$CardProperty = new ProductPropertyController($Db, $Translate, 'card');
$TableProperty = new ProductPropertyController($Db, $Translate, 'table');
$Category = new CategoryController($Db, $Translate);
$Promocode = new PromocodeController($Db, $Translate);

$servers = $Server->getAll();
$products = $Product->getAll();
$properties = $CardProperty->getAll();
$prices = $OptionPrice->getAll();
$options = $ShopOptions->getAll();
$discounts = $Discount->getAll();
$categories = $Category->getAllSorted();
$promocodes = $Promocode->getAll();


if (!isset($_SESSION['user_admin']) && $options['only_for_admin']) {
    get_iframe( '030', $Translate->get_translate_module_phrase('module_page_store', '_adminMode') );
}

if(isset($_SESSION['user_admin'])){
    $serversLR = $WebServer->getAll();
    if($_POST['button'] == 'change-column-count'){
        exit(json_encode($ShopOptions->update($_POST), true));
    }
}

$Modules->set_page_title( 
    $Translate->get_translate_module_phrase('module_page_store', '_SHOP') . ' | ' . $General->arr_general['short_name']
);

require MODULES . 'module_page_store/forward/routes.php';
