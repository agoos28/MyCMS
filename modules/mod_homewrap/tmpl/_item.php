<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$img = JFilterOutput::ampReplace($item->rawcontent->pr_img);
/*$img = explode('/',$img);
$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb1/'.$img[3];*/
?>

<div class="image" style="background-image: url(<?php echo JURI::base().JFilterOutput::linkXHTMLSafe($img); ?>);" >
	<img src="<?php echo JURI::base(); ?>images/square.png" draggable="false" />
</div>

