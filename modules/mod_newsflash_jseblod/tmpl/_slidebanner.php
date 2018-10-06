<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
jimport( 'joomla.filter.filteroutput' );
$img = $item->rawcontent->hs_img;

?>
<?php if($img){ ?>
<li class="item">
<div class="imgwrapper" style="background-image: url('<?php echo JFilterOutput::linkXHTMLSafe($img); ?>');">
	<img src="<?php echo $img ?>" />
</div>
</li> 
<?php } ?>