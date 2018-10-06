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

// Labels & Tooltips
$displayLabel		=	$this->params->get( 'siteDisplayLabel' );
$labelColor			=	$this->params->get( 'siteLabelColor' );
$labelSeparator		=	$this->params->get( 'siteLabelSeparator' );

$displayTooltip		=	$this->params->get( 'siteDisplayTooltip' );
$tooltipIcon		=	$this->params->get( 'siteTooltipIcon' );
$tooltipIcon		=	( $tooltipIcon ) ? $tooltipIcon : 'balloon-default.png';

// Default Box
JHTML::_( 'behavior.modal' );
?>

<link rel="stylesheet" href="<?php echo ( @$client->id ) ? '..' : $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/<?php echo $client->name; ?>.css" type="text/css" />

<?php if ( $displayTooltip ) { ?>
    <script src="<?php echo $this->baseurl; ?>/media/jseblod/mootips/mootips.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/jseblod/mootips/mootips.css" type="text/css" />
	<script type="text/javascript">
	window.addEvent("domready",function(){	
		var tipsOnClick = 0;
		if(tipsOnClick==1){var AjaxTooltips=new MooTips($$(".DescriptionTip"),{className:"ajaxTool",showOnClick:true,showOnMouseEnter:false,fixed:true})}else{var AjaxTooltips=new MooTips($$(".DescriptionTip"),{className:"ajaxTool",fixed:true})}
	});
	</script>
<?php } ?>

