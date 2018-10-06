<?php
/**
* @version		$Id: calendar.php 14401 2010-01-26 14:10:00Z louis $
* @package		Framework
* @subpackage	Parameter
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Renders a calendar element
 *
 * @package 	Framework
 * @subpackage	Parameter
 * @since		1.5
 */
class JElementCalendar extends JElement
{
	/**
	* Element name
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Calendar';

	function fetchElement($name, $value, &$node, $control_name)
	{
		JHTML::_('behavior.calendar'); //load the calendar behavior

		$format	= ( $node->attributes('format') ? $node->attributes('format') : '%Y-%m-%d' );
		$class	= $node->attributes('class') ? $node->attributes('class') : 'inputbox';

		$id   = $control_name.$name;
		$name = $control_name.'['.$name.']';

		return JHTML::_('calendar', $value, $name, $id, $format, array('class' => $class));
	}
}
