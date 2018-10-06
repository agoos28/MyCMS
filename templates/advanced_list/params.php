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
?>

<?php
/**
 * Init Style Parameters
 **/
 
// Init Client
$client				=&	JApplicationHelper::getClientInfo( $mainframe->getClientId() );

// Init Path
$path				=	( $client->id ) ? @$this->rooturl . '/templates/' . $this->template : $this->baseurl . '/templates/' . $this->template;
?>
<link rel="stylesheet" href="<?php echo ( @$client->id ) ? '..' : $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/<?php echo $client->name; ?>.css" type="text/css" />

<?php
// Params
$listLayout			=	$this->params->get( 'listLayout' );
$catalogName		=	( $this->params->get( 'catalogName' ) ) ? $this->params->get( 'catalogName' ) : 'category';
//
$columnNum			=	( $this->params->get( 'listLayout' ) == 'catalog' ) ? $this->params->get( 'catalogNum' ) : $this->params->get( 'listNum' );
$pxLeftMargin		=	$this->params->get( 'pxLeftMargin' );
$pxIntervalMargin	=	$this->params->get( 'pxIntervalMargin' );

$styleListLayout	=	( $this->params->get( 'styleListLayout' ) ) ? $this->params->get( 'styleListLayout' ) : 'none';
$typeListLayout		=	( $styleListLayout == 'decimal' || ( strpos( $styleListLayout, '-' ) !== false ) ) ? 'ol' : 'ul';

$start_col			=	( $this->params->get( 'startCol' ) ) ? $this->params->get( 'startCol' ) : 0;
?>
