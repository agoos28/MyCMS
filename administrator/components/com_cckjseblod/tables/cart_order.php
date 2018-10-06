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
class TableCart_Order extends JTable
{
	/**
	 * Vars
	 **/
	var $id = null;					//Int

	var $user = null;				//Varchar (50)
	var $email = null;				//Varchar (50)
	var $phone = null;				//Tinyint (4)
	var $products = null;				//Varchar (50)
	var $shipment = null;				//Varchar (50)
	var $value = null;				//Tinyint (4)
	var $payment = null;				//Varchar (50)
	var $status = null;				//Varchar (50)
	var $resi = null;				//Tinyint (4)
	var $adm_note = null;				//Varchar (50)
	var $usr_note = null;				//Varchar (50)
	var $read_date = null;				//Tinyint (4)
	var $order_date = null;				//Varchar (50)
	var $code = null;				//Varchar (50)
	var $type = null;				//Varchar (50)

	/**
	 * Constructor
	 **/
	function TableCart_Order( & $db ) {
		parent::__construct( '#__cart_order', 'id', $db );
	}
	
}
?>