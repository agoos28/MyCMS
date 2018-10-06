<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$model = $this->getModel();
$rented = $model->getRentedProducts();

JModel::addIncludePath (JPATH_SITE . DS . 'components' . DS . 'com_cckjseblod' . DS . 'models');
$cart_model =& JModel::getInstance('cart', 'CCKjSeblodModel');

///echo'<pre>';print_r($rented);echo'</pre>';die();

?>

<div id="content">
  <div class="container">
    <div class="cart_c frm">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-right">
          <div class="history">
            <div class="list-group">
                  <div class="list-group-item">
                    <h5 class="pink">Rented Products</h5>
                  </div>
                  <?php foreach($rented as $item){ 
									$product = $cart_model->getRawContent($item->product_id); 
									$pickup = strtotime($item->pickup);
									$now = strtotime(date('Y-m-d'));
									$daysLeft  = round(($pickup - $now) / (60 * 60 * 24));
									$product->thumb = $cart_model->getTumbnail($product->imagex);
									$extendbility = $cart_model->checkExtendbility($item->product_id, $item->pickup);
									?>
                  <div id="<?php echo $product->id ?>" class="list-group-item">
                    <div class="row">
                      <div class="col-xs-8">
                        <div class="pull-left m-r-15"> 
                        <a href="<?php echo $cart_model->getArticleLink($product->id); ?>">
                        <img class="thumbnail m-b-5 m-t-5" style="width: 100px;" src="<?php echo $product->thumb; ?>" draggable="false"> 
													</a>
                        </div>
                        <div class="desc media-body p-t-15" style="font-size: 14px;"> <a class="text-bold m-b-5" href="<?php echo $cart_model->getArticleLink($product->id); ?>" style="font-size: 18px;"><?php echo $item->title ?></a>
                          <div class="size text-w-400"><?php echo $product->option; ?></div>
                          <div class="itemcount type-sm-bl"> Deliver on : <?php echo JHtml::_('date', $item->deliver); ?> <br>
                            Pickup on : <?php echo JHtml::_('date', $item->pickup) ?> <br />
														<a href="<?php echo JURI::base(); ?>transactions?layout=transaction_view&id=<?php echo base64_encode($item->order_id); ?>" class="small btn-link">&gt; View Transaction</span></a>
                            </div>
                        </div>
                      </div>
                      <div class="col-xs-4 text-right text-w-500 p-t-20"> 
                      	<div style="font-size: 22px; font-weight: bold; margin-bottom: 5px;">
                      		<?php 
													if($daysLeft > 0){
														if($daysLeft == 1){
															echo $daysLeft.' Day left'; 
														}else{
															echo $daysLeft.' Days left'; 
														}
													}else{
														if($daysLeft == -1){
															echo ($daysLeft*-1).' Day overdue'; 
														}else{
															echo ($daysLeft*-1).' Days overdue'; 
														}
													}
													?>
                     		</div>
                     		<button class="btn btn-sm show-extend btn-red" data-id="<?php echo $product->id; ?>" data-extendbility="<?php echo $extendbility; ?>">Extend Booking</button>
                      </div>
                      <div id="extend-container-<?php echo $product->id; ?>" class="col-sm-12 hide">
												<div class="m-b-10 purple text-bold">Select extend duration</div>
                      <?php  $options = $cart_model->getProductOption($product->id); ?>
                        <table class="table table-bordered option-container">
                        <tbody>
                          <?php $i=0; foreach($options as $opt){ $opt = (object) $opt;
														if($opt->pr_opt_days > $extendbility){
															continue;
														}; $i++; 			
													?>
                          <tr>
                            <td><label class="m-l-20 m-b-0" style="display: block;line-height: 19px;">
                                <input type="radio" name="option-<?php echo $product->id; ?>" value="<?php echo $opt->pr_option; ?>" data-price="<?php echo $opt->pr_opt_price; ?>" data-days="<?php echo $opt->pr_opt_days; ?>" />
                                <?php echo $opt->pr_option; ?> (<?php echo $opt->pr_opt_days; ?> hari) - <span class="woocommerce-Price-amount amount">Rp <?php echo number_format($opt->pr_opt_price, 0, '', '.'); ?></span></label></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                      <div class="text-center m-b-10">
                      <button data-id="<?php echo $product->id; ?>" class="btn btn-default hide-extend" type="button">Cancel</button>
                      <button class="addcart btn btn-red" 
												data-id="<?php echo $product->id ?>"
												data-title="<?php echo $product->title; ?>"
												data-thumb="<?php echo $product->thumb; ?>"
												data-booking_type="extend"
												data-pickup="<?php echo $item->pickup; ?>"
												data-text="Book Now"
											>Extend Now</button>
												</div>
											</div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <?php 
						$document = JFactory::getDocument();
						$renderer = $document->loadRenderer('module');
						$module = JModuleHelper::getModule('login','Sidebar Login');
						echo $renderer->render($module);
					?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
