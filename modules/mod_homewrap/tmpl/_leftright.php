<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="image" style="background-image: url('<?php echo JFilterOutput::linkXHTMLSafe($item->rawcontent->ab_img); ?>');"></div>
<div class="desc">
	<div class="wrapper">
        <h3><?php echo $item->title; ?></h3>
        <div class="text">
            <?php echo  $item->rawcontent->ab_intro; ?>
        </div>
        <a href="<?php echo $item->linkOn; ?>" class="readmore">EXPLORE</a>
    </div>
</div>