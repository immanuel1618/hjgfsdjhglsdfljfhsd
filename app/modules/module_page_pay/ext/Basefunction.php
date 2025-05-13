<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_pay\ext;

// Импортирование глобального класса отвечающего за работу с модулями.
use app\ext\Modules;

// Импортирование основного глобального класса.
use app\ext\General;

// Импортирование глобального класса отвечающего за работу с базами данных.
use app\ext\Db;

use app\ext\Notifications;

use app\ext\Translate;

use app\ext\AltoRouter;

class Basefunction{

	public $kassa;
	public $decod;
	public $pay;
	public $summ;
	public $bonus;
	public $db;
	public $General;
	public $Modules;
	public $Notifications;
	public $Translate;
	public $Router;

	public function __construct() {
		$this->db =  new Db;
		$this->Translate = new Translate;
		$this->Notifications = new Notifications( $this->Translate, $this->db );
		$this->General = new General( $this->db );
		$this->Router = new AltoRouter;
		empty( $this->General->arr_general['site'] ) && $this->General->arr_general['site'] = '//' . preg_replace('/^(https?:)?(\/\/)?(www\.)?/', '', $_SERVER['HTTP_REFERER']);
		$this->Modules = new Modules( $this->General, $this->Translate, $this->Notifications, $this->Router );
	}

	/**
     * Фунция запроса проверяющий наличие и активности платежного шлюза.
     *
     * @param string $kassa         Навание платежного шлюза.
     * @return bool false|true      Возвращает результат проверки.
     */
	public function BChekGateway($gateway){
		$param = ['id' => $this->decod[0]];
		$this->kassa = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pay_service WHERE id = :id", $param);
		if(empty($this->kassa[0]['status'])){
			$this->LkAddLog('_Foff', ['gateway' =>$gateway]);
				return false;
		}else return true;
	}

