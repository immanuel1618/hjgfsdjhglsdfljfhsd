<?php

/**
 * @author Love
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_promo\ext;

class Promo
{
    public $name;
    public $Modules;
    public $General;
    public $Db;
    public $Notifications;
    public $Translate;

    public function __construct($Translate, $Notifications, $General, $Modules, $Db)
    {
        $this->Modules = $Modules;
        $this->Translate = $Translate;
        $this->General = $General;
        $this->db = $Db;
        $this->Notifications = $Notifications;
    }

    public function Promo_ActivatePromocode($post)
    {
        if (empty($_SESSION['steamid64'])) {
            $this->message($this->Translate->get_translate_phrase('_NotAuthorization'), 'error');
        }

        $promoCode = $post['promo_name'];
        $steamId64 = $_SESSION['steamid64']; 
        $steamId32 = $_SESSION['steamid32']; 
    
        if (empty($promoCode) || !preg_match('/^[\p{L}\p{Nd}._-]{3,35}$/u', $promoCode)) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_InvalidPromoCode'), 'error');
        }
    
        $promo = $this->db->query("Core", 0, 0, "SELECT * FROM `lvl_web_promocodes` WHERE BINARY `names` = :names", 
            [
                'names' => $promoCode
            ]);
    
        if (!$promo) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_InvalidPromoCode'), 'error');
        }
        if ($promo['created_at'] > time()) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_PromoNotAvailableYet'), 'error');
        } elseif ($promo['end_at'] < time()) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_PromoExpired'), 'error');
        } elseif ($promo['limites'] != -1 && $promo['activates'] >= $promo['limites']) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_PromoLimitReached'), 'error');
        }
        
        $checkUsage = $this->db->query("Core", 0, 0, "SELECT * FROM `lvl_web_promocode_uses` WHERE `steamid64` = :steamid64 AND `promocode_id` = :promocode_id", 
            [
                'steamid64' => $steamId64,
                'promocode_id' => $promo['id']
            ]);
        
        if ($checkUsage) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_PromoAlreadyActivated'), 'error');
        }
        
        $rewardMessage = '';
        switch ($promo['reward_type']) {
            case 'cash':
                $this->giveCashReward($steamId32, $steamId64, $promo['reward_value']);
                $rewardMessage = $this->Translate->get_translate_module_phrase('module_page_promo', '_YouSuccessfullyReceived') . ' ' . $promo['reward_value'] . ' ' . $this->Translate->get_translate_module_phrase('module_page_promo', '_Wallet');
                break;
                
            case 'rev_item':
                $this->giveRevItem($steamId32, $promo['reward_value']);
                $rewardMessage = $this->Translate->get_translate_module_phrase('module_page_promo', '_YouSuccessfullyReceivedItem');
                break;
                
            case 'flames_item':
                $this->giveFlamesItem($steamId64, $promo['reward_value']);
                $rewardMessage = $this->Translate->get_translate_module_phrase('module_page_promo', '_YouSuccessfullyReceivedItem');
                break;
                
            default:
                $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_UnknownRewardType'), 'error');
                break;
        }
        
        if ($promo['limites'] != -1) {
            $this->db->query("Core", 0, 0, "UPDATE `lvl_web_promocodes` SET `activates` = `activates` + 1 WHERE `id` = :id", 
            [
                'id' => $promo['id']
            ]);
        }
        
        $this->db->query("Core", 0, 0, "INSERT INTO `lvl_web_promocode_uses` (`steamid64`, `promocode_id`, `uses_at`) VALUES (:steamid64, :promocode_id, :uses_at)", 
            [
                'steamid64' => $steamId64,
                'promocode_id' => $promo['id'],
                'uses_at' => time()
            ]);
    
        $this->message($rewardMessage, 'success');
    }

    private function giveCashReward($steamId32, $steamId64, $amount)
    {
        $name = $this->General->checkName($steamId64);
        $user = $this->db->query("lk", 0, 0, "SELECT * FROM `lk` WHERE `auth` = :auth", 
            [
                'auth' => $steamId32
            ]);

        if ($user) {
            $this->db->query("lk", 0, 0, "UPDATE `lk` SET `cash` = `cash` + :sum WHERE `auth` = :auth", 
                [
                    'sum' => $amount,
                    'auth' => $steamId32
                ]);
        } else {
            $this->db->query("lk", 0, 0, "INSERT INTO `lk` (`auth`, `name`, `cash`, `all_cash`) VALUES (:auth, :name, :cash, 0)", 
                [
                    'auth' => $steamId32,
                    'name' => $name, 
                    'cash' => $amount 
                ]);
        }
    }

    private function giveRevItem($steamId32, $itemId)
    {
        $itemData = $this->db->query("Core", 0, 0, "SELECT `id`, `subject_name`, `subject_desc`, `subject_class`, `subject_img`, `subject_sale` FROM `cases_subjects` WHERE `id` = :item_id",
            [
                'item_id' => $itemId
            ]);
        
        if (!$itemData) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_ItemNotFound'), 'error');
        }
        
        $this->db->query("Core", 0, 0, "INSERT INTO `cases_wins` (`subject_id`, `subject_name`, `subject_desc`, `subject_style`, `subject_img`, `steam_id`, `sale`, `up`, `sell`) VALUES (:subject_id, :subject_name, :subject_desc, :subject_style, :subject_img, :steam_id, :sale, 0, 0)",
            [
                'subject_id' => $itemData['id'],
                'subject_name' => $itemData['subject_name'],
                'subject_desc' => $itemData['subject_desc'],
                'subject_style' => $itemData['subject_class'],
                'subject_img' => $itemData['subject_img'],
                'sale' => $itemData['subject_sale'],
                'steam_id' => $steamId32
            ]);
    }

    private function giveFlamesItem($steamId64, $itemId)
    {
        $this->db->query("Core", 0, 0, "INSERT INTO `lvl_web_inventory` (`steam`, `item_id`, `gived`, `case_id`, `server`) VALUES (:steam, :item_id, 'NONE', NULL, NULL)", 
            [
                'steam' => $steamId64,
                'item_id' => $itemId
            ]);
    }

    protected function message($text, $status)
    {
        exit(json_encode([
            'text' => $text,
            'status' => $status
        ]));
    }
}