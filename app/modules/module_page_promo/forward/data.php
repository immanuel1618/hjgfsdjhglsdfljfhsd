<?php
use app\modules\module_page_promo\ext\Admin;

if (IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

$Admin = new Admin($Translate, $Notifications, $General, $Modules, $Db);

if (isset($_SESSION['user_admin'])) {
    if (isset($_POST['addpromo'])) {
        $Admin->Admin_AddPromocode($_POST);
        exit;
    } else if (isset($_POST['editid'])) {
        $Admin->Admin_EditPromocode($_POST);
        exit;
    } else if (isset($_POST['promocode_delete'])) {
        $Admin->Admin_DeletePromocode($_POST);
        exit;
    } else if (isset($_POST['create_tables'])) {
        $Admin->Admin_CreateTables();
        exit;
    }
}