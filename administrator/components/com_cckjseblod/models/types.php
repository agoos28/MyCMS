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
 * Content Types	Model Class
 **/
class CCKjSeblodModelTypes extends JModel
{
	/**
	 * Vars
	 **/
	var $_data 			= null;
	var $_total 		= null;
	var $_pagination	= null;
	
	/**
	 * Constructor
	 **/
	function __construct()
	{
        parent::__construct();
		
        global $mainframe, $option;
		$controller = 	JRequest::getWord( 'controller' );
		$task		=	JRequest::getVar( 'layout' );
		
        // Get Pagination Request Variables
        $limit = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg( 'list_limit' ), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.limitstart', 'limitstart', 0, 'int' );
        //$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		
        // In case Limit has been Changed, Adjust it
        $limitstart = ( $limit != 0 ? ( floor( $limitstart / $limit ) * $limit ) : 0 );
		
        $this->setState( 'limit', $limit );
        $this->setState( 'limitstart', $limitstart );
	}
	
	/**
	 * Get Data from Database
	 **/
	function getData( $layout, $action = null )
	{
		if ( empty( $this->_data ) )
		{
			$query = $this->_buildQuery( $layout, $action );
			$this->_data = $this->_getList( $query, $this->_pagination->limitstart, $this->_pagination->limit );
			
			if ( $layout == 'element' ) {

			} else {
				
				$query = 'SELECT s.typeid, COUNT( s.typeid ) AS num'
					   . ' FROM #__jseblod_cck_type_item AS s'
					   . ' LEFT JOIN #__jseblod_cck_items AS cc ON cc.id = s.itemid'
					   . ' WHERE s.client = "admin"'
					   . ' GROUP BY s.typeid';
				$this->_db->setQuery( $query );
				$admin = $this->_db->loadObjectList( 'typeid' );
				
				$query = 'SELECT s.typeid, COUNT( s.typeid ) AS num'
					   . ' FROM #__jseblod_cck_type_item AS s'
					   . ' LEFT JOIN #__jseblod_cck_items AS cc ON cc.id = s.itemid'
					   . ' WHERE s.client = "site"'
					   . ' GROUP BY s.typeid';
				$this->_db->setQuery( $query );
				$site = $this->_db->loadObjectList( 'typeid' );
				
				$query = 'SELECT s.typeid, COUNT( s.typeid ) AS num'
					   . ' FROM #__jseblod_cck_type_cat AS s'
					   . ' LEFT JOIN #__categories AS cc ON cc.id = s.catid '
					   . ' WHERE cc.id'
					   . ' GROUP BY s.typeid';
				$this->_db->setQuery( $query );
				$catViews = $this->_db->loadObjectList( 'typeid' );
				
				$query = 'SELECT s.typeid, COUNT( s.typeid ) AS num'
					   . ' FROM #__jseblod_cck_type_url AS s'
					   . ' GROUP BY s.typeid';
				$this->_db->setQuery( $query );
				$comViews = $this->_db->loadObjectList( 'typeid' );
				
				$query = 'SELECT s.typeid, cc.bool2 AS num'
					   . ' FROM #__jseblod_cck_type_item AS s'
					   . ' LEFT JOIN #__jseblod_cck_items AS cc ON cc.id = s.itemid'
					   . ' WHERE cc.type=25 AND s.client = "admin"'
					   . ' GROUP BY s.typeid';
				$this->_db->setQuery( $query );
				$actionMode	= $this->_db->loadObjectList( 'typeid' );
				
				if ( sizeof( $this->_data ) ) {
					foreach ( $this->_data as $item ) {
						$item->adminFields		= @$admin[$item->id]->num ? $admin[$item->id]->num : 0;
						$item->siteFields		= @$site[$item->id]->num ? 	$site[$item->id]->num : 0;
						$item->catViews			= @$catViews[$item->id]->num ? $catViews[$item->id]->num : '-';
						$item->comViews			= @$comViews[$item->id]->num ? $comViews[$item->id]->num : '-';
						$item->actionMode		= @$actionMode[$item->id]->num ? $actionMode[$item->id]->num : 0;
					}
				}
			
			}
		}
		
		return $this->_data;
	}

	/**
	 * Get Total
	 **/
	function getTotal( $layout, $action )
	{
        if ( empty( $this->_total ) ) {
            $query = $this->_buildQuery( $layout, $action );
            $this->_total = $this->_getListCount( $query );
        }
		
        return $this->_total;
	}
	
