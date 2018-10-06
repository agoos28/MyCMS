<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php' );

JModel::addIncludePath (JPATH_SITE . DS . 'components' . DS . 'com_cckjseblod' . DS . 'models');
$cart_model =& JModel::getInstance('cart', 'CCKjSeblodModel');


$user	= JFactory::getUser();
$model = $this->getModel();
$id = base64_decode(JRequest::getVar('id'));
$ts = $model->viewTransaction($id);

$shipment = json_decode($ts->shipment);

$pi = json_decode($ts->products);

//echo'<pre>';print_r($ts->products);echo'</pre>';

if($ts->resi){
	$resi = json_decode($ts->resi);
	$tracking = $cart_model->getShippingTracking($resi->code, $resi->courier);
	//echo'<pre>';print_r($tracking);echo'</pre>';
}


?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $cart_model->_VTclientKey; ?>"></script>

<div id="content">
  <div class="container">
    <div class="cart_c frm">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-right">
          <?php if($ts){ ?>
          <div class="history">
            <h3 class="text-extra-large text-w-400 m-b-15 purple"><?php echo JText::_( 'TRANSACTION_DETAIL' ); ?> Order ID #<?php echo $ts->id; ?></h3>
            <?php if(JRequest::getVar('err') && $ts->payment_id){ ?>
            <div class="alert alert-danger">
              <button data-dismiss="alert" class="close"> × </button>
              <?php if(JRequest::getVar('err') == 'unfinish'){ ?>
              <strong>You not yet finish the online payment, </strong> <br />
              Your order is stored under your account, to submitting payment click payment button bellow.
              <?php }else{ ?>
              <strong>Oops! </strong> something gone wrong. <br />
              Your order is stored under your account, to submitting payment again click payment button bellow.
              <?php } ?>
            </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-4 col-sm-12 col-xs-12 pull-right">
                <div class="list-group">
                  <div class="list-group-item">
                    <h5 class="pink">ORDER</h5>
                  </div>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6"> <strong>Status</strong> </div>
                      <div class="col-md-7 col-sm-6 col-xs-6"> <?php echo $cart_model->statuslabel($ts->status); ?> </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6"> <strong><?php echo JText::_( 'ORDER_DATE' ); ?></strong> </div>
                      <div class="col-md-7 col-sm-6 col-xs-6"> <?php echo JHtml::_('date', $ts->order_date, '%A, %d %B %Y %H:%M'); ?> </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6"> <strong>Product</strong> </div>
                      <div class="col-md-7 col-sm-6 col-xs-6 text-w-500"> Rp. <?php echo number_format($ts->value - ($shipment->pricing), 0, '', '.'); ?> </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6"> <strong>Shipping</strong> </div>
                      <div class="col-md-7 col-sm-6 col-xs-6 text-w-500"> Rp. <?php echo number_format($shipment->pricing, 0, '', '.'); ?> </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6"> <strong>Total</strong> </div>
                      <div class="col-md-7 col-sm-6 col-xs-6 text-w-500"> Rp. <?php echo number_format($ts->value, 0, '', '.'); ?> </div>
                    </div>
                  </div>
                </div>
                <div class="list-group">
                  <div class="list-group-item">
                    <h5 class="pink">PAYMENT</h5>
                  </div>
                  <?php if($ts->payment_id){ ?>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6">
                        <h5 class="pink"><?php echo JText::_( 'METHOD' ); ?> </h5>
                      </div>
                      <div class="col-md-7 col-sm-6 col-xs-6"> <?php echo $ts->to; ?> </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6">
                        <h5 class="pink"><?php echo JText::_( 'DATE' ); ?> </h5>
                      </div>
                      <div class="col-md-7 col-sm-6 col-xs-6"> <?php echo JHtml::_('date', $ts->submit_date, '%A, %d %B %Y %H:%M'); ?> </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-6">
                        <h5 class="pink"><?php echo JText::_( 'AMOUNT' ); ?> </h5>
                      </div>
                      <div class="col-md-7 col-sm-6 col-xs-6"> Rp. <?php echo number_format($ts->payment_amount, 0, '', '.'); ?> </div>
                    </div>
                  </div>
                  <?php }else{ ?>
                  <div class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12"> <p>Belum ada pembayaran.</p> </div>
                    </div>
                  </div>
                  <?php } ?>
                  <div class="m-t-20 m-b-20"> <a class="btn btn-block btn-lg btn-red text-small m-b-5" href="<?php echo JURI::base(); ?>transactions?layout=transaction_view&id=<?php echo JRequest::getVar('id'); ?>&format=pdf" style="display: inline-block;"><i class="fa fa-file-pdf-o"></i> Download PDF</a> </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-12 col-xs-12">
                <?php if($ts->payment_id == false && $ts->status == 'new'){ ?>
                <div class="list-group">
                  <div class="list-group-item">
                    <h5 class="pink">Pembayaran melalui transfer antar bank</h5>
                  </div>
                  <div class="list-group-item">
                      
                        <p><span>Total yang harus anda transfer adalah<strong> Rp. <?php echo number_format($ts->value, 0, '', '.'); ?></strong> ,anda bisa melakukan pembayaran melalui bank transfer ke rekening berikut:</span></p>
                        <table class="table table-bordered" style="max-width: 500px; border: 1px solid #c7c7c7; width: 100%; height: 77px;" cellpadding="0" border="1">
                          <tbody>
                            <tr class="partition-pink">
                              <td style="text-align: center;"><span style="font-size: 10px;">Bank</span></td>
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
                        <p>Jika telah melakukan pembayaran, lakukan konfirmasi melalui link berikut</p>
                    <div class=""> <a class="btn btn-lg btn-red text-small m-b-5" href="<?php echo JURI::base().'payment-confirmation?id='.base64_encode($ts->id); ?>" style="display: inline-block;">Konfirmasi Pembayaran</a> 
                      <!--<a id="vtsnap" class="btn btn-lg btn-red text-small disabled" href="<?php echo JURI::base().'checkout?task=vtsnap&orderid='.base64_encode($ts->id); ?>" style="display: inline-block;">Pay Online Now</a>--> </div>
                  </div>
                </div>
                <?php } ?>
                <?php if($tracking){ ?>
                <div class="list-group">
                  <div class="list-group-item">
                    <h5 class="pink"><?php echo JText::_( 'SHIPPMENT TRACKING' ); ?></h5>
                  </div>
                  <div class="list-group-item">
                    <table class="table table-striped m-b-0">
                      <tbody>
                        <tr>
                          <td width="40%"><strong><?php echo JText::_( 'Delivery Status' ); ?></strong></td>
                          <td><?php echo $tracking->summary->status; ?></td>
                        </tr>
                        <tr>
                          <td width="40%"><strong><?php echo JText::_( 'Tracking Code' ); ?></strong></td>
                          <td><?php echo $tracking->summary->waybill_number; ?> <?php echo strtoupper($tracking->summary->courier_code); ?>-<?php echo $tracking->summary->service_code; ?></td>
                        </tr>
                        <tr>
                          <td width="40%"><strong><?php echo JText::_( 'Shippper Name' ); ?></strong></td>
                          <td><?php echo $tracking->summary->shipper_name; ?></td>
                        </tr>
                        <?php if($tracking->delivery_status->status == 'DELIVERED'){ ?>
                        <tr>
                          <td width="40%"><strong><?php echo JText::_( 'Receiver By' ); ?></strong></td>
                          <td><?php echo $tracking->delivery_status->pod_receiver; ?></td>
                        </tr>
                        <tr>
                          <td width="40%"><strong><?php echo JText::_( 'Received Date' ); ?></strong></td>
                          <td><?php echo JHTML::_('date',$tracking->delivery_status->pod_date); ?> <?php echo $tracking->delivery_status->pod_time; ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td width="40%"><strong>Manifest Tracking</strong></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row no-margin">
                      <?php foreach($tracking->manifest as $manifests){ ?>
                      <div class="col-sm-4 padding-5">
                        <div class="list-group m-b-0">
                          <div class="list-group-item small"> <strong><?php echo $manifests->manifest_description; ?></strong><br />
                            <span class="small"><?php echo JHTML::_('date',$manifests->manifest_date, '%a, %d %B %Y %H:%M'); ?> <?php echo $manifests->manifest_time; ?></span></div>
                          <div class="list-group-item small"> <strong><?php echo $manifests->city_name; ?></strong> </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <div class="list-group">
                  <div class="list-group-item">
                    <h5 class="pink"><?php echo JText::_( 'SHIPPING' ); ?></h5>
                  </div>
                  <div class="list-group-item p-b-0">
                    <table width="100%" class="table table-striped">
                      <tbody>
                        <tr>
                          <th><?php echo JText::_( 'SHIPPING_COST' ); ?></th>
                          <td class="text-w-500">Rp. <?php echo number_format($shipment->pricing, 0, '', '.'); ?></td>
                        </tr>
                        <tr>
                          <th width="40%"><?php echo JText::_( 'RECIEVER_NAME' ); ?></th>
                          <td><?php echo $shipment->address->name; ?></td>
                        </tr>
                        <tr>
                          <th><?php echo JText::_( 'RECIEVER_PHONE' ); ?></th>
                          <td><?php echo $shipment->address->phone; ?></td>
                        </tr>
                        <tr>
                          <th><?php echo JText::_( 'DESTINATION' ); ?></th>
                          <td><?php echo $shipment->address->district.' '.$shipment->address->province.' '.$shipment->address->country_name; ?></td>
                        </tr>
                        <tr>
                          <th><?php echo JText::_( 'ADDRESS' ); ?></th>
                          <td><?php echo $shipment->address->address.', '.$shipment->address->address_opt; ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><div class="row"><?php echo html_entity_decode($shipment->method_desc); ?></div></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="list-group">
                  <div class="list-group-item">
                    <h5 class="pink"><?php echo JText::_( 'PRODUCTS' ); ?></h5>
                  </div>
                  <?php foreach($pi as $item){ 
									$opt = $cart_model->getProductOption($item->id); 
									?>
                  <div id="<?php echo $item->id ?>" class="list-group-item">
                    <div class="row">
                      <div class="col-xs-8">
												<div class="pull-left m-r-15">
													<a href="<?php echo $cart_model->getArticleLink($item->id); ?>">
                       			<img class="thumbnail m-b-5 m-t-5" style="width: 100px;" src="<?php echo $item->thumb; ?>" draggable="false">
                       		</a> 
                       	</div>
                        <div class="desc media-body p-t-15"> <a class="text-bold" href="<?php echo $cart_model->getArticleLink($item->id); ?>" ><?php echo $item->title ?></a>
                          <div class="size text-w-400"><?php echo $item->option; ?></div>
                          <div class="itemcount type-sm-bl"> Deliver on : <?php echo JHtml::_('date', $item->deliver); ?> <br>
                            Pickup on : <?php echo JHtml::_('date', $item->pickup) ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-4 col-xs-3 text-right text-w-500 p-t-20"> 
												<div class="m-b-20">Rp. <?php echo number_format($item->price, 0, '', '.') ?> </div>
                      <button class="btn btn-sm show-extend btn-red" data-id="<?php echo $item->id; ?>">Extend Booking</button>
                      </div>
                      <div id="extend-container-<?php echo $item->id; ?>" class="col-sm-12 hide">
												<div class="m-b-10 purple text-bold">Select extend duration</div>
                      <?php  $options = $cart_model->getProductOption($item->id); ?>
                        <table class="table table-bordered option-container">
                        <tbody>
                          <?php $i=0; foreach($options as $opt){ $opt = (object) $opt; $i++; ?>
                          <tr>
                            <td><label class="m-l-20 m-b-0" style="display: block;line-height: 19px;">
                                <input type="radio" name="option-<?php echo $item->id; ?>" value="<?php echo $opt->pr_option; ?>" data-price="<?php echo $opt->pr_opt_price; ?>" data-days="<?php echo $opt->pr_opt_days; ?>" />
                                <?php echo $opt->pr_option; ?> (<?php echo $opt->pr_opt_days; ?> hari) - <span class="woocommerce-Price-amount amount">Rp <?php echo number_format($opt->pr_opt_price, 0, '', '.'); ?></span></label></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                      <div class="text-center m-b-10">
                      <button data-id="<?php echo $item->id; ?>" class="btn btn-default hide-extend" type="button">Cancel</button>
                      <button class="addcart btn btn-red" 
												data-id="<?php echo $item->id; ?>"
												data-title="<?php echo $item->title; ?>"
												data-thumb="<?php echo $item->thumb; ?>"
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
                <div class="m-b-30"> <a href="<?php echo JURI::base(); ?>transactions" class="btn btn-lg btn-link btn-xs-block text-small padding-15"><i class="fa fa-chevron-left"></i> <?php echo JText::_( 'VIEW_OTHER_TRANSACTION' ); ?></a> </div>
              </div>
            </div>
          </div>
          <?php }else{ ?>
          <div class="alert alert-danger text-center">
            <h5 class="pink">Transaction not found!</h5>
          </div>
          <?php } ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
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
