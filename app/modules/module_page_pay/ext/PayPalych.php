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

use app\modules\module_page_pay\ext\Basefunction;

class PayPalych extends Basefunction{

	public function PPCheckIP(){
		if(!in_array($this->getIP(), array('138.201.53.39', '176.9.155.22', '2.58.70.63', '213.136.76.226', '213.136.84.70'))){
				$this->LkAddLog('_DeniedIP', ['gateway' =>'PayPalych', 'ip'=>$this->getIP()]);
				die('Request from Denied IP');
		}
	}

	public function PPCheckSignature($post){
		$us = $this->Decoder($post['custom']);
		$this->decod = explode(',', $us);
		$BChekGateway = $this->BChekGateway('PayPalych');
		if(empty($BChekGateway))
			die('Gatewqy Freekassa not Exist.');
		$sign = strtoupper(md5($post['OutSum'] . ":" . $post['InvId'] . ":" . $this->kassa[0]['secret_key_2']));
		if($sign != $post['SignatureValue']){
			$this->LkAddLog('_NOTSIGN', ['gateway'=>'PayPalych']);
			die('Invalid digital signature.');
		}
}

	public function PPProcessPay($post){
		$BCheckPay = $this->BCheckPay('PayPalych');
		if(empty($BCheckPay))die('Pay not found');
		if($post['Status'] != "SUCCESS"){
			$this->LkAddLog('_NOTSIGN', ['gateway'=>'PayPalych']);
			die('Invalid digital signature.');
		}
		if($this->decod[2] != $post['BalanceAmount']){
			$this->LkAddLog('_NoValidSumm', ['gateway'=>'PayPalych','amount' => $this->decod[2].'/'.$post['BalanceAmount']]);
			die("Amount does't match");
		}

		$this->BCheckPlayer();
		$this->BCheckPromo('PayPalych');
		$this->BUpdateBalancePlayer($this->decod[3], $post['BalanceAmount']);
		$this->BUpdatePay();
		$this->BNotificationDiscord('PayPalych');
		$this->LkAddLog('_NewDonat', ['gateway'=>'PayPalych','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_pay','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
		$admins = $this->db->queryAll( 'Core', 0, 0, "SELECT * FROM lvl_web_admins WHERE flags = 'z' ");
		foreach( $admins as $key ){
			$this->Notifications->SendNotification(
				$key['steamid'],
				'_LK',
				'_GetDonat',
				['amount' => $this->decod[2], 'course' => $this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'), 'module_translation' => 'module_page_pay'],
				$this->General->arr_general['site'] . 'pay/?section=payments#p'.$this->decod[1],
				'pay',
				'_Go'
			);
		}
		$this->Notifications->SendNotification(
			$this->decod[3], 
			'_LK',
			'_YouPay',
			['amount' => $this->decod[2], 'course' => $this->Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'), 'module_translation' => 'module_page_pay'],
			$this->General->arr_general['site'] . 'pay/?section=payments#p'.$this->decod[1],
			'pay',
			'_Go'
		);
		die('YES');
	}

	protected function getIP(){
			//if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
			return $this->General->get_client_ip_cdn();
	}
}