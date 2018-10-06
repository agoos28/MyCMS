<?php
/**
* @version 			1.9.0
* @author       	http://www.seblod.com
* @copyright		Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
* @package			SEBLOD 1.x (CCK for Joomla!)
**/

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
require_once(dirname(__FILE__) .DS. 'Veritrans.php');
require_once(dirname(__FILE__) .DS. 'rajaongkir.php');

/**
 * Article		Model Class
 **/
class CCKjSeblodModelCart extends JModel
{
	/**
	 * Vars
	 **/
	var $_data		=	null;
	var $_request	=	null;
	var $_errors	=	array();
	
	var $_tr_data = null;
	var $transaction = null;
	var $tr_total = null;
	var $pageNav = null;
	var $_total = null;
	
	var $_VTis3ds = true;
	
	/*var $_VTlive = false;
	var $_VTclientKey = 'VT-client-eJRpQ9CO4wXIkW9h';
	var $_VTserverKey = 'VT-server-Eo2UAbMCIvSTOm08pB0KyYeX';*/
	
	var $_VTlive = true;//liveurl
	var $_VTclientKey = 'VT-client-m-pM368AdSuUZkN2';
  var $_VTserverKey = 'VT-server-kN5KQplkvm2Tta1DBIjP6mUV';//livekey
	
	
	//var $_admin_email = 'agus_riyanto_28@yahoo.com';
	var $_admin_email = 'order@toiss.id';
	
	
	/**
	 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		global $mainframe;
		$this->_request		=	(object)JRequest::get('default');
		$this->_data->user	=&	JFactory::getUser();
		
		if($this->_request->task == 'checkExpired'){
			$this->checkExpired();
		}
		if($this->_request->task == 'bookingReminder'){
			$this->bookingReminder();
		}
		if($this->_request->task == 'blastNewSite'){
			$this->blastNewSite();
		}
		
		if($this->_request->addcart){
			$cid = $this->_request->addcart;
			if(!$this->_request->count){
				$this->_request->count = 1;
			}

			if($this->_request->deliver){
				$availability = $this->checkAvailability($cid, $option, $this->_request->deliver);
				if($availability->error){
					if($this->_request->useajax){
						echo $availability->error;die();exit();
					}
					return;
				}
			}
			$this->addCart($cid);
			if($this->_request->useajax){
				echo 'success';die();exit();
			}
		}
		if($this->_request->updatecart){
			//$cid = $this->_request->updatecart;
			//$qty = $this->_request->qty;
			//return $this->updateQty($this->_request->prodcount);
		}
		if($this->_request->del){
			$cid = $this->_request->del;
			//print_r($this->delCartItem($cid));
			$this->delCartItem($cid);
			if($this->_request->useajax){
				echo 'success';die();exit();
			}
		}
		if($this->_request->task == 'checkout'){
			if(!$this->saveorder()){
				return false;
			}
		}
		if($this->_request->task == 'check' || $this->_request->status_code > 0){
			if(!$this->_request->order_id){
				$mainframe->redirect(JURI::base(), 'Missing Parameter!!', 'error');
				return false;
			}else{
				$this->checkVeritrans($this->_request->order_id);
				return false;
			}
		}
		if($this->_request->task == 'vtweb'){
			if(!$this->_request->orderid){
				$mainframe->redirect(JURI::base(), 'Missing Parameter!!', 'error');
				return false;
			}
			$orderid = base64_decode($this->_request->orderid);
			$vtweb_url = $this->veritrans($orderid);
			if($vtweb_url){
				$mainframe->redirect($vtweb_url.'?selected_color=gray');
			}
		}
		
		if($this->_request->task == 'vtsnap'){
				$snapToken = $this->veritrans(base64_decode($this->_request->orderid), '', true);
				$ret = new stdClass();
				$ret->token = $snapToken;
				$ret->success = JURI::base().'thank-you?order_id='.$invoice_id;
				$ret->pending = JURI::base().'payment-pending?order_id='.$invoice_id;
				$ret->unfinish = JURI::base().'transactions?layout=transaction_view&err=unfinish&id='.$invoice_id;
				$ret->error = JURI::base().'transactions?layout=transaction_view&err=err&id='.$invoice_id;
				echo json_encode($ret);
				die();
			}
		
		if($this->_request->task == 'confirmation'){
			$this->saveConfirmation($this->_request->invoice_id, 'Manual Transfer');
		}
		
		if($this->_request->task == 'stat'){
			$this->updateOrderStatus($this->_request->invoice, $this->_request->status);
			$this->redirect('', $this->_request->return , 'Status Change !', 'success');
		}
		
		if($this->_request->task == 'update_booking'){
			if($this->_data->user->usertype != 'Super Administrator'){
				$this->redirect('', JURI::base().'administration/store/calendar' , 'Admin only !', 'error');
			}else{
				$this->updateBooking(0, $this->_request->id, $this->_request->status);
				$this->redirect('', JURI::base().'administration/store/calendar' , 'Status Change !', 'success');
			}
		}
		
		if($this->_request->getCountry){
			$countries = json_decode(rajaOngkir::internationalDestination());
			$indonesia = new stdClass();
			$indonesia->country_id = 999;
			$indonesia->country_name = 'Indonesia';
			$countries->rajaongkir->results[] = $indonesia;
			$countries = str_replace('country_id','id', json_encode($countries->rajaongkir->results));
			echo str_replace('country_name','text', $countries);die();
			//echo json_encode($this->getCountry($this->_request->getCountry));die();
		}
		
		if($this->_request->getProvince){
			if($this->_request->testongkir){
				$province = str_replace('province_id','id', rajaOngkir::province());
				$province = json_decode(str_replace('province','text', $province));
				//echo'<pre>';print_r($province->rajaongkir->results);	echo'</pre>';
				echo json_encode($province->rajaongkir->results); die();
			}
			echo json_encode($this->getLocalProvince($this->_request->getProvince));die();
		}
		
		if($this->_request->getDistrict){
			if($this->_request->testongkir){
				$district = str_replace('city_id','id', rajaOngkir::city());
				$district = json_decode(str_replace('city','text', $district));
				echo json_encode($district->rajaongkir->results); die();
			}
			echo json_encode($this->getLocalDistrict($this->_request->getDistrict));die();
		}
		
		if($this->_request->getShipping){
			echo $this->getShippingOption($this->_request->district, $this->_request->country);die();
		}
		
		if($this->_request->getUsers){
			if($this->_data->user->usertype != 'Super Administrator'){
				die('Forbiden!');
			}
			echo json_encode($this->getUsers($this->_request->getUsers));die();
		}
		
		if($this->_request->getUser){
			if($this->_data->user->usertype != 'Super Administrator'){
				die('Forbiden!');
			}
			echo json_encode($this->getUser($this->_request->getUser));die();
		}
		if($this->_request->validate_extend){
			$this->validate_booking_extend($this->_request->validate_extend, $this->_request->pickup);
		}
	}
	
	function checkform(){
		
	}
	
	function newsletter($name = '', $email = null, $stat = 1){
		$db = JFactory::getDBO();
		$query = "SELECT email FROM #__newsletter WHERE email = '".$email."'";
		$db->setQuery($query);
		$exist = count($db->loadObjectList());
		$secret = strtr(base64_encode($email), '+/=', '-_,');
		if($email){
			if($exist == 0){
				$query = "INSERT INTO #__newsletter (email,type,secret,full_name,status) VALUES ('$email','nw','$secret','$name','$stat')";
				$db->setQuery($query);
				$db->query();
			}
		}
	}
	
	function saveUser()
	{
		global $mainframe;
		$instance = clone(JFactory::getUser());
		
		if(!$this->_request->name && !$this->_request->phone && !$this->_request->email){
			JFactory::getApplication()->enqueueMessage('Complete your information!', 'ERROR');
			return false;
		}
		
		jimport( 'joomla.user.helper' );
		jimport('joomla.application.component.helper');
		$config   = &JComponentHelper::getParams( 'com_users' );
		$usertype = $config->get( 'new_usertype', 'Registered' );
		
		$acl =& JFactory::getACL();
		
		$salt  = JUserHelper::genRandomPassword(32);
		$crypt = JUserHelper::getCryptedPassword($this->_request->password, $salt);
		$password = $crypt.':'.$salt;
		if(!$this->_request->nwl){
			$newsletter = 1;
		}else{
			$newsletter = 0;
		}
		
		$address = json_encode($this->processLocalShipping($this->_request->address));
		
		$instance->set( 'id'					, 0 );
		$instance->set( 'name'				, $this->_request->name );
		$instance->set( 'phone'				, $this->_request->phone );
		$instance->set( 'address'			, $address );
		$instance->set( 'newsletter'	, $newsletter );
		$instance->set( 'username'		, $this->_request->email );
		$instance->set( 'password'		, $password );
		$instance->set( 'email'				, $this->_request->email );	// Result should contain an email (check)
		$instance->set( 'gid'					, $acl->get_group_id( '', $usertype));
		$instance->set( 'usertype'		, $usertype );
		if(!$instance->save()) {
			$instance->set( 'guest', 1);
			JFactory::getApplication()->enqueueMessage($instance->getError(), 'ERROR');
			return false;
		}else{
			$instance->set( 'guest', 0);
			$this->_data->user = $instance; 
			//$this->sendMailMessage($invoice_id, 152, $user->email, 'TOISS.ID order - '.$invoice_id);
			if($newsletter){
				$this->newsletter($this->_request->username, $this->_request->email);
			}else{
				$this->newsletter($this->_request->username, $this->_request->email, 0);
			}
			return $instance;
		}
		
	}
	
	function checkVeritrans($orderid){
		global $mainframe;
		Veritrans_Config::$isProduction = $this->_VTlive;
		Veritrans_Config::$serverKey = $this->_VTserverKey;
		$status = Veritrans_Transaction::status($orderid);
		if($status->status_code == 200){
			$this->_request->to = 'Veritrans';
			$this->_request->from = $status->transaction_id;
			$this->_request->from_acc = $status->payment_type;
			$this->_request->amount = $status->gross_amount;
			$this->_request->payment_date = JFactory::getDate($status->transaction_time)->toMySQL();
			$this->saveConfirmation($orderid,'veritrans');
			$mainframe->redirect(JURI::base()."thank-you?order_id=".$orderid);
		}else if($status->status_code == 201){
			if($status->permata_va_number){
				$this->_request->code = $status->permata_va_number;
			}
			if($status->payment_code){
				$this->_request->code = $status->payment_code;
			}
			if($status->va_numbers){
				$this->_request->code = $status->va_numbers->va_number;
			}
			if($status->payment_type){
				$this->_request->payment_type = $status->payment_type;
			}
			$this->updateOrderStatus($orderid, $status->transaction_status);
			$mainframe->redirect(JURI::base()."payment-pending?order_id=".$orderid);
		}else{
			$mainframe->redirect(JURI::base()."transactions?layout=transaction_view&id=".$orderid."&err=err");
		}
	}
	
	function veritrans($orderid = null,$user = null, $snap = false){
		global $mainframe;
		
		Veritrans_Config::$isProduction = $this->_VTlive;
		Veritrans_Config::$serverKey = $this->_VTserverKey;
		Veritrans_Config::$is3ds = $this->_VTis3ds;
		
		$date =& JFactory::getDate();
		$sqldate = $date->toMySQL();
		$session =& JFactory::getSession();
		
		if(!$user){
			$user = $this->_data->user;
		}
		
		$order = $this->getOrder($orderid);
		if($order->status == 'expired'){
			$referer = $_SERVER['HTTP_REFERER'];
			if (strpos($referer,'toiss.id') !== false) {
				$this->redirect(null, $referer, 'Order is Expired', 'error');
			}else{
				$this->redirect(null, JURI::base(), 'Order is Expired', 'error');
			}
		}
		$products = json_decode($order->products);
		$shipping = json_decode($order->shipment);
		
		$item_details = array();
		
		foreach($products as $item){
			$item_details[] = array(
				'id' => $item->id,
				'price' => (int)$item->price,
				'quantity' => (int)$item->count,
				'name' => $item->title.', '.$item->size
			);
		}
		
		$item_details[] = array(
			'id' => 1,
			'price' => (int)$shipping->pricing * ceil($shipping->weight),
			'quantity' => 1,
			'name' => $shipping->weight.'kg shipping'
		);
		
		
		// Required
		$transaction_details = array(
		  'order_id' => $orderid,
		  'gross_amount' => $order->value, // no decimal allowed for creditcard
		  );
		
		// Optional
		$customer_details = array(
			'first_name'    => $user->name,
			'email'         => $user->email,
			'phone'         => $user->phone,
		);
		
		
		
		/*$enabled_payments = JRequest::getVar('payment_methode','credit_card');
		
		if($enabled_payments == 'cc'){
			$enabled_payments = 'bank_transfer';
		}*/
		
