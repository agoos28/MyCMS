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
<?php 
$model = &$this->getModel();
$params =& $mainframe->getParams();

if(JRequest::getVar('methode') == 'manual'){
	$invoiceID = str_replace('#','',JRequest::getVar('id'));
}else{
	$invoiceID = base64_decode(JRequest::getVar('id'));
}



function getDiscount($code=0, $total=0){
	$result = new stdClass();
	$db = JFactory::getDBO();
	$query = "SELECT value FROM #__promo_code WHERE code = '".$code."'";
	$db->setQuery($query);
	$value = $db->loadResult();
	$error = $db->getErrorMsg();
	if($value){
		$result->discount = $value;
		$result->total = $total - ($total * ($value/100));
	}else{
		$result->discount = '';
		$result->total = $total;
	}
	return $result;
}
function getOrder($id = 0){
	$result = new stdClass();
	$db = JFactory::getDBO();
	$query = 	"SELECT a.*, b.*, c.name FROM #__cart_order AS a".
				" LEFT JOIN #__cart_payment AS b ON b.order_id = a.id".
				" LEFT JOIN #__users AS c ON c.id = a.user".
				" WHERE a.id=".(int)$id;
	$db->setQuery($query);
	$order = $db->loadObject();
	$error = $db->getErrorMsg();
	if($error){
		//JFactory::getApplication()->enqueueMessage('DB Query ERROR!, '.$error, 'ERROR');
	}
	if(!$order){
		JFactory::getApplication()->enqueueMessage('Order not found!, '.$error, 'ERROR');
		return false;
	}
	$products = json_decode($order->products);
	$prod_tot = 0;
	$total = 0;
	$shipment = json_decode($order->shipment);
	$product = '';
	foreach($products as $item){
		$thumb = str_replace('_thumb1','_thumb1',$item->thumb);
		$subtotal = (int)$item->count * (int)$item->price;
		$prod_tot += $subtotal;
		$product .= '<div class="row gutter-20">
                <div class="col-xs-3">
                  <div class="thumbnail no-margin"><img src="'.JURI::base().$thumb.'"></div>
                </div>
                <div class="col-xs-6"> <a href="#"><strong>'.$item->title.'</strong></a>
                  <div class="size text-w-400">'.$item->option.'</div>
                  <div class="itemcount type-sm-bl">
									Deliver on : '.JHtml::_('date', $item->deliver).' <br>
                  Pickup on : '.JHtml::_('date', $item->pickup).'
									</div>
                </div>
                <div class="col-xs-3 text-right">
                  <div class="price">Rp. <span class="subtotal">'.number_format($subtotal, 0, '', '.').'</span></div>
                </div>
                <div class="col-xs-12">
                  <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                </div>
              </div>';
	}
	
	if($shipment->pricing > 100){
		$shipment_cost = 'Rp. '.number_format($shipment->pricing, 0, '', '.');
		$grand_total = $prod_tot + ($shipment->pricing);
	}else{
		$shipment_cost = 'Free';
		$grand_total = $prod_tot;
	}
	$product .= '';
	
	$product .= '<div class="row">
                <div class="col-xs-6 m-b-5 purple">Subtotal</div>
                <div class="col-xs-6 m-b-5 text-right">Rp. <span class="carttotal addDolar">'.number_format($prod_tot, 0, '', '.').'</span></div>
                '.html_entity_decode($shipment->method_desc).'
                <div class="col-xs-12">
                  <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                </div>
              </div>';
							
	if($order->disc_code){
		$discount = $grand_total - $order->value;
		$product .= '<div class="row purple">
                <div class="col-xs-6 m-b-5">Discount</div>
                <div class="col-xs-6 m-b-5 text-right">-Rp. <span class="carttotal addDolar">'.number_format($discount, 0, '', '.').'</span></div></div>';
	}
		
   $product .= '<div class="row purple">
                <div class="col-xs-6">Total</div>
                <div class="col-xs-6 text-right text-extra-large text-w-500">Rp. <span class="cktotal addDolar">'.number_format($order->value, 0, '', '.').'</span> </div>
              </div>';
	
	$result->product = $product;
	$result->order = $order;
	$result->shipment = $shipment;
	return $result;
}
if($invoiceID){
	$order_detail = getOrder($invoiceID);
	$ts = $model->viewOrderFree($invoiceID);
}
$user	= JFactory::getUser();
$var = array(
	'{user_name}' => $user->name,
	'{confirm_link}' => JURI::base().'payment-confirmation?id='.base64_encode($order_detail->order->id),
	'{total_price}' => number_format($order_detail->order->value, 0, '', '.')
);
$content = strtr($jSeblod->wysiwyg_text->value, $var);

