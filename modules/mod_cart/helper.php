<?php
/**
* @package		JJ Module Generator
* @author		JoomJunk
* @copyright	Copyright (C) 2011 - 2012 JoomJunk. All Rights Reserved
* @license		http://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

function getCart(){
	$session =& JFactory::getSession();
	$cartItems = $session->get('cart');

	if($cartItems){
		return json_decode($cartItems);
	}else{
		return 0;
	}
}
function getProductOption($id = 0, $key = null, $val = null){
		$db 	= JFactory::getDBO();
		$query	= 'SELECT options FROM #__content WHERE id = '.$id;
		$db->setQuery($query);
		$opt = $db->loadResult();
		$options = json_decode($opt);
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
function getArticleLink($cid){
	require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
	jimport('joomla.application.component.helper');
	$db = JFactory::getDBO();
	$query = "SELECT id, sectionid, catid FROM #__content WHERE id = ".$cid;
	$db->setQuery($query);
	$result = $db->loadObject();
	return JRoute::_( ContentHelperRoute::getArticleRoute($result->id, $result->catid, $result->sectionid));
}

?>