		// Fill transaction details
		$transaction = array(
			//'payment_type' => 'bank_transfer',
			/*'vtweb' => array(
				'credit_card_3d_secure' => true,
				'enabled_payments' => $enabled_payments,
				"finish_redirect_url" => JURI::base()."checkout?id=".$orderid."&task=check", 
   				"unfinish_redirect_url" => JURI::base()."transactions?layout=transaction_view&id=".$orderid."&err=retry",
    			"error_redirect_url" => JURI::base()."transactions?layout=transaction_view&id=".$orderid."&err=err"
				),*/
			'transaction_details' => $transaction_details,
			'customer_details' => $customer_details,
			'item_details' => $item_details,
			);
			
		if($snap){	
			$snapToken = Veritrans_Snap::getSnapToken($transaction);
			if($snapToken){
				return $snapToken;
			}else{
				return false;
			}
		}else{
			$vtweb_url = Veritrans_Vtweb::getRedirectionUrl($transaction);
			if($vtweb_url){
				return $vtweb_url;
			}else{
				return false;
			}
		}
	}
	
	function validateDiscCode($code=0, $total=0){
		
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__promo_code WHERE code = '".$code."'";
		$db->setQuery($query);
		$disc = $db->loadObject();
		$error = $db->getErrorMsg();
		if($error){
			die($error);
		}
		$cart = $this->getCart();
		if($disc->product_id > 0){
			
			$valid = false;
			foreach($cart as $item){
				if($item->id == $disc->product_id){
					$valid = 1;
					break;
				}
			}
			if(!$valid){
				return $result;
			}
		}
		
		if($disc->rule == 'limited' && $disc->use_count <= $disc->max_usage ){
			return $result;
		}
		if($disc->type == 'percent'){
			$result = $total - ($total * ($disc->value/100));
		}elseif($disc->type == 'amount'){
			$result = $total - $disc->value;
		}
		
		return $result;
	}
	
	function getDiscount($code=0, $total=0){
		$result = new stdClass();
		$result->discount = '';
		$result->total = $total;
			
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__promo_code WHERE code = '".$code."'";
		$db->setQuery($query);
		$disc = $db->loadObject();
		$error = $db->getErrorMsg();
		
		if($disc->product_id){
			$cart = $this->getCart();
			$valid = false;
			foreach($cart as $item){
				if($item->id == $disc->product_id){
					$valid = 1;
					$product_subtotal = $item->price * $item->count;
					break;
				}
			}
			if($valid){
				if($disc->type == 'percent'){
					$result->discount = $disc->value;
					$result->value = $product_subtotal * ($disc->value/100);
					$result->total = $total - $result->value;
				}elseif($disc->type == 'amount'){
					$result->discount = $disc->value;
					$result->value = $product_subtotal - $disc->value;
					$result->total = $total - $result->value;
				}
				return $result;
			}else{
				$result->err = 'Missing specified product';
				return $result;
			}
		}
		
		if($disc->rule == 'limited' && $disc->use_count >= $disc->max_usage ){
			$result->err = 'The code expired.';
			return $result;
		}
		if($disc->type == 'percent'){
			$result->discount = $disc->value;
			$result->total = $total - ($total * ($disc->value/100));
		}elseif($disc->type == 'amount'){
			$result->discount = $disc->value;
			$result->total = $total - $disc->value;
		}
		
		return $result;
	}
	
	function updateDiscData($code=0){
		$db = JFactory::getDBO();
		
		$query = "SELECT use_count FROM #__promo_code WHERE code = '$code'";
		$db->setQuery($query);
		$count = $db->loadResult();
		$count = $count + 1;
		
		$query = "UPDATE #__promo_code SET use_count = $count WHERE code = '$code'";
		$db->setQuery($query);
		$db->query();
		$error = $db->getErrorMsg();
		if($error){
			die($error);
		}
		return true;
	}
	
	function validateShippingCost($dest,$service,$type=null){
		$db = JFactory::getDBO();
		if($type == 'int'){
			$query = "SELECT regular AS reg, express AS yes FROM #__country WHERE  short_name = '".$dest."'";
		}else{
			$dest = explode(' - ',$dest);
			$query = "SELECT * FROM #__jne WHERE kota = '".$dest[1]."'";
		}
		$db->setQuery($query);
		$result = $db->loadObject();
	}
	
	function processLocalShipping($address, $service = null){
		
		$shipment = new stdClass();
		
		$db = JFactory::getDBO();
		$query = "SELECT a.* FROM #__jne AS a WHERE a.id = ".(int)$address->district;
		$db->setQuery($query);
		$result = $db->loadObject();
		
		$shipment_process = $this->getRentalShipping($address->district, 'data');

		if($result->country){
			$address->country = $result->country;
		}else{
			$address->country = $address->country_name;
		}
		
		$address->district_name = $result->kecamatan;
		
		$shipment->address = $address;
		
		$shipment->method_desc = htmlentities($shipment_process->html_content);
		$shipment->pricing = $shipment_process->total;
		
		return $shipment;
		
	}
	
	function saveAddress($address,$userid){
		$db = JFactory::getDBO();
		$address = json_encode($address);
		$query = "INSERT INTO #__user_address (user_id,address) ".
        		 " VALUES ('$userid','$address')";
		$db->setQuery($query);
		$db->query();
		
		return $db->insertid();
	}
	
	function saveorder(){
		global $mainframe;
		$user = $this->_data->user;
		$date =& JFactory::getDate();
		$sqldate = $date->toMySQL();
		$session =& JFactory::getSession();
		$discCode = $session->get('promo_code');
		//$shippingcost = explode('||',$this->_request->service);
		
		$cart = $this->getCart();
		$products = $this->getCart('json');
		
		$this->_request->address = (object)$this->_request->address;
		
		if(!$this->_request->address->name){
			$this->_request->address->name = $this->_data->user->name;
		}
		if(!$this->_request->address->phone){
			$this->_request->address->phone = $this->_data->user->phone;
		}
		
		$shipping = $this->processLocalShipping($this->_request->address, $this->_request->service);
		
		//save user
		if($user->guest == 1){
			if(!$this->saveUser()){
				return false;
			}
		}else{
			if($this->_request->user > 0 && $this->_data->user->usertype == 'Super Administrator'){
				$instance =& JFactory::getUser($this->_request->user);
			}else{
				$instance =& JFactory::getUser($this->_data->user->id);
			}
			$save = false;
			if($this->_request->phone){
				$instance->set( 'phone'	, $this->_request->phone );
				$save = true;
			}
			if($this->_data->user->address){
				$address = new stdClass();
				$address->address = (object)$this->_request->address;
				$instance->set( 'address'	, json_encode($address));
				$save = true;
			}
			if($save){
				$instance->save();
			}
		}
		
		
		
		if($this->_request->user > 0 && $this->_data->user->usertype == 'Super Administrator'){
			$tempuser = $this->getUser($this->_request->user);
			$this->saveAddress($shipping->address, $this->_request->user);
			$userid = $this->_request->user;
			$emailuser = $tempuser->email;
			$userphone = $tempuser->phone;
		}else{
			$this->saveAddress($shipping->address, $this->_data->user->id);
			$userid = $this->_data->user->id;
			$emailuser = $this->_data->user->email;
			$userphone = $this->_data->user->phone;
		}

		$total = 0;
		$weight = 0;
		
		if($cart){
			foreach($cart as $item){
				$weight +=  (int)$item->weight * (int)$item->count;
				$total += ((int)$item->price * (int)$item->count);
				$count += (int)$item->count;
			}
		}
		
		if(!$total){
			return false;
		}
		
		if($discCode){
			$total = $this->validateDiscCode($discCode, $total);
		}
		
		$shipping->weight = $weight;
		
		$shipment = str_replace("'","\'",json_encode($shipping));
		$usernote = $this->_request->notes;
		
		if($shipping->pricing < 100){
			$shipping->pricing = 0;
		}
		
		//$total = $total + ($shipping->pricing * ceil($weight));
		
		$total = $total + $shipping->pricing;
		
		$status = 'new';
		
		if($shipping->method === 'COD'){
			$status = 'new_cod';
		}
		
		
		
		
		$db = JFactory::getDBO();
		$query = "INSERT INTO #__cart_order (user,email,phone,products,shipment,value,status,disc_code,usr_note,order_date)
        		  VALUES ('$userid','$emailuser','$userphone','$products','$shipment','$total','$status','$discCode','$usernote','$sqldate')";
		$db->setQuery($query);
		$db->query();
		
		$invoice_id = $db->insertid();
		$error = $db->getErrorMsg();

		if($error){
			//JFactory::getApplication()->enqueueMessage($error, 'ERROR');
			jimport( 'joomla.error.log' );
			$log = JLog::getInstance('error_log.php','',JPATH_BASE.DS.'logs');
			$log_entry = array('LEVEL' => '1', 'STATUS' => "Error:", 'COMMENT' => $error );
			$log->addEntry($log_entry);
			$mainframe->redirect(JURI::base().'checkout', 'Error occured, please try again', 'error');
		}else{
			
			if($discCode){
				$total = $this->updateDiscData($discCode);
			}
			
			foreach($cart as $item){
				$this->saveBooking($item->id, $invoice_id, $item->deliver, $item->pickup, $item->duration);
			}

			$this->clearCart();
			$session->set('promo_code', '');
			$session->set('discount', '');
			$session->set('discount_type', '');
		}
		
		
		if($shipping->method === 'COD'){
			$this->sendMailMessage($invoice_id, 359, $emailuser, 'COD order - '.$invoice_id) ;
			$this->sendMailMessage($invoice_id, 154, $this->_admin_email, 'New COD Order - '.$invoice_id);
			$this->redirect(360,'','','',$invoice_id);
		}
		
		if($this->_request->payment_methode == 'snap'){
			$snapToken = $this->veritrans($invoice_id, '', true);
			if($snapToken){
				if($this->_request->ajax){
					$ret = new stdClass();
					$ret->token = $snapToken;
					$ret->success = JURI::base().'thank-you?order_id='.$invoice_id;
					$ret->pending = JURI::base().'payment-pending?order_id='.$invoice_id;
					$ret->unfinish = JURI::base().'transactions?layout=transaction_view&err=unfinish&id='.$invoice_id;
					$ret->error = JURI::base().'transactions?layout=transaction_view&err=err&id='.$invoice_id;
					echo json_encode($ret);
					die();
				}
				$mainframe->redirect(JURI::base().'payment?id='.$invoice_id);
			}else{
				$mainframe->redirect(JURI::base().'transactions?layout=transaction_view&err=err&id='.$invoice_id);
			}
		}
		
		if($this->_request->payment_methode == 'vtweb'){
			$vtweb_url = $this->veritrans($invoice_id, $this->_data->user);
			if($vtweb_url){
				$this->sendMailMessage($invoice_id, 154, $this->_admin_email, 'Pesanan masuk #'.$invoice_id);
				$this->sendMailMessage($invoice_id, 152, $emailuser, 'Pesanan anda #'.$invoice_id) ;
				$mainframe->redirect($vtweb_url);
			}else{
				JFactory::getApplication()->enqueueMessage('Error occured, please try again', 'ERROR');
				$mainframe->redirect(JURI::base().'checkout', 'Error occured, please try again', 'error');
			}
		}
		
		if($this->_request->payment_methode == 'transfer'){
			$this->sendMailMessage($invoice_id, 154, $this->_admin_email, 'Pesanan masuk #'.$invoice_id);
			$this->sendMailMessage($invoice_id, 152, $emailuser, 'Pesanan anda #'.$invoice_id) ;
			$this->redirect(151,'','','',$invoice_id);
		}
		
		return;
	}
	
	function checkExtendbility($id = 0, $from_date = null){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__booking WHERE product_id = ".$id." AND (deliver > ".$from_date.") AND book_status IN ('pending','processing','booked') ORDER BY deliver" ;
		$db->setQuery($query);
		$booking = $db->loadObject;
		
		if($booking){
			return round((strtotime($booking->deliver) - strtotime($from_date)) / (60 * 60 * 24));
		}
		return 1000;
	}
	
	function checkAvailability($id = 0, $option = null, $deliver = null){
		$ret = array();
		$opt = $this->getProductOption($id, 'pr_option', $option);
		
		if($deliver){
			$db = JFactory::getDBO();
			$query = "SELECT * FROM #__booking WHERE product_id = ".$id." AND book_status IN ('pending','processing','booked')";
			$db->setQuery($query);
			$booking = $db->loadObjectList();
			
			if(count($booking)){
				//$selected_date = new DatePeriod(new DateTime($deliver), new DateInterval('P1D'), (int)$opt->pr_opt_days + 1);
				$selected_date = new DatePeriod(new DateTime($deliver), new DateInterval('P1D'), (int)$opt->pr_opt_days);
				$block_date = array();
				
				foreach($booking as $book){
					//$period = new DatePeriod(new DateTime($book->deliver), new DateInterval('P1D'), (int)$book->duration + 1);
					$period = new DatePeriod(new DateTime($book->deliver), new DateInterval('P1D'), (int)$book->duration); 
					foreach($period as $date) { 
							$block_date[] = $date->format('Y-m-d'); 
					}
				}
				
				foreach($selected_date as $s_date) { 
					if(in_array($s_date->format('Y-m-d'), $block_date)){
						$ret['err'] = 'Date Taken';
						break;
					}
				}
			}	
		}else{
			if(!$opt->pr_stock){
				$ret['err'] = 'No Stock';
			}elseif(((int)$opt->pr_stock - (int)$amount) <= 0){
				$ret['err'] = 'Over Limit';
			}
		}
		
		return (object)$ret;
	}
	
	
	function updateProd($id = 0, $option = null, $amount = 1){
		$raw = $this->getRawContent($id);

		$neededObjects = null;
		$num = 0;
		foreach($raw->pr_options as $struct) {
				if ($option == $struct['pr_option']) {
						$neededObjects = $struct;
						$neededObjects['num'] = $num;
						break;
				}
				$num++;
		}
		//$key = str_replace('pr_option|','pr_stock|',$key);
		
		
		$key = $neededObjects['num'];
		$name = $neededObjects['pr_option'];
		$stock = (int)$neededObjects['pr_stock'];
		$color = $neededObjects['pr_color'];
		
		$val = $stock - (int)$amount;
		
		
		$db = JFactory::getDBO();
		$queryget = "SELECT introtext, stock, buycount, options  FROM #__content WHERE id=".$id;
		$db->setQuery($queryget);
		$result = $db->loadObject();
		
		if($result->stock){
			$totalstock = (int)$result->stock - $amount;
			$buycount = (int)$result->buycount + $amount;
		}else{
			$totalstock = 0;
		}
		
		if($stock == 0 || $stock - (int)$amount < 0){
			$this->redirect('',JURI::base().'cart', 'Please check your order again');
		}
		
		$html = $result->introtext;
		$html = str_replace('::pr_stock|'.$key.'|pr_options::'.$stock.'::/pr_stock|'.$key.'|pr_options::', '::pr_stock|'.$key.'|pr_options::'.$val.'::/pr_stock|'.$key.'|pr_options::', $html);
		
		$option = $result->options;
		$option = str_replace('{"pr_option":"'.$name.'","pr_color":"'.$color.'","pr_stock":"'.$stock.'"}','{"pr_option":"'.$name.'","pr_color":"'.$color.'","pr_stock":"'.$val.'"}',$option);
		
		$queryset = "UPDATE #__content SET introtext = '$html', stock = '$totalstock', buycount=".$buycount.", options = '$option' WHERE id=".$id ;
		$db->setQuery($queryset);
		$ok = $db->query();
		
		$error = $db->getErrorMsg();
		if($error){
			print_r($error);
		}
		
		$db->setQuery($queryget);
		$result = $db->loadObject();
		
		return true;
	}
	
	function bookingReminder(){
		
		$db = JFactory::getDBO();
		$query = "SELECT a.*, b.email, DATE_FORMAT(CURRENT_DATE() + 1, '%Y-%m-%d') AS now FROM #__booking AS a ".
						" LEFT JOIN #__cart_order AS b ON b.id = a.order_id".
						" WHERE (a.pickup = (CURDATE() + 1) OR a.deliver = (CURDATE() + 1)) AND b.status = 'paid' GROUP BY a.order_id ORDER BY a.id";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$error = $db->getErrorMsg();

		//print_r($result);die();	
		
		if(!count($result)){
			die();
		}
		
		jimport( 'joomla.error.log' );
		$log = JLog::getInstance('auto_email_log.php','',JPATH_BASE.DS.'logs'); // get an instance of JLog
		foreach($result as $book){
			if($book->deliver == $book->now){
				//$this->sendMailMessage($book->order_id, 505, $this->_admin_email, 'Pengingat pengiriman esok hari');
				$this->sendMailMessage($book->order_id, 507, $book->email, 'Pesanan anda akan kami kirimkan esok hari');
				$log_entry1 = array('LEVEL' => '1', 'STATUS' => "Sent delivery reminder:", 'COMMENT' => 'Order '.$book->order_id.' to '.$book->email );
				$log->addEntry($log_entry1);
			}
			if($book->pickup == $book->now){
				//$this->sendMailMessage($book->order_id, 506, $this->_admin_email, 'Pengingat penjemputan esok hari');
				$this->sendMailMessage($book->order_id, 504, $book->email, 'Masa sewa berakhir esok hari');
				$log_entry2 = array('LEVEL' => '1', 'STATUS' => "Sent pickup reminder:", 'COMMENT' => 'Order '.$book->order_id.' to '.$book->email );
				$log->addEntry($log_entry2);
			}
		}
		
		$log->_closeLog(); 
		die();
		
	}
	
	function checkExpired(){
		$db = JFactory::getDBO();
		$query = "SELECT UNIX_TIMESTAMP(NOW()) AS 'now', id, products, email, UNIX_TIMESTAMP(order_date) AS 'date' FROM #__cart_order WHERE status = 'new' AND order_date BETWEEN NOW() - INTERVAL 1 DAY AND NOW() ORDER BY id";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$error = $db->getErrorMsg();
		$action = 0;
		//print_r($result);die();	
			
		if($error){
			JFactory::getApplication()->enqueueMessage('DB Query ERROR!, '.$error, 'ERROR');
		}else{
			jimport( 'joomla.error.log' );
			$log = JLog::getInstance('auto_email_log.php','',JPATH_BASE.DS.'logs'); // get an instance of JLog
			$results = array();
			$i = 0;
			foreach($result as $item){
				$i++;
				if($item->now - $item->date > 3600*12 && $item->now - $item->date < 3600*13 ){
					$this->sendMailMessage($item->id, 305, $item->email, 'Pengingat pesanan Order ID #'.$item->id);
					$log_entry = array('LEVEL' => '1', 'STATUS' => "Sent order reminder:", 'COMMENT' => 'Order '.$item->id.' to '.$item->email );
					$log->addEntry($log_entry);
				}else if($item->now - $item->date > 3600*23 && $item->now - $item->date < 3600*24 ){
					$log_entry = array('LEVEL' => '1', 'STATUS' => "Expired:", 'COMMENT' => 'Order '.$item->id );
					$this->updateOrderStatus($item->id, 'expired');
				}
				else if($item->now - $item->date > 3600*24){
					$log_entry = array('LEVEL' => '1', 'STATUS' => "Expired:", 'COMMENT' => 'Order '.$item->id );
					$this->updateOrderStatus($item->id, 'expired');
				}
				
			}
		}
		$log->_closeLog(); 
		die();
	}
	
	function getOrder($id = 0){
		$db = JFactory::getDBO();
		$query = 	"SELECT a.*, b.*, c.name, c.phone AS user_phone FROM #__cart_order AS a".
					" LEFT JOIN #__cart_payment AS b ON b.order_id = a.id".
					" LEFT JOIN #__users AS c ON c.id = a.user".
					" WHERE a.id=".$id;
		$db->setQuery($query);
		$result = $db->loadObject();
		$error = $db->getErrorMsg();
		if($error){
			JFactory::getApplication()->enqueueMessage('DB Query ERROR!, '.$error, 'ERROR');
		}
		return $result;
	}
	
	
	
	function getTotal($query){
 	// Load the content if it doesn't already exist
 	if (empty($this->_total)) {
 	    $this->_total = $this->_getListCount($query);	
 	}
 	return $this->_total;
	}
	
	function getOrders(){
		global $mainframe;
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		
		$lim	= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 30, 'int');
		$lim0	= JRequest::getVar('limitstart', 0, '', 'int');
		
		if(JRequest::getVar('keyword')){
			$where = " WHERE c.name LIKE '%".JRequest::getVar('keyword')."%'";
		}
		
		$query = 	"SELECT a.*, b.*, c.name, c.phone AS user_phone FROM #__cart_order AS a".
					" LEFT JOIN #__cart_payment AS b ON b.payment_id = a.payment".
					" LEFT JOIN #__users AS c ON c.id = a.user".
					$where.
					" ORDER BY a.order_date DESC";
		$db->setQuery($query, $lim0, $lim);
		$result = $db->loadObjectList();
		$error = $db->getErrorMsg();
		
		$db->setQuery('SELECT FOUND_ROWS();');  //no reloading the query! Just asking for total without limit
		$this->tr_total = $db->loadResult();
		jimport('joomla.html.pagination');
		$this->pageNav = new JPagination( $this->getTotal($query), $lim0, $lim );
		if($error){
			die('getOrders'.$error);
		}
		
		$this->transaction = $result;
		return $result;
	}
	
	function validate_booking_extend($product_id = 0, $pickup = '0000-00-00'){
		$db = JFactory::getDBO();
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		
		$query = 	"SELECT a.*, b.user FROM #__booking AS a ".
							"LEFT JOIN #__cart_order AS b ON b.id = a.order_id ".
							"WHERE a.book_status = 'processing' AND a.product_id = ".$product_id." AND a.pickup = '".$pickup."' AND b.user = ".$userId;
		
		$db->setQuery($query);
		$result = $db->loadObject();	
		$error = $db->getErrorMsg();
		
		print_r($result);die();
		
		if($error){
			die('validate_booking_extend = '.$error);
		}
	}
	
	function saveBooking($product_id = 0, $order_id = 0, $deliver = null, $pickup = null, $duration = 0, $book_status = 'pending'){
		global $mainframe;
		$db = JFactory::getDBO();
		$query = "INSERT INTO #__booking (product_id,order_id,deliver,pickup,duration,book_status) VALUES ($product_id,$order_id,'$deliver','$pickup',$duration,'$book_status')";
		$db->setQuery($query);
		$db->query();
	}
	
	function updateBooking($order_id = 0, $id = 0, $book_status = ''){
		$db = JFactory::getDBO();
		if($order_id){
			$query = "UPDATE #__booking SET book_status = '$book_status' WHERE order_id = $order_id";
		}
		if($id){
			$query = "UPDATE #__booking SET book_status = '$book_status' WHERE id = $id";
		}
		$db->setQuery($query);
		$db->query();
	}
	
	function getBookingCalendar($month, $year, $day = null)
	{
		global $mainframe;
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		
		$deliver_query = "SELECT deliver, COUNT(id) AS count FROM #__booking WHERE book_status = 'processing'".
					" GROUP BY deliver";
					
		$pickup_query = "SELECT pickup, COUNT(id) AS count FROM #__booking WHERE book_status = 'processing'".
					" GROUP BY pickup";
					
		$db->setQuery($deliver_query);
		$deliver = $db->loadObjectList();
		
		$db->setQuery($pickup_query);
		$pickup = $db->loadObjectList();
		
		$error = $db->getErrorMsg();
		
		if($error){
			die('getBookings'.$error);
		}
		
		$result = array_merge($deliver,$pickup);
		
		if(!$result){
			return;
		}
		
		$bookings = array();

		
		foreach($result as $item){
			if($item->deliver){
				$item->start = $item->deliver;
				$item->end = $item->deliver;
				$item->category = 'Booking';
				$item->className = 'delivery';
				$item->title = $item->count.' delivery';
			}else{
				$item->start = $item->pickup;
				$item->end = $item->pickup;
				$item->category = 'Booking';
				$item->className = 'pickup';
				$item->title = $item->count.' pickup';
			}
			$item->allDay = false;
			$bookings[] = $item;
		}
		
		return $bookings;
	}
	
	function getBookingCalendarView($date)
	{
		global $mainframe;
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		
		$query = "SELECT a.*, b.title AS product, c.status AS order_status, c.shipment FROM #__booking AS a ".
					" LEFT JOIN #__content AS b ON b.id = a.product_id ".
					" LEFT JOIN #__cart_order AS c ON c.id = a.order_id".
					" WHERE (a.deliver = '$date' OR a.pickup = '$date') AND a.book_status = 'processing'".
					" ORDER BY a.id ASC";
					
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		return $result;
	}
	
	function viewOrder($id){
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		$query = 	"SELECT a.*, b.* FROM #__cart_order AS a".
					" LEFT JOIN #__cart_payment AS b ON b.payment_id = a.payment".
					" WHERE a.user = ".$userId." AND a.id = ".$id;
		$db->setQuery($query);
		$result = $db->loadObject();
		$error = $db->getErrorMsg();
		if($error){
			die('viewOrder'.$error);
		}
		$this->transaction = $result;
		return $result;
	}
	
	function viewOrderAdmin($id){
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		$query = 	"SELECT a.*, b.*, c.id AS user_id, c.name, c.email AS user_mail, c.phone AS user_phone, d.value AS discount, d.type AS discount_type, d.code FROM #__cart_order AS a".
					" LEFT JOIN #__cart_payment AS b ON b.order_id = ".$id.
					" LEFT JOIN #__users AS c ON c.id = a.user".
					" LEFT JOIN #__promo_code AS d ON a.disc_code = d.code".
					" WHERE a.id = ".$id;
		$db->setQuery($query);
		$result = $db->loadObject();
		$error = $db->getErrorMsg();
		if($error){
			die($error);
		}
		return $result;
	}
	
	function viewOrderFree($id){
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		$query = 	" SELECT a.*, b.*, c.name FROM #__cart_order AS a".
					" LEFT JOIN #__cart_payment AS b ON b.payment_id = a.payment".
					" LEFT JOIN #__users AS c ON c.id = a.user".
					" WHERE a.id = '".$id."'";
		$db->setQuery($query);
		$result = $db->loadObject();
		$error = $db->getErrorMsg();
		if($error){
			die('viewOrderFree'.$error);
		}
		$this->transaction = $result;
		return $result;
	}
	
	function saveConfirmation($id, $methode = null){
		global $mainframe;
		$db = JFactory::getDBO();
		$query = "SELECT email FROM #__cart_order WHERE id = ".$id;
		$db->setQuery($query);
		$email = $db->loadResult();
		
		$query = "SELECT payment_id FROM #__cart_payment WHERE order_id = ".$id;
		$db->setQuery($query);
		$payment_id = $db->loadResult();
		
		
		//JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cckjseblod'.DS.'tables');
		$row = JTable::getInstance( 'cart_payment', 'Table' );
		if($payment_id){
			$row->load($payment_id);
		}else{
			$row->order_id = $id;
		}
		$row->from = $this->_request->from;
		$row->to = $this->_request->to;
		$row->from_acc = $this->_request->from_acc;
		$row->payment_amount = (int) str_replace('.','',$this->_request->amount);
		$row->payment_date = JFactory::getDate($this->_request->payment_date)->toMySQL();
		
		$this->saveBase64Image($this->_request->ident, JPATH_BASE.DS.'images'.DS.'transactions'.DS, $id.'_ident.jpg');
		$this->saveBase64Image($this->_request->bukti_bayar, JPATH_BASE.DS.'images'.DS.'transactions'.DS, $id.'_bukti_bayar.jpg');
		
		if($row->from && $row->to && $row->from_acc && $row->payment_amount && $row->payment_date){
			if($methode == 'veritrans'){
				$row->store();
				$this->updateOrderStatus($id, 'paid');
				$this->sendMailMessage($id, 282, $email, 'Pembayaran pesanan #'.$id) ;
				$this->sendMailMessage($id, 283, $this->_admin_email, 'Pembayaran pesanan #'.$id);
				$this->redirect(284,'','','',$id);
			}else{
				$row->store();
				$this->updateOrderStatus($id, 'verifying');
				$this->sendMailMessage($id, 185, $this->_admin_email, 'Verifikasi pembayaran pesanan #'.$id);
				$this->redirect(184,'','','',$id);
			}
		}else{
			JFactory::getApplication()->enqueueMessage('Complete Form !', 'ERROR');
			return false;
		}
	}
	
	function statuslabel($status = null){
		$ret = new stdClass();
		switch ($status) {
			case 'new':
				$ret->label = '<span class="label label-warning">'.JText::_( 'WAITING_PAYMENT' ).'</span>'; 
				break;
			case 'new_cod':
				$ret->label = '<span class="label label-warning">'.JText::_( 'WAITING_PAYMENT' ).'</span>'; 
				break;
			case 'pending':
				$ret->label = '<span class="label label-inverse">'.JText::_( 'PENDING' ).'</span>';
				break;
			case 'verifying':
				$ret->label = '<span class="label label-default">'.JText::_( 'VERIFY_PAYMENT' ).'</span>';
				break;
			case 'paid':
				$ret->label = '<span class="label label-success">'.JText::_( 'PAID' ).'</span>';
				break;
			case 'on_delivery':
				$ret->label = '<span class="label label-success">'.JText::_( 'ON_DELIVERY' ).'</span>';
				break;
			case 'on_cod_delivery':
				$ret->label = '<span class="label label-default">'.JText::_( 'ON_COD_DELIVERY' ).'</span>';
				break;
			case 'complete':
				$ret->label = '<span class="label label-inverse">'.JText::_( 'COMPLETE' ).'</span>';
				break;
			case 'expired':
				$ret->label = '<span class="label label-inverse">'.JText::_( 'EXPIRED' ).'</span>';
				break;
			default:
				$ret->label = '<span class="label label-info">'.JText::_( $status ).'</span>';
		}
		
		return $ret->label;
		
	}
	
	function updateOrderStatus($id, $status, $message = null){
		if($status){
			//return false;
		}
		
		$row =	JTable::getInstance( 'cart_order', 'Table' );
		
		$row->load($id);
		$email = $row->email;
		
		$row->status = $status;
		if($this->_request->code){
			$row->code = $this->_request->code;
		}
		if($this->_request->resi){
			$row->resi = json_encode($this->_request->resi);
		}
		if($this->_request->payment_type){
			$row->type = $this->_request->payment_type;
		}
		
		if (!$row->store()) {
			die($row->getError());
		}
		
		if($status == 'new'){
			if($this->_request->sendmail){
				$this->sendMailMessage($id, 152, $email, 'Pesanan masuk #'.$id) ;
			}
		}
		
		if($status == 'pending'){
			if($this->_request->sendmail){
				$this->sendMailMessage($id, 499, $email,'Pesanan anda #'.$id.' terpending') ;
			}
		}
		
		if($status == 'verifying'){
			if($this->_request->sendmail){
				$this->sendMailMessage($id, 499, $email,'Pembayaran pesanan #'.$id.' sedang kami verifikasi');
			}
		}
		
		if($status == 'paid'){
			$this->updateBooking($id, 0, 'processing');
			$this->sendMailMessage($id, 158, $email,'Pembayaran pesanan #'.$id.' sudah kami terima') ;
		}
		
		if($status == 'on_delivery'){
			if($this->_request->sendmail){
				$this->sendMailMessage($id, 187, $row->email,'order #'.$id.' is on the way') ;
			}
		}
		
		if($status == 'on_cod_delivery'){
			if($this->_request->sendmail){
				$template = $this->email_template($id, 361);
				$this->sendEmail($row->email,'info@toiss.id',$template['content'],'COD Order #'.$id.' is on the way');
			}
		}
		
		if($status == 'complete'){
			if($this->_request->sendmail){
				$this->sendMailMessage($invoice_id, 152, $to, 'Pesanan anda #'.$id.' telah selesai') ;
			}
		}
		
		if($status == 'expired'){
			$this->updateBooking($id, 0, 'expired');
			$this->sendMailMessage($id, 306, $row->email,'Pesanan anda #'.$id.' telah dibatalkan');
		}
		
	}
	
	function sendInfoEmail($prodid, $status){
		if($status = 'confirmed'){
			
		}
	}
	
	function sendMailMessage($orderid, $cid, $to = null, $subject){
		$template = $this->email_template($orderid, $cid);
		$this->sendEmail($to,'info@toiss.id',$template['content'],$subject);
	}
	
	function email_template($orderid = 0, $cid = 0){
		$template = array();
		$order = $this->getOrder($orderid);
		$products = json_decode($order->products);
		$prod_tot = 0;
		
		$product = '<table border="0" class="table table-bordered" style="width: 100%;" cellpadding="0">
		<tbody>
		<tr>
		<td colspan="2" style="color: #ffffff; background: #7EC6BD url("none") repeat scroll 0% 0%;text-align: left; vertical-align: middle;"><span style="font-size: 12px;">&nbsp;Produk</span></td>
		<td style="color: #ffffff; background: #7EC6BD url("none") repeat scroll 0% 0%;text-align: center; vertical-align: middle;"><span style="font-size: 12px;">Harga</span></td>
		</tr>';
		
		foreach($products as $item){
			$thumb = str_replace('_thumb1','_thumb2',$item->thumb);
			$subtotal = (int)$item->count * (int)$item->price;
			$prod_tot = $prod_tot + $subtotal;
			$opt = $this->getProductOption($item->id, 'pr_option', $item->size);
			$product .= '<tr>
			<td><img class="thumbnail" style="width: 50px;height: 50px;" src="'.JURI::base().$item->thumb.'" /></td>
			<td style="font-size: 11px;">
				<strong>'.$item->title.'</strong><br />
				<strong>Delivery Date:</strong> '.JHtml::_('date', $item->deliver).'<br/>
				<strong>Pickup Date:</strong> '.JHtml::_('date', $item->pickup).'<br/>
				<strong>Total Days:</strong> '.$item->duration.'
			</td>
			<td style="text-align: right;"><span style="font-size: 10px;">Rp. '.number_format($subtotal, 0, '', '.').'</span></td>
			</tr>';
			
		}
		
		
		
		if($order->disc_code){
			$disc = $this->getDiscount($order->disc_code, $prod_tot);
			$prod_tot = $disc->total;
			$discount = ' (-'.$disc->discount.'%)';
		}
		
		$shipment = json_decode($order->shipment);
		
		if($shipment->pricing > 100){
			$shipmentTotal = 'Rp '.number_format($shipment->pricing, 0, '', '.');
		}else{
			$shipmentTotal = 'Free';
		}
		
		$resi = $resi = json_decode($order->resi);
	
		
		$product .= '<tr>
								<td colspan="2" style="text-align: left;">
								<span style="font-size: 12px;"><strong>Pengiriman : </strong></span>
								<span style="font-size: 12px;">'.$shipment->address->address.'<br />'.$shipment->address->province.' '.$shipment->address->country.'</span>
								</td>
								<td style="text-align: right; verical-align: top;"><span style="font-size: 12px;">'.$shipmentTotal.'</span></td>
								</tr>
								<tr>
								<td colspan="2" style="text-align: right;"><span style="font-size: 12px;">Grand Total </span></td>
								<td style="text-align: right;"><span style="font-size: 12px;">Rp '.number_format($order->value, 0, '', '.').' </span></td>
								</tr>
								</tbody>
								</table>';
		
		
		
		$var = array(
			'{order_number}' => $order->id,
			'{name}' => $order->name,
			'{date}' => JHTML::_('date', $order->order_date),
			'{email}' => $order->email,
			'{phone}' => $order->user_phone,
			'{user_note}' => $order->usr_note,
			'{product}' => $product,
			'{ship_to}' => $shipment->address->address.' '.$shipment->address->address_opt.'<br />'.$shipment->address->province.' '.$shipment->address->country,
			'{ship_price}' =>'Rp. '. number_format($order->value - $prod_tot, 0, '', '.'),
			'{total_price}' => 'Rp. '.number_format($order->value, 0, '', '.'),
			'{prod_price}' => 'Rp. '.number_format($prod_tot, 0, '', '.').$discount,
			'{confirm_link}' => JURI::base().'payment-confirmation?id='.base64_encode($order->id),
			'{admin_view_button}' => '<a href="'.JURI::base().'administration/store/invoices?invoice='.$order->id.'">View Order</a>',
			'{from_name}' => $order->from_acc,
			'{from_acc}' => $order->from,
			'{to_acc}' => $order->to,
			'{payment_date}' => $order->payment_date,
			'{submit_date}' => $order->submit_date,
			'{payment_amount}' => 'Rp. '. number_format($order->payment_amount, 0, '', '.'),
			'{tracking_code}' => '<a href="'.JURI::base().'transactions?layout=transaction_view&id='.$order->id.'">'.$resi->code.'</a>',
			'{pdf_button}' => '<a href="'.JURI::base().'transactions?layout=transaction_view&format=pdf&id='.base64_encode($order->id).'">Download PDF</a>',
			'{admin_message}' => $this->_request->admin_message
		);
		
		$css = '<style type="text/css">body{font-size:12px;line-height:1.5;color:#333;font-weight:300;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;margin:0;padding:0}p,ul,ol,pre,table,blockquote{margin-bottom:1px}img{vertical-align:middle;border:0}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}p{margin:0 0 15px;padding:0}table{border-spacing:0;border-collapse:collapse}.table{width:100%;max-width:100%;margin-bottom:20px}.table > tbody > tr > td,.table > tbody > tr > th,.table > tfoot > tr > td,.table > tfoot > tr > th,.table > thead > tr > td,.table > thead > tr > th{padding:8px;line-height:1.42857143;vertical-align:top}.table-bordered{border:1px solid #ddd}.table-bordered > tbody > tr > td,.table-bordered > tbody > tr > th,.table-bordered > tfoot > tr > td,.table-bordered > tfoot > tr > th,.table-bordered > thead > tr > td,.table-bordered > thead > tr > th{border:1px solid #ddd}.partition-light-green {background-color: #7ec6bd ;position: relative;color: white;}.panel-pink, .partition-pink {background-color: #fe6b9f;position: relative;color: white;}</style>';
		
		$html = $this->getRawContent($cid);
		$html = str_replace('img src="images','img src="'.JURI::base().'images',$html->wysiwyg_text);
		$html = str_replace('url(\'images/','url(\''.JURI::base().'images/',$html);
		$html = strtr($html, $var);
		$html = '<html><head>'.$css.'</head><body>'.$html.'</body></html>';
		$template['content'] = $html;
		$template['subject'] = $html->title;
		return $template;
	}
	
	function sendEmail($to,$from,$content,$subject)
	{
		global $mainframe;
		$from = $mainframe->getCfg('mailfrom');
		$replyto = $mainframe->getCfg('mailfrom');
		
		$mail =& JFactory::getMailer();
		$mail->isHTML(true);

		$mail->setBody($content); 
		$mail->addReplyTo(array($replyto));
		$mail->setSender($from);
		$mail->setSubject($mainframe->getCfg('sitename').' - '.$subject);
		$mail->addRecipient($to);
		//$mail->setAltBody($content);
		$stat = $mail->Send();
		if($stat != true){
			JFactory::getApplication()->enqueueMessage('Email ERROR!, '.$to.', '.$subject, 'ERROR');
			return false;
		}else{
			//JFactory::getApplication()->enqueueMessage('Email sent, '.$to.', '.$subject);
			return true;
		}
	}
	
	function getCart($format = null){
		$session =& JFactory::getSession();
		$cartItems = $session->get('cart');
		if($format == 'json'){
			return $cartItems;
		}else{
			return (array)json_decode($cartItems);
		}
	}
	
	function addCart($cid = 0,$count = 1, $size = null, $option = null){
		$session =& JFactory::getSession();
		
		$product = $this->getRawContent($cid);
		 
		$cartItems = $this->getCart();
		
		if(!$option){
			$option = $this->_request->opt;
		}
		
		$cur_opt = $this->getProductOption($cid, 'pr_option', $option);
		
		if($cur_opt->pr_opt_price){
			$price = $cur_opt->pr_opt_price;
		}else{
			$price = $product->pr_price;
		}
		
		if(!count($cartItems)){
			$cartItems = array();
			$cartItems[0][id] = $product->id;
			$cartItems[0][count] = $this->_request->count;
			$cartItems[0][title] = htmlspecialchars($product->title);
			$cartItems[0][weight] = $product->pr_weight;
			$cartItems[0][price] = $price;
			$cartItems[0][oldprice] = $product->pr_old_price;
			$cartItems[0][thumb] = $this->getTumbnail($product->imagex);
			if($option){
				$cartItems[0][option] = $option;
			}
			$cartItems[0][deliver] = $this->_request->deliver;
			$cartItems[0][pickup] = date('Y-m-d', strtotime($this->_request->deliver. ' + '.$cur_opt->pr_opt_days.' days'));
			$cartItems[0][duration] = $cur_opt->pr_opt_days;
			$cartItems[0][booking_type] = $this->_request->booking_type;
			
			$cartItems[0][is_free] = $product->pr_shipping;
			$ses = json_encode($cartItems);
			$session->set('cart', $ses);
			return $cartItems;
		}
		
		foreach($cartItems as $key => $cartItem){
			if($cartItem->id == $cid && $cartItem->option == $option){
				$cartItems[$key]->count = (int)$cartItem->count + $this->_request->count;
				$similar = 1;
			}
		}
		if(!$similar){
			$count = count($cartItems);
			$cartItems[$count][id] = $product->id;
			$cartItems[$count][count] = $this->_request->count;
			$cartItems[$count][title] = htmlspecialchars($product->title);
			$cartItems[$count][weight] = $product->pr_weight;
			$cartItems[$count][price] = $price;
			$cartItems[$count][oldprice] = $product->pr_old_price;
			$cartItems[$count][thumb] = $this->getTumbnail($product->imagex);
			if($option){
				$cartItems[$count][option] = $option;
			}
			$cartItems[$count][deliver] = $this->_request->deliver;
			$cartItems[$count][pickup] = date('Y-m-d', strtotime($this->_request->deliver. ' + '.$cur_opt->pr_opt_days.' days'));
			$cartItems[$count][duration] = $cur_opt->pr_opt_days;
			$cartItems[$count][booking_type] = $this->_request->booking_type;
			$cartItems[$count][is_free] = $product->pr_shipping;
		}
		
		$ses = json_encode($cartItems);
		$session->set('cart', $ses);
		
		return $cartItems;
	}
	
	function updateQty($arr = array()){
		
		$session =& JFactory::getSession();
		$cartItems = $this->getCart();
		
		$sizes = JRequest::getVar('size');
		$i = 0;
		
		foreach($cartItems as $key => $cartItem){
			$cartItem->size = $sizes[$i];
			$i++; 
		}
		
		foreach($arr as $id => $count){
			
			foreach($cartItems as $key => $cartItem){
				if($cartItem->id == $id){
					$cartItem->count = $count;
					$cartItems = array_values($cartItems);
				}
				
			}
		}
		$ses = json_encode($cartItems);
		$session->set('cart', $ses);
		return $count;
	}
	
	function delCartItem($cid){
		$session =& JFactory::getSession();
		$cartItems = $this->getCart();
		
		foreach($cartItems as $key => $cartItem){
			if($cartItem->id == $cid){
				unset($cartItems[$key]);
				$cartItems = array_values($cartItems);
			}
		}
		
		$ses = json_encode($cartItems);
		$session->set('cart', $ses);
		
		return $cartItems;
	}
	
	function clearCart(){
		$session =& JFactory::getSession();
		$session->set('cart', '');
	}
	
	function getTumbnail($images = null){
		preg_match('#\|\|imagex\|\|(.*?)\|\|/imagex\|\|#s',$images, $match);
		if(count($match) > 1){
			$image = explode('/',$match[1]);
		}else{
			$image = explode('/',$images);
		}
		return $image[0].'/'.$image[1].'/'.$image[2].'/_thumb1/'.$image[3];
	}
	
	function getContent($cid, $jSeblod_template = 'default_content')
	    {
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__content WHERE id = ".$cid;
		$db->setQuery($query);
		$result = $db->loadObject();
		$result = $result;
		
		
		$dispatcher	=& JDispatcher::getInstance();
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		JPluginHelper::importPlugin('content');
				
		$result->text = $result->introtext;
		$result->jSeblod_template = $jSeblod_template;
		$result->event = new stdClass ();
		
		$results = $dispatcher->trigger('onPrepareContent', array ( & $result, & $parameters, $limitstart));
		
		$results = $dispatcher->trigger('onAfterDisplayTitle', array ($result, & $parameters, $limitstart));
		
		$result->event->afterDisplayTitle = trim(implode("\n", $results));
		
		$result->event->beforeDisplayContent = trim(implode("\n", $results));
		$results = $dispatcher->trigger('onAfterDisplayContent', array ( & $result, & $parameters, $limitstart));
		$result->event->afterDisplayContent = trim(implode("\n", $results));
					
		$result->introtext = $result->text;
		$result->text = str_ireplace("<script>", "&lt;script&gt;", $result->text);
		
		return $result;
		
    }

	function getRawContent($cid = null)
    {
		if($cid == null){
			return 'Content not found!';
		}
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__content WHERE id = ".$cid;
		$db->setQuery($query);
		$result = $db->loadObject();
		$error = $db->getErrorMsg();
		
		if($error){
			return $error;
		}
		$group	=	array();
		$regex	=	'#::(.*?)::(.*?)::/(.*?)::#s';
		preg_match_all( $regex, $result->introtext, $matches );
		
		if ( sizeof( $matches[1] ) ) {
			foreach ( $matches[1] as $key => $val ) {
				$gmatch = explode('|', $val);
				if(count($gmatch) > 1){
					$gkey = $gmatch[1];
					$iname = $gmatch[0];
					$gname = $gmatch[2];
					$group[$gkey][$iname] = $matches[2][$key];
					$res[$gname] = $group;
				}else{
					$res[$val]	=	$matches[2][$key];
				}
			}
		}
		$res = (object) $res;
		$res->id = $cid;
		$res->stock = $result->stock;
		$res->title = $result->title;
		return $res;
  }
	
	function getProductOption($id = 0, $key = null, $val = null){
		$db 	=& JFactory::getDBO();
		$query	= 'SELECT options FROM #__content WHERE id = '.$id;
		$db->setQuery($query);
		$opt = $db->loadResult();
		$options = json_decode($opt);
		if($key == 'option_label'){
			$raw = $this->getRawContent($id);
			return $raw->pr_opt_label;
		}
		if($key == null && $val == null){
			return $options;
		}else{
			foreach($options as $opt){
				if($opt->$key == $val){
					$result = $opt;
					break;
				}
			}
			return $result;
		}
	}
	
	function getEdit($id = null, $contentType = null){
		$user = JFactory::getUser();
		if($user->usertype != 'Super Administrator'){
			return false;
		}
		if($id){
			
			$db 	=& JFactory::getDBO();
			$query	= 'SELECT id FROM #__jseblod_cck_types WHERE name = "'.$contentType.'"';
			$db->setQuery($query);
			$contentTypeId = $db->loadResult();
			//return $contentType;
			return '<a class="btn btn-xs btn-red btn-edit" href="'.JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$contentTypeId.'&cckid='.$id ).'" >edit</a>';
		}
	}
	
	function getArticleLink($cid){
		require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
		jimport('joomla.application.component.helper');
		$db = JFactory::getDBO();
		$query = "SELECT id, alias, sectionid, catid FROM #__content WHERE id = ".$cid;
		$db->setQuery($query);
		$result = $db->loadObject();
		return JRoute::_( ContentHelperRoute::getArticleRoute($result->id.':'.$result->alias, $result->catid, $result->sectionid));
	}
	
	function redirect($cid = null, $url = null, $message = null, $msgType = null, $order_id = null){
		global $mainframe;
		if($cid){
			require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
			jimport('joomla.application.component.helper');
			$url = JRoute::_( ContentHelperRoute::getArticleRoute($cid));
			if($order_id){
				$url .= '?order_id='.$order_id;
			}
		}
		
		JFactory::getApplication()->redirect($url, $message = null, $msgType = null, true);
	}
	
	
