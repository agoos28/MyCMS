<?php
/**
* @version		$Id: helper.php 14401 2010-01-26 14:10:00Z louis $
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

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modPagebannerHelper
{
	var $cid = null;
	function getItem()
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$menu = & JSite::getMenu();
		$menuid = $menu->getActive();
		
		$menuid = '::sb_attach_menu::'.$menuid->id.'::/sb_attach_menu::';
		
		$query = "SELECT id, introtext FROM #__content" .
			" WHERE introtext LIKE '%".$menuid."%'" .
			" AND catid = 51";
		$db->setQuery($query, 0, 1);
		$result = $db->loadObject();
		
		$option = JRequest::getVar('option');
		$view = JRequest::getVar('view');
		$temp = JRequest::getString('id');
		$temp = explode(':', $temp);
		$id = $temp[0];
		
		if ($option == 'com_content' && $id != 0 && count((array)$result) == 0){
			if ($view == 'category'){      
				$catid = '::sb_attach_category::'.$id.'::/sb_attach_category::';
		  	}
			if ($view == 'article'){      
				$db->setQuery('SELECT catid FROM #__content WHERE id='.$id);   
				$result = $db->loadResult();
				if($result){
					$catid = '::sb_attach_category::'.$result.'::/sb_attach_category::';
				}
		  	}
			if($catid){
				$query = "SELECT id, introtext FROM #__content" .
				" WHERE introtext LIKE '%".$catid."%'" .
				" AND catid = 51";
				$db->setQuery($query, 0, 1);
				$result = $db->loadObject();
			}else{
				return false;
			}
		}
		if (JRequest::getVar('layout') == 'form'){   
			$query = "SELECT id, introtext FROM #__content" .
			" WHERE id = ".(int) JRequest::getVar('cckid');
			" AND catid = 51";
			$db->setQuery($query, 0, 1);
			$result = $db->loadObject();
		}
			
		$error = $db->getErrorMsg();
		if($error){
			die($error);
		}
		$this->cid = $result->id;
		$result = modPagebannerHelper::getRawContent($result->introtext);
		
		//echo'<pre>';print_r($result);die();
		
		return $result;
	}
	
	
	function getViewdesc(){
		
		return modPagebannerHelper::getItem();
      
	}
	
	function getEdit($contentType = null){
		$user = JFactory::getUser();
		if($user->usertype != 'Super Administrator'){
			return false;
		}
			$db 	=& JFactory::getDBO();
			$query	= 'SELECT id FROM #__jseblod_cck_types WHERE name = "'.$contentType.'"';
			$db->setQuery($query);
			$contentTypeId = $db->loadResult();
			//return $contentType;
			return '<a class="btn btn-xs btn-red btn-edit" href="'.JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$contentTypeId.'&cckid='.$this->cid ).'" >edit</a>';
	}
	
	function getRawContent($text = null)
    {	
		$res	=	array();
		$group	=	array();
		$regex	=	'#::(.*?)::(.*?)::/(.*?)::#s';
		$i = 0;
		preg_match_all( $regex, $text, $matches );
		
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
		$res = (object)$res;
		$res->editlink = modPagebannerHelper::getEdit($res->jseblod);
		return $res;
    }
}
