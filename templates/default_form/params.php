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
$root				=	( $client->id ) ? @$this->rooturl : $this->baseurl;
$path				=	( $client->id ) ? @$this->rooturl . '/templates/' . $this->template : $this->baseurl . '/templates/' . $this->template;

// Form Basics
$bgColor			=	( $client->id ) ? $this->params->get( 'adminBackgroundColor' ) : $this->params->get( 'siteBackgroundColor' );
$bgColor			=	( $bgColor ) ? 'background-color: '.$bgColor.'; ' : '';
$borderColor		=	( $client->id ) ? $this->params->get( 'adminBorderColor' ) : $this->params->get( 'siteBorderColor' );
$borderColor		=	( $borderColor ) ? 'border-color: '.$borderColor.'; ' : '';
$borderStyle		=	( $client->id ) ? $this->params->get( 'adminBorderStyle' ) : $this->params->get( 'siteBorderStyle' );
$borderStyle		=	( $borderStyle ) ? 'border-style: '.$borderStyle.'; ' : '';
$fieldsetStyle		=	( $bgColor || $borderColor || $borderStyle ) ? 'style="'.$bgColor.$borderColor.$borderStyle.'"' : '';

// Form Titles (Legend)
$showTitle			=	( $client->id ) ? $this->params->get( 'adminShowTitle' ) : $this->params->get( 'siteShowTitle' );
$titleColor			=	( $client->id ) ? $this->params->get( 'adminTitleColor' ) : $this->params->get( 'siteTitleColor' );
$titleColor			=	( $titleColor ) ? 'color: '.$titleColor.'; ' : '';
$titleStyle			=	( $client->id ) ? $this->params->get( 'adminTitleStyle' ) : $this->params->get( 'siteTitleStyle' );
$titleStyle			=	( $titleStyle ) ? 'font-style: '.$titleStyle.'; ' : '';
$titleWeight		=	( $client->id ) ? $this->params->get( 'adminTitleWeight' ) : $this->params->get( 'siteTitleWeight' );
$titleWeight		=	( $titleWeight ) ? 'font-weight: '.$titleWeight.'; ' : '';
$titleBorderC		=	( $client->id ) ? $this->params->get( 'adminTitleBorderC' ) : $this->params->get( 'siteTitleBorderC' );
$titleBorderC		=	( $titleBorderC ) ? $titleBorderC : '';
$titleBorderS		=	( $client->id ) ? $this->params->get( 'adminTitleBorderS' ) : $this->params->get( 'siteTitleBorderS' );
$titleBorderS		=	( $titleBorderS && $titleBorderS != 'none' ) ? 'padding: 6px 8px 6px 7px; border: 1px '.$titleBorderS.' '.$titleBorderC.'; ' : 'padding: 6px 8px 6px 7px;';
$legendStyle		=	( $titleColor || $titleStyle || $titleWeight || $titleBorderS ) ? 'style="'.$titleColor.$titleStyle.$titleWeight.$titleBorderS.'"' : '';

// Panels Title
$panelColor			=	( $client->id ) ? $this->params->get( 'adminPanelColor' ) : $this->params->get( 'sitePanelColor' );
$panelColor			=	( $panelColor ) ? 'color: '.$panelColor.'; ' : '';
$panelStyle			=	( $client->id ) ? $this->params->get( 'adminPanelStyle' ) : $this->params->get( 'sitePanelStyle' );
$panelStyle			=	( $panelStyle ) ? 'font-style: '.$panelStyle.'; ' : '';
$panelWeight		=	( $client->id ) ? $this->params->get( 'adminPanelWeight' ) : $this->params->get( 'sitePanelWeight' );
$panelWeight		=	( $panelWeight ) ? 'font-weight: '.$panelWeight.'; ' : '';
$panelBorderC		=	( $client->id ) ? $this->params->get( 'adminPanelBorderC' ) : $this->params->get( 'sitePanelBorderC' );
$panelBorderC		=	( $panelBorderC ) ? $panelBorderC : '';
$panelBorderS		=	( $client->id ) ? $this->params->get( 'adminPanelBorderS' ) : $this->params->get( 'sitePanelBorderS' );
$panelBorderS		=	( $panelBorderS && $panelBorderS != 'none' ) ? 'padding: 6px 8px 6px 7px; border: 1px '.$panelBorderS.' '.$panelBorderC.'; ' : 'padding: 6px 8px 6px 7px;';
$panelTitleStyle	=	( $panelColor || $panelStyle || $panelWeight || $panelBorderS ) ? 'style="'.$panelColor.$panelStyle.$panelWeight.$panelBorderS.'"' : '';

