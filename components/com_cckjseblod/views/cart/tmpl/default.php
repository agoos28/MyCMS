<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );

$model = $this->getModel();
$cart = $model->getCart();
$session =& JFactory::getSession();
$discount = $session->get('discount');
$discount_type = $session->get('discount_type');
$count = 0;
$total = 0;
if($cart){
	foreach($cart as $item){
		if((int)$item->oldprice){
			$olprice += ((int)$item->oldprice - $item->price) * (int)$item->count;
		}
		$total += ((int)$item->price * (int)$item->count);
		$count += (int)$item->count;
	}
}
if($discount){
	$discount_value = $discount;
	$total = $total - $discount_value;
	$olprice = $olprice + $discount_value;
}
?>

<div id="content">
  <div class="container">
    <div class="cart_c">
      <div class="cart_top">
        <div class="row">
          <form method="post" action="<?php echo JURI::base(); ?>checkout" id="cart">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 prodright">
            	<h3 class="text-extra-large text-w-400 p-l-15 pink" ><?php echo JText::_( 'Products' ); ?></h3>
              <div class="cart_tbl checkout_tbl m-b-60">
                <div class="clearfix con_row">
                  <?php if($cart){ ?>
                  <?php foreach($cart as $item){ 
									$checkAvailability = $model->checkAvailability($item->id,$item->option,$item->deliver);
									$options = $model->getProductOption($item->id);
									$cur_opt = $model->getProductOption($item->id, 'pr_option', $item->option);
									$opt_label = $model->getProductOption($item->id, 'option_label');
									?>
                  <ul id="<?php echo $item->id ?>" class="">
                    <li class="media"> <a href="<?php echo $model->getArticleLink($item->id); ?>" class="pull-left"><img src="<?php echo $item->thumb ?>" class="thumbnail media-object" draggable="false"></a>
                      <div class="media-body">
                        <h5 class="m-b-10"><a href="<?php echo $model->getArticleLink($item->id); ?>"><?php echo $item->title ?></a></h5>
                        <div class="size text-small">
													<div class="opt-desc">
                          Deliver on : <?php echo JHtml::_('date', $item->deliver); ?> <br />
                          Pikup on : <?php echo JHtml::_('date', $item->pickup); ?>
                          </div>
                        	
                        </div>
                        
                        </div>
                    </li>
                    <li class="p-t-40 text-center" style="line-height: 1.2;">
                      <?php echo $cur_opt->pr_option; ?> <br />
                      <span class="text-small">(<?php echo $cur_opt->pr_opt_days; ?> days)</span>
                      <input class="prodcount" name="prodcount" type="hidden" value="1" data-prodprice="<?php echo $item->price; ?>" />
                    </li>
                    <li class="p-t-40 text-center">
                      
                      <div class="price text-bold">Rp. <span class="subtotal"><?php echo number_format(($item->price * $item->count), 0, '', '.') ?> </span></div>
                    </li>
                    <li class="p-t-40 text-right">
                      <a href="#" class="del_btn delbag m-r-5" data-id="<?php echo $item->id ?>">Remove</a>
                    </li>
                    <?php  if($checkAvailability->err){ ?>
                    <?php if($checkAvailability->err == 'No Stock'){ ?>
                    <div class="erroverlay outofstock" data-id="<?php echo $item->id ?>"> This item is out of stock, remove from bag to continue<br />
                      Click to remove item from shopping bag. </div>
                   	<?php }else if($checkAvailability->err == 'Date Taken'){ ?>
                    <div class="erroverlay outofstock" data-id="<?php echo $item->id ?>"> Booking date already taken, remove from bag to continue<br />
                      Click to remove item from shopping bag. </div>
                    <?php }else{ ?>
                    <div class="erroverlay overlimit" data-id="<?php echo $item->id ?>" data-max="<?php echo $checkstock->max; ?>"> This item stock is <?php echo $checkstock->max; ?> left.<br />
                      Click to reduce your order to fit stock. </div>
                    <?php } ?>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                  <?php }else{ ?>
                  <div class="ckinfo padding-50 text-center border-dark border-bottom">
                    <h3>Cart Empty!</h3>
                  </div>
                  <?php } ?>
                </div>
                <!--<div class="clearfix added_row p-t-25 p-b-20 p-l-15">-->
                  <?php 
									$document = JFactory::getDocument();
									$renderer = $document->loadRenderer('module');
									$module = JModuleHelper::getModule('newsflash_jseblod','Quick cart add');
									//echo $renderer->render($module);
									?>
                <!--</div>-->
                <div class="clearfix total_row p-t-20">
									
                    
                    <div class="col-sm-8 col-xs-12 pull-right text-right text-center-xs no-float-sm"> 
                    	<div class="dicount">
                    	<?php if($discount){ ?>
                      	Discount -Rp. <span class="alldisc" data-value="<?php echo $discount_value; ?>"><?php echo number_format($discount_value, 0, '', '.') ?></span>
                      <?php } ?>
                      </div>
                      <div class="price m-b-20"><span class="pricelabel">Total Harga</span> Rp. <span class="alltot"><?php echo number_format($total, 0, '', '.') ?></span>
                        <?php  if($olprice > 0){ ?>
                        <div class="olpricetot">Anda hemat Rp. <span class="allold"><?php echo number_format($olprice, 0, '', '.') ?></span> </div>
                        <?php } ?>
                      </div> 
                      <div class="text-right text-center-xs m-b-30 ">
												<?php if($cart){ ?>
                        <a href="#" class="next_btn btn btn-lg btn-red rounded"><?php echo JText::_( 'CHECKOUT' ); ?></a>
                        <?php }else{ ?>
                        <a href="<?php echo JURI::base() ?>our-pick" class="next_btn btn-yellow next_btn btn btn-lg"><?php echo JText::_( 'CART_EMPTY' ); ?></a>
                        <?php } ?>
                      </div>
                    </div>
                  	<div class="col-sm-4 col-xs-10 m-auto-sm no-float-sm">
                  	<div class="dis_cd_wrap text-center-xs p-t-10">
                      <h3 class="text-extra-large text-w-400 m-b-15 pink" ><?php echo JText::_( 'HAVE_DISCOUNT_CODE' ); ?></h3>
                      <div class="dis_cd_respons clearfix"></div>
                      <div class="input-group m-b-15">
                        <input id="discount_code" class="form-control txtbox discount_code_input" type="text" name="discount_code" placeholder="Enter dicount code" />
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-red val_disc_code">Validate</button>
                        </span>
                      </div>
                      <p>Enter your discount code and click the validation button to check your code.</p>
                    </div>
                	</div>
                </div>
                <div class="row action_row">
                  
                  
                </div>
              </div>
            </div>
            <input type="hidden" name="updatecart" value="1" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
