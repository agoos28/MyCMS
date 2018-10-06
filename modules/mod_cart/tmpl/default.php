<?php
/**
* @package    modtemplate
* @author     agoos28
* @copyright  bebas
* @license    bebas
**/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once (dirname (dirname ( __FILE__ )) . "/helper.php");

$session =& JFactory::getSession();
$cart = getCart();
$count = 0;
$total = 0;

if($cart){
	foreach($cart as $item){
		$total += ((int)$item->price * (int)$item->count);
		$count += (int)$item->count;
	}
}
//$session->set('cart', '');
//echo'<pre>';print_r($cart);echo'</pre>';die();
?>
<script type="text/javascript">
var baseURL = '<?php echo JURI::base() ?>'
</script>

<a class="fa-stack fa-lg"> <span class="fa fa-circle fa-stack-2x"></span> <span class="fa fa-shopping-basket fa-stack-1x fa-inverse"></span>
<?php if($count){ ?>
<span class="qcount"><?php echo $count; ?></span>
<?php } ?>
</a>
<div class="menu_c cart_menu panel shoppingcart">
  <div class="panel-heading partition-purple">
    <h4 class="panel-title"><?php echo JText::_('SHOPPING_CART'); ?></h4>
  </div>
  <div class="panel-body">
    <div class="cart_row">
      <?php if($cart){ ?>
				<?php foreach($cart as $item){ 
				$opt = getProductOption($item->id, 'pr_option', $item->size);
				$cur_opt = getProductOption($item->id, 'pr_option', $item->option);
				?>
        <ul id="<?php echo $item->id ?>" class="item row no-padding">
          <li class="col-sm-2 col-xs-3 p-r-0">
            <div class="pro_img"><span><img src="<?php echo $item->thumb ?>" /></span></div>
          </li>
          <li class="col-sm-5 col-xs-7">
            <h5 class="m-b-10"><a href="<?php echo getArticleLink($item->id); ?>"><?php echo $item->title ?></a></h5>
            <div class="size">
							<?php echo $cur_opt->pr_option; ?> 
              <span class="text-small">(<?php echo $cur_opt->pr_opt_days; ?> days)</span>
            </div>
          </li>
          <li class="col-sm-4 col-xs-10">
            <div class="price">Rp. <span class="subtotal"><?php echo number_format(($item->price * $item->count), 0, '', '.') ?></span></div>
          </li>
          <li class="col-sm-1 col-xs-2 p-l-0"> <a href="#" class="del_btn del"><i class="fa fa-trash-o"></i></a> </li>
        </ul>
        <?php } ?>
      <?php }else{ ?>
      <ul class="row no-padding">
        <li class="col-sm-12 noitem text-center padding-15"><?php echo JText::_('CART_EMPTY'); ?></li>
      </ul>
      <?php } ?>
    </div>
  </div>
  <div class="panel-footer">
    <div class="row">
      <div class="col-sm-6 total"> TOTAL : Rp. <span class="tot"><?php echo number_format($total, 0, '', '.'); ?></span> </div>
      <div class="col-sm-6 text-right"> <a href="<?php echo JURI::base() ?>cart" class="btn btn-purple"><?php echo JText::_('CHECKOUT_BUTTON'); ?></a> </div>
    </div>
  </div>
</div>
