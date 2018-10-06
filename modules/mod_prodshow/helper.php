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

class modProdShowHelper
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
				$regX =	'#\|\|'.$val.'\|\|(.*?)\|\|/'.$val.'\|\|#s';
				preg_match_all( $regX, $matches[2][$key], $xitem );
				if(sizeof( $xitem[1] )){
					$res[$val] = $xitem[1];
				}else{
					if(strpos($val, 'jseblod_') !== false){
						//$res[$val] = modProdShowHelper::CONTENT_getXValues(str_replace('jseblod_','',$val), $text);
						/*$groupname = str_replace('jseblod_','',$val);
						$regxx = '#::(.*?)\|(.*?)\|'.$groupname.'::(.*?)::/(.*?)\|'.$i.'\|'.$groupname.'::#s';
						preg_match_all( $regxx, $text, $matchesx );
						echo'<pre>';print_r($matchesx);echo'</pre>';
						$res[$groupname] = array();
						foreach ( $matchesx[4] as $key2 => $val2 ) {
							$res[$groupname][$val2] = $matchesx[3][$key2];
						}*/
					}else{
						$res[$val]	=	$matches[2][$key];
					}
				}
				
			}
		}
		return (object)$res;
    }
	

	
	function CONTENT_getValues( $text, $fieldnames = '' )
	{
		$res	=	array();
		
		//TODO:: if $fieldnames
		
		$regex	=	CCK::CONTENT_getRegex();
		preg_match_all( $regex, $text, $matches );
		
		
		if ( sizeof( $matches[1] ) ) {
			foreach ( $matches[1] as $key => $val ) {
				$res[$val]	=	$matches[2][$key];
			}
		}
		
		return $res;
	}
	
	function CONTENT_getXValues($text = null, $fieldname )
    {	
		$gcount = modProdShowHelper::CONTENT_getValues( $text, $fieldname );
		preg_match_all( '#::(.*?)::(.*?)::/(.*?)::#s', $group, $matches );
		
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
		$item->rawcontent = modProdShowHelper::getRawContent($item->text);
		$item->linkOn = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid));
		$item->editlink = modProdShowHelper::getEdit($item->id,$item->rawcontent->jseblod);
		if ($params->get('readmore') || $params->get('link_titles'))
		{
			if ($params->get('intro_only'))
			{
				// Check to see if the user has access to view the full article
				if ($item->access <= $user->get('aid', 0)) {
					
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
		
		$results = $mainframe->triggerEvent('onBeforeDisplayContent', array (&$item, &$params, 1));
		$item->beforeDisplayContent = trim(implode("\n", $results));

		require(JModuleHelper::getLayoutPath('mod_prodshow', '_item'));
	}
	
	function getDescription($cid = 0){
		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		
		$descquery = 'SELECT *, a.id, a.title, a.introtext, cc.value' .
				' FROM #__content AS a' .
				' LEFT JOIN #__jf_content AS cc ON cc.reference_id = '. (int) $cid.
				' WHERE a.state = 1 ' .
				' AND a.id = '. (int) $cid ;
		
		$db->setQuery($descquery, 0, 1);
		$result = $db->loadObjectList();
		$result = $result[0];
		if($this->language == 'en-gb'){
			$result->introtext = $result->value;
		}
		$error = $db->getErrorMsg();
		
		
		if($error){
			die( $error);
		}else{
			$desc = modProdShowHelper::getRawContent($result->introtext);
			$desc->edit = modProdShowHelper::getEdit($cid, 'module_desc');
			$desc->title = $result->title;
			return $desc;
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
		$layout = $params->get('layout');
		

		$contentConfig	= &JComponentHelper::getParams( 'com_content' );
		$noauth			= !$contentConfig->get('show_noauth');
		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$nullDate = $db->getNullDate();
		
		$where = '';
		
		if($secid > 0){
			$where .= ' AND a.sectionid = '.$secid;
		}
		if($catid > 0){
			$where .= ' AND a.catid = '.$catid;
		}
		
		if($layout == 'newest'){
			$ordering = ' ORDER BY a.ordering ASC';
		}elseif($layout == 'popular'){
			$ordering = ' ORDER BY a.hits DESC';
		}elseif($layout == 'seller'){
			$ordering = ' ORDER BY a.buycount DESC';
		}elseif($layout == 'pick'){
			$where .= ' AND a.staf_pick = 1';
			$ordering = ' ORDER BY a.ordering ASC';
		}
		
		
		// query to determine article count
		$query = 'SELECT a.*,' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE a.state = 1 ' .
			' AND a.stock > 0'.
			($noauth ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			' AND cc.published = 1' .
			$where.
			' AND s.published = 1'.
			$ordering;
			
			
		
		$db->setQuery($query, 0, $items);
		
		$rows = $db->loadObjectList();
		$error = $db->getErrorMsg();

		return $rows;
	}
}
