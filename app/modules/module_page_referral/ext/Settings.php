<?php
namespace app\modules\module_page_referral\ext;

class Settings
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

    public function checkTablesExist()
    {
        $tables = [
            'lvl_web_referrals_settings',
            'lvl_web_referrals_users',
            'lvl_web_referrals_output',
            'lvl_web_referrals_pays',
            'lvl_web_referrals_used'
        ];
        
        foreach ($tables as $table) {
            $result = $this->Db->query("Core", 0, 0, "SHOW TABLES LIKE '$table'");
            if (!$result) {
                return false;
            }
        }
        
        return true;
    }

    public function referralCreateTable()
    {
        $this->Db->query("Core", 0, 0, "CREATE TABLE IF NOT EXISTS `lvl_web_referrals_settings` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `min_withdrawal_amount` int(11) NOT NULL DEFAULT 100,
            `first_deposit_bonus` int(11) NOT NULL DEFAULT 10,
            `first_deposit_amount` int(11) NOT NULL DEFAULT 500,
            `available_withdrawal_types` varchar(255) NOT NULL DEFAULT 'СПБ,Карта',
            `withdrawal_switch_type` tinyint(4) NOT NULL DEFAULT 0,
            `percentage_converting` int(11) NOT NULL DEFAULT 1,
            `commission_output` int(11) NOT NULL DEFAULT 5,
            `level1_requirement` int(11) DEFAULT NULL,
            `level1_bonus` int(11) NOT NULL DEFAULT 0,
            `level2_requirement` int(11) DEFAULT NULL,
            `level2_bonus` int(11) DEFAULT NULL,
            `level3_requirement` int(11) DEFAULT NULL,
            `level3_bonus` int(11) DEFAULT NULL,
            `level4_requirement` int(11) DEFAULT NULL,
            `level4_bonus` int(11) DEFAULT NULL,
            `level5_requirement` int(11) DEFAULT NULL,
            `level5_bonus` int(11) DEFAULT NULL,
            `discord_webhook_new_ref` varchar(255) DEFAULT NULL,
            `discord_webhook_withdraw` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
        $this->Db->query("Core", 0, 0, "CREATE TABLE IF NOT EXISTS `lvl_web_referrals_users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `steam_id` bigint(20) NOT NULL,
            `referral` varchar(255) DEFAULT NULL,
            `lvl` int(11) DEFAULT '0',
            `money` int(11) DEFAULT '0',
            `money_all` int(11) DEFAULT '0',
            `money_all_issued` int(11) DEFAULT '0',
            `money_transfer_now` int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            UNIQUE KEY `steam_id` (`steam_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
        $this->Db->query("Core", 0, 0, "CREATE TABLE IF NOT EXISTS `lvl_web_referrals_output` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `referral_id` int(11) NOT NULL,
            `type` text NOT NULL,
            `create_date` int(11) NOT NULL DEFAULT '0',
            `details` text NOT NULL,
            `cash` int(6) NOT NULL,
            `reason` text NOT NULL,
            `status` enum('pending','accepted','declined') NOT NULL DEFAULT 'pending',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
        $this->Db->query("Core", 0, 0, "CREATE TABLE IF NOT EXISTS `lvl_web_referrals_pays` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `referral_id` int(11) NOT NULL,
            `steam_id` bigint(23) NOT NULL,
            `date_pay` datetime NOT NULL,
            `sum` int(11) NOT NULL,
            `proccent` int(11) NOT NULL,
            `sum_proccent` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
        $this->Db->query("Core", 0, 0, "CREATE TABLE IF NOT EXISTS `lvl_web_referrals_used` (
            `referral_id` int(11) NOT NULL,
            `steam_id` bigint(20) NOT NULL,
            PRIMARY KEY (`referral_id`,`steam_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
        $this->Db->query("Core", 0, 0, "ALTER TABLE `lvl_web_referrals_used` 
            ADD CONSTRAINT `fk_referral_id` FOREIGN KEY (`referral_id`) 
            REFERENCES `lvl_web_referrals_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    
        $settings = $this->Db->query("Core", 0, 0, "SELECT * FROM lvl_web_referrals_settings WHERE id = 1");
        if (!$settings) {
            $this->Db->query("Core", 0, 0, "INSERT INTO lvl_web_referrals_settings 
                (`id`, `min_withdrawal_amount`, `first_deposit_bonus`, `first_deposit_amount`, 
                `available_withdrawal_types`, `withdrawal_switch_type`, `percentage_converting`, 
                `commission_output`) 
                VALUES 
                (1, 100, 10, 500, 'СПБ,Карта', 0, 1, 5)");
        }
    
        return ['status' => 'success', 'text' => 'Таблицы реферальной системы успешно созданы и настроены'];
    }


    public function getReferralSettingsAdmin()
    {
        $result = $this->Db->query("Core", 0, 0, "SELECT * FROM lvl_web_referrals_settings WHERE id = 1");

        return $result ?: [];
    }

    public function updateReferralSettings($postData)
    {
        if (empty($postData['available_withdrawal_types'])) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalTypesNotSpecified')];
        }

        $withdrawalTypes = is_array($postData['available_withdrawal_types']) ? implode(',', array_map('trim', $postData['available_withdrawal_types'])) : $postData['available_withdrawal_types'];
        $params = [
            'min_withdrawal_amount' => (int)$postData['min_withdrawal_amount'],
            'first_deposit_bonus' => (int)$postData['first_deposit_bonus'],
            'first_deposit_amount' => (int)$postData['first_deposit_amount'],
            'available_withdrawal_types' => $withdrawalTypes,
            'withdrawal_switch_type' => (int)$postData['withdrawal_switch_type'],
            'percentage_converting' => (int)$postData['percentage_converting'],
            'commission_output' => (int)$postData['commission_output'],
            'discord_webhook_new_ref' => $postData['discord_webhook_new_ref'],
            'discord_webhook_withdraw' => $postData['discord_webhook_withdraw']
        ];
    
        $this->Db->query("Core", 0, 0, "UPDATE lvl_web_referrals_settings SET min_withdrawal_amount = :min_withdrawal_amount, first_deposit_bonus = :first_deposit_bonus, first_deposit_amount = :first_deposit_amount, available_withdrawal_types = :available_withdrawal_types, withdrawal_switch_type = :withdrawal_switch_type, percentage_converting = :percentage_converting, commission_output = :commission_output, discord_webhook_new_ref = :discord_webhook_new_ref, discord_webhook_withdraw = :discord_webhook_withdraw WHERE id = 1", $params);
        
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_SettingsUpdatedSuccessfully')];
    }
    
    public function updateLevelSettings($postData)
    {
        $requiredFields = [
            'level1_requirement', 'level1_bonus',
            'level2_requirement', 'level2_bonus',
            'level3_requirement', 'level3_bonus',
            'level4_requirement', 'level4_bonus',
            'level5_requirement', 'level5_bonus'
        ];
        foreach ($requiredFields as $field) {
            if (!isset($postData[$field])) {
                return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_NotAllLevelFieldsFilled')];
            }
        }
        $params = [
            'level1_requirement' => (int)$postData['level1_requirement'],
            'level1_bonus' => (int)$postData['level1_bonus'],
            'level2_requirement' => (int)$postData['level2_requirement'],
            'level2_bonus' => (int)$postData['level2_bonus'],
            'level3_requirement' => (int)$postData['level3_requirement'],
            'level3_bonus' => (int)$postData['level3_bonus'],
            'level4_requirement' => (int)$postData['level4_requirement'],
            'level4_bonus' => (int)$postData['level4_bonus'],
            'level5_requirement' => (int)$postData['level5_requirement'],
            'level5_bonus' => (int)$postData['level5_bonus']
        ];
        $this->Db->query("Core", 0, 0, "UPDATE lvl_web_referrals_settings SET level1_requirement = :level1_requirement, level1_bonus = :level1_bonus, level2_requirement = :level2_requirement, level2_bonus = :level2_bonus, level3_requirement = :level3_requirement, level3_bonus = :level3_bonus, level4_requirement = :level4_requirement, level4_bonus = :level4_bonus, level5_requirement = :level5_requirement, level5_bonus = :level5_bonus WHERE id = 1", $params);
        
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_LevelSettingsUpdatedSuccessfully')];
    }
}