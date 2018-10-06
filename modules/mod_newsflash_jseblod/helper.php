<?php
/**
* @version		$Id: helper.php 10868 2008-08-30 07:22:26Z willebil $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
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

class modNewsFlashjSeblodHelper
{
	function getRawContent($text = null)
    {	
		$res	=	array();
		$group	=	array();
		$regex	=	'#::(.*?)::(.*?)::/(.*?)::#s';
		$regexItemX =	'#\|\|'.$item->name.'\|\|(.*?)\|\|/'.$item->name.'\|\|#s';
					
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
					$regX =	'#\|\|'.$val.'\|\|(.*?)\|\|/'.$val.'\|\|#s';
					preg_match_all( $regX, $matches[2][$key], $xitem );
					if(count($xitem[1])){
						$res[$val]	= $xitem[1];
					}else{
						$res[$val]	=	$matches[2][$key];
					}
				}
			}
		}
		return (object)$res;
  }
	function CONTENT_getXValues($text = null, $fieldname )
    {	
		$gcount = CCK::CONTENT_getValue( $text, $fieldname );
		preg_match_all( CCK::CONTENT_getRegex(), $group, $matches );
		
		$res	=	'#::'.$fieldname.'\|'.$gx.'\|'.$groupname.'::'.$value.'::/'.$fieldname.'\|'.$gx.'\|'.$groupname.'::#s';
		
		$val = array();
		
		for($i=0; $i < $gcount; $i++){
			$regxx = '#::(.*?)\|'.$i.'\|pr_options::(.*?)::/(.*?)\|'.$i.'\|pr_options::#s';
			preg_match_all( $regxx, $text, $matchesx );
			$gxcount = count($matchesx[3]);
			$valx = array();
			for($ii=0; $ii < $gxcount; $ii++){
				$key = $matchesx[3][$ii];
				$value = $matchesx[2][$ii];
				$valx[$key] = $value;
				//$valx = $matchesx[$i][$ii];
			}
			$val[$i] = (object)$valx;
		}
		
		return $val;
    }
	
	function getEdit($id = null, $contentType = null){
		$user = JFactory::getUser();
		if($user->usertype == 'Super Administrator'){
			if($id){
			
				$db 	=& JFactory::getDBO();
				$query	= 'SELECT id FROM #__jseblod_cck_types WHERE name = "'.$contentType.'"';
				$db->setQuery($query);
				$contentTypeId = $db->loadResult();
				//return $contentType;
				return '<a class="btn btn-xs btn-red btn-edit" href="'.JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$contentTypeId.'&cckid='.$id ).'" >edit</a>';
			}
		}else{
			return false;
		}
		
	}
	
	function truncate($string,$length=100,$append="&hellip;") {
	  $string = trim($string);
	
	  if(strlen($string) > $length) {
		$string = wordwrap($string, $length);
		$string = explode("\n", $string, 2);
		$string = $string[0] . $append;
	  }
	
	  return $string;
	}
	function renderItem(&$item, &$params, &$access)
	{
		global $mainframe;

		$user 	=& JFactory::getUser();
		if(!is_object($item)){
			$item = new stdClass();
		}
		$item->text 	= $item->introtext;
		$item->groups 	= '';
		$item->readmore = (trim($item->fulltext) != '');
		$item->rawcontent = modNewsFlashjSeblodHelper::getRawContent($item->text);
		$item->editlink = modNewsFlashjSeblodHelper::getEdit($item->id,$item->rawcontent->jseblod);
		if ($params->get('readmore') || $params->get('link_titles'))
		{
			if ($params->get('intro_only'))
			{
				// Check to see if the user has access to view the full article
				if ($item->access <= $user->get('aid', 0)) {
					$item->linkOn = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid));
					$item->editlink = modNewsFlashjSeblodHelper::getEdit($item->id,$item->rawcontent->jseblod);
					
					$item->linkText = JText::_('Read more text');
				} else {
					$item->linkOn = JRoute::_('index.php?option=com_user&view=login');
					$item->linkText = JText::_('Login To Read More');
				}
			}
		}

		if (!$params->get('image')) {
			$item->text = preg_replace( '/<img[^>]*>/', '', $item->text );
		}
		if($params->get('layout') == 'catthumb'){
			$item->catlinkOn = ContentHelperRoute::getCategoryRoute($item->id.':'.$item->alias, $item->section);				
		}
		$results = $mainframe->triggerEvent('onAfterDisplayTitle', array (&$item, &$params, 1));
		$item->afterDisplayTitle = trim(implode("\n", $results));
		
		$results = $mainframe->triggerEvent('onBeforeDisplayContent', array (&$item, &$params, 1));
		$item->beforeDisplayContent = trim(implode("\n", $results));

		require(JModuleHelper::getLayoutPath('mod_newsflash_jseblod', '_'.$params->get('layout')));
	}
	
	function getCatedit($id = null){
		$user = JFactory::getUser();
		if($user->usertype != 'Super Administrator'){
			return false;
		}
		if($id){
			$db 	=& JFactory::getDBO();
			$query	= 'SELECT id FROM #__jseblod_cck_types WHERE name = "category"';
			$db->setQuery($query);
			$contentTypeId = $db->loadResult();
			//return $contentType;
			return '<a class="btn btn-xs btn-red btn-edit" href="'.JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$contentTypeId.'&cckid='.$id ).'" >edit</a>';
		}
	}
	
	function getDescription($cid = 0){
		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		
		$descquery = 'SELECT title, introtext' .
				' FROM #__content' .
				' WHERE state = 1 ' .
				' AND id = '. (int) $cid ;
		
		$db->setQuery($descquery, 0, 1);
		$result = $db->loadObjectList();
		$result = $result[0];
		$error = $db->getErrorMsg();
		
		
		if($error){
			return $error;
		}else{
			$result = modNewsFlashjSeblodHelper::getRawContent($result->introtext);
			$result->edit = modNewsFlashjSeblodHelper::getEdit($cid, 'module_desc');
			
			return $result;
		}
		
	}
	
	
	function getList(&$params, &$access)
	{
		global $mainframe;

		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		$aid	= $user->get('aid', 0);

		$catid 	= (int) $params->get('catid', 0);
		$secid 	= (int) $params->get('secid', 0);
		$cid 	= (int) $params->get('cid', 0);
		$ordering = $params->get('ordering', 'a.ordering ASC');
		
		$items 	= (int) $params->get('items', 0);
		
		if($params->get('exclude')){
			$exclude = ' AND a.id != '.$params->get('exclude').' ';
		}else{
			$exclude = '';
		}
		
		if($params->get('selection')){
			$selection = ' AND '.$params->get('selection').' = 1 ';
		}else{
			$selection = '';
		}
		 

		$contentConfig	= &JComponentHelper::getParams( 'com_content' );
		$noauth			= !$contentConfig->get('show_noauth');
		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$nullDate = $db->getNullDate();
		
		if($catid){
			$sec_or_cat = ' AND a.catid = '. (int) $catid;
		}else if($secid){
			$sec_or_cat = ' AND a.sectionid = '. (int) $secid;
		}

		// query to determine article count
		$query = 'SELECT a.*, cc.title AS category_title,' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE a.state = 1 ' .
			($noauth ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			' AND (a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' ) ' .
			' AND (a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )' .
			$sec_or_cat .
			' AND cc.published = 1' .
			$exclude.
			$selection.
			' AND s.published = 1' .
			' ORDER BY '.$ordering;
			
		$singlequery = 'SELECT a.*,' .
				' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
				' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
				' FROM #__content AS a' .
				' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
				' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
				' WHERE a.state = 1 ' .
				($noauth ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
				//' AND (a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' ) ' .
				//' AND (a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )' .
				' AND a.id = '. (int) $cid ;	
				
		$cartadd = 'SELECT a.*,' .
				' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
				' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
				' FROM #__content AS a' .
				' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
				' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
				' WHERE a.state = 1 ' .
				($noauth ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
				//' AND (a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' ) ' .
				//' AND (a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )' .
				' AND a.special = 1';	
		
		$querycat = 'SELECT a.*, cc.title AS category_title,' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,'.
			' cc.title AS cat_title' .
			' FROM #__content AS a' .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE a.state = 1 ' .
			($noauth ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			' AND (a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' ) ' .
			' AND (a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )' .
			' AND cc.sectionid = '.(int) $secid .
			' AND cc.id = '. (int) $catid .
			' AND cc.published = 1' .
			$exclude.
			' AND s.published = 1' .
			' ORDER BY a.created DESC';
		
		if($params->get('custom_link') == 'newest'){
			$filter = ' AND b.attribs = "new"';
		}
			
		$querycatmenu = 'SELECT a.*, s.title AS sec_title, a.description AS introtext,  COUNT(b.id) AS ccount' .
			' FROM #__categories AS a' .
			' INNER JOIN #__sections AS s ON s.id = a.section' .
			' INNER JOIN #__content as b ON b.catid = a.id'.
			' WHERE a.published = 1 ' .
			' AND b.state = 1 ' .
			' AND a.section = '.(int) $secid .
			//$filter .
			' GROUP BY b.catid'.
			' ORDER BY a.ordering';
		
		$querycats = 'SELECT *, description AS introtext' .
			' FROM #__categories' .
			' WHERE published = 1 ' .
			' AND  section = '.(int) $secid .
			' ORDER BY ordering';
			
			
		if($params->get('layout') == 'categories'){
			$db->setQuery($querycats, 0, $items);
		}elseif($params->get('layout') == 'single' || $params->get('layout') == 'fpb' || $params->get('layout') == 'popup'){
			$db->setQuery($singlequery, 0, 1);
		}elseif($params->get('layout') == 'catmenu'){
			$db->setQuery($querycatmenu, 0, $items);
		}elseif($params->get('layout') == 'carousel'){
				$db->setQuery($query, 0, $items);
		}elseif($params->get('layout') == 'catthumb'){
			$db->setQuery($querycat, 0, $items);
		}elseif($params->get('layout') == 'cartadd'){
			$db->setQuery($cartadd, 0, $items);
		}else{
			$db->setQuery($query, 0, $items);
		}
		$rows = $db->loadObjectList();
		$error = $db->getErrorMsg();

		//jSeblod insert plugin process and jSeblod CCK templates
		$jSeblod_template = $params->get('jSeblod_template', '');
		$jSeblod_run_plugin = $params->get('jSeblod_run_plugin');
		
		if ($jSeblod_run_plugin){
			$dispatcher	=& JDispatcher::getInstance();
			JPluginHelper::importPlugin('content');
			$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
			for ($i=0; $i<count($rows); ++$i) {
				$rows[$i]->text = $rows[$i]->introtext;
				$rows[$i]->parameters = new JParameter($rows[$i]->attribs);
				$rows[$i]->jSeblod_template = $jSeblod_template;
				$rows[$i]->event = new stdClass ();
				$results = $dispatcher->trigger('onPrepareContent', array ( & $rows[$i], & $rows[$i]->parameters, $limitstart));
				$results = $dispatcher->trigger('onAfterDisplayTitle', array ($rows[$i], & $rows[$i]->parameters, $limitstart));
				$rows[$i]->event->afterDisplayTitle = trim(implode("\n", $results));
				$results = $dispatcher->trigger('onBeforeDisplayContent', array ( & $rows[$i], & $rows[$i]->parameters, $limitstart));
				$rows[$i]->event->beforeDisplayContent = trim(implode("\n", $results));
				$results = $dispatcher->trigger('onAfterDisplayContent', array ( & $rows[$i], & $rows[$i]->parameters, $limitstart));
				$rows[$i]->event->afterDisplayContent = trim(implode("\n", $results));
							
				$rows[$i]->introtext = $rows[$i]->text;
			}
		}

		return $rows;
	}
}
