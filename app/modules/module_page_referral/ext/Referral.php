<?php
namespace app\modules\module_page_referral\ext;
use app\modules\module_page_referral\ext\Discord;
use app\modules\module_page_referral\ext\log;

class Referral
{
    protected $Db, $General, $Translate, $Modules;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
        $this->Discord = new Discord($Db, $General, $Translate, $Modules, $Notifications);
        $this->log = new log($Db, $General, $Translate, $Modules, $Notifications);
    }

    public function getReferralPays($page = 1, $perPage = 10)
    {
        $referralData = $this->getReferral();

        if (!$referralData || !isset($referralData['id'])) {
            return ['data' => [], 'total' => 0, 'pages' => 1, 'page_num' => 1, 'page_max' => 1, 'startPag' => 1];
        }
        $referralId = $referralData['id'];
        $total = $this->Db->query("Core", 0, 0, "SELECT COUNT(*) as count FROM lvl_web_referrals_pays WHERE referral_id = :referral_id", 
        ['referral_id' => $referralId])['count'];

        $page_num = max(1, (int)$page);
        $page_max = ceil($total / $perPage);
        $startPag = max(1, min($page_num - 2, $page_max - 4));
        $offset = ($page_num - 1) * $perPage;

        $data = $this->Db->queryAll("Core", 0, 0, "SELECT * FROM lvl_web_referrals_pays WHERE referral_id = :referral_id ORDER BY date_pay DESC LIMIT :limit OFFSET :offset",
        [
            'referral_id' => $referralId,
            'limit' => $perPage,
            'offset' => $offset
        ]);

        return ['data' => $data ?: [], 'total' => $total, 'pages' => $page_max, 'page_num' => $page_num, 'page_max' => $page_max, 'startPag' => $startPag];
    }

    public function getReferral()
    {
        if (!isset($_SESSION['steamid64'])) {
            return null;
        }
        $steamId = $_SESSION['steamid64'];

        $result = $this->Db->query("Core", 0, 0, "SELECT * FROM lvl_web_referrals_users WHERE steam_id = :steam_id", 
        ['steam_id' => $steamId]);

        return $result;
    }

    public function getActivatedReferrals()
    {
        $referralData = $this->getReferral();

        if (!$referralData || !isset($referralData['id'])) {
            return 0;
        }
        $result = $this->Db->query("Core", 0, 0, "SELECT COUNT(*) as count FROM lvl_web_referrals_used WHERE referral_id = :referral_id",
        ['referral_id' => $referralData['id']]);

        return $result ? (int)$result['count'] : 0;
    }

    public function getReferralSettings()
    {
        $result = $this->Db->query("Core", 0, 0, "SELECT * FROM lvl_web_referrals_settings WHERE id = 1" );

        return $result ?: [];
    }

    public function getLevelsData()
    {
        $settings = $this->getReferralSettings();

        if (empty($settings)) {
            return [];
        }
        $levels = [];
        $maxLevel = 5;
        for ($i = 1; $i <= $maxLevel; $i++) {
            $levels[] = [
                'level' => $i,
                'requirement' => $settings["level{$i}_requirement"] ?? 0,
                'bonus' => $settings["level{$i}_bonus"] ?? 0
            ];
        }

        return $levels;
    }

    public function NewReffCode($POST)
    {
        $refcode = $POST['referral_code'];

        if (!isset($_SESSION['steamid64'])) {
            return false;
        }
        preg_match_all('/[!@#$%^&*()_+\-=\[\]{};\'"\\|,.<>\/?\s]+/', $refcode, $matches);
        if (!empty($matches[0])) {
            $invalidChars = implode(', ', array_unique($matches[0]));
            $invalidChars = str_replace(' ', 'пробел', $invalidChars);
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_InvalidReferralCodeChars', ['invalidChars' => $invalidChars])];
        }

        $existingCode = $this->Db->query("Core", 0, 0, "SELECT id FROM lvl_web_referrals_users WHERE referral = :referral",
        ['referral' => $refcode]);

        if ($existingCode) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_ReferralCodeExists')];
        }

        $steamId = $_SESSION['steamid64'];

        $this->Db->query("Core", 0, 0, "INSERT INTO lvl_web_referrals_users (steam_id, referral, lvl, money, money_all, money_all_issued) VALUES (:steam_id, :referral, 1, 0, 0, 0)",
        ['steam_id' => $steamId, 'referral' => $refcode]);

        $username = $this->General->checkName($steamId);
        $this->log->writeLog("Игрок {$username} создал новый реферальный код: {$refcode}", 'success');

        $profileUrl = 'https:' . $this->General->arr_general['site'] . 'profiles/' . $steamId;

        $embeds = ['embeds' => [
                [
                    'title' => "🎉 Новый код",
                    'description' => "**В системе зарегистрирован новый реферальный код!**",
                    'color' => 0x00FF00,
                    'timestamp' => date('c'),
                    'fields' => [
                        [
                            'name' => "Игрок",
                            'value' => "[{$username}]({$profileUrl})",
                            'inline' => true
                        ],
                        [
                            'name' => "Новый код",
                            'value' => "`{$refcode}`",
                            'inline' => true
                        ]
                    ],
                    'footer' => [
                        'text' => "Реферальная система"
                    ]
                ]
             ]
        ];

        $this->Discord->sendDiscordWebhookRefUsed($embeds);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_ReferralCodeCreated')];
    }

    public function getTodayReferralPayments()
    {
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');
        $referralData = $this->getReferral();

        if (!$referralData || !isset($referralData['id'])) {
            return 0;
        }

        $result = $this->Db->query("Core", 0, 0, "SELECT SUM(sum_proccent) as today_sum FROM lvl_web_referrals_pays WHERE referral_id = :referral_id AND date_pay BETWEEN :today_start AND :today_end",
        ['referral_id' => $referralData['id'], 'today_start' => $todayStart, 'today_end' => $todayEnd]);

        return $result ? (float)$result['today_sum'] : 0;
    }

    function processWithdrawalRequest($POST) {
        $details = $POST['details'];
        $real_withdraw_amount = $POST['real_withdraw_amount'];
        $withdrawal_output_type = $POST['withdrawal_output_type'];
        $settings = $this->getReferralSettings();
        
        if (isset($settings['withdrawal_switch_type']) && $settings['withdrawal_switch_type'] == 2) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalsDisabled')];
        }
    
        if (!preg_match('/^[0-9]+$/', $details)) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_OnlyDigitsAllowed')];
        }
    
        $minLength = 10;
        if (strlen($details) < $minLength) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_MinDigitsRequired')];
        }
    
        $referralData = $this->getReferral();
        if (!$referralData || !isset($referralData['id'])) {
            return 0;
        }
        if (!isset($withdrawal_output_type, $details, $real_withdraw_amount) || (int)$real_withdraw_amount < 0) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_RequiredFieldsMissing')];
        }
    
        $settings = $this->getReferralSettings();
        $minWithdrawalAmount = $settings['min_withdrawal_amount'] ?? 0;
        
        if ((int)$real_withdraw_amount < $minWithdrawalAmount) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_MinWithdrawalAmounts') . " {$minWithdrawalAmount} руб."];
        }
    
        $commission = $settings['commission_output'];
        $requestedAmount = (int)$real_withdraw_amount;
        $finalAmount = $requestedAmount - ($requestedAmount * $commission / 100);
        $userBalance = $this->Db->query("Core", 0, 0,"SELECT money FROM lvl_web_referrals_users WHERE id = :id",
        ['id' => $referralData['id']]);
    
        if (!$userBalance || $userBalance['money'] < $requestedAmount) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_InsufficientFunds')];
        }
    
        $this->Db->query("Core", 0, 0, "UPDATE lvl_web_referrals_users SET money = money - :requestedAmount, money_transfer_now = money_transfer_now + :finalAmount WHERE id = :id",
        ['requestedAmount' => $requestedAmount, 'finalAmount' => $finalAmount, 'id' => $referralData['id']]);
        $data = ['referral_id' => $referralData['id'], 'type' => $withdrawal_output_type, 'create_date' => time(), 'details' => $details, 'cash' => (int)$finalAmount, 'status' => 'pending'];
    
        $this->Db->query("Core", 0, 0, "INSERT INTO lvl_web_referrals_output (referral_id, type, create_date, details, cash, status) VALUES (:referral_id, :type, :create_date, :details, :cash, :status)", $data);
        $RequestId = $this->Db->lastInsertId('Core', 0, 0);
        $steamId = $_SESSION['steamid64'];
        $username = $this->General->checkName($steamId);
        $this->log->writeLog("Игрок {$username} создал новую заявку на вывод средств: {$RequestId}", 'success');
    
        $profileUrl = 'https:' . $this->General->arr_general['site'] . 'profiles/' . $steamId;
        $RoundAmount = round($finalAmount, 0);
    
        $embeds = ['embeds' => [
                [
                    'title' => "Новая заявка на вывод средств",
                    'color' => 0x00FF00,
                    'timestamp' => date('c'),
                    'fields' => [
                        [
                            'name' => "Игрок",
                            'value' => "[{$username}]({$profileUrl})",
                            'inline' => true
                        ],
                        [
                            'name' => "Сумма на вывод",
                            'value' => "`{$RoundAmount}` Руб.",
                            'inline' => true
                        ],
                        [
                            'name' => "Id заявки",
                            'value' => "`{$RequestId}`",
                            'inline' => false
                        ]
                    ],
                    'footer' => [
                        'text' => "Реферальная система"
                    ]
                ]
             ]
        ];
    
        $this->Discord->sendDiscordWebhookRefWithdraw($embeds);
    
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalRequestCreated')];
    }

    function processSiteWithdrawalRequest($POST) {
        $site_withdraw_amount = $POST['site_withdraw_amount'];

        $settings = $this->getReferralSettings();
        
        if (isset($settings['withdrawal_switch_type']) && $settings['withdrawal_switch_type'] == 1) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalsDisabled')];
        }

        $referralData = $this->getReferral();
        if (!$referralData || !isset($referralData['id'])) {
            return 0;
        }
        if (!isset($site_withdraw_amount) || (int)$site_withdraw_amount < 0) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_InvalidWithdrawalAmount')];
        }
        $settings = $this->getReferralSettings();
        $conversionRate = $settings['percentage_converting'];
        $requestedAmount = (int)$site_withdraw_amount;
        $finalAmount = $requestedAmount - ($requestedAmount * $conversionRate / 100);
        $userBalance = $this->Db->query("Core", 0, 0, "SELECT money FROM lvl_web_referrals_users WHERE id = :id",
        ['id' => $referralData['id']]);

        if (!$userBalance || $userBalance['money'] < $requestedAmount) {
            return ['status' => 'error', 'text' => 'Недостаточно средств для вывода'];
        }
        $this->Db->query("Core", 0, 0, "UPDATE lvl_web_referrals_users SET money = money - :requestedAmount, money_all_issued = money_all_issued + :finalAmount WHERE id = :id",
        ['requestedAmount' => $requestedAmount, 'finalAmount' => $finalAmount, 'id' => $referralData['id']]);
        $this->Db->query("lk", 0, 0, "UPDATE lk SET cash = cash + :finalAmount, all_cash = all_cash + :finalAmount WHERE auth = :steam_id",
        ['finalAmount' => $finalAmount, 'steam_id' => $_SESSION['steamid32']]);

        $steamId = $_SESSION['steamid64'];
        $username = $this->General->checkName($steamId);
        $RoundAmount = round($finalAmount, 0);
        $this->log->writeLog("Игрок {$username} конвертировал деньги на сайт и получил: {$RoundAmount}", 'success');

        $profileUrl = 'https:' . $this->General->arr_general['site'] . 'profiles/' . $steamId;

        $embeds = ['embeds' => [
                [
                    'title' => "Конвертация денег на сайт",
                    'description' => "**Игрок вывел деньги на сайт!**",
                    'color' => 0x00FF00,
                    'timestamp' => date('c'),
                    'fields' => [
                        [
                            'name' => "Игрок",
                            'value' => "[{$username}]({$profileUrl})",
                            'inline' => true
                        ],
                        [
                            'name' => "Списано денег с системы",
                            'value' => "`{$requestedAmount}` Руб.",
                            'inline' => true
                        ],
                        [
                            'name' => "Зачислено на сайт",
                            'value' => "`{$RoundAmount}` Руб.",
                            'inline' => false
                        ]
                    ],
                    'footer' => [
                        'text' => "Реферальная система"
                    ]
                ]
             ]
        ];

        $this->Discord->sendDiscordWebhookRefWithdraw($embeds);

        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_FundsConverted')];
    }
}
