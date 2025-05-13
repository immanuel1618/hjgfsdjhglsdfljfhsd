<?php

/**
 * @author Love
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_promo\ext;

class Admin
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

    public function Admin_AddPromocode($post)
    {
        if (!isset($_SESSION['user_admin']) || IN_LR != true) {
            exit;
        }
    
        if (empty($post['addpromo'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_PromoRequired'), 'error');
            return;
        } else {
            $promo = $post['addpromo'];
        }
    
        if (!preg_match('/^[\p{L}\p{Nd}._-]{3,35}$/u', $promo)) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_ErrorNamePromo'), 'error');
        } else if (empty($post['limites'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_LimitPromo'), 'error');
        } else if (!preg_match('/^[0-9\.]+$/', $post['limites'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_LimitField'), 'error');
        } else if (empty($post['rewardvalue'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_EnterBonus'), 'error');
        } else if (!preg_match('/^[0-9a-zA-Z\.]+$/', $post['rewardvalue'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_NotCorBonus'), 'error');
        } else if (empty($post['rewardtype'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_SelectRewardType'), 'error');
        } else if (empty($post['created_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Create_At_Sus'), 'error');
        } else if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $post['created_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Create_At_Field'), 'error');
        } else if (empty($post['end_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_End_At_Sus'), 'error');
        } else if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $post['end_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_End_At_Field'), 'error');
        }
    
        $created_at_timestamp = strtotime(str_replace('T', ' ', $post['created_at']));
        $end_at_timestamp = strtotime(str_replace('T', ' ', $post['end_at']));
    
        $param = ['names' => $promo];
        $expromo = $this->db->queryAll('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT names FROM lvl_web_promocodes WHERE BINARY names = :names", $param);
        
        if (!empty($expromo)) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_ExistPromo'), 'error');
        }
    
        $params = [
            'names' => $promo,
            'reward_type' => $post['rewardtype'],
            'reward_value' => $post['rewardvalue'],
            'limites' => $post['limites'],
            'created_at' => $created_at_timestamp,
            'end_at' => $end_at_timestamp,
            'creator_steamid' => $_SESSION['steamid64'],
        ];
    
        $this->db->query('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "INSERT INTO lvl_web_promocodes (names, reward_type, reward_value, limites, activates, created_at, end_at, creator_steamid) VALUES(:names, :reward_type, :reward_value, :limites, 0, :created_at, :end_at, :creator_steamid)", $params);
    
        $this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_promo', '_AddedPromo'), ['namepromo' => $promo]), 'success');
    }
    
    public function Admin_EditPromocode($post)
    {
        if (!isset($_SESSION['user_admin']) || IN_LR != true) {
            exit;
        }
    
        if (empty($post['editid'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Error'), 'error');
        } else if (!preg_match('/^\d+$/', $post['editid'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Error'), 'error');
        } else if (empty($post['editpromo'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_EditPromoName'), 'error');
        } else if (!preg_match('/^[\p{L}\p{Nd}._-]{3,35}$/u', $post['editpromo'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_ErrorNamePromo'), 'error');
        } else if (empty($post['editrewardvalue'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_EnterSum'), 'error');
        } else if (!preg_match('/^[0-9a-zA-Z\.]+$/', $post['editrewardvalue'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_NotCorSum'), 'error');
        } else if (empty($post['editrewardtype'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_SelectRewardType'), 'error');
        } else if (empty($post['editlimit'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_LimitPromo'), 'error');
        } else if (!preg_match('/^[0-9\.]+$/', $post['editlimit'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_LimitField'), 'error');
        } else if (empty($post['edit_start_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Create_At_Sus'), 'error');
        } else if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $post['edit_start_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Create_At_Field'), 'error');
        } else if (empty($post['edit_end_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_EnterDate'), 'error');
        } else if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $post['edit_end_at'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_NotDate'), 'error');
        }
    
        $start_at_timestamp = strtotime(str_replace('T', ' ', $post['edit_start_at']));
        $end_at_timestamp = strtotime(str_replace('T', ' ', $post['edit_end_at']));
    
        $param = ['id' => $post['editid']];
        $expromo = $this->db->queryAll('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT id FROM lvl_web_promocodes WHERE BINARY id = :id", $param);
        
        if (empty($expromo)) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Error'), 'error');
        }
    
        $params = [
            'id' => $post['editid'],
            'names' => $post['editpromo'],
            'reward_type' => $post['editrewardtype'],
            'reward_value' => $post['editrewardvalue'],
            'limites' => $post['editlimit'],
            'created_at' => $start_at_timestamp,
            'end_at' => $end_at_timestamp,
            'creator_steamid' => $_SESSION['steamid64'],
        ];
    
        $this->db->query('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "UPDATE lvl_web_promocodes SET names = :names, reward_type = :reward_type, reward_value = :reward_value, limites = :limites, created_at = :created_at, end_at = :end_at, creator_steamid = :creator_steamid WHERE id = :id", $params);
    
        $this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_promo', '_EditedPromo'), ['namepromo' => $post['editpromo']]), 'success');
    }

    public function Admin_DeletePromocode($post)
    {
        if (!isset($_SESSION['user_admin']) || IN_LR != true) {
            exit;
        }

        if (empty($post['promocode_delete'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Error'), 'error');
        } else if (!preg_match('/^\d+$/', $post['promocode_delete'])) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Error'), 'error');
        }

        $param = ['id' => $post['promocode_delete']];
        $expromo = $this->db->queryAll('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT * FROM lvl_web_promocodes WHERE id = :id", $param);
        
        if (empty($expromo)) {
            $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_Error'), 'error');
        }

        $this->db->query('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "DELETE FROM lvl_web_promocodes WHERE id = :id", $param);
        $this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_DeletedPromo'), 'success');
    }

    public function Admin_GetUserData($user)
    {
        if (!preg_match('/^[0-9\.]+$/', $user)) {
            return false;
        }

        $param = ['steamid64' => $user];
        return $this->db->queryAll('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT * FROM lvl_web_promocode_uses WHERE steamid64 = :steamid64", $param);
    }

    public function Admin_UsagePromo($promo, $limit = 10, $offset = 0)
    {
        if (!preg_match('/^[0-9]+$/', $promo)) {
            return false;
        }

        $param = ['promocode_id' => $promo];
        return $this->db->queryAll('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT steamid64, uses_at FROM lvl_web_promocode_uses WHERE promocode_id = :promocode_id ORDER BY uses_at DESC LIMIT :limit OFFSET :offset", array_merge($param, 
		[
			'limit' => $limit, 
			'offset' => $offset
		])
        );
    }

    public function Admin_UsagePromoCount($promo)
    {
        if (!preg_match('/^[0-9]+$/', $promo)) {
            return false;
        }

        $param = ['promocode_id' => $promo];
        return $this->db->queryColumn('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT COUNT(*) FROM lvl_web_promocode_uses WHERE promocode_id = :promocode_id", $param);
    }

    public function Admin_Promocodes()
    {
        return $this->db->queryAll('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT * FROM lvl_web_promocodes");
    }

    public function Admin_PromoCode($id)
    {
        if (!isset($_SESSION['user_admin']) || IN_LR != true) {
            exit();
        }

        $param = ['id' => $id];
        return $this->db->query('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'], "SELECT * FROM lvl_web_promocodes WHERE id = :id", $param);
    }

	public function Admin_CreateTables()
	{
		if (!isset($_SESSION['user_admin']) || IN_LR != true) {
			exit;
		}
	
		$this->db->query('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'],
			"CREATE TABLE IF NOT EXISTS `lvl_web_promocodes` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`names` varchar(35) NOT NULL,
				`reward_type` enum('cash','rev_item','flames_item') NOT NULL,
				`reward_value` varchar(255) NOT NULL,
				`limites` int(11) NOT NULL,
				`activates` int(11) NOT NULL DEFAULT 0,
				`created_at` int(11) NOT NULL,
				`end_at` int(11) NOT NULL,
				`creator_steamid` varchar(22) NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `names` (`names`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
	
		$this->db->query('Core', $this->db->db_data['Core'][0]['USER_ID'], $this->db->db_data['Core'][0]['DB_num'],
			"CREATE TABLE IF NOT EXISTS `lvl_web_promocode_uses` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`promocode_id` int(11) NOT NULL,
				`steamid64` varchar(22) NOT NULL,
				`uses_at` int(11) NOT NULL,
				PRIMARY KEY (`id`),
				KEY `promocode_id` (`promocode_id`),
				KEY `steamid64` (`steamid64`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
	
		$this->message($this->Translate->get_translate_module_phrase('module_page_promo', '_TablesCreatedSuccess'), 'success');
		
	}

    protected function message($text, $status)
    {
        exit(trim(json_encode(
            array(
                'text' => $text,
                'status' => $status,
            )
        )));
    }
}