// Labels & Tooltips
$tooltipIcon		=	( $client->id ) ? $this->params->get( 'adminTooltipIcon' ) : $this->params->get( 'siteTooltipIcon' );
$tooltipIcon		=	( $tooltipIcon ) ? $tooltipIcon : 'balloon-default.png';

$labelColor			=	( $client->id ) ? $this->params->get( 'adminLabelColor' ) : $this->params->get( 'siteLabelColor' );
$labelSeparator		=	( $client->id ) ? $this->params->get( 'adminLabelSeparator' ) : $this->params->get( 'siteLabelSeparator' );

// Fields & Validations
$animPanels			=	( $client->id ) ? $this->params->get( 'adminAnimatedPanels' ) : $this->params->get( 'siteAnimatedPanels' );

$requiredColor		=	( $client->id ) ? $this->params->get( 'adminRequiredColor' ) : $this->params->get( 'siteRequiredColor' );
$requiredBorderS	=	( $client->id ) ? $this->params->get( 'adminRequiredBorderS' ) : $this->params->get( 'siteRequiredBorderS' );
$requiredBorderC	=	( $client->id ) ? $this->params->get( 'adminRequiredBorderC' ) : $this->params->get( 'siteRequiredBorderC' );
$requiredBorder		=	( $requiredBorderS && $requiredBorderS != 'none' ) ? 'border: 1px '.$requiredBorderS.' '.$requiredBorderC.'; ' : 'border: 0;';

$successColor		=	( $client->id ) ? $this->params->get( 'adminSuccessColor' ) : $this->params->get( 'siteSuccessColor' );
$successBorderS		=	( $client->id ) ? $this->params->get( 'adminSuccessBorderS' ) : $this->params->get( 'siteSuccessBorderS' );
$successBorderC		=	( $client->id ) ? $this->params->get( 'adminSuccessBorderC' ) : $this->params->get( 'siteSuccessBorderC' );
$successBorder		=	( $successBorderS && $successBorderS != 'none' ) ? 'border: 1px '.$successBorderS.' '.$successBorderC.'; ' : 'border: 0;';
$failureColor		=	( $client->id ) ? $this->params->get( 'adminFailureColor' ) : $this->params->get( 'siteFailureColor' );
$failureBorderS		=	( $client->id ) ? $this->params->get( 'adminFailureBorderS' ) : $this->params->get( 'siteFailureBorderS' );
$failureBorderC		=	( $client->id ) ? $this->params->get( 'adminFailureBorderC' ) : $this->params->get( 'siteFailureBorderC' );
$failureBorder		=	( $failureBorderS && $failureBorderS != 'none' ) ? 'border: 1px '.$failureBorderS.' '.$failureBorderC.'; ' : 'border: 0;';
$alertColor			=	( $client->id ) ? $this->params->get( 'adminAlertColor' ) : $this->params->get( 'siteAlertColor' );
//... 
$buttonTextColor	=	$this->params->get( 'siteButtonTextColor' );
$buttonBackColor	=	$this->params->get( 'siteButtonBackColor' );
$buttonBorderColor	=	$this->params->get( 'siteButtonBorderColor' );

?>

