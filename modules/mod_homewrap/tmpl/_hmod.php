<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
?>
<div class="wrapper">
<h3><?php echo $item->rawcontent->hm_title ?></h3>
<div class="text"><?php echo $item->rawcontent->hm_desc ?></div>
<a class="readmore" href="<?php echo $item->rawcontent->hm_link ?>">Read more</a>
</div>