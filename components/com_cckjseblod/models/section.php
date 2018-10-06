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

/**
 * Category			Model Class
 **/
class CCKjSeblodModelSection extends JModel
{
	/**
	 * Vars
	 **/
	var $_data		=	null;
	
	/**
	 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		
		$user		=&	JFactory::getUser();
		
		$userId		=	$user->get('id');
		$userGId	=	$user->get('gid');
		$this->setValues( $userId, $userGId );
	}

	/**
	 * Set Values
	 **/
	function setValues( $userId, $userGId )
	{
		// Set Values
		$this->_data	=	null;
		$this->_userId	=	$userId;
		
		$this->_userGId	=	$userGId;
	}
	
	/**
	 * Get Data from Database
	 **/
	function &getData()
	{
		if ( empty( $this->_data ) )
		{
			if ( $this->_userId ) {
				global $mainframe;
								
				$where		=	$this->_buildContentWhere();
				$orderby	=	$this->_buildContentOrderBy();
				
				$query	= 'SELECT id, title, alias, published, description, grouping'
						. ' FROM #__sections'
						. $where
						//. $orderby
						;
				$this->_db->setQuery( $query );
				$this->_data	=	$this->_db->loadObjectList();

			}
		}
		//print_r($this->_data);die();
		return $this->_data;
	}
	
	/**
	 * Get Data from Database
	 **/
	function _buildContentWhere()
	{
		global $mainframe;
		$params	=&	$mainframe->getParams();
						
		$where_state	=	( $params->get( 'show_unpublished', 0 ) ) ? 'published >= 0' : 'published = 1';
		$where			=	" WHERE grouping = ".$this->_db->Quote($params->get( 'secgroup', 0 ));
		//echo'<pre>';print_r($params->get( 'secid', 0 ));die();
		
		return $where;
	}
	
	/**
	 * Get Data from Database
	 **/
	function _buildContentOrderBy()
	{
		global $mainframe;
		$params	=&	$mainframe->getParams();
		require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'query.php');
		
		$orderby	= ' ORDER BY ';
		$order		=	$params->get( 'orderby', 'alpha' );
		$orderby	.=	$order;

		return $orderby;
	}
	
	
	
	function save( $option, $scope, $task )
	{
		global $mainframe;
	
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_content'.DS.'helper.php');
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		$db			=& JFactory::getDBO();
		$menu		= JRequest::getVar( 'menu', 'mainmenu', 'post', 'menutype' );
		$menuid		= JRequest::getVar( 'menuid', 0, 'post', 'int' );
		$oldtitle	= JRequest::getVar( 'oldtitle', '', '', 'post', 'string' );
	
		$post = JRequest::get('post');
	
		// fix up special html fields
		$post['description'] = ContentHelper::filterText(JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW ));
	
		$row =& JTable::getInstance('section');
		if (!$row->bind($post)) {
			JError::raiseError(500, $row->getError() );
		}
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		if ( $oldtitle ) {
			if ( $oldtitle != $row->title ) {
				$query = 'UPDATE #__menu'
				. ' SET name = '.$db->Quote($row->title)
				. ' WHERE name = '.$db->Quote($oldtitle)
				. ' AND type = "content_section"'
				;
				$db->setQuery( $query );
				$db->query();
			}
		}
	
		// if new item order last in appropriate group
		if (!$row->id) {
			$row->ordering = $row->getNextOrder();
		}
	
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		$row->checkin();
	
	}
	
	/**
	 * Publish / Unpublish
	 **/
	function publish( $sid = array(), $publish = 1 )
	{
		global $mainframe;
		
		if ( count( $sid ) ) {
			JArrayHelper::toInteger( $cid );
			$cids	=	implode( ',', $cid );
				
			$query	= 'UPDATE #__sections'
					. ' SET published = '.(int)$publish
					. ' WHERE id IN ( '.$sids.' )'
					;
			$this->_db->setQuery( $query );
			if ( ! $this->_db->query() ) {
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Delete
	 **/
	function trash()
	{
		global $mainframe;
		$cids	=	JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		if ( $n = count( $cids ) )
		{
			$cids = implode( ',', $cids );

			// Check got Articles??
			$query	= 'SELECT s.id, s.title, COUNT( cc.catid ) AS numcat'
					. ' FROM #__categories AS s'
					. ' LEFT JOIN #__content AS cc ON cc.catid = s.id'
					. ' WHERE s.id IN ( '.$cids.' )'
					. ' GROUP BY s.id'
					;
			$this->_db->setQuery( $query );		
			if ( ! ( $rows = $this->_db->loadObjectList() ) ) {
				return false;
			}
			
			foreach($rows as $row) {
				if ( $row->numcat && $row->numcat > 0 ) {
					$mainframe->enqueueMessage( JText::_( 'ONLY EMPTY CATEGORIES CAN BE DELETED' ), "error" );
					return false;
				}
			}
			
			$query	= 'DELETE FROM #__categories'
					. ' WHERE id IN ( '.$cids.' )'
					;
			$this->_db->setQuery( $query );
			if ( ! $this->_db->query() ) {
				return false;
			}	
		}
		
		return $n;
	}

}
?>