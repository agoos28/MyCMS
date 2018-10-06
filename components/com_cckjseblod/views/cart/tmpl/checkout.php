<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
global $mainframe;
$model = $this->getModel();
$cart = $model->getCart();
$session =& JFactory::getSession();
$discount = $session->get('discount');
$discount_type = $session->get('discount_type');
$user =& JFactory::getUser();
$request	=	(object)JRequest::get('default'); 

if($request->address){
	$address = (object) $request->address;
}else{
	$address = json_decode($user->address);
	$address = $address->address;
}
$count = 0;
$total = 0;
$hemat = 0;
if($cart){
	foreach($cart as $item){
    $checkAvailability = $model->checkAvailability($item->id,$item->option,$item->deliver);
    if($checkAvailability->err){
      $mainframe->redirect(JURI::base().'cart', 'Product date already taken', 'error');
      break;
    }
		if($item->oldprice){
			$hemat += ((int)$item->oldprice - (int)$item->price) * (int)$item->count; 
		}
		$total += ((int)$item->price * (int)$item->count);
		$totw += ((int)$item->weight * (int)$item->count);
		$count += (int)$item->count;
	}
	$subtotal = $total;
	if($discount){
		$discount_value = $discount;
		$total = $total - $discount_value;
	}
}else{
	$mainframe->redirect(JURI::base().'cart');
}

