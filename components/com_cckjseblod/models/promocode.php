<?php 

/**
 * Joomla! 1.5 component myextension
 * Code generated by : Danny's Joomla! 1.5 MVC Component Code Generator (v 0.7 beta )
 * http://www.joomlafreak.be
 * date generated:  
 * @package myextension
 * @license GNU Public License (because open source matters...)
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.model');

class CCKjSeblodModelPromocode extends JModel{
	
	var $_request;
	
	function __construct(){
		parent::__construct();
		global $mainframe;
		$this->_request		=	(object)JRequest::get('default');
		if($this->_request->task == 'savecode'){
			$this->saveCode();
		}
		if($this->_request->delcode){
			$user = &JFactory::getUser();
			if($user->usertype != 'Super Administrator'){
				JFactory::getApplication()->redirect(JURI::current(), 'Restricted!, Admin only', 'error', true);
				return;
			}else{
				$resp = $this->delPromoCode($this->_request->delcode);
				JFactory::getApplication()->redirect(JURI::current(), $resp, 'message', true);
			}
			
		}
		
	}
	
	function validateCode($code = null){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__promo_code WHERE code = '".$code."'";
		$db->setQuery($query);
		$result = new stdClass();
		$result = $db->loadObject();
		
		$error = $db->getErrorMsg();
		if($error){
			die($error);
		}
		if($result->id){
			
			if($result->rule == 'onetime' && $result->use_count >= 1){
				$result->error = 1;
				$result->text = 'Code expired!';
				return $result;
			}
			
			$cart_items = $this->getCart();
			
			if($result->product_id > 0){
				
				
				if($cart_items){
					foreach($cart_items as $item){
						if($item->id == $result->product_id){
							$result->price = $item->price;
							$found = true;
							break;
						}
					}
					if(!$found){
						$result->error = 1;
						$result->text = 'Product unmatch!';
						return $result;
					}
				}
			}else{
				$carttotal = 0;
				
				foreach($cart_items as $item){
					$carttotal += $item->price;
				}
				$item->price = $carttotal;
			}
			
			if($result->type == 'amount'){
				$result->text = 'Rp. '.$result->value;
			}else{
				$result->value = $item->price * ($result->value / 100);
				$result->text = 'Rp. '.$result->value;
			}
			
		}else{
			$result = new stdClass();
			$result->error = 1;
			$result->text = 'Not found!';
			return $result;
		}

		return $result;
	}
	
	function delPromoCode($id){
		$db = JFactory::getDBO();
		$query = "SELECT used_by FROM #__promo_code WHERE id = ".$id;
		$db->setQuery($query);
		$result = $db->loadResult();
		if($result){
			return 'The discount code already used!';
		}else{
			$query = "DELETE FROM #__promo_code WHERE id = ".$id;
			$db->setQuery($query);
			$db->query();
			return 'The discount code deleted';
		}
	}

	function getPromocode($code = null){
		global $mainframe;
		$user = &JFactory::getUser();
		$promo = new stdClass();
		
		if($user->usertype != 'Super Administrator'){
			return 'Restricted!, Admin only';
		}
		
			
		$db = JFactory::getDBO();
		
		if($this->_request->code){
			$query = "SELECT a.*, b.title AS product FROM #__promo_code AS a LEFT JOIN #__content AS b ON b.id = a.product_id WHERE code = '".$code."'" ;
			$db->setQuery($query);
			$promo->result = $db->loadObjectList();
		}else{
			$query = "SELECT a.*, b.title AS product FROM #__promo_code AS a LEFT JOIN #__content AS b ON b.id = a.product_id" ;
			$db->setQuery($query);
			$promo->result = $db->loadObject();
		}

		$db->setQuery($query);
		$promo->result = $db->loadObjectList();
		
		if($error){
			die($error);
		}
		return $promo;
	}
	
	function saveCode(){
		
		global $mainframe;
		$value = JRequest::getInt('value',0);
		$type = JRequest::getVar('type','percent');
		$rule = JRequest::getVar('rule','unlimited');
		$max_usage = JRequest::getInt('max_usage',1);
		$product_id = JRequest::getInt('product_id',0);
		$owner = JRequest::getVar('owner');
		$email_desc = JRequest::getVar('email_desc');
		
		if(!$value){
			JFactory::getApplication()->enqueueMessage('Please set the discount value', 'ERROR');
			return false;
		}
		
		if(trim(JRequest::getVar('code'))){
			$code = trim(JRequest::getVar('code'));
		}else{
			$code = substr(md5(microtime()),rand(0,26),6);
		}
		
		$user = &JFactory::getUser();
		if($user->usertype != 'Super Administrator'){
			return 'You are not authorize!';
		}
		$db = JFactory::getDBO();

		$exist = $this->getPromocode($code);
		if($exist->code){
			JFactory::getApplication()->enqueueMessage('Code already exist!', 'ERROR');
			return false;
		}
		
		$query = "INSERT INTO #__promo_code (code,value,type,rule,owner,max_usage,product_id)
					VALUES ('$code','$value','$type','$rule','$owner','$max_usage','$product_id')";		

		$db->setQuery($query);
		$db->query();
		
		$error = $db->getErrorMsg();
		if($error){
			JFactory::getApplication()->enqueueMessage($error, 'ERROR');
			return false;
		}else{
			if($type == 'amount'){
				$amount = 'Rp. ';
			}else{
				$percent = '%';
			}
			$var = array(
				'{discount_value}' => $amount.$value.$percent,
				'{discount_code}' => $code,
				'{product}' => $product,
				'{description}' => $email_desc
			);
			if($owner){
				$content = $this->email_template(362, $var);
				$this->sendEmail($owner,'',$content,'A discount code for you.');
				JFactory::getApplication()->redirect(JRequest::getVar('return_url'), 'Promo code created and sent to '.$owner, 'success', true);
			}else{
				JFactory::getApplication()->redirect(JRequest::getVar('return_url'), 'Promo code created.', 'success', true);
			}
		}
	}

	function email_template($cid = 0, $var = array()){
		$html = $this->getRawContent($cid);
		jimport('joomla.filesystem.file');
		$cssuri = JPATH_BASE.DS.'templates'.DS.'blank_j15'.DS.'css'.DS.'email.css';
		if(JFile::exists($cssuri)){
			$emailcss = JFile::read($cssuri);
		}
		$css = '<style type="text/css">'.$emailcss.'</style>';
		
		$html = $this->getRawContent($cid);
		$html = str_replace('img src="images','img src="'.JURI::base().'images',$html->wysiwyg_text);
		$html = str_replace('url(\'images/','url(\''.JURI::base().'images/',$html);
		$html = strtr($html, $var);
		$html = '<html><body>'.$css.$html.'</body></html>';
		return $html;
	}
	
	function sendEmail($to,$from,$content,$subject)
	{
		global $mainframe;
		$from = $mainframe->getCfg('mailfrom');
		$mail =& JFactory::getMailer();
		$replyto = $from;
		$mail->isHTML(true);

		$mail->setBody($content); 
		$mail->addReplyTo(array($replyto));
		$mail->setSender($from);
		$mail->setSubject($subject);
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
	
	function getCart(){
		$session =& JFactory::getSession();
		$cartItems = $session->get('cart');
		return json_decode($cartItems);
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

		return $res;
  }

}