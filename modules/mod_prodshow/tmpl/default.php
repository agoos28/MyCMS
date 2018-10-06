<?php defined('_JEXEC') or die('Restricted access'); 

?>

<section class="prod-home">    
<?php foreach ($list as $key => $item){ $item->key = $key;?>
	<?php modProdShowHelper::renderItem($item, $params, $access); ?>
<?php } ?>
</section>       
