<?php
/**
* @version		$Id: mod_newsflash.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');
jimport( 'joomla.filter.filteroutput' );
$document = JFactory::getDocument();

$params->set('intro_only', 1);
$params->set('hide_author', 1);
$params->set('hide_createdate', 0);
$params->set('hide_modifydate', 1);


// Disable edit ability icon
$access = new stdClass();
$access->canEdit	= 0;
$access->canEditOwn = 0;
$access->canPublish = 0;
$doc =& JFactory::getDocument();
$item = modPagebannerHelper::getViewdesc();
$base = JURI::base();
$renderer = $doc->loadRenderer('module');

$menus = &JSite::getMenu();
$menu  = $menus->getActive();
$menu_params = new JParameter( $menu->params );

$title = $document->getTitle();


//echo'<pre>';print_r($item->sb_slides);//die();
// check if any results returned
if (!count($item->sb_slides)) { ?>
	<section class="page-banner">
  <div class="background paralax background-cover height-40 no-padding middle-center" style="background-image: url(<?php echo JURI::base(); ?>images/header-cart.jpg); background-position: 50% 50%;">
    <div class="col-md-12 p-b-10 text-white lead text-center">
      <h2><?php echo str_replace($mainframe->getCfg('sitename') . ' - ','',$title); ?></h2>
      <?php 
    $module = JModuleHelper::getModule('breadcrumbs','Page Breadcrumbs');
    echo $renderer->render($module);
    ?>
    </div>
  </div>
</section>
<?php }else if (count($item->sb_slides) == 1) { ?>
<section class="page-banner m-b-50">
	<?php echo $item->editlink;?>
  <div class="background paralax background-cover height-40 no-padding middle-center" 
  style="background-image: url('<?php echo $item->sb_slides[0]['sb_image']; ?>'); background-position: 50% 50%;">
    <div class="col-md-12 p-b-10 text-white lead text-center">
      <h2><?php echo str_replace($mainframe->getCfg('sitename') . ' - ','',$title); ?></h2>
      <?php 
    $module = JModuleHelper::getModule('breadcrumbs','Page Breadcrumbs');
    echo $renderer->render($module);
    ?>
    </div>
  </div>
</section>
<?php }else{ ?>

<script type="text/javascript" src="<?php echo $base; ?>templates/blank_j15/js/revolution.plugins.min.js"></script>
<script type="text/javascript" src="<?php echo $base; ?>templates/blank_j15/js/revolution.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>templates/blank_j15/css/revslider.css" media="screen" />


<?php if(JRequest::getVar('layout') == 'form'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>templates/ja_purity/css/reveditor.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>templates/ja_purity/css/fontello.css" media="screen" />
<script type="text/javascript" src="<?php echo $base; ?>templates/ja_purity/js/reveditor.js"></script>
<article class="spectaculus">
<div class="fullwidthbanner" style="position:relative;"> 
  <ul>
<?php foreach($item->sb_slides as $itm){ ?>
	<?php 
	$itm = (object)$itm;
	if($itm->sb_image){ ?>
    <li data-transition="fade" data-slotamount="5" data-masterspeed="700" >
    
    	<?php if($itm->sb_image_link){ ?>
        <a href="<?php echo $itm->sb_image_link ?>">
        <img src="<?php echo $itm->sb_image ?>" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat" />
        </a>
		<?php }else{ ?>
        <img src="<?php echo $itm->sb_image ?>" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat" />
    	<?php } ?>

    </li> 
    <?php } ?>
<?php } ?>
	</ul>
    <div class="tp-bannertimer"></div>
</div>
</article>

<script type="text/javascript">

var revapi;

jQuery(document).ready(function() {

	   revapi = jQuery('.fullwidthbanner').revolution(
		{
			delay:4000,
			startwidth:1170,
			startheight:500,
			hideThumbs:10,

			thumbWidth:100,
			thumbHeight:50,
			thumbAmount:5,

			navigationType:"both",
			navigationArrows:"solo",
			navigationStyle:"round",

			touchenabled:"on",
			onHoverStop:"on",

			navigationHAlign:"center",
			navigationVAlign:"bottom",
			navigationHOffset:0,
			navigationVOffset:0,

			soloArrowLeftHalign:"left",
			soloArrowLeftValign:"center",
			soloArrowLeftHOffset:20,
			soloArrowLeftVOffset:0,

			soloArrowRightHalign:"right",
			soloArrowRightValign:"center",
			soloArrowRightHOffset:20,
			soloArrowRightVOffset:0,

			shadow:0,
			fullWidth:"on",
			fullScreen:"off",

			stopLoop:"on",
			stopAfterLoops:0,
			stopAtSlide:1,


			shuffle:"off",

			autoHeight:"off",
			forceFullWidth:"off",

			hideThumbsOnMobile:"off",
			hideBulletsOnMobile:"on",
			hideArrowsOnMobile:"on",
			hideThumbsUnderResolution:0,

			hideSliderAtLimit:0,
			hideCaptionAtLimit:768,
			hideAllCaptionAtLilmit:0,
			startWithSlide:0,
			videoJsPath:"plugins/revslider/rs-plugin/videojs/",
			fullScreenOffsetContainer: ""
		});

});	//ready

</script>
<section class="container" style="display: none;">
			<article class="toolpad">
				<!--<section class="tryme"></section>-->

				<section class="tool first" id="transitselector">
						<div class="tooltext norightcorner long" id="mranim" style="cursor:pointer">Fade</div>
						<div class="toolcontrols short">
							<div class="toolcontroll noleftcorner"><div class="icon-up-dir-1 centertop"></div><div class="icon-down-dir-1 centerbottom"></div></div>
						</div>
						<div class="transition-selectbox-holder">
						  <div class="transition-selectbox">
							<ul>
								<li class="animchanger" data-anim="">Flat Fade Transitions</li>
								<li class="animchanger" data-anim="fade">Fade</li>
								<li class="animchanger" data-anim="boxfade">Fade Boxes</li>
								<li class="animchanger" data-anim="slotfade-horizontal">Fade Slots Horizontal</li>
								<li class="animchanger" data-anim="slotfade-vertical">Fade Slots Vertical</li>
								<li class="animchanger" data-anim="fadefromright">Fade and Slide from Right</li>
								<li class="animchanger" data-anim="fadefromleft">Fade and Slide from Left</li>
								<li class="animchanger" data-anim="fadefromtop">Fade and Slide from Top</li>
								<li class="animchanger" data-anim="fadefrombottom">Fade and Slide from Bottom</li>
								<li class="animchanger" data-anim="fadetoleftfadefromright">Fade To Left and Fade From Right</li>
								<li class="animchanger" data-anim="fadetorightfadetoleft">Fade To Right and Fade From Left</li>
								<li class="animchanger" data-anim="fadetobottomfadefromtop">Fade To Top and Fade From Bottom</li>
								<li class="animchanger" data-anim="fadetotopfadefrombottom">Fade To Bottom and Fade From Top</li>
							</ul>

							<ul>
								<li class="animchanger" data-anim="">Flat Zoom Transitions</li>
								<li class="animchanger" data-anim="scaledownfromright">Zoom Out and Fade From Right</li>
								<li class="animchanger" data-anim="scaledownfromleft">Zoom Out and Fade From Left</li>
								<li class="animchanger" data-anim="scaledownfromtop">Zoom Out and Fade From Top</li>
								<li class="animchanger" data-anim="scaledownfrombottom">Zoom Out and Fade From Bottom</li>
								<li class="animchanger" data-anim="zoomout">ZoomOut</li>
								<li class="animchanger" data-anim="zoomin">ZoomIn</li>
								<li class="animchanger" data-anim="slotzoom-horizontal">Zoom Slots Horizontal</li>
								<li class="animchanger" data-anim="slotzoom-vertical">Zoom Slots Vertical</li>
							</ul>

							<ul>
								<li class="animchanger" data-anim="">Flat Parallax Transitions</li>
								<li class="animchanger" data-anim="parallaxtoright">Parallax to Right</li>
								<li class="animchanger" data-anim="parallaxtoleft">Parallax to Left</li>
								<li class="animchanger" data-anim="parallaxtotop">Parallax to Top</li>
								<li class="animchanger" data-anim="parallaxtobottom">Parallax to Bottom</li>
							</ul>

							<ul>
								<li class="animchanger" data-anim="">Flat Slide Transitions</li>
								<li class="animchanger" data-anim="slideup">Slide To Top</li>
								<li class="animchanger" data-anim="slidedown">Slide To Bottom</li>
								<li class="animchanger" data-anim="slideright">Slide To Right</li>
								<li class="animchanger" data-anim="slideleft">Slide To Left</li>
								<li class="animchanger" data-anim="slidehorizontal">Slide Horizontal (depending on Next/Previous)</li>
								<li class="animchanger" data-anim="slidevertical">Slide Vertical (depending on Next/Previous)</li>
								<li class="animchanger" data-anim="boxslide">Slide Boxes</li>
								<li class="animchanger" data-anim="slotslide-horizontal">Slide Slots Horizontal</li>
								<li class="animchanger" data-anim="slotslide-vertical">Slide Slots Vertical</li>
								<li class="animchanger" data-anim="curtain-1">Curtain from Left</li>
								<li class="animchanger" data-anim="curtain-2">Curtain from Right</li>
								<li class="animchanger" data-anim="curtain-3">Curtain from Middle</li>
							</ul>

							<ul>
								<li class="animchanger" data-anim="">Premium Transitions</li>
								<li class="animchanger" data-anim="3dcurtain-horizontal">3D Curtain Horizontal</li>
								<li class="animchanger" data-anim="3dcurtain-vertical">3D Curtain Vertical</li>
								<li class="animchanger" data-anim="cubic">Cube Vertical</li>
								<li class="animchanger" data-anim="cubic-horizontal">Cube Horizontal</li>
								<li class="animchanger" data-anim="incube">In Cube Vertical</li>
								<li class="animchanger" data-anim="incube-horizontal">In Cube Horizontal</li>
								<li class="animchanger" data-anim="turnoff">TurnOff Horizontal</li>
								<li class="animchanger" data-anim="turnoff-vertical">TurnOff Vertical</li>
								<li class="animchanger" data-anim="papercut">Paper Cut</li>
								<li class="animchanger" data-anim="flyin">Fly In</li>
								<li class="animchanger" data-anim="random-static">Random Premium</li>
								<li class="animchanger" data-anim="random">Random Flat and Premium</li>
							</ul>
						  </div>
						</div>
						<div class="clear"></div>
				</section>

				<section class="tool">
						<div data-val="700" id="mrtime" class="tooltext">Time: 0.7s</div>
						<div class="toolcontrols">
							<div id="dectime" class="toolcontroll withspace"><i class="icon-minus"></i></div>
							<div id="inctime" class="toolcontroll withspace2"><i class="icon-plus"></i></div>
						</div>
						<div class="clear"></div>
				</section>

				<section class="tool last">
						<div data-val="5" class="tooltext" id="mrslot">Slots: 5</div>
						<div class="toolcontrols">
							<div id="decslot" class="toolcontroll withspace"><i class="icon-minus"></i></div>
							<div id="incslot" class="toolcontroll withspace2"><i class="icon-plus"></i></div>
						</div>
						<div class="clear"></div>
				</section>
				<div class="clear"></div>


			</article>

		</section>
        
<?php }else{ ?>
<div class="row m-b-50" style="position:relative;">
<div style="position: absolute; right: 0; top: 0; z-index: 999;"><?php echo $item->editlink;?></div>
<div class="fullwidthbanner" style="position:relative;">
  <ul>
<?php foreach($item->sb_slides as $itm){ ?>
	<?php 
	$itm = (object)$itm;
	if($itm->sb_image){ ?>
    <li data-transition="<?php echo $itm->sb_transition ?>" data-slotamount="<?php echo $itm->sb_slot ?>" data-masterspeed="700" >
    
    	<?php if($itm->sb_image_link){ ?>
        <a href="<?php echo $itm->sb_image_link ?>">
        <img src="<?php echo $itm->sb_image ?>" data-bgfit="cover " data-bgposition="center center" data-bgrepeat="no-repeat" />
        </a>
		<?php }else{ ?>
        <img src="<?php echo $itm->sb_image ?>" data-bgfit="cover " data-bgposition="center center" data-bgrepeat="no-repeat" />
    	<?php } ?>

    </li> 
    <?php } ?>
<?php } ?>
	</ul>
    <div class="tp-bannertimer"></div>
</div>
</div>
<script type="text/javascript">
var revapi;
jQuery(document).ready(function() {

       revapi = jQuery('.fullwidthbanner').revolution(
        {
            delay:4000,
            startwidth:1600,
            startheight:600,
			autoHeight:"on",
            hideThumbs:10,

            thumbWidth:100,
            thumbHeight:50,
            thumbAmount:5,

            navigationType:"none",
            navigationArrows:"solo",
            navigationStyle:"round",

            touchenabled:"on",
            onHoverStop:"on",

            navigationHAlign:"center",
            navigationVAlign:"bottom",
            navigationHOffset:0,
            navigationVOffset:0,

            soloArrowLeftHalign:"left",
            soloArrowLeftValign:"center",
            soloArrowLeftHOffset:20,
            soloArrowLeftVOffset:0,

            soloArrowRightHalign:"right",
            soloArrowRightValign:"center",
            soloArrowRightHOffset:20,
            soloArrowRightVOffset:0,

            shadow:0,
            fullWidth:"on",
            fullScreen:"off",

            stopLoop:"off",
            stopAfterLoops:0,
            stopAtSlide:0,


            shuffle:"off",

            autoHeight:"off",
            forceFullWidth:"off",

            hideThumbsOnMobile:"off",
            hideBulletsOnMobile:"on",
            hideArrowsOnMobile:"on",
            hideThumbsUnderResolution:0,

            hideSliderAtLimit:0,
            hideCaptionAtLimit:768,
            hideAllCaptionAtLilmit:0,
            startWithSlide:0,
            videoJsPath:"plugins/revslider/rs-plugin/videojs/",
            fullScreenOffsetContainer: ""
        });

});	//ready

</script>
<?php } }?>