$shipment = $order_detail->shipment;

//print_r($order_detail);

?>
<?php if(!$invoiceID || !$ts){ ?>

<div id="content" class="checkout-view no-padding">
  <div class="container ">
    <div class="ship_frm_c">
      <div class="frm ship_frm">
        <div class="row gutter-60">
          <div class="col-sm-6 m-t-50 m-b-50">
            <div class="alert alert-danger hide">
              <div class="notification"></div>
            </div>
            <div class="m-b-15">
              <h3 class="text-extra-large text-w-400 pink">Masukkan Order ID</h3>
            </div>
            <p><span style="font-size: 10px;"><span style="font-size: 12px;">Masukkan pada form dibawah Order ID anda pada saat melakukan pesanan dan pada email tagihan atau anda bisa bisa melihatnya di <a href="<?php echo JURI::base(); ?>transactions">history transaksi anda.</a></strong> </span></span></p>
            <form method="post"  action="<?php echo JURI::current(); ?>" enctype="multipart/form-data" id="ckform" class="" >
              <input id="id" name="id" class="txtbox no-empty" placeholder="Order ID, Contoh: #1234" type="text" />
              <input type="hidden" name="methode" value="manual" />
              <div class="text-right">
                <button type="submit" class="btn btn-lg btn-red text-small padding-15 sendck">Find Order</button>
              </div>
            </form>
          </div>
          <div class="col-sm-6 m-t-50 m-b-100">
            <div class="m-b-30">
              <div class="m-b-15">
                <h3 class="text-extra-large text-w-400 pink" >How to pay with bank transfer</h3>
              </div>
              <p><span style="font-size: 10px;"><span style="font-size: 12px;">Apabila anda belum melakukan pembayaran, anda bisa melakukan pembayaran melalui bank transfer ke rekening berikut. </span></span></p>
              <table class="table table-bordered" style="width: 100%; height: 77px;" cellpadding="0" border="1">
                <tbody>
                  <tr>
                    <td class="partition-pink" style="text-align: center;"><span style="font-size: 10px;">Bank</span>&nbsp;</td>
                    <td class="partition-pink" style="text-align: center;"><span style="font-size: 10px;">Nomor Rekening</span></td>
                    <td class="partition-pink" style="text-align: center;"><span style="font-size: 10px;">Atas Nama</span></td>
                  </tr>
                  <tr>
                    <td style="text-align: center;"><strong>BCA</strong></td>
                    <td style="text-align: center;"><strong>345-014-7426</strong></td>
                    <td style="text-align: center;"><strong>Annisa Oktantiani</strong></td>
                  </tr>
                  <tr>
                    <td style="text-align: center;"><strong>MANDIRI</strong></td>
                    <td style="text-align: center;"><strong>157-000-541-3365 </strong></td>
                    <td style="text-align: center;"><strong>Trie Utari</strong></td>
                  </tr>
                </tbody>
              </table>
              <p>Apabila anda menemukan kesulitan atau pertanyaan silahkan <a target="_blank" href="<?php echo JURI::base(); ?>contact">hubungi kami</a>.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }else{ ?>
<link rel="stylesheet" href="<?php echo $url; ?>templates/blank_j15/css/bootstrap-datepicker3.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $url; ?>templates/admin/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css" type="text/css" />
<script type="text/javascript" src="<?php echo JURI::base(); ?>templates/blank_j15/js/bootstrap-datepicker.min.js"></script> 
<script type="text/javascript" src="<?php echo JURI::base(); ?>templates/admin/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script> 
<script type="text/javascript">
jQuery(document).ready(function(e) {
		$('#date').datepicker();
});
</script>
<?php 

$shipment = json_decode($ts->shipment);
$pi = json_decode($ts->products);

if($ts->status == 'confirmed'){
	$status = '<span style="color: #FFA544;">'.JText::_( 'Confirmed' ).'</span>';
}elseif($ts->status == 'ready'){
	$status = '<span style="color: #9687D9;">'.JText::_( 'Ready to be delivered' ).'</span>';
}elseif($ts->status == 'on_delivery'){
	$status = '<span style="color: #299FE9;">'.JText::_( 'On Delivery' ).'</span>';
}elseif($ts->status == 'complete'){
	$status = '<span style="color: #A7D267;">'.JText::_( 'Completed' ).'</span>';
}elseif($ts->status == 'expired'){
	$model->redirect('', JURI::base(), 'Order is Expired', 'ERROR');
}else{
	$status = '<span style="color: #F53A3A;">'.JText::_( 'Waiting Payment' ).'</span>';
}



?>
<div id="content" class="checkout-view no-padding">
  <div class="container ">
    <div class="cart_c">
      <div class="row gutter-60">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-w-400 p-t-100 p-b-100 pull-right">
          <div class="m-b-20">
            <div class="ck-cart-togle">
              <div class="row no-margin">
                <div class="col-xs-6"> <a class="btn btn-link p-l-0 p-r-0 capitalize ck-cart-togle-btn"><span class="fa fa-shopping-basket"></span> Show order summary <span class="fa fa-angle-down"></span></a> </div>
                <div class="col-xs-6 text-right">
                  <div class="price text-large text-w-500" style="margin-top:3px;">Rp.<?php echo number_format($ts->value, 0, '', '.'); ?></div>
                </div>
              </div>
            </div>
            <div class="ck-cart-body">
              <div class="h5 m-b-10 purple">Shipping Address</div>
              <div class="recap text-w-400"> <?php echo $shipment->address->name; ?><br />
                <?php echo $shipment->address->address; ?> <?php echo $shipment->address->address_opt; ?><br />
                <?php echo $shipment->address->district_name; ?>, <?php echo $shipment->address->province; ?> <?php echo $shipment->address->postal; ?><br />
                <?php echo $shipment->address->country_name; ?><br />
                <?php echo $shipment->address->phone; ?> </div>
              <div class="border-bottom border-dark p-t-15 m-b-15"></div>
              <div class="ck-cart">
                <div class="h5 m-b-10 purple">Product</div>
                <?php echo $order_detail->product; ?> </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 p-t-80 p-b-100 padding-xs-0 white-bg">
          <div class="ship_frm_c">
            <div class="frm ship_frm">
              <div class="m-b-60">
                <div class="m-b-15">
                  <h3 class="text-extra-large text-w-400" style="color: #ed2a88;">Confirm your bank transfer</h3>
                </div>
                <p><span style="font-size: 12px;">Konfirmasikan pembayaran transfer anda untuk pemesanan <strong>Order ID #<?php echo $ts->id; ?></strong> pada tanggal <?php echo JHtml::_('date', $ts->order_date, '%d %B %Y %H:%M'); ?> sebesar <strong>Rp.&nbsp;<?php echo number_format($ts->value, 0, '', '.'); ?></strong>, menggunakan form dibawah.</span></p>
                <div class="alert alert-danger hide">
                  <div class="notification"><?php echo $this->error; ?></div>
                </div>
                <form method="post" enctype="multipart/form-data" id="ckform" class="" >
                  <div class="row gutter-10">
                    <div class="col-sm-8" >
                      <input id="from_acc" type="text" name="from_acc" class="txtbox no-empty" placeholder="Nama pemegang rekening" />
                    </div>
                    <div class="col-sm-4" >
                      <input id="from" type="text" name="from" class="txtbox no-empty" placeholder="Nomor rekening pengirim" />
                    </div>
                    <div class="col-sm-5" >
                      <input id="date" class="txtbox no-empty date-picker" data-date-format="dd-mm-yyyy" data-date-viewmode="years" type="text" name="payment_date" placeholder="Tanggal transfer" />
                    </div>
                    <div class="col-sm-7" >
                      <input id="amount" type="text" name="amount" class="txtbox no-empty num-only" placeholder="Nominal transfer (<?php echo number_format($ts->value, 0, '', '.'); ?>)"  />
                    </div>
                    <div class="col-sm-12 col-xs-12 m-b-30">
                      <select id="to" name="to" class="txtbox no-empty">
                        <option value="">Ke rekening (pilih)</option>
                        <option value="BCA - 3450147426 – Annisa Oktantiani">BCA : 3450147426 – a/n: Annisa Oktantiani</option>
                        <option value="Mandiri - 1570005413365 – Trie Utari">Mandiri : 1570005413365 – a/n Trie Utari</option>
                      </select>
                    </div>
                    <div class="col-sm-6 col-xs-12" >
                      <label class="pink">Scan/Foto bukti transfer</label>
                      <div id="bukti_bayar_container" class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA?text=no+image" alt=""/> </div>
                        <div class="fileupload-preview fileupload-exists thumbnail"></div>
                        <div> <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
                          <input id="bukti_bayar" type="file" accept="image/*" />
                          </span> <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload"> <i class="fa fa-times"></i> Remove </a> </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-xs-12" >
                      <label class="pink">Scan/Foto kartu identitas(ktp/sim/passport)</label>
                      <div id="ident_container" class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA?text=no+image" alt=""/> </div>
                        <div class="fileupload-preview fileupload-exists thumbnail"></div>
                        <div> <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
                          <input id="ident" type="file" accept="image/*" />
                          </span> <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload"> <i class="fa fa-times"></i> Remove </a> </div>
                      </div>
                    </div>
                  </div>
                  <div class="row m-t-30 m-b-30">
                    <div class="col-sm-6 col-xs-12 text-right m-b-15">
                      <button type="submit" class="btn btn-lg btn-red btn-block text-small padding-15 sendck">Send Confirmation</button>
                    </div>
                    <div class="col-sm-6 col-xs-12"> </div>
                  </div>
                  <input name="ident" class="no-empty" type="hidden" placeholder="Scan/Foto kartu identitas(ktp/sim/passport)" />
                  <input name="bukti_bayar" class="no-empty" type="hidden" placeholder="Scan/Foto bukti transfer" />
                  <input type="hidden" name="task" value="confirmation" />
                  <input type="hidden" name="invoice_id" value="<?php echo $invoiceID; ?>" />
                </form>
                <div class="m-b-30">
                  <div class="m-b-15">
                    <h3 class="text-extra-large text-w-400" style="color: #ed2a88;">How to pay with bank transfer</h3>
                  </div>
                  <p><span style="font-size: 10px;"><span style="font-size: 12px;">Apabila anda belum melakukan pembayaran, anda bisa melakukan pembayaran melalui bank transfer ke rekening berikut dengan nominal <strong>Rp.<?php echo number_format($ts->value, 0, '', '.'); ?>.</strong> </span></span></p>
                  <table class="table table-bordered" style="width: 100%; height: 77px;" cellpadding="0" border="1">
                    <tbody>
                      <tr class="partition-pink">
                        <td style="text-align: center;"><span style="font-size: 10px;">Bank</span>&nbsp;</td>
                        <td style="text-align: center;"><span style="font-size: 10px;">Nomor Rekening</span></td>
                        <td style="text-align: center;"><span style="font-size: 10px;">Atas Nama</span></td>
                      </tr>
                      <tr>
                        <td style="text-align: center;"><strong>BCA</strong></td>
                        <td style="text-align: center;"><strong>345-014-7426</strong></td>
                        <td style="text-align: center;"><strong>Annisa Oktantiani</strong></td>
                      </tr>
                      <tr>
                        <td style="text-align: center;"><strong>MANDIRI</strong></td>
                        <td style="text-align: center;"><strong>157-000-541-3365 </strong></td>
                        <td style="text-align: center;"><strong>Trie Utari</strong></td>
                      </tr>
                    </tbody>
                  </table>
                  <p>Apabila anda menemukan kesulitan atau pertanyaan silahkan <a target="_blank" href="<?php echo JURI::base(); ?>contact">hubungi kami</a>.</p>
                </div>
                <div class="border-bottom border-dark p-t-15 m-b-15"></div>
                <a target="_blank" href="<?php echo JURI::base(); ?>terms-a-conditions">Terms &amp; Condition</a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>