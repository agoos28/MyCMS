<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$count = count($list);
if($module->title == 'Category Menu'){
	$ul_cls = ' class="menu main-menu cat-menu pull-right"';
	$li_cls = ' class="menu-item menu-item-type-custom menu-item-object-custom"';
}else{
	$ul_cls = '';
	$li_cls = '';
}
?>
<ul <?php echo $ul_cls;?>>
<?php $o=0; foreach ($list as $item) : ?>
	<li <?php echo $li_cls;?>>
  <?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?>
  </li>
<?php endforeach; ?>
</ul>