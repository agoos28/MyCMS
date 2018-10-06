<?php 

/**
 * Joomla! 1.5 component myextension
 * Code generated by : Danny's Joomla! 1.5 MVC Component Code Generator (v 0.7 beta )
 * http://www.joomlafreak.be
 * date generated:  
 * @package myextension
 * @license GNU Public License (because open source matters...)
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-eJRpQ9CO4wXIkW9h"></script>
<?php 
$model = &$this->getModel();
$params =& $mainframe->getParams();
$invoice_id = JRequest::getVar('id');
if($invoice_id){
	$ts = $model->viewOrderFree($invoice_id);
	$snapToken = $model->veritrans($invoice_id, '', true);
}
//$order = $model->viewOrder($invoiceID);
//$order = $model->viewOrder(77);

//print_r($ts);
?>
<script type="text/javascript">
	snap.show();
	//$(window).load(function(e) {

	//});
	
	snap.pay('<?php echo $snapToken; ?>', {
		onSuccess: function(result){console.log('success');console.log(result);},
		onPending: function(result){console.log('pending');console.log(result);},
		onError: function(result){console.log('error');console.log(result);},
		onClose: function(){console.log('customer closed the popup without finishing the payment');}
	})

</script>
<div class="container">

</div>

<?php 

$shipment = json_encode($ts->shipment);
if($ts->status == 'confirmed'){
	$status = '<span style="color: #FFA544;">'.JText::_( 'Confirmed' ).'</span>';
}elseif($ts->status == 'ready'){
	$status = '<span style="color: #9687D9;">'.JText::_( 'Ready to be delivered' ).'</span>';
}elseif($ts->status == 'on_delivery'){
	$status = '<span style="color: #299FE9;">'.JText::_( 'On Delivery' ).'</span>';
}elseif($ts->status == 'complete'){
	$status = '<span style="color: #A7D267;">'.JText::_( 'Completed' ).'</span>';
}elseif($ts->status == 'expired'){
	$referer = $_SERVER['HTTP_REFERER'];
	if (strpos($referer,'lunahabit.com') !== false) {
		$model->redirect('', $referer, 'Order is Expired', 'ERROR');
	}else{
		$model->redirect('', JURI::base(), 'Order is Expired', 'ERROR');
	}
}else{
	$status = '<span style="color: #F53A3A;">'.JText::_( 'Waiting Payment' ).'</span>';
	$actbut = '<a class="next_btn" href="'.JURI::base().'payment-confirmation?id='.base64_encode($ts->id).'" style="display: inline-block;">'.JText::_( 'CONFIRM_PAYMENT' ).'</a>';
}

$pi = (array)json_decode($ts->products);
?>



<div id="content" class="checkout-view no-padding">
  <div class="container ">
    <div class="cart_c">
      <div class="row gutter-60">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-w-500 p-t-100 p-b-100 pull-right">
          <div class="ck-cart">
            <div class="ck-cart-togle">
              <div class="row no-margin">
                <div class="col-xs-6"> <a class="btn btn-link p-l-0 p-r-0 capitalize ck-cart-togle-btn"><span class="fa fa-shopping-basket"></span> Show order summary <span class="fa fa-angle-down"></span></a> </div>
                <div class="col-xs-6 text-right">
                  <div class="price text-large text-w-500" style="margin-top:3px;">Rp. <span class="subtotal"><?php echo number_format($total, 0, '', '.') ?></span></div>
                  <?php if($hemat){ ?>
                  <div class="olpricetot text-red">Anda hemat Rp. <span class="allold"><?php echo number_format(($hemat), 0, '', '.') ?></span></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="ck-cart-body">
              <?php foreach($pi as $item){  ?>
              <div class="row gutter-20">
                <div class="col-xs-3">
                  <div class="thumbnail no-margin"><img src="<?php echo $item->thumb ?>"></div>
                </div>
                <div class="col-xs-5"> <a href="<?php echo $model->getArticleLink($item->id); ?>"><strong><?php echo $item->title ?></strong></a>
                  <div class="size"><?php echo $item->size ?></div>
                  <div class="itemcount type-sm-bl">Rp. <span class="prc"><?php echo number_format((int)$item->price, 0, '', '.'); ?></span> x <span class="cnt"><?php echo $item->count; ?></span></div>
                </div>
                <div class="col-xs-4 text-right">
                  <div class="price">Rp. <span class="subtotal"><?php echo number_format(($item->price * $item->count), 0, '', '.') ?></span></div>
                </div>
                <div class="col-xs-12">
                  <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                </div>
              </div>
              <?php } ?>
              <div class="row">
                <div class="col-xs-6 m-b-5">Subtotal</div>
                <div class="col-xs-6 m-b-5 text-right">Rp. <span class="carttotal addDolar" data-carttotal="<?php echo $total; ?>"><?php echo number_format($total, 0, '', '.') ?></span></div>
                <div class="col-xs-6" ><?php echo JText::_( 'SHIPMENT' ); ?></div>
                <div class="col-xs-6 text-right">Rp. <span class="shippingcost addDolar">0</span> </div>
                <div class="col-xs-12">
                  <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">Total</div>
                <div class="col-xs-6 text-right text-extra-large text-w-500">Rp. <span class="cktotal addDolar"><?php echo number_format($total, 0, '', '.') ?></span> </div>
              </div>
              <div class="hide">
                <div class="">
                  <h5><?php echo JText::_( 'HAVE_DISCOUNT_CODE' ); ?></h5>
                </div>
                <div class="">
                  <div class="dis_cd_respons"></div>
                  <div class="input-group">
                    <input id="discount_code" class="txtbox discount_code_input" type="text" name="discount_code" />
                    <span class="input-group-btn">
                    <button type="button" class="val_disc_code btn btn-yellow"><?php echo JText::_( 'GET' ); ?></button>
                    </span> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 p-t-80 p-b-100 white-bg">
          <div class="ship_frm_c">
            <div class="frm ship_frm">
              <div class="breadcrumbs m-b-30 text-w-400"> <a href="#">Cart</a> <i class="fa fa-chevron-right"></i> <a href="#" class="current">Customer information</a> <i class="fa fa-chevron-right"></i> <a href="#" class="disabled">Shipping method</a> <i class="fa fa-chevron-right"></i> <a href="#" class="disabled">Payment method</a> </div>
              <div class="alert alert-danger hide">
                <div class="notification"></div>
              </div>
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
</div>
</div>
	
