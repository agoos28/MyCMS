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

class CCKjSeblodModelShipping extends JModel{

function getCountry($keyword = null){
	global $mainframe;
	$user = &JFactory::getUser();
	$result = new stdClass();
	
	$lim	= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 30, 'int');
	$lim0	= JRequest::getVar('limitstart', 0, '', 'int');
	
	if ($this->_category->access > $user->get('aid', 0)) {
		JError::raiseError(403, JText::_("ALERTNOTAUTH"));
		return false;
	}
	
	$db = JFactory::getDBO();
	if($keyword){
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM #__country WHERE short_name LIKE '%".$keyword."%' ORDER BY short_name" ;
	}else{
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM #__country";
		
	}
	
	$db->setQuery($query, $lim0, $lim);
	
	$result->result = $db->loadObjectList();
	
	$db->setQuery('SELECT FOUND_ROWS()');  //no reloading the query! Just asking for total without limit
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	
	$result->pageNav = new JPagination( $total, $lim0, $lim );
	
	return $result;
}

function getJne($keyword = null){
	global $mainframe;
	$user = &JFactory::getUser();
	$jne = new stdClass();
	
	if ($this->_category->access > $user->get('aid', 0)) {
		JError::raiseError(403, JText::_("ALERTNOTAUTH"));
		return false;
	}
	
	$lim	= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 30, 'int');
	$lim0	= JRequest::getVar('limitstart', 0, '', 'int');
		
	$db = JFactory::getDBO();
	
	if($keyword){
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM #__jne WHERE kecamatan LIKE '%".$keyword."%' OR kota LIKE '%".$keyword."%' " ;
	}else{
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM #__jne " ;
	}
	$db->setQuery($query, $lim0, $lim);
	$jne->result = $db->loadObjectList();
	$db->setQuery('SELECT FOUND_ROWS()');  //no reloading the query! Just asking for total without limit
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$jne->pageNav = new JPagination( $total, $lim0, $lim );
	if($error){
		die($error);
	}
	return $jne;
}

function updateJne($id = null, $reg = null, $yes = null, $cod = null){
	$user = &JFactory::getUser();
	if ($this->_category->access > $user->get('aid', 0)) {
		JError::raiseError(403, JText::_("ALERTNOTAUTH"));
		return false;
	}
	if($id == null){
		return 'Update data failed!';
	}
	$db = JFactory::getDBO();
	$query = "UPDATE #__jne SET reg = '$reg', yes = '$yes', cod = '$cod'  WHERE id = ".$id;
	$db->setQuery($query);
	$db->query();
	$error = $db->getErrorMsg();
	if($error){
		return $error;
	}else{
		return 'Succcess update';
	}
}

function updateCountry($id = null, $regular = null, $express = null){
	$user = &JFactory::getUser();
	if ($this->_category->access > $user->get('aid', 0)) {
		JError::raiseError(403, JText::_("ALERTNOTAUTH"));
		return false;
	}
	if($id == null){
		return 'Update data failed!';
	}
	$db = JFactory::getDBO();
	$query = "UPDATE #__country SET regular = '$regular', express = '$express'  WHERE country_id = ".$id;
	$db->setQuery($query);
	$db->query();
	$error = $db->getErrorMsg();
	if($error){
		return $error;
	}else{
		return 'Succcess update';
	}
}
}