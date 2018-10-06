<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="flexslider"> 
  <ul class="slides">
<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
	<?php modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); ?>
<?php endfor; ?>
	</ul>
</div>
