<?php
use app\modules\module_page_promo\ext\Promo;

if (IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

$Promo = new Promo($Translate, $Notifications, $General, $Modules, $Db);

if (isset($_POST['promo_name'])) {
    $Promo->Promo_ActivatePromocode($_POST);
    exit;
}