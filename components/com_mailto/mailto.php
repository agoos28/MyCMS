<?php
/**
 * @version		$Id: mailto.php 21078 2011-04-04 20:52:23Z dextercowley $
 * @package		Joomla
 * @subpackage	MailTo
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper');

require_once( JPATH_COMPONENT.DS.'helpers'.DS.'mailto.php');
require_once( JPATH_COMPONENT.DS.'controller.php' );

$controller	= new MailtoController( );
$controller->registerDefaultTask('mailto');
$controller->execute(JRequest::getCmd('task'));

//$controller->redirect();