	/**
     * Фунция запроса проверяющий наличие платежа.
     *
     * @param string $gateway         Навание платежного шлюза.
     * @return bool false|true      Возвращает результат проверки.
     */
	public function BCheckPay($gateway){
		preg_match('/:[0-9]{1}:\d+/i', $this->decod[3], $auth);
		$params = [
			'order' 	=> $this->decod[1],
			'auth'		=> '%'.$auth[0].'%',
		];
		$this->pay = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pays WHERE pay_order = :order AND pay_auth LIKE :auth AND pay_status = 0", $params);
		if(empty($this->pay)){
				$this->LkAddLog('_PayNotExist', ['course'=>$this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'),'numberpay' => $this->decod[1], 'steam'=>$this->decod[3],'amount'=>$this->decod[2],'gateway' =>$gateway]);
					return false;
		}else return true;
	}

	/**
     * Фунция запроса проверяющий наличие игрока, при отсутствии добавляет в базу.
     */
	public function BCheckPlayer(){
		preg_match('/:[0-9]{1}:\d+/i', $this->decod[3], $auth);
		$param = ['auth'=>'%'.$auth[0].'%'];
		$player = $this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk WHERE auth LIKE :auth LIMIT 1", $param);
		if(empty($player)){
			$params = [
				'auth' 		=> $this->decod[3],
				'name'		=> $this->General->checkName(con_steam32to64($this->decod[3]))
			];
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk(auth, name, cash, all_cash) VALUES (:auth,:name,0,0)", $params);
		}
	}

	/**
     * Фунция запроса проверяющий наличие промокода.
     *
     * @param string $gateway         Навание платежного шлюза.
     */
	public function BCheckPromo($gateway){
		$param = ['code' => $this->pay[0]['pay_promo']];
		$promoCode = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_promocodes WHERE code = :code",$param);
		if(empty($promoCode)){
			$this->summ = $this->decod[2];
		}
		else{
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_promocodes SET attempts = attempts - 1 WHERE code = :code",$param);
			$this->bonus = ($this->decod[2]/100)*$promoCode[0]['percent'];
			$this->summ = $this->bonus+$this->decod[2];

			$this->LkAddLog('_SetPromo',['course'=>$this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'),'numberpay' => $this->decod[1], 'promocode'=>$this->pay[0]['pay_promo'],'amount'=>$this->bonus,'gateway' =>$gateway]);
		}
	}

	/**
     * Фунция запроса отправляющего уведомление в Discord канал.
     *
     * @param string $kassa         Навание платежного шлюза.
     */
	public function BNotificationDiscord($kassa){
		$ds = $this->db->queryAll('lk', 0, 0, "SELECT `url`, `auth` FROM `lk_discord` LIMIT 1");
		$summ = $this->db->queryAll('lk', 0, 0, "SELECT `all_cash` FROM `lk` WHERE `auth` = :auth LIMIT 1", ["auth" => $this->decod[3]]);
		$summ_put = number_format($this->decod[2], 0, '.', ' ') . " " .  html_entity_decode($this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'));
		$summ_all = $summ[0]['all_cash'] . " " . html_entity_decode($this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'));
		if (!empty($ds[0]['auth'])) {
			$steam64 = con_steam32to64($this->decod[3]);
			$json = json_encode([
				"embeds" =>
				[
					[
						"title" => "Новое пополнение на сайте",
						"color"	=> hexdec("5FB36C"),
						"description" => "[Открыть логи пополнений](https:{$this->General->arr_general['site']}adminpanel/?section=logslk)",
						"author" => [
							"name" => "Открыть профиль " . $this->General->checkName($steam64) . "",
							"url" => "https:{$this->General->arr_general['site']}profiles/{$steam64}/?search=1",
							"icon_url" => $this->General->getAvatar($steam64, 1)
						],
						"image" => [
							"url" => "https:{$this->General->arr_general['site']}app/modules/module_page_pay/assets/gateways_discord/pay_image.png"
						],
						"thumbnail"	=> [
							"url" => "https:{$this->General->arr_general['site']}app/modules/module_page_pay/assets/gateways_discord/" . mb_strtolower($kassa) . ".png",
						],
						"fields" =>
						[
							[
								"name" => '💸 Сумма пополнения',
								"value" => '```' . $summ_put . '```',
								"inline" => false,
							],
							[
								"name" => '🛠️ ID платежа',
								"value" => '```' . $this->decod[1] . '```',
								"inline" => true,
							],
							[
								"name" => '💚 Всего пожертвовал',
								"value" => '```' . $summ_all . '```',
								"inline" => true,
							],
						],
						"footer"=>
						[
							"text" => "Время покупки",
						],
						"timestamp" => date("c"),
						],
				],
			]);
			$cl = curl_init($ds[0]['url']);
			curl_setopt($cl, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($cl, CURLOPT_POST, 1);
			curl_setopt($cl, CURLOPT_POSTFIELDS, $json);
			curl_exec($cl);
		}
	}

	/**
     * Фунция запроса обновления баланса игрока.
     *
     * @param string $steam         Steam ID игрока к зачислению.
     * @param int $summ        	 	Сумма пополнения.
     */
	public function BUpdateBalancePlayer($steam,$summ){
		preg_match('/:[0-9]{1}:\d+/i', $steam, $auth);

		 $params = [
				'auth' 		=> '%'.$auth[0].'%',
				'cash'		=> $this->summ,
				'all_cash'	=> $summ,
			];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk SET `cash` = `cash` + :cash, `all_cash` = `all_cash` + :all_cash WHERE auth LIKE :auth LIMIT 1", $params);
		
		$this->processReferralBonus($steam, $summ);
	}
	
	public function processReferralBonus($steam, $summ) {
		$steamAuth64 = $this->con_steam32to64($steam);
	
		$referralUsed = $this->db->query("Core", 0, 0,
			"SELECT referral_id FROM lvl_web_referrals_used WHERE steam_id = :steam LIMIT 1",
			['steam' => $steamAuth64]
		);
	
		if (empty($referralUsed)) {
			return;
		}
	
		$referralId = $referralUsed['referral_id'];
	
		$referrerInfo = $this->db->query("Core", 0, 0,
			"SELECT lvl, money_all FROM lvl_web_referrals_users WHERE id = :id LIMIT 1",
			['id' => $referralId]
		);
	
		if (empty($referrerInfo)) {
			return;
		}
	
		$referrerLvl = $referrerInfo['lvl'];
		$levelBonusColumn = "level{$referrerLvl}_bonus";
	
		$levelSettings = $this->db->query("Core", 0, 0,
			"SELECT * FROM lvl_web_referrals_settings LIMIT 1", []
		);
	
		if (empty($levelSettings)) {
			return;
		}
	
		$percent = $levelSettings[$levelBonusColumn];
	
		if ($percent <= 0) {
			return;
		}
	
		$referralSum = round(($summ * $percent) / 100);
		$currentDateTime = date('Y-m-d H:i:s');
	
		$this->db->query("Core", 0, 0,"UPDATE lvl_web_referrals_users SET `money` = `money` + :money, `money_all` = `money_all` + :money_all WHERE id = :id LIMIT 1",
			['id' => $referralId, 'money' => $referralSum, 'money_all' => $referralSum]
		);
	
		$newMoneyAll = $referrerInfo['money_all'] + $referralSum;
		$newLevel = $referrerLvl;
		
		if ($newMoneyAll >= $levelSettings['level5_requirement']) {
			$newLevel = 5;
		} elseif ($newMoneyAll >= $levelSettings['level4_requirement']) {
			$newLevel = 4;
		} elseif ($newMoneyAll >= $levelSettings['level3_requirement']) {
			$newLevel = 3;
		} elseif ($newMoneyAll >= $levelSettings['level2_requirement']) {
			$newLevel = 2;
		}
		
		if ($newLevel > $referrerLvl) {
			$this->db->query("Core", 0, 0,"UPDATE lvl_web_referrals_users SET lvl = :lvl WHERE id = :id LIMIT 1",
			['id' => $referralId, 'lvl' => $newLevel]);
		}
		$this->checkFirstDepositBonus($steam, $summ);
	
		$this->db->query("Core", 0, 0,"INSERT INTO lvl_web_referrals_pays (referral_id, steam_id, date_pay, sum, proccent, sum_proccent) VALUES (:referral_id, :steam_id, :date_pay, :sum, :proccent, :sum_proccent)",
			['referral_id' => $referralId, 'steam_id' => $steamAuth64, 'date_pay' => $currentDateTime, 'sum' => $summ, 'proccent' => $percent,'sum_proccent' => $referralSum]
		);

	}

    protected function checkFirstDepositBonus($steam, $summ)
    {
        $steam64 = $this->con_steam32to64($steam);
        
        $referralUsed = $this->db->query("Core", 0, 0,"SELECT COUNT(*) as count FROM lvl_web_referrals_used WHERE steam_id = :steam",
            ['steam' => $steam64]
        );
        
        if (empty($referralUsed) || $referralUsed['count'] == 0) {
            return;
        }
        
        $paymentExists = $this->db->query("Core", 0, 0,"SELECT COUNT(*) as count FROM lvl_web_referrals_pays WHERE steam_id = :steam",
            ['steam' => $steam64]
        );
        
        if (!empty($paymentExists) && $paymentExists['count'] > 0) {
            return;
        }
        
        $settings = $this->db->query("Core", 0, 0,"SELECT first_deposit_bonus, first_deposit_amount FROM lvl_web_referrals_settings LIMIT 1"
        );
        
        if (empty($settings)) {
            return;
        }
        
        if ($summ < $settings['first_deposit_amount']) {
            return;
        }
        
        $this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'],"UPDATE lk SET cash = cash + :bonus WHERE auth = :steam LIMIT 1",
            ['steam' => $steam, 'bonus' => $settings['first_deposit_bonus']]
        );
    }
	
	public function con_steam32to64($id) {
		if ($id[0] == 'S') {
			$arr = explode(":", $id);
			if (!empty($arr[2])) {
				return bcadd(bcmul((int)$arr[2], 2), bcadd((int)$arr[1], '76561197960265728'), 0);
			}
		} else {
			return is_numeric($id) ? $id : false;
		}
	}

	/**
     * Фунция запроса обновления статуса платежа.
     */
	public function BUpdatePay(){
		 $params = [
				'auth' 		=> $this->decod[3],
				'summ' 		=> $this->decod[2],
				'order'		=> $this->decod[1],
			];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_pays SET `pay_status` = 1, `pay_summ` = :summ WHERE pay_auth = :auth AND pay_order = :order LIMIT 1", $params);
	}
	
	/**
     * Фунция декодирования хеша.
     *
     * @param string $string        Хеш кодировки base64.
     * @param int $summ        	 	Сумма пополнения.
     * @return sting                Возвращает результат декодирования.
     */
	public function Decoder($string){
			$decod = base64_decode(base64_decode($string));
			return $decod;
	}

	/**
     * Фунция записи лога в базу данных.
     *
     * @param string $act        Содержание лога.
     */
	public function LkAddLog($act, $log_value = []){
			$params = [
			'log_name' 		=> date('d_m_Y'),
			'log_value' 	=> json_encode($log_value),//Формируем Json
			'log_time'		=> date('_H:i:s: '),
			'log_content'	=> $act
		];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk_logs(log_name, log_value, log_time, log_content) VALUES (:log_name,:log_value,:log_time,:log_content)",$params);
	}
}
