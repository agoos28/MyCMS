<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$session =& JFactory::getSession();
$cartids = array();  
$cartItems = json_decode($session->get('cart'));
if($cartItems){
	foreach($cartItems as $itm){
		$cartids[] = $itm->id;
	}
}
$count = 0;
?>

<?php foreach ($list as $item) : ?>
<?php 
	if(!in_array($item->id, $cartids)){
		$count++;
	}
?>
<?php endforeach; ?>
<?php if($count){ ?>
<h4 class="cartadd-title">+ TAMBAH ITEM LAINNYA</h4>
<?php } ?>
<?php foreach ($list as $item) : ?>
<?php 
	if(!in_array($item->id, $cartids)){
		modNewsFlashjSeblodHelper::renderItem($item, $params, $access); 
	}
?>
<?php endforeach; ?>