?>
<div id="content" class="checkout-view no-padding">
  <div class="container ">
    <div class="cart_c">
      <div class="row gutter-60">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-w-500 p-t-80 p-b-100 pull-right">
          <div class="ck-cart">
            <div class="ck-cart-togle">
              <div class="row no-margin">
                <div class="col-xs-6"> <a class="btn btn-link p-l-0 p-r-0 capitalize ck-cart-togle-btn purple"><span class="fa fa-shopping-basket"></span> Show order summary <span class="fa fa-angle-down"></span></a> </div>
                <div class="col-xs-6 text-right">
                  <div class="price text-large text-w-500" style="margin-top:3px;">Rp. <span class="subtotal"><?php echo number_format($total, 0, '', '.') ?></span></div>
                </div>
              </div>
            </div>
            <div class="m-b-30 hidden-xs">
              <h3 class="text-extra-large text-w-400 purple">Order Summary</h3>
            </div>
            <div class="ck-cart-body">
              <?php foreach($cart as $item){ 
							$opt = $model->getProductOption($item->id, 'pr_option', $item->option);
							 ?>
              <div class="row gutter-20">
                <div class="col-xs-3">
                  <div class="thumbnail no-margin"><img src="<?php echo $item->thumb ?>"></div>
                </div>
                <div class="col-xs-6"> <a class="text-w-500" href="<?php echo $model->getArticleLink($item->id); ?>"><strong><?php echo $item->title ?></strong></a>
                  <div class="size text-w-400 text-small m-t-5 m-b-5"><?php echo $opt->pr_opt_desc ?></div>
                  <div class="size"><?php echo $item->option ?></div>
                  <?php if($item->duration){ ?>
                  <div class="opt-desc text-small">
                    Deliver on : <?php echo JHtml::_('date', $item->deliver); ?> <br>
                    Pickup on : <?php echo JHtml::_('date', $item->pickup); ?>
                  </div>
                  <?php } ?>
                </div>
                <div class="col-xs-3 text-right">
                  <div class="price text-w-500 ">Rp. <span class="subtotal"><?php echo number_format(($item->price * $item->count), 0, '', '.') ?></span></div>
                </div>
                <div class="col-xs-12">
                  <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                </div>
              </div>
              <?php } ?>
              <div class="row">
              	
                <div class="col-xs-6 m-b-5 purple">Subtotal</div>
                <div class="col-xs-6 m-b-5 text-right purple">Rp. <span class="carttotal addDolar" data-carttotal="<?php echo $total; ?>"><?php echo number_format($subtotal, 0, '', '.') ?></span></div>
                <?php if($discount){ ?>
                  <div class="col-xs-6 m-b-5 purple">Discount</div>
                <div class="col-xs-6 m-b-5 text-right purple">-Rp. <span class="alldisc" data-value="<?php echo $discount_value; ?>"><?php echo number_format($discount_value, 0, '', '.') ?></span></div>
                <?php } ?>
                <div class="service-option m-b-60">
                    
                </div>
                <div class="col-xs-12">
                  <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                </div>
              </div>
              <div class="row purple">
                <div class="col-xs-6">Total</div>
                <div class="col-xs-6 text-right text-extra-large text-w-500">Rp. <span class="cktotal addDolar"><?php echo number_format($total, 0, '', '.') ?></span> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 p-t-80 p-b-100 white-bg">
          <div class="ship_frm_c">
            <div class="frm ship_frm">
              <div class="breadcrumbs m-b-30 text-w-400"> <a href="<?php echo JURI::base(); ?>cart">Cart</a> <i class="fa fa-chevron-right"></i> <a href="#" class="current">Customer & Shipping</a> <i class="fa fa-chevron-right"></i> <a href="#" class="disabled">Payment method</a> </div>
              <div class="alert alert-danger hide">
                <div class="notification"></div>
              </div>
              <?php 
                $document = JFactory::getDocument();
                $renderer = $document->loadRenderer('module');
                $module = JModuleHelper::getModule('login','Form Login');
                echo $renderer->render($module);
                ?>
              <form id="ckform" action="<?php echo JURI::current() ?>" method="post">
                <div id="customer-info" class="checkoutstep show">
                  <?php if ($user->guest){ ?>
                  <div class="m-b-30">
                    <div class="register-form m-b-15">
                    	<div class="m-b-15">
                        <h3 class="text-extra-large text-w-400 pink">Customer information</h3>
                      </div>
                      <div class="row">
                        <div class="col-xs-12" >
                          <input type="text" name="name" class="txtbox no-empty" placeholder="Full name" value="<?php echo $request->name; ?>">
                        </div>
                        <div class="col-xs-12" >
                          <input type="text" name="phone" class="txtbox no-empty num-only" placeholder="Handphone number" value="<?php echo $request->phone; ?>">
                        </div>
                        <div class="col-xs-12" >
                          <input type="text" name="email" class="txtbox no-empty check-mail" placeholder="Email" value="<?php echo $request->email; ?>">
                        </div>
                      </div>
                      <div class="row gutter-10">
                        <div class="col-xs-6">
                          <input type="password" name="password" class="txtbox no-empty" placeholder="Create password" value="<?php echo $request->password; ?>">
                        </div>
                        <div class="col-xs-6">
                          <input type="password" name="password2" class="txtbox no-empty" placeholder="Repeat password" value="<?php echo $request->password2; ?>">
                        </div>
                        <div class="col-xs-12">
                          <label class="checkbox-inline" for="nwl">
                            <input id="nwl" name="nwl" value="1" type="checkbox" class="chkbox icheckbox_minimal" />
                            Subscribe to our newsletter</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 text-right"> <a class="btn btn-block btn-purple show-login m-b-5">I aready have an account</a> </div>
                      <div class="col-xs-12 text-right"> <a style="display: none;" class="btn btn-block btn-purple show-register m-b-15">I'm new customer</a> </div>
                    </div>
                    <div class="row gutter-10 m-b-30">
                      <div class="col-xs-12 m-b-10 text-center"> ------ or use my ------ </div>
                      <div class="col-xs-6 m-b-5"> <a  class="btn btn-block btn-social btn-facebook fb-login text-center"><i class="fa fa-facebook"></i>Facebook Account</a> </div>
                      <div class="col-xs-6" id="gConnect">
                        <button type="button" id="g-login"
             								 data-theme="dark"
                            class="g-signin btn btn-block btn-social btn-google-plus text-center" ><i class="fa fa-google-plus"></i>Google Account</button>
                      </div>
                    </div>
                  </div>
                  <?php }else{ ?>
                  <div class="m-b-30">
                  	<div class="m-b-15">
                      <h3 class="text-extra-large text-w-400 pink">Customer information</h3>
                    </div>
                    <?php if($user->usertype == 'Super Administrator'){ ?>
                    <div class="row m-b-15">
                      <div class="col-sm-12">
                          <select id="asuser" name="user" class="txtbox">
                            <option value="">Use another user</option>
                          </select>
                      </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="txtbox"><span id="username"><?php echo $user->name; ?></span></div>
                      </div>
                      <div class="col-xs-12">
                      <?php if(!$user->phone){ ?>
                         <input type="text" name="phone" class="txtbox no-empty num-only" placeholder="Handphone number" value="<?php echo $request->phone; ?>">
                         <?php }else{ ?>
                         <div class="txtbox"><span id="phone"><?php echo $user->phone; ?></span></div>
                         <?php } ?>
                      </div>
                      <div class="col-xs-12">
                        <div class="txtbox"><span id="email"><?php echo $user->email; ?></span></div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <div class="m-b-30">
                    <div class="m-b-15">
                     <div class="row gutter-10">
                      <div class="col-sm-6">
                      	<h3 class="text-extra-large text-w-400 pink">Shipping address</h3>
											 </div>
											 <div class="col-sm-6 text-right">
												 <label for="self_delivery" class="m-r-15 m-t-5" style="font-size: 16px;line-height: 16px;">
                              <input class="no-empty" type="checkbox" id="self_delivery" name="self_delivery" value="1" placeholder="Pick up and drop off handled by the customer." determinate="false" />
                              Self Delivery
                          </label>
												 
											 </div>
											</div>
                    </div>
                    <div id="pickup_address" class="list-group block" style="display: none;">
                    <div class="list-group-item text-center padding-20" style="font-size: 14px;">
											<h2 class="m-b-10" style="text-align: center; font-size: 22px; font-weight: bold; color: #92278f; padding: 0px 0px;">Self Pick up & Drop Off</h2>
                   		<div style="padding: 0 20px;">
                    		Customer yang mengambil barangnya sendiri diwajibkan untuk menyerahkan copy KTP  sebagai arsip kami.
											</div>
											</div>
										</div>
                    <div id="address_form" class="">
                      <div class="row gutter-10">
                      <div class="col-sm-6">
                        <select id="country" name="address[country]" class="txtbox no-empty" disabled="disabled">
                          <?php if($address->country){ ?>
                          <option value="999" selected="selected"><?php echo $address->country_name; ?></option>
                          <?php }else{ ?>
                          <option value="999" selected="selected">Indonesia</option>
                          <?php } ?>
                        </select>
                        <input id="country_name" type="hidden" name="address[country_name]" value="<?php echo $address->country_name; ?>">
                      </div>
                      <div class="col-sm-6">
                        <select id="province" name="address[province]" class="txtbox no-empty">
                          <?php if($address->province){ ?>
                          <option value="<?php echo $address->province; ?>" selected="selected"><?php echo $address->province; ?></option>
                          <?php }else{ ?>
                          <option value="">Select Province/Kota</option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-sm-8">
                        <select id="district" name="address[district]" class="txtbox no-empty">
                          <?php if($address->district){ ?>
                          <option value="<?php echo $address->district; ?>" selected="selected"><?php echo $address->district_name; ?></option>
                          <?php }else{ ?>
                          <option value="">Select District/Kecamatan</option>
                          <?php } ?>
                        </select>
                        <input id="district_name" type="hidden" name="address[district_name]" value="<?php echo $address->district_name; ?>">
                      </div>
                      <div class="col-sm-4">
                        <input id="postal" name="address[postal]" type="text" class="txtbox no-empty" placeholder="Postal code" value="<?php echo $address->postal; ?>">
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="txtbox no-empty" id="address1" name="address[address]" value="<?php echo $address->address; ?>" placeholder="Address">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="txtbox" id="address2" name="address[address_opt]" placeholder="Apt, suit, etc (optional)" value="<?php echo $address->address_opt; ?>">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="row m-t-50 m-b-50">
                    <div class="col-sm-6 col-xs-12 text-right pull-right m-b-15"> <a href="#" class="btn btn-lg btn-red btn-block text-small to-shipping padding-15">Next Step &nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a> </div>
                    <div class="col-sm-6 col-xs-12"> <a href="<?php echo JURI::base(); ?>cart" class="btn btn-lg btn-link btn-xs-block text-small padding-15 pink"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp; Return to cart</a></div>
                  </div>
                  <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                  <a target="_blank" href="<?php echo JURI::base(); ?>terms-a-conditions" >Terms & Condition</a>
                </div>
                <div id="shipping-method" class="checkoutstep">
                  <div class="m-b-30">
                    <div class="well">
                      <div class="h5 m-b-10">Shipping Address</div>
                      <div class="recap"></div>
                    </div>
                  </div>
                  <div class="m-b-30">
                    <div class="m-b-15">
                      <h3 class="text-extra-large text-w-400 pink">Select Payment Method</h3>
                    </div>
                    <div class="">
                      <div class="row payment_methode gutter-15">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <label for="local" class="checked list-group block">
                          	<div class="list-group-item">
                              <div class="checkbox-inline">
                              <input id="local" type="radio" name="payment_methode" checked="checked" value="transfer" />
                              Bank Transfer </div>
                            </div>
                            <div class="list-group-item">
                              Using manual confirmation
                            </div>
                          </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6" style="opacity: .8;">
                        	<label for="midtrans" class="checked list-group block disabled">
                          	<div class="list-group-item">
                              <div class="checkbox-inline">
                              <input id="midtrans" type="radio" name="payment_methode" value="vtweb" disabled="disabled" />
                              Other Payment </div>
                            </div>
                            <div class="list-group-item">
                              Coming soon
                            </div>
                          </label>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                        	<label for="tnc" class="checked list-group block">
                          	<div class="list-group-item block">
                              <div class="checkbox-inline">
                              <input class="no-empty" type="checkbox" id="tnc" name="tnc" value="1" placeholder="Term and condition checkbox"  />
                              I agree for <a style="color: #e11f79;" target="_blank" href="<?php echo JURI::base(); ?>terms-a-conditions">terms & condition</a></div>
                            </div>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row m-t-50 m-b-50">
                    <div class="col-sm-6 col-xs-12 text-right pull-right m-b-15"> <a href="#" class="btn btn-lg btn-red btn-block text-small padding-15 sendck">Continue to Payment</a> </div>
                    <div class="col-sm-6 col-xs-12"> <a href="<?php echo JURI::base(); ?>cart" class="btn btn-lg btn-link btn-xs-block text-small padding-15 showinfo pink"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp; Customer & Shipping</a></div>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class=""> </div>
                  </div>
                </div>
                <?php echo JHTML::_( 'form.token' ); ?>
                <input type="hidden" name="task" value="checkout" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">

$(window).load(function(){
	
})
$(document).ready(function() {
	var loader = '<section class="text-center"><div id="outline"><div class="circle"></div></div><div class="desc">Please wait</div></section>'
	$('.show-login').click(function(e){
		e.preventDefault()
		$('.register-form').stop(true)
			$('.register-form').hide()
			$('#login-form').show()
			$('.show-login').hide()
			$('.show-register').show()
			$('.register-form input').prop("disabled", true)
	})
	
	$('.show-register').click(function(e){
		e.preventDefault()
		$('.register-form').stop(true)
			$('#login-form').hide()
			$('.register-form').show()
			$('.show-login').show()
			$('.show-register').hide()
			$('.register-form input').prop("disabled", false)
	})
	$('a.ck-cart-togle-btn').unbind('click')
	$('a.ck-cart-togle-btn').click(function(e){
		if($('.ck-cart-body').css('display') == 'none'){
			$('.ck-cart-body').show()
		}else{
			$('.ck-cart-body').hide()
		}
		e.preventDefault()
	})
	
	$('a.showinfo').click(function(e){
		e.preventDefault()
		document.querySelector('#content').scrollIntoView({ 
			behavior: 'smooth' 
		});
		$('.checkoutstep').not($('#customer-info')).removeClass('show')
		$('#customer-info').addClass('show')
	})
	
	
	$('#self_delivery').on('ifChecked', function(event){
		$('#pickup_address').show();
		$('#address_form').hide();
	});
	$('#self_delivery').on('ifUnchecked', function(event){
		$('#pickup_address').hide();
		$('#address_form').show();
	});
	
  $('#country').trigger('change')
	if($('#province').val() && !$('#district').val()){
		$('#province').trigger('change')
	}
	if($('#district').val()){
		if($('#province').val()){
		$.getJSON(baseUrl + 'cart', {
        getDistrict: $('#province').val()
      }, function(result) {
        $('#district').select2({
          data: result,
          theme: "bootstrap",
          minimumResultsForSearch: Infinity
        })
      })
		}
		$('#district').trigger('change')
	}
	
		$('.to-shipping').click(function(e){
			e.preventDefault()
			var err = checkForm('#customer-info')
			if($('#login-form').css('display') != 'none'){
				$('.show-register').click()
			}
				err = checkForm('#customer-info')

			if(err){
				document.querySelector('#content').scrollIntoView({ 
					behavior: 'smooth' 
				});
				$('#content .notification').html(err)
				$('#content .alert').removeClass('hide')
			}else{
				document.querySelector('#content').scrollIntoView({ 
					behavior: 'smooth' 
				});
				$('.checkoutstep').not($('#shipping-method')).removeClass('show')
				$('#shipping-method').addClass('show')	
				
				$('#content .alert').addClass('hide')
				var recap = $('#address1').val() +', '+ $('#address2').val() +'<br />' + $('#district').find('option:selected').text() +', '+ $('#province').val() +' '+ $('#postal').val() +'<br />'+ $('#country').find('option:selected').text()
				$('.recap').html(recap)
				
			}
		})
		
		$('#district').change(function(){
			$('.service-option').html(loader)
			$.post(baseUrl+'cart', {getShipping: 1, district: $('#district').val(), country: $('#country').val()}, function(result){
					
					$('.service-option').html(result)
					
					setTimeout(function(){
						if($('.alldisc').length){
							$('.cktotal').text(
								addCommas(
									parseInt($('.shipping-cost').data('shipping-cost')) + 
									parseInt(removeCommas($('.carttotal').text())) - 
									parseInt($('.alldisc').data('value'))
								)
							)
						}else{
							$('.cktotal').text(
								addCommas(
									parseInt($('.shipping-cost').data('shipping-cost')) + 
									parseInt(removeCommas($('.carttotal').text()))
								)
							)
						}
					},500)
				}	
			)
		})
		
		$('.to-payment').click(function(e){
			e.preventDefault()
			var err = checkForm('#customer-info')
			if(!$('#district').val()){
				err = true
			}
			if(err){
				document.querySelector('#content').scrollIntoView({ 
					behavior: 'smooth' 
				});
				$('#content .notification').html(err)
				$('#content .alert').removeClass('hide')
			}else{
				document.querySelector('#content').scrollIntoView({ 
					behavior: 'smooth' 
				});
				$('#shipping-method').addClass('show')
				$('.checkoutstep').not($('#shipping-method')).removeClass('show')
				$('#content .alert').addClass('hide')
				var recap = $('#address1').val() +', '+ $('#address2').val() +'<br />' + $('#district').find('option:selected').text() +', '+ $('#province').val() +' '+ $('#postal').val() +'<br />'+ $('#country').find('option:selected').text()
				$('.recap').html(recap)
				
			}
		})
});
</script>