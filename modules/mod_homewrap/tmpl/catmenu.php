<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
?>
<ul class="prodcat">
	<?php foreach ($list as $item) : ?>
			<li><?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?></li>
	<?php endforeach; ?>
    <li><a href="<?php echo JURI::base().strtolower($item->sec_title); ?>">Lihat Semua</a></li>
</ul>