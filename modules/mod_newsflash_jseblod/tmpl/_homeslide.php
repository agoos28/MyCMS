<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
jimport( 'joomla.filter.filteroutput' );


?>

<div class="lead testy-item">
<?php echo $item->editlink; ?>
<p><?php echo $item->rawcontent->hs_desc; ?></p> 
<p><?php echo $item->rawcontent->hs_subtitle; ?></p>
</div>