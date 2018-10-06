<?php
/**
* @version 			1.9.0
* @author       	http://www.seblod.com
* @copyright		Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
* @package			#TITLE# #TYPE# Template (Custom) - jSeblod CCK ( Content Construction Kit )
**/

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php
/**
 * Init jSeblod Process Object { !Important; !Required; }
 **/
$jSeblod	=	clone $this;
?>

<?php 
/**
 * Init Style Parameters
 **/
include( dirname(__FILE__) . '/params.php' );
?>

#FIELDS#