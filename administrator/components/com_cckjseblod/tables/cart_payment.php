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

/**
 * Content Types	Table Class
 **/
class TableCart_Payment extends JTable
{
	/**
	 * Vars
	 **/
	var $payment_id = null;					//Int

	var $order_id = null;				//Varchar (50)
	var $from = null;				//Varchar (50)
	var $to = null;				//Tinyint (4)
	var $payment_amount = null;				//Varchar (50)
	var $payment_status = null;				//Varchar (50)
	var $payment_date = null;				//Tinyint (4)
	var $submit_date = null;				//Tinyint (4)

	/**
	 * Constructor
	 **/
	function TableCart_Payment( & $db ) {
		parent::__construct( '#__cart_payment', 'payment_id', $db );
	}
	
}
?>