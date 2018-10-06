<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

?>

<div class="fpb" style="overflow: hidden; padding: 0 30px;">
<?php echo $item->editlink ?>
<div class="row">
<div class="col-lg-6 col-md-16 col-sm-6 col-xs-12" style="overflow: hidden;">
	<div class="background paralax" style="background-image: url('<?php echo $item->rawcontent->fpb_image; ?>')">
    	<div class="container desc">
        	<h3><?php echo $item->rawcontent->fpb_title ?></h3>
            <p><?php echo $item->rawcontent->fpb_subtitle ?></p>
            <a href="<?php echo $item->rawcontent->fpb_link ?>" class="btn"><?php echo $item->rawcontent->fpb_link_text ?></a>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-16 col-sm-6 col-xs-12" style="overflow: hidden;">
	<div class="background paralax" style="background-image: url('<?php echo $item->rawcontent->fpb_image_2; ?>')">
    	<div class="container desc">
        	<h3><?php echo $item->rawcontent->fpb_title_2 ?></h3>
            <p><?php echo $item->rawcontent->fpb_subtitle_2 ?></p>
            <a href="<?php echo $item->rawcontent->fpb_link_2 ?>" class="btn"><?php echo $item->rawcontent->fpb_link_text_2 ?></a>
        </div>
    </div>
</div>
</div>
</div>