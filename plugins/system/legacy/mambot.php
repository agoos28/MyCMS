<?php
/**
* @version		$Id: mambot.php 14401 2010-01-26 14:10:00Z louis $
* @package		framework
* @subpackage	1.5
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

// Register legacy classes for autoloading
JLoader::register('JTablePlugin'   , JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'table'.DS.'plugin.php');

/**
 * Legacy class, replaced by {@link JTablePlugin}
 *
 * @deprecated	As of version 1.5
 * @package framework.Legacy
 * @subpackage	1.5
 */
class mosMambot extends JTablePlugin
{
	/**
	 * Constructor
	 */
	function __construct(&$db)
	{
		parent::__construct( $db );
	}

	function mosMambot(&$db)
	{
		parent::__construct( $db );
	}

	/**
	 * Legacy Method, use {@link JTable::reorder()} instead
	 * @deprecated As of 1.5
	 */
	function updateOrder( $where='' )
	{
		return $this->reorder( $where );
	}

	/**
	 * Legacy Method, use {@link JTable::publish()} instead
	 * @deprecated As of 1.0.3
	 */
	function publish_array( $cid=null, $publish=1, $user_id=0 )
	{
		$this->publish( $cid, $publish, $user_id );
	}
}