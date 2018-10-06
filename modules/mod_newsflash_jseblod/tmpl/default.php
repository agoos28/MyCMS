<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="blog-links">
	<h4 class="m-l-15 text-w-500 m-b-10"><?php echo $module->title; ?></h4>
  <div class="list-group">
    <?php $o=0; foreach ($list as $item) : ?>
        <?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?>
    <?php endforeach; ?>
  </div>
</div>