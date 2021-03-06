<?php
/**
* @version 			1.9.0
* @author       	http://www.seblod.com
* @copyright		Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
* @package			Product Form Template (Custom) - jSeblod CCK ( Content Construction Kit )
**/

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php
/**
 * Init Style Parameters
 **/
 
// Init Client
$client				=&	JApplicationHelper::getClientInfo( $mainframe->getClientId() );

// Init Path
$path				=	( $client->id ) ? @$this->rooturl . '/templates/' . $this->template : $this->baseurl . '/templates/' . $this->template;

echo '<style type="text/css">'.$this->params->get( 'custcss' ).'</style>';
?>

