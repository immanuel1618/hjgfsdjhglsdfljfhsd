<?php 
use app\modules\module_page_pay\ext\Lk_module;
use app\modules\module_page_referral\ext\Referral_pays;

if (!empty($Db->db_data['lk'])) {
    if (IN_LR != true) {
        header('Location: ' . $General->arr_general['site']);
        exit;
    }

    $LK = new Lk_module($Translate, $Notifications, $General, $Modules, $Db);
    $Referral_pays = new Referral_pays($Db, $General, $Translate, $Modules, $Notifications);
    $hasPayment = $Referral_pays->hasPayment();
    $hasBouns = $Referral_pays->getBonusAmount();


    if (isset($_POST['steam'])) {
        $LK->LkOnPayment($_POST);
        exit;
    } else if (!empty($_POST['promocode']) && !empty($_POST['amount']) && !empty($_POST['steamid'])) {
        $LK->LkCalculatePromo($_POST['promocode'], $_POST['steamid'], $_POST['amount']);
        exit;
    } else if (isset($_POST['steamidload'])) {
        $LK->LkLoadPlayerProfile($_POST['steamidload']);
        exit;
    } else if (isset($_POST['referral'])) {
        $Referral_pays->addReferralUsed($_POST['referral']);
        exit;
    }
}

$referral_pays = $Referral_pays->getReferral();