function getCountry($keyword = null){
	$db = JFactory::getDBO();
	$query = "SELECT country_id AS id, short_name AS text FROM #__country WHERE short_name LIKE '%".$keyword."%'";
	$db->setQuery($query, 0, 100);
	$result = $db->loadObjectList();
	if($db->getErrorMsg()){
		die($error);
	}
	return $result;
}

function getLocalProvince($keyword = null){
	$db = JFactory::getDBO();
	$query = "SELECT kota AS id, kota AS text FROM #__jne WHERE cod > 0 AND kota LIKE '%".$keyword."%' GROUP BY kota";
	$db->setQuery($query);
	$result = $db->loadObjectList();
	if($db->getErrorMsg()){
		die($error);
	}
	return $result;
}

function getLocalDistrict($kota = null){
	$db = JFactory::getDBO();
	$query = "SELECT id, cod, kecamatan AS text FROM #__jne WHERE kota = '$kota' AND cod != 0";
	$db->setQuery($query);
	$result = $db->loadObjectList();
	if($db->getErrorMsg()){
		die($error);
	}
	if($result){
		foreach($result as $res){
			$res->text = $res->text.' - Rp. '.number_format($res->cod, 0, '', '.');
		}
	}
	return $result;
}

function getIdFromRajaOngkir($kota = null, $kecamatan = null, $country = null){
	$couriers = explode(',','jne,jnt,pos');
	
	if($country){
		$countries = json_decode(rajaOngkir::internationalDestination());
	}
	
	
	$cities = json_decode(rajaOngkir::city());
	$cities = $cities->rajaongkir->results;

	if(strpos($kota, 'Kab.') !== false) {
		$city_name = str_replace('Kab. ','', $kota);
		$type = 'Kabupaten';
	}else{
		$city_name = str_replace('Kota ','', $kota);
		$city_name = str_replace('Administrasi ','', $city_name);
    $type = 'Kota';
	}
	if(count($cities)){
		foreach($cities as $city){
			if($city->type == $type  && $city->city_name == $city_name){
				$city_id = $city->city_id;
				break;
			}
		}
	}
	$subdistricts = json_decode(rajaOngkir::subdistrict($city_id));
	$subdistricts = $subdistricts->rajaongkir->results;
	if(count($subdistricts)){
		foreach($subdistricts as $district){
			if($district->city == $city_name && $district->subdistrict_name == $kecamatan){
				$subdistrict_id = $district->subdistrict_id;
				break;
			}
		}
	}
	if($subdistrict_id){
		$destination = $subdistrict_id;
		$destination_type = 'subdistrict';
	}else{
		$destination = $city_id;
		$destination_type = 'city';
	}

	$res = rajaOngkir::cost(153 , 'city', $destination, $destination_type, 1000, implode(':',$couriers));
		if($res){
			$res = json_decode($res);
			
			$res = $res->rajaongkir->results;
			if($res){
				$results = $res;
			}
		}
	
	return $results;
}


