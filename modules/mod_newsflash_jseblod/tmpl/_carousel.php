<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$img = $item->rawcontent->imagex[0];

$img = explode('/',$img);
$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb3/'.$img[3];

$cartimg = str_replace('_thumb1', '_thumb2', $img);
//echo'<pre>';print_r($item);die();
$imghov = $item->rawcontent->pr_img_hov;
$imghov = explode('/',$imghov);
$imghov = $imghov[0].'/'.$imghov[1].'/'.$imghov[2].'/_thumb1/'.$imghov[3];

$options = modNewsFlashjSeblodHelper::CONTENT_getXValues($item->introtext,'pr_options');

?>

<div class="product type-product">
  <div class="product-thumbnail-outer">
    <div class="product-thumbnail-outer-inner"> <a href="<?php echo $item->linkOn;?>"> <img src="<?php echo $img; ?>" alt="<?php echo $item->rawcontent->pr_title; ?>" /></a>
      <div class="addtocart-btn">
        <div class="svg-overlay-shop">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 250" enable-background="new 0 0 500 250" xml:space="preserve" preserveAspectRatio="none">
            <path d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"></path>
          </svg>
        </div>
        <a href="<?php echo $item->linkOn;?>" class="button add_to_cart_button product_type_external"><i class="fa fa-bars cart-icons-shop" aria-hidden="true"></i> Take a look</a> </div>
    </div>
    <div class="product-content-inner">
      <h3><a href="<?php echo $item->linkOn;?>"><?php echo $item->rawcontent->pr_title; ?></a></h3>
      <div class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp</span>&nbsp;<?php echo number_format($item->rawcontent->pr_price, 0, '', '.'); ?></span></div> </div>
  </div>
</div>
