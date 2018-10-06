<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
?>
<ul class="prodcat">
	<?php foreach ($list as $item) : ?>
			<li><?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?></li>
	<?php endforeach; ?>
    
</ul>