function getShippingOption($id = 0, $country = 999){
	
	return  $this->getRentalShipping($id);
	
	$services = array();
	$db = JFactory::getDBO();
	if($country == 103 || $country == 999){
		$query = "SELECT reg AS regular, yes AS express, kota, kecamatan FROM #__jne WHERE id = ".(int)$id;
		$db->setQuery($query);
		$result = $db->loadObject();
		if($db->getErrorMsg()){
			die($error);
		}
		$services = $this->getIdFromRajaOngkir($result->kota, $result->kecamatan, $result->country);
	}else{ 
		$res = rajaOngkir::internationalCost(153, $country, 1000, 'jne');

		if($res){
			$res = json_decode($res);
			$country_name = $res->rajaongkir->destination_details->country_name;
			$currency = $res->rajaongkir->currency->value;
			$res = $res->rajaongkir->results;
			if($res){
				$country_name_helper = '<input type="hidden" name="address[country_name]" value="'.$country_name.'" />';
				$services = $res;
			}
		}
	}
	$cart = $this->getCart();
	
	$weight = 0;
	foreach($cart as $itm){
		$weight += $itm->weight;
	}
	
	$html = '';
	
	foreach($services as $service){
		if(!$service->costs[0]){
			continue;
		}
		$html .= '<div class="list-group"><div class="row gutter-10 list-group-item no-margin text-extra-small text-w-500"><div class="col-xs-6">'.$service->name.'</div><div class="col-xs-2">Price/Kg</div><div class="col-xs-2 text-center">Total Weight</div><div class="col-xs-2 text-right">Shipping Cost</div></div>';
		
		foreach($service->costs as $key => $item){
			
			if(strpos($item->description, 'Trucking') !== false) {
				continue;
			}
			if(strpos($item->description, 'Dokumen') !== false) {
				continue;
			}
			if(strpos($item->description, 'Surat') !== false) {
				continue;
			}
			if(strpos($item->description, 'Unknown') !== false) {
				continue;
			}
			
			if($item->service == $item->description || $item->description == false){
				$desc = $item->service;
			}else{
				$desc = $item->service.' - '.$item->description;
			}
			
			if($item->currency === 'USD'){
				$pricing = $item->cost * $currency;
			}else{
				$pricing = $item->cost[0]->value;
			}
			
			//echo'<pre>';print_r($item);echo'</pre>';
			
			
			$price = 'Rp. '.number_format($pricing, 0, '', '.');
			$tot = $pricing * ceil($weight);
			$total = 'Rp. '.number_format($tot, 0, '', '.');
			
			if(trim($item->cost[0]->etd)){
				$etd = 'Est '.$item->cost[0]->etd.' day';
			}elseif(trim($item->etd)){
				$etd = 'Est '.$item->etd.' day';
			}else{
				$etd = '';
			}
			
			$item->opt = $service->code.'|'.$item->service.'|'.$item->description.'|'.$pricing;
			
			$html .= '<label class="row gutter-10 list-group-item no-margin"><div class="col-xs-6"><div class="checkbox-inline no-margin"><input type="radio" name="service" value="'.$item->opt.'" data-total="'.$tot.'" /><div class="pull-left"><img src="'.JURI::base().'images/'.$service->code.'.jpg" /></div><div class="media-body p-l-10">'.$desc.'<br />'.$etd.' </div></div></div><div class="col-xs-2">'.$price.'</div><div class="col-xs-2 text-center">'.$weight.' Kg</div><div class="col-xs-2 text-right">'.$total.'</div></label>';
		}
		$html .= '</div>';
	}
	
	
	
	if(!trim($html)){
		//return '<div class="alert alert-danger"><div class="notification">Sorry.. we doesn\'t support your shipping location </div></div>';
	}else{
		//return $html.$country_name_helper;
	}
	
}