	/**
	 * Get Pagination Object
	 **/
	function getPagination( $layout, $action )
	{
		if ( empty( $this->_pagination ) ) {
			jimport( 'joomla.html.pagination' );
			$this->_pagination = new JPagination( $this->getTotal( $layout, $action ), $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
			
			if ( $this->_pagination->limitstart && ( $this->_pagination->limitstart == $this->_pagination->total ) ) {
				$this->_pagination->limitstart = $this->_pagination->limitstart - $this->_pagination->limit;
			}
		}
		
		return $this->_pagination;
	}
	
	/**
	 * Return Database Query
	 **/
	function _buildQuery( $layout, $action )
	{
		global $mainframe;
		
		$where = $this->_buildContentWhere( $layout, $action );
		$orderby = $this->_buildContentOrderBy();
		
		$query = 'SELECT s.*, cc.title AS categorytitle, cc.color AS categorycolor, cc.introchar AS categoryintrochar, cc.colorchar AS categorycolorchar, u.name AS editor'
				.' FROM #__jseblod_cck_types AS s'
				.' LEFT JOIN #__jseblod_cck_types_categories AS cc ON cc.id = s.category'
				.' LEFT JOIN #__jseblod_cck_type_item AS ccc ON ccc.typeid = s.id'
				.' LEFT JOIN #__jseblod_cck_items AS cccc ON cccc.id = ccc.itemid'
				.' LEFT JOIN #__users AS u ON u.id = s.checked_out'
				. $where
				.' GROUP BY s.id'
				. $orderby
				;
			
		 return $query;
	}
	
	/**
	 * Return Where into Query 
	 **/
	function _buildContentWhere( $layout, $action )
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();
		$controller			=	JRequest::getWord( 'controller' );
		$task				=	JRequest::getVar( 'layout' );
		$contentItemFilter	=	JRequest::getInt( 'contentfilter' );
		$categoryFilter 	=	JRequest::getInt( 'categoryfilter' );
		$templateFilter		=	JRequest::getInt( 'templatefilter' );
		
		$filter_restricted	= $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.filter_restricted', 'filter_restricted', _RESTRICTION_TYPE,	'int' );
		$filter_category	= ( $categoryFilter || $contentItemFilter ) ? 0 : $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.filter_category',		'filter_category',		0,		'int' );
		$filter_assignment	= ( $categoryFilter || $contentItemFilter ) ? 0 : $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.filter_assignment',	'filter_assignment',	0,		'int' );
		$filter_state		= ( $task == 'element' ) ? 'P' : ( ( $categoryFilter || $contentItemFilter ) ? '' : $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.filter_state',			'filter_state',			'',			'word' ) );
		$filter_search		= ( $templateFilter ) ? 9 : ( ( $categoryFilter || $contentItemFilter ) ? ( ( $contentItemFilter ) ? 8 : 5 ) : ( $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.filter_search',	'filter_search', 0, 'int' ) ) );
		$search				= ( $templateFilter ) ? $templateFilter : ( ( $categoryFilter || $contentItemFilter ) ? ( ( $contentItemFilter ) ? $contentItemFilter : $categoryFilter ) : ( $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.search', 'search', '', 'string' ) ) );
		$search				= JString::strtolower( $search );
		
		$where = null;
		
		if ( $filter_restricted ) {
			$where = ' WHERE (cc.display = '.$filter_restricted.' OR cc.display > '.$filter_restricted.') ';
		}
		
		if ( $filter_category ) {
			$categories = $this->_getBranch( $filter_category );
			if ( $categories ) {
				$where .= ( $where ) ? ' AND s.category IN ('.$categories.')' : ' WHERE s.category IN ('.$categories.')';
			}
		}
		
		if ( $filter_assignment ) {
			$views = $this->_getTypeWithViews();
			if ( $filter_assignment == -1 ) {
				$where .= ( $where ) ? ' AND s.id NOT IN ('.$views.')' : ' WHERE s.id NOT IN ('.$views.')';
			} else if ( $filter_assignment == 1 ) {
				$where .= ( $where ) ? ' AND s.id IN ('.$views.')' : ' WHERE s.id IN ('.$views.')';
			}
		}
		
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where .= ( $where ) ? ' AND s.published = 1' : ' WHERE s.published = 1';
			} else if ($filter_state == 'U' ) {
				$where .= ( $where ) ? ' AND s.published = 0' : ' WHERE s.published = 0';
			}
		}
		
		if ( $layout == 'element' ) {
			if ( $action == -1 ) {
				$where	.=	' AND ccc.client = "site" AND cccc.type = 25 AND ( cccc.bool2 = 0 OR cccc.bool2 = 1 OR cccc.bool2 = 2 )' ;
			} else {
				$where	.=	' AND ccc.client = "site" AND cccc.type = 25 AND cccc.bool2 = '.$action;
			}
		}
		
		if ( $search ) {
			if ( $filter_search == 9 ) {
				$where .= ( $where ) ? ' AND ( s.contenttemplate = '.(int)$search.' OR s.admintemplate = '.(int)$search.' OR s.sitetemplate = '.(int)$search.' )'
									 : ' WHERE ( s.contenttemplate.id = '.(int)$search.' OR s.admintemplate.id = '.(int)$search.' OR s.sitetemplate.id = '.(int)$search.' )';
			} else if ( $filter_search == 8 ) {
				$where .= ( $where ) ? ' AND cccc.id = '.(int)$search : ' WHERE cccc.id = '.(int)$search;
			} else if ( $filter_search == 7 ) {
				$where .= ( $where ) ? ' AND LOWER(cccc.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ) : ' WHERE LOWER(cccc.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			} else if ( $filter_search == 6 ) {
				$where .= ( $where ) ? ' AND LOWER(cccc.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ) : ' WHERE LOWER(cccc.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );				
			} else if ( $filter_search == 5 ) {
				$where .= ( $where ) ? ' AND s.category = '.(int)$search : ' WHERE s.category = '.(int)$search;
			} else if ( $filter_search == 4 ) {
				$where .= ( $where ) ? ' AND LOWER(cc.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ) : ' WHERE LOWER(cc.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			} else if ( $filter_search == 3 ) {
				$where .= ( $where ) ? ' AND s.id = '.(int)$search : ' WHERE s.id = '.(int)$search;
			} else if ( $filter_search == 2 ) {
				$where .= ( $where ) ? ' AND LOWER(s.description) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ) : ' WHERE LOWER(s.description) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			} else if ( $filter_search == 1 ) {
				$where .= ( $where ) ? ' AND LOWER(s.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ) : ' WHERE LOWER(s.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			} else {
				$where .= ( $where ) ? ' AND LOWER(s.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ) : ' WHERE LOWER(s.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			}
		}
		
		return $where;
	}
	
	/**
	 * Return OrderBy into Query 
	 **/
	function _buildContentOrderBy() {
		
		global $mainframe, $option;
		$controller	=	JRequest::getWord( 'controller' );
		$task		=	JRequest::getVar( 'layout' );
		
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.filter_order',		'filter_order',		's.title',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'.'.$controller.'.'.$task.'.filter_order_Dir',	'filter_order_Dir',	'asc',		'cmd' );
		
		$orderby = ' ORDER BY '.$filter_order .' '. $filter_order_Dir;
		
		return $orderby;
	}
	
	function _getBranch( $currentId )
	{
		if ( empty( $this->_branch ) ) {
			$query = 'SELECT s.id, (COUNT(parent.id) - (branch.depth + 1)) AS depth'
					.' FROM #__jseblod_cck_types_categories AS s,'
					.' #__jseblod_cck_types_categories AS parent,'
					.' #__jseblod_cck_types_categories AS subparent,'
					.' ('
						.' SELECT s.id, (COUNT(parent.id) - 1) AS depth'
						.' FROM #__jseblod_cck_types_categories AS s,'
						.' #__jseblod_cck_types_categories AS parent'
						.' WHERE s.lft BETWEEN parent.lft AND parent.rgt'
						.' AND s.id ='.$currentId
						.' GROUP BY s.id'
						.' ORDER BY s.lft'
						.' ) AS branch'
					.' WHERE s.lft BETWEEN parent.lft AND parent.rgt'
					.' AND s.lft BETWEEN subparent.lft AND subparent.rgt'
					.' AND subparent.id = branch.id'
					.' GROUP BY s.id'
					.' ORDER BY s.lft';
			
			$this->_db->setQuery( $query );
			$this->_branch = $this->_db->loadResultArray();
			if ( is_array( $this->_branch ) ) {
				$this->_branch = implode( ',', $this->_branch );
			}
		}
		
		return( $this->_branch );
	}
	
	function _getTypeWithViews()
	{
		if ( empty( $this->_views ) ) {
			$query	= 'SELECT s.typeid'
					. ' FROM #__jseblod_cck_type_cat AS s'
					. ' LEFT JOIN #__categories AS cc ON cc.id = s.catid '
					. ' WHERE cc.id'
					. ' UNION'
					. ' SELECT s.typeid'
					. ' FROM #__jseblod_cck_type_url AS s'
					;
			$this->_db->setQuery( $query );
			$this->_views = $this->_db->loadResultArray();
			if ( is_array( $this->_views ) ) {
				$this->_views = implode( ',', $this->_views );
			}
		}
		
		return ( $this->_views );
	}
}
?>