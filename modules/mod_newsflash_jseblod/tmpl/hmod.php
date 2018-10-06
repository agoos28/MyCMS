<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="hmod">
	<div class="row">
<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
		<div class="column four"><?php modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); ?></div>
<?php endfor; ?>
	</div>
</div>
