<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$raw = $item->rawcontent;
$desc = modNewsFlashjSeblodHelper::truncate($raw->wysiwyg_description);
$link = JURI::base().strtolower($item->sec_title).'/'.$item->id.'-'.$item->alias;
?>
<a href="<?php echo $link;?>"><?php echo $item->title;?> (<?php echo $item->ccount; ?>)</a>