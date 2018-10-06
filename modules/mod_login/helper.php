<?php
/**
* @version		$Id: helper.php 15198 2010-03-05 09:06:05Z ian $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modLoginHelper
{
	function getReturnURL($params, $type)
	{
		
			// stay on the same page
			$uri = JFactory::getURI();
			$url = $uri->toString(array('path', 'query', 'fragment'));

		return base64_encode($url);
	}

	function getType()
	{
		$user = & JFactory::getUser();
		return (!$user->get('guest')) ? 'logout' : 'login';
	}
	
	function getTransactionCount(){
		$db = JFactory::getDBO();
		$user = & JFactory::getUser();
		$query = 	"SELECT COUNT(id) AS count FROM #__cart_order WHERE user=".$user->id;
		$db->setQuery($query);
		$result = $db->loadResult();
		if(!$result){
			$result = 0;
		}
		return $result;
	}
	
	function getRentedProducts($userid = 0){
		$user	= JFactory::getUser();
		
		if(!$userid){
			$userid = $user->id;
		}
		$db = JFactory::getDBO();
		$query = 	"SELECT COUNT(b.id) AS countc FROM #__cart_order AS a".
							" INNER JOIN #__booking AS b ON b.order_id = a.id".
							" LEFT JOIN #__content AS c ON c.id = b.product_id".
							" WHERE a.user = ".$userid." AND a.status = 'paid'".
							" AND b.pickup >= CURDATE()";
		$db->setQuery($query);
		$result = $db->loadResult();
		$error = $db->getErrorMsg();
		if($error){
			JFactory::getApplication()->enqueueMessage('DB Query ERROR!, '.$error, 'ERROR');
		}
		return $result;
	}
}
