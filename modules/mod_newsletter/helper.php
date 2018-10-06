<?php
/**
* @package		JJ Module Generator
* @author		JoomJunk
* @copyright	Copyright (C) 2011 - 2012 JoomJunk. All Rights Reserved
* @license		http://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$email = JRequest::getVar('email');
$nl = JRequest::getVar('newsletter');
$ajax = JRequest::getVar('ajax');
$promo = JRequest::getVar('promo_id', 0);
$name = JRequest::getVar('name','');

if($nl == 1){
	$db = JFactory::getDBO();
	$query = "SELECT email FROM #__newsletter WHERE email = '".$email."'";
	$db->setQuery($query);
	$exist = count($db->loadObjectList());
	$secret = strtr(base64_encode($email), '+/=', '-_,');
	//$secret = base64_decode(strtr( $string , '-_,', '+/='));
	if($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if($exist == 0){
				$query = "INSERT INTO #__newsletter (email,type,secret,promo_id,full_name,status) VALUES ('$email','nw','$secret','$promo','$name',1)";
				$db->setQuery($query);
				$db->query();
				$respons =  'OK';
			}else{
				$respons = JText::_('EMAIL ALREADY REGISTERED.');
			}
		}else{
			 $respons = JText::_('INVALID EMAIL');
		}
	}else{
		$respons = JText::_('ENTER EMAIL');
	}
}else{
	$respons = '';
}
if($ajax){
	echo '<div id="respond">'.$respons.'</div>';
	die();
}

?>