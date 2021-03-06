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
class CCKjSeblodModelCategory extends JModel
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
				
				$query	= 'SELECT a.id, a.title, a.alias, a.section, a.published, a.parent_id, a.description, a.created_user_id, a.checked_out, a.checked_out_time, u.name AS author, u.name AS editor, '
						. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END AS slug'
						. ' FROM #__categories AS a'
						. ' LEFT JOIN #__users AS u ON u.id = a.created_user_id'
						. $where
						//. $orderby
						. ' ORDER BY a.parent_id ASC'
						;
				$this->_db->setQuery( $query );
				$data	=	$this->_db->loadObjectList();
				
				
				
				$contentTypeId	=	null;
				$regex			=	"#"._OPENING."jseblod"._CLOSING."(.*?)"._OPENING."/jseblod"._CLOSING."#s";
				$new = array();
				if ( sizeof( $data ) ) {
					foreach ( $data as $key => $item ) {
						preg_match_all( $regex, $item->description, $contentMatches );	
						$contentType	=	@$contentMatches[1][0];
						$query	= 'SELECT s.id'
							. ' FROM #__jseblod_cck_types AS s'
							. ' WHERE s.name = "'.$contentType.'"'
							;
						$this->_db->setQuery( $query );
						$contentTypeId	=	$this->_db->loadResult();
						$item->content_typeid	=	( @$contentTypeId ) ? $contentTypeId : null;
						$item->count	= $this->getCategoryCount($item->id);
						$item->child = array();
						if($item->parent_id == 0){
							foreach($data as $key2 => $item2){
								if($item2->parent_id == $item->id){
									$item->child[] = $item2;
									unset($data[$key2]);
								}
							}
						}
					}
				}
			}
		}
		$this->_data = $data;
		return $this->_data;
	}
	
	/**
	 * Get Data from Database
	 **/
	function _buildContentWhere()
	{
		global $mainframe;
		$params	=&	$mainframe->getParams();
						
		$where_state	=	( $params->get( 'show_unpublished', 0 ) ) ? 'a.published >= 0' : 'a.published = 1';
		$where			=	' WHERE a.section NOT LIKE "%com_%" AND '.$where_state;
		$where			.=	' AND a.section = '.$params->get( 'secid', 0 );
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
		$order		=	$params->get( 'orderby_sec', 'alpha' );
		$orderby	.=	ContentHelperQuery::orderbySecondary( $order );

		if ( strpos( $orderby, 'a.created_by_alias,' ) ) {
			$orderby	=	str_replace( 'a.created_by_alias,', '', $orderby );
		}
		if ( strpos( $orderby, 'a.created_by_alias DESC,' ) ) {
			$orderby	=	str_replace( 'a.created_by_alias DESC,', '', $orderby );
		}
		
		return $orderby;
	}
	
	/**
	 * Publish / Unpublish
	 **/
	function publish( $cid = array(), $publish = 1 )
	{
		global $mainframe;
		
		if ( count( $cid ) ) {
			JArrayHelper::toInteger( $cid );
			$cids	=	implode( ',', $cid );
			$query	= 'UPDATE #__categories'
					. ' SET published = '.(int)$publish
					. ' WHERE id IN ( '.$cids.' )'
					;
			$this->_db->setQuery( $query );
			if ( ! $this->_db->query() ) {
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}
		}
		
		return true;
	}
	
	function getCategoryCount($catid = 0){
		$query	= "SELECT COUNT(id) FROM #__content WHERE catid = ".$catid;
		$this->_db->setQuery( $query );
		$count = $this->_db->loadResult();
		$this->setError( $this->_db->getErrorMsg() );
		if ( !$count ) {
			return 0;
		}else{
			return $count;
		}
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