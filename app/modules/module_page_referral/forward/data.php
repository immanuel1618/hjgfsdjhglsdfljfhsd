<?php
use app\modules\module_page_referral\ext\Referral;
use app\modules\module_page_referral\ext\Settings;
use app\modules\module_page_referral\ext\Request;

if(!isset($_SESSION['steamid'])) 
{
    get_iframe("404", "Авторизуйтесь, чтобы использовать реферальную систему!");
}


$Router->map('GET|POST', 'referral/[:page]/[:id]', 'referral');
$Router->map('GET|POST', 'referral/[:page]/', 'referral');
$Map = $Router->match();
$page = $Map['params']['page'] ?? 'referral';

$Referral = new Referral($Db, $General, $Translate, $Modules, $Notifications);
$Settings = new Settings($Db, $General, $Translate, $Modules, $Notifications);
$Request = new Request($Db, $General, $Translate, $Modules, $Notifications);

switch($page){
    case 'settings':
        if(isset($_SESSION['user_admin'])){
        $settingsAdmin = $Settings->getReferralSettingsAdmin();
        $tablesExist = $Settings->checkTablesExist();
        } else {
            get_iframe("P4", "Кажется, эта страница не доступна") && die();
        }
    break;
    case 'request':
        if(isset($_SESSION['user_admin'])){
            $currentPage = isset($_GET['num']) ? max(1, (int)$_GET['num']) : 1;
            $perPage = 10;
            $requestData = $Request->getReferralOutput($currentPage, $perPage);
            $request = $requestData['data'];
            $requestTotal = $requestData['total'];
            $page_num = $requestData['page_num'];
            $page_max = $requestData['page_max'];
            $startPag = max(1, $page_num - 2);
            $endPag = min($page_max, $page_num + 2);
            } else {
                get_iframe("P4", "Кажется, эта страница не доступна") && die();
            }
    break;
    case 'referral':
        $referral = $Referral->getReferral();
        $activatedReferralsCount = $Referral->getActivatedReferrals();
        $referralSettings = $Referral->getReferralSettings();
        $levels = $Referral->getLevelsData();
        $currentPage = isset($_GET['num']) ? max(1, (int)$_GET['num']) : 1;
        $perPage = 5;
        $referralPaysData = $Referral->getReferralPays($currentPage, $perPage);
        $referralPays = $referralPaysData['data'];
        $referralPaysTotal = $referralPaysData['total'];
        $page_num = $referralPaysData['page_num'];
        $page_max = $referralPaysData['page_max'];
        $startPag = $referralPaysData['startPag'];
        
        $todayPayments = $Referral->getTodayReferralPayments();
    break;
    default:
        get_iframe("P4", "Кажется, эта страница не доступна") && die();
    break;
}

//referral
if (isset($_POST['ref'])) {
    exit(json_encode($Referral->NewReffCode($_POST), true));
} elseif (isset($_POST['real-withdrawal-form'])) {
    exit(json_encode($Referral->processWithdrawalRequest($_POST), true));
} elseif (isset($_POST['site-withdrawal-form'])) {
    exit(json_encode($Referral->processSiteWithdrawalRequest ($_POST), true));
}

if(isset($_SESSION['user_admin'])){
    if (isset($_POST['referral_settings_form'])) {
        exit(json_encode($Settings->updateReferralSettings($_POST), true));
    } elseif (isset($_POST['referral_settings_lvl_form'])) {
        exit(json_encode($Settings->updateLevelSettings($_POST), true));
    } elseif (isset($_POST['get_request_data'])) {
        exit(json_encode($Request->getReferralInfo($_POST), true));
    } elseif (isset($_POST['action'])) {
        exit(json_encode($Request->updateRequestStatus($_POST), true));
    } elseif (isset($_POST['ref_request_delete_btn'])) {
        exit(json_encode($Request->DeleteRequest($_POST), true));
    } elseif (isset($_POST['ref_create_table'])) {
        exit(json_encode($Settings->referralCreateTable($_POST), true));
    }
}

$Modules->set_page_title("{$Translate->get_translate_module_phrase('module_page_referral', '_RefPageName')} | {$General->arr_general['short_name']}");