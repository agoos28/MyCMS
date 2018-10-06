<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="leftright">
<?php $i=0; foreach ($list as $item) : ?>
	<div class="item <?php if($i %2){echo 'left';}else{ echo 'right';} ?> hide">
	<?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?>
    </div>
<?php $i++; endforeach; ?>
</div>