<?php

/**
 * @author WizZzarD <artur.rusanov2013@gmail.com>
 *
 * @link https://steamcommunity.com/id/WizzarD_1/
 *
 * @license GNU General Public License Version 3
 */

if (empty($Db->db_data['lk'] && $Db->db_data['lk'])) get_iframe('S3', 'Не найден мод - lk') && die();

use app\modules\module_page_store\ext\Shop;

if (IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

$Shop = new Shop($Db, $Translate, $Notifications, $Auth, $General);

// Получение баланса
$balance = $Shop->getBalance();

// Получение кэша
$cache = $Shop->getCache();

// Получение содержимого корзины
$cart = $Shop->getCart();

// Получение скидки на товары
$discount = $Shop->getDiscount()['discount'];
/**
 * Админ-часть 
 */
if (isset($_SESSION['user_admin'])) {
    // Получение серверов из LR WEB
    $serversLR = $Shop->getLrServers();
}
/**
 * Конец админ-части
 */

// Задаём заголовок страницы.
$Modules->set_page_title($Translate->get_translate_module_phrase('module_page_store', '_SHOP') . ' | ' . $General->arr_general['short_name']);

// Основная проверка на админ
if (isset($_SESSION['user_admin'])) {
    // Проверяем нажатие кнопки "Добавить сервер"
    if ($_POST['button'] == 'add-server') {
        exit(json_encode($Shop->addServer($_POST), true));
    }
    // Проверяем нажатие кнопки "Удалить сервер"
    if ($_POST['button'] == 'delete-server') {
        exit(json_encode($Shop->deleteServer($_POST), true));
    }
    // Проверяем нажатие кнопки "Добавить товар"
    if ($_POST['button'] == 'add-product') {
        exit(json_encode($Shop->addProduct($_POST), true));
    }
    // Проверяем нажатие кнопки "Удалить товар"
    if ($_POST['button'] == 'delete-product') {
        exit(json_encode($Shop->deleteProduct($_POST), true));
    }
    // Проверяем нажатие кнопки "Изменить товар"
    if ($_POST['button'] == 'edit-product') {
        exit(json_encode($Shop->editProduct($_POST), true));
    }
    // Проверяем нажатие кнопки "Установить скидку"
    if ($_POST['button'] == 'discount') {
        exit(json_encode($Shop->changeDiscount($_POST), true));
    }
    if ($_POST['button'] == 'webhook') {
        exit(json_encode($Shop->changeWebhook($_POST), true));
    }
    if ($_POST['button'] == 'webhookcolor') {
        exit(json_encode($Shop->changeWebhookColor($_POST), true));
    }
    // Ajax запрос для получения привилегии
    if ($_POST['button'] == 'edit-ajax-product') {
        exit(json_encode($Shop->editAjaxProduct($_POST), true));
    }
}
// Добавление товара в корзину
if ($_POST['button'] == 'add-product-cart') {
    exit(json_encode($Shop->addProductInCart($_POST), true));
}
// Ajax запрос для очистки корзины
if ($_POST['button'] == 'clean-basket') {
    exit(json_encode($Shop->cleanBasket($_POST), true));
}
// Проверяем нажатия кнопки "Купить"
if ($_POST['button'] == 'pay-product') {
    exit(json_encode($Shop->shopDistributor($_POST), true));
}