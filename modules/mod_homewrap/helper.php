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

class modHomeWrapHelper
{
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
		return (object)$res;
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

		$item->text 	= $item->introtext;
		$item->groups 	= '';
		$item->readmore = (trim($item->fulltext) != '');
		
		if ($params->get('readmore') || $params->get('link_titles'))
		{
			if ($params->get('intro_only'))
			{
				// Check to see if the user has access to view the full article
				if ($item->access <= $user->get('aid', 0)) {
					$item->linkOn = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid));
					$item->catlinkOn = JRoute::_(ContentHelperRoute::getCategoryRoute($item->id.':'.$item->alias, $category->section));
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

		$results = $mainframe->triggerEvent('onAfterDisplayTitle', array (&$item, &$params, 1));
		$item->afterDisplayTitle = trim(implode("\n", $results));
		$item->rawcontent = modHomeWrapHelper::getRawContent($item->text);
		$results = $mainframe->triggerEvent('onBeforeDisplayContent', array (&$item, &$params, 1));
		$item->beforeDisplayContent = trim(implode("\n", $results));

		require(JModuleHelper::getLayoutPath('mod_homewrap', '_item'));
	}

	function getList(&$params, &$access, $type = null)
	{
		global $mainframe;

		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		$aid	= $user->get('aid', 0);

		$catid 	= (int) $params->get('catid', 0);
		$secid 	= (int) $params->get('secid', 0);
		$cid 	= (int) $params->get('cid', 0);
		$items 	= (int) $params->get('items', 0);
		

		$contentConfig	= &JComponentHelper::getParams( 'com_content' );
		$noauth			= !$contentConfig->get('show_noauth');
		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$nullDate = $db->getNullDate();
		
		if($type == 'latest'){
			$ordering = ' ORDER BY a.created DESC';
		}elseif($type == 'popular'){
			$ordering = ' ORDER BY a.hits DESC';
		}elseif($type == 'pick'){
			$where = ' AND a.staf_pick = 1';
		}elseif($type == 'seller'){
			$ordering = ' ORDER BY a.buycount DESC';
		}
		
		if($secid > 0){
			$section = ' AND cc.section = '.$secid;
		}
		// query to determine article count
		$query = 'SELECT a.*,' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE a.state = 1 ' .
			' AND a.stock != 0'.
			($noauth ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			' AND cc.published = 1' .
			$section.
			$where.
			' AND s.published = 1'.
			$ordering;
			
		
		$db->setQuery($query, 0, 1);
		$rows = $db->loadObjectList();
		$error = $db->getErrorMsg();

		return $rows;
	}
}
