<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$desc = modNewsFlashjSeblodHelper::truncate($raw->wysiwyg_description);
$link = JURI::base().$params->get('custom_link').'/'.$item->id.'-'.$item->alias;
?>

	<a title="<?php echo $item->title;?>" href="<?php echo $link;?>"><?php echo $item->title;?></a>