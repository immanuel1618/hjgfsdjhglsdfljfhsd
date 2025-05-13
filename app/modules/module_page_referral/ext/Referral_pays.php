<?php
namespace app\modules\module_page_referral\ext;
use app\modules\module_page_referral\ext\Discord;
use app\modules\module_page_referral\ext\log;

class Referral_pays
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

    public function getReferral()
    {
        if (empty($_SESSION['steamid64'])) {
            return [];
        }
        $steamId = $_SESSION['steamid64'];
        
        $referralUsed = $this->Db->query("Core", 0, 0, "SELECT referral_id FROM lvl_web_referrals_used WHERE steam_id = :steam_id",
        ['steam_id' => $steamId]);
        
        if (empty($referralUsed)) {
            return [];
        }
        $referralUser = $this->Db->query("Core", 0, 0,"SELECT referral FROM lvl_web_referrals_users WHERE id = :id",
        ['id' => $referralUsed['referral_id']]);
        
        return $referralUser ?: [];
    }
	
    public function addReferralUsed($referral)
    {
        $steamId = $_SESSION['steamid64'];
        $referralUser = $this->Db->query("Core", 0, 0,"SELECT id, steam_id FROM lvl_web_referrals_users WHERE referral = :referral",
        ['referral' => $referral]);
        
        if (empty($referralUser)) {
            $this->message('Реферальный код не найден', 'error');
        }
        
        if ($referralUser['steam_id'] == $steamId) {
            $this->message('Вы не можете активировать свой собственный реферальный код', 'error');
        }
        
        $referralId = $referralUser['id'];
        
        $existingRecord = $this->Db->query("Core", 0, 0,"SELECT id FROM lvl_web_referrals_used WHERE steam_id = :steam_id AND referral_id = :referral_id",
        ['steam_id' => $steamId, 'referral_id' => $referralId]);
        if (!empty($existingRecord)) {
            $this->message('Вы уже использовали этот реферальный код', 'error');
        }
    
        $this->Db->query("Core", 0, 0,"INSERT INTO lvl_web_referrals_used (steam_id, referral_id) VALUES (:steam_id, :referral_id)",
        ['steam_id' => $steamId, 'referral_id' => $referralId]);
    
        $username = $this->General->checkName($steamId);
        $profileUrl = 'https:' . $this->General->arr_general['site'] . 'profiles/' . $steamId;
    
        $embeds = ['embeds' => [
                [
                    'title' => "🎉 Реферальный код",
                    'description' => "**В системе зарегистрировано использование реферального кода!**",
                    'color' => 0x00FF00,
                    'timestamp' => date('c'),
                    'fields' => [
                        [
                            'name' => "Игрок",
                            'value' => "[{$username}]({$profileUrl})",
                            'inline' => true
                        ],
                        [
                            'name' => "Использованный код",
                            'value' => "`{$referral}`",
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
        $this->log->writeLog("Игрок {$username} успешно применил реферальный код: {$referral}", 'success');
    
        $this->message('Реферальный код успешно применен', 'success');
    }


    public function hasPayment()
    {
        if (empty($_SESSION['steamid64'])) {
            return 0;
        }
        $steamId = $_SESSION['steamid64'];

        $referralUsed = $this->Db->query("Core", 0, 0,"SELECT COUNT(*) as count FROM lvl_web_referrals_used WHERE steam_id = :steam_id",
        ['steam_id' => $steamId]);
        if (empty($referralUsed) || $referralUsed['count'] == 0) {
            return 0;
        }

        $payment = $this->Db->query("Core", 0, 0,"SELECT COUNT(*) as count FROM lvl_web_referrals_pays WHERE steam_id = :steam_id",
        ['steam_id' => $steamId]);
        
        return (empty($payment) || $payment['count'] == 0) ? 1 : 0;
    }

    public function getBonusAmount()
    {
        $settings = $this->Db->query("Core", 0, 0,"SELECT first_deposit_bonus, first_deposit_amount FROM lvl_web_referrals_settings LIMIT 1");
        
        return $settings ?: ['first_deposit_bonus' => 0, 'first_deposit_amount' => 0];
    }

    protected function message($text, $status)
    {
        exit(json_encode([
            'text' => $text,
            'status' => $status
        ]));
    }
}