<script type="text/javascript">
function CCK_GROUP_Copy(el, maximum) { 
	var elem = $(el).getParent().getParent().getParent();
	var list = elem.getParent();
	var length = ( list.getChildren().length );	

	if ( length < maximum ) {
		var newElem = elem.clone();
		
		var listname = list.getProperty( 'id' );
		var num = eval("groupmax_"+listname);
		eval("groupmax_"+listname+"++");
		
		newElem.setHTML( newElem.innerHTML.replace(/\[\d+\]\[/g,"\["+num+"\]\[") );
		newElem.setHTML( newElem.innerHTML.replace(/-\d+-/g,"-"+num+"-") );
		
		newElem.injectAfter(elem);
			
		new Sortables($(listname), {
			'handles': $(listname).getElements('img.button-drag')
		});	
	}
}
function CCK_GROUP_Remove(el) { 
	var elem = $(el).getParent().getParent().getParent();
	elem.remove();
}

function CCK_ELEM_Copy(el, maximum) { 
	var elem = $(el).getParent().getParent().getParent();
	var list = elem.getParent();
	var length = ( list.getChildren().length );	
	
	if ( length < maximum ) {
		var newElem = elem.clone();
		
		var listname = list.getProperty( 'id' );
		var num = eval("elemmax_"+listname);
		eval("elemmax_"+listname+"++");
		
		newElem.setHTML( newElem.innerHTML.replace(/-\d-wysiwyg/g,"-"+num+"-wysiwyg") );
		
		newElem.injectAfter(elem);
			
		new Sortables($(listname), {
			'handles': $(listname).getElements('img.button-drag')
		});	
	}
}
function CCK_ELEM_Remove(el) { 
	var elem = $(el).getParent().getParent().getParent();
	elem.remove();
}
</script>

<link rel="stylesheet" href="<?php echo ( @$client->id ) ? '..' : $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/<?php echo $client->name; ?>.css" type="text/css" />

<style type="text/css">
	.pane-sliders .title {
		cursor: pointer;
		margin-bottom: 6px;
		<?php echo $panelBorderS; ?>!important;
		<?php echo $panelColor; ?>!important;
		<?php echo $panelStyle; ?>!important;
		<?php echo $panelWeight; ?>!important;
	}
	input.required-enabled,
	select.required-enabled,
	textarea.required-enabled {
		<?php echo $requiredBorder; ?>
		background-color: <?php echo $requiredColor; ?>!important; 
	}
	input.required-disabled,
	textarea.required-disabled {
		color: #888;
		<?php echo $requiredBorder; ?>
		background-color: <?php echo $requiredColor; ?>!important; 
	}
	.validation-advice {
		color: <?php echo $alertColor; ?>!important;
	}
	.validation-passed {
		<?php echo $successBorder; ?>
		background-color: <?php echo $successColor; ?>!important; 
	}
	.validation-failed {
		<?php echo $failureBorder; ?>
		background-color: <?php echo $failureColor; ?>!important; 
	}
	button.color-button {
		background-color:<?php echo $buttonBackColor; ?>;
		border: 1px <?php echo $buttonBorderColor; ?> solid;
		color:<?php echo $buttonTextColor; ?>;
		font-size:11px;
		font-weight:bold;
		height:24px;
		margin-left:2px;
		margin-right:2px;
		cursor:pointer;
	}
	input.color-button {
		background-color:<?php echo $buttonBackColor; ?>;
		border: 1px <?php echo $buttonBorderColor; ?> solid;
		color:<?php echo $buttonTextColor; ?>;
		font-size:11px;
		font-weight:bold;
		height:24px;
		margin-left:2px;
		margin-right:2px;
		cursor:pointer;
	}
	

/* GROUPS */
ul.collection-group-repeatable {
	margin: 0;
	padding: 0;
}
li.collection-group-repeatable {
	list-style: none;
	margin: 0;
}
div.collection-group-wrap {
	border-bottom: 1px dotted #CCC;
	overflow: hidden;
	margin-bottom: 5px !important;
}
div.collection-group-form {
	margin-top: 5px !important;
	margin-right: 10px !important;
	margin-bottom: 5px !important;
	margin-left: 0px !important;
	float: left;
}
div.collection-group-button {
	float: left;
	padding-top: 3px !important;
}

/* ELEMENTS */
ul.collection-elem-repeatable {
	margin: 0;
	padding: 0;
}
li.collection-elem-repeatable {
	list-style: none;
	margin: 0;
}
div.collection-elem-wrap {
	overflow: hidden;
}
div.collection-elem-form {
	margin-top: 5px !important;
	margin-right: 10px !important;
	margin-bottom: 5px !important;
	margin-left: 0px !important;
	float: left;
}
div.collection-elem-button {
	float: left;
	padding-top: 3px !important;
}

/* BUTTONS */
img.button-del {
	cursor: pointer;
}
img.button-add {
	cursor: pointer;
}
img.button-drag {
	cursor: move;
}

</style>