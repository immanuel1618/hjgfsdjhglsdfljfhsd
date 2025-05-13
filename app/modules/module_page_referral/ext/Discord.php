<?php
namespace app\modules\module_page_referral\ext;

class Discord
{
    protected $Db, $General, $Translate, $Modules;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
    }

    public function sendDiscordWebhookRefUsed($embeds)
    {
        $settings = $this->Db->query("Core", 0, 0,
            "SELECT discord_webhook_new_ref FROM lvl_web_referrals_settings LIMIT 1"
        );

        if (empty($settings['discord_webhook_new_ref'])) {
            return;
        }

        $webhookUrl = $settings['discord_webhook_new_ref'];
        
        $data = $embeds;

        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }

    public function sendDiscordWebhookRefWithdraw($embeds)
    {
        $settings = $this->Db->query("Core", 0, 0,
            "SELECT discord_webhook_withdraw FROM lvl_web_referrals_settings LIMIT 1"
        );

        if (empty($settings['discord_webhook_withdraw'])) {
            return;
        }

        $webhookUrl = $settings['discord_webhook_withdraw'];
        
        $data = $embeds;

        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}