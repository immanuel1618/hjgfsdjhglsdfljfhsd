<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */

use app\modules\module_page_pay\ext\AnyPay;
use app\modules\module_page_pay\ext\Aaio;
use app\modules\module_page_pay\ext\PayPalych;
use app\modules\module_page_pay\ext\Freekassa;
use app\modules\module_page_pay\ext\Webmoney;
use app\modules\module_page_pay\ext\YooMoney;
use app\modules\module_page_pay\ext\Cshost;
use app\modules\module_page_pay\ext\SkinPay;
use app\modules\module_page_pay\ext\Paypal;

if( IN_LR != true ){ die( 'Hacking detected' ); }

switch ($_GET['gateway']){
	case 'freekassa':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Freekassa = new Freekassa;
		$Freekassa->FKCheckIP();
		$Freekassa->FKCheckSignature($_POST);
		$Freekassa->FKProcessPay($_POST);
	break;
	case 'paypalych':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$PayPalych = new PayPalych;
		$PayPalych->PPCheckIP();
		$PayPalych->PPCheckSignature($_POST);
		$PayPalych->PPProcessPay($_POST);
	break;
	case 'webmoney':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Webmoney = new Webmoney;
		$Webmoney->WBCheckPurse( $_POST );
		$Webmoney->WBCheckSignature( $_POST );
		$Webmoney->WBProcessPay( $_POST );
	break;
	case 'yoomoney':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Yandexmoney = new YooMoney;
		$Yandexmoney->YMCheckSignature( $_POST );
		$Yandexmoney->YMProcessPay( $_POST );
	break;
	case 'anypay':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$AnyPay = new AnyPay;
		$AnyPay->APCheckIP();
		$AnyPay->APCheckSignature($_POST);
		$AnyPay->APProcessPay($_POST);
	break;
	case 'cshost':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Cshost = new Cshost;
		$Cshost->CshostCheckSignature($_POST);
		$Cshost->CshostProcessPay($_POST);
	break;
	case 'skinpay':
		if (empty($_POST)) die('Hacking detected');
		$SkinPay = new SkinPay;
		$SkinPay->SPCheckSignature($_POST);
		$SkinPay->SPProcessPay($_POST);
	break;
	case 'aaio':
		if (empty($_POST)) die('Hacking detected');
		$Aaio = new Aaio;
		$Aaio->AACheckSignature($_POST);
		$Aaio->AAProcessPay($_POST);
	break;
	case 'paypal':
		if(empty($_POST)) die('Hacking detected');
		$Paypal = new Paypal;
		$Paypal->PPProcessPay($_POST);
	break;
	default:
		die( 'Hacking detected' );
}