function getRentalShipping($id, $result_type = null){
	if(!$id){
		if($result_type == 'data'){
			$data = new stdClass();
			$data->html_content = '<div class="col-xs-12 text-right shipping-cost purple" style="margin-top: -25px;" data-shipping-cost="0"></div>';
			$data->total = 0;
			return $data;
		}else{
			return '<div class="col-xs-12 text-right shipping-cost purple" style="margin-top: -25px;" data-shipping-cost="0"></div>';
		}
	}
	$db = JFactory::getDBO();
	$query = "SELECT cod FROM #__jne WHERE id = ".(int)$id;
	$db->setQuery($query);
	$cost = $db->loadResult();
	if($db->getErrorMsg()){
		die($error);
	}
	if(!$cost){
		if($result_type == 'data'){
			$data = new stdClass();
			$data->html_content = '';
			$data->total = 0;
			return $data;
		}else{
			return '';
		}
	}
	
	
	$cost = $cost/2;
	$cart = $this->getCart();
	$deliverAndPickup = array();
	$deliverAndPickup_list = '<ul class="p-l-15 p-t-0" style="margin-bottom: 5px;">';
	$deliver = array();
	$deliver_list = '<ul class="p-l-15 p-t-0" style="margin-bottom: 5px;">';
	$pickup = array();
	$pickup_list = '<ul class="p-l-15 p-t-0" style="margin-bottom: 5px;">';
	$deliver_cost = $pickup_cost = $deliverAndPickup_cost = 0;
	if($cart){
		foreach($cart as $item){
			if(in_array($item->deliver, $pickup) || in_array($item->pickup, $deliver)){
				$deliverAndPickup[] = $item->deliver;
				$deliverAndPickup_list .= '<li>'.JHtml::_('date',$item->deliver).'</li>';
				$deliverAndPickup_cost += $cost;
			}else{
				if(!in_array($item->deliver, $deliver)){
					$deliver[] = $item->deliver;
					$deliver_list .= '<li>'.JHtml::_('date',$item->deliver).'</li>';
					$deliver_cost += $cost;
				}
				if(!in_array($item->pickup, $pickup)){
					$pickup[] = $item->pickup;
					$pickup_list .= '<li>'.JHtml::_('date',$item->pickup).'</li>';
					$pickup_cost += $cost;
				}
			}
		}
		$deliverAndPickup_list .= '</ul>';
		$deliver_list .= '</ul>';
		$pickup_list .= '</ul>';
		$total_cost = $deliverAndPickup_cost + $pickup_cost + $deliver_cost;
		$html = '';
		if(count($deliver)){
			$html .= count($deliver).'x Delivery Rp. '.number_format($deliver_cost, 0, '', '.').$deliver_list;
		}
		if(count($pickup)){
			$html .= count($pickup).'x Pickup Rp. '.number_format($pickup_cost, 0, '', '.').$pickup_list;
		}
		if(count($deliverAndPickup)){
			$html .= count($deliverAndPickup).'x Delivery & Pickup Rp. '.number_format($deliver_cost, 0, '', '.').$deliverAndPickup_list;
		}
		
		$html_content = '<div class="col-xs-12"><div class="border-bottom border-dark p-t-15 m-b-15"></div></div><div class="col-xs-12"><div class="m-b-5 purple">Shipping Cost</div><div class="text-small m-l-5">'.$html.'</div></div><div class="col-xs-12 text-right shipping-cost purple" style="text-align: right;" data-shipping-cost="'.$total_cost.'">Rp. '.number_format($total_cost, 0, '', '.').'</div>';
		
		if($result_type == 'data'){
			$data = new stdClass();
			$data->pickup = $deliver;
			$data->html_content = $html_content;
			$data->total = $total_cost;
			return $data;
		}else{
			return $html_content;
		}
	}
}

function getShippingTracking($waybill_number = false, $courier = false){
	if($waybill_number == false && $courier == false){
		return false;
	}
	$result = json_decode(rajaOngkir::waybill($waybill_number, $courier));
	return $result->rajaongkir->result;
}

function getUsers($username){
	$db = JFactory::getDBO();
	$query = "SELECT id, CONCAT(name, ' - ', email) AS text FROM #__users WHERE name LIKE '%".$username."%'";
	$db->setQuery($query, 0, 30);
	$users = $db->loadObjectList();
	$error = $db->getErrorMsg();
	if($error){
		die($error);
	}
	$users[] = (object) array('id' => $this->_data->user->id, 'text' => 'Use another user');
	return $users;
}

function blastNewSite(){
	$db = JFactory::getDBO();
	//$query = "SELECT name, email, activation FROM #__users WHERE lastvisitDate = '2017-09-22 22:22:50'";
	$query = "SELECT name, email, activation FROM #__users";
	$db->setQuery($query, 0, 1);
	$users = $db->loadObjectList();
	$css = '<style type="text/css">body{font-family:arial;font-size:12px;line-height:1.5;color:#333;font-weight:300;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;margin:0;padding:0}p,ul,ol,pre,table,blockquote{margin-bottom:1px}img{vertical-align:middle;border:0}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}p{margin:0 0 15px;padding:0}table{border-spacing:0;border-collapse:collapse}.table{width:100%;max-width:100%;margin-bottom:20px}.table > tbody > tr > td,.table > tbody > tr > th,.table > tfoot > tr > td,.table > tfoot > tr > th,.table > thead > tr > td,.table > thead > tr > th{padding:8px;line-height:1.42857143;vertical-align:top}.table-bordered{border:1px solid #ddd}.table-bordered > tbody > tr > td,.table-bordered > tbody > tr > th,.table-bordered > tfoot > tr > td,.table-bordered > tfoot > tr > th,.table-bordered > thead > tr > td,.table-bordered > thead > tr > th{border:1px solid #ddd}.partition-light-green {background-color: #7ec6bd ;position: relative;color: white;}.panel-pink, .partition-pink {background-color: #fe6b9f;position: relative;color: white;}</style>';
		
	$html = $this->getRawContent(631);
	$html = str_replace('img src="images','img src="'.JURI::base().'images',$html->wysiwyg_text);
	$html = str_replace('url(\'images/','url(\''.JURI::base().'images/',$html);
	

	foreach($users as $user){
		$var = array(
			'{password}' => $user->activation,
			'{name}' => $user->name,
			'{forgot-pass}' => '<a href="http://toiss.id/forgot-pass" style="color: #00ccff;">forgot password</a>',
			'{my-account}' => '<a href="http://toiss.id/my-account" style="color: #00ccff;">my account menu</a>',
			);
		$html = strtr($html, $var);
		$html = '<html><head>'.$css.'</head><body>'.$html.'</body></html>';
		$this->sendEmail($user->email,'info@toiss.id',$html,'New and refreshed website');
		print_r($html);die();
	}

}

function saveBase64Image($imgData = null, $dir = null, $filename = null){
	jimport('joomla.filesystem.file');
	if(!$imgData){
		die('no image data');
	}
	$image_parts = explode(";base64,", $imgData);
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = $image_type_aux[1];
	$image_base64 = base64_decode($image_parts[1]);
	
	$file = $dir . $filename;
	JFile::write($file, $image_base64);
}

function getUser($userid){
	$db = JFactory::getDBO();
	$query = "SELECT * FROM #__users WHERE id = $userid";
	$db->setQuery($query);
	$user = $db->loadObject();
	$error = $db->getErrorMsg();
	if($error){
		die($error);
	}
	$user->address = json_decode($user->address);
	return $user;
}

	
}

?>