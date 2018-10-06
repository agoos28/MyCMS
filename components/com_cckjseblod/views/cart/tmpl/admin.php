<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );

//echo'<pre>';print_r($model->transaction);
$model = $this->getModel();

?>
<?php if(JRequest::getVar('invoice')){ 
	$listing = $model->viewOrderFree(JRequest::getVar('invoice'));
	require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php' );
$user	= JFactory::getUser();
$ts = $model->viewOrderAdmin(JRequest::getVar('invoice'));
$shipment = json_decode($ts->shipment);

if($ts->status == 'confirmed'){
	$status = '<span style="color: #FFA544;">'.JText::_( 'Confirmed' ).'</span>';
}elseif($ts->status == 'ready'){
	$status = '<span style="color: #9687D9;">'.JText::_( 'Ready to be delivered' ).'</span>';
}elseif($ts->status == 'new_cod'){
	$status = '<span style="color: #9687D9;">'.JText::_( 'New COD' ).'</span>';
}elseif($ts->status == 'expired'){
	$status = '<span class="label label-sm label-danger">Expired</span>';
}elseif($ts->status == 'on_delivery'){
	$status = '<span style="color: #299FE9;">'.JText::_( 'On Delivery' ).'</span>';
}elseif($ts->status == 'on_cod_delivery'){
	$status = '<span class="label label-sm label-info">On COD Delivery</span>';
}elseif($ts->status == 'complete'){
	$status = '<span class="label label-sm label-success">Complete</span>';
}else{
	$status = '<span class="label label-sm label-warning">Unpaid</span>';
	$actbut = '<a class="next_btn" href="'.JURI::base().'payment-confirmation?id='.base64_encode($ts->id).'" style="display: inline-block;">'.JText::_( 'CONFIRM_PAYMENT' ).'</a>';
}

$pi = (array)json_decode($ts->products);

if($ts->resi){
	$resi = json_decode($ts->resi);
	$tracking = $model->getShippingTracking($resi->code, $resi->courier);
}


?>

<div class="row">
  <div class="col-md-8">
    <div class="panel panel-white">
      <div class="panel-heading">
        <h4 class="panel-title">Order ID <span class="text-bold"> <?php echo $ts->id; ?> </span></h4>
        <div class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <dl>
              <dt>Order Date</dt>
              <dd><?php echo JHtml::_('date', $ts->order_date, '%a, %d %B %Y %H:%M'); ?></dd>
            </dl>
            <dl>
              <dt><?php echo JText::_( 'USER' ); ?></dt>
              <dd><?php echo $ts->name; ?></dd>
            </dl>
          </div>
          <div class="col-md-6">
            <dl>
              <dt>Total Shopping</dt>
              <dd>Rp. <?php echo number_format($ts->value, 0, '', '.') ?></dd>
            </dl>
            <dl>
              <dt><?php echo JText::_( 'EMAIL' ); ?></dt>
              <dd><?php echo $ts->email; ?></dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-white">
      <div class="panel-heading">
        <h4 class="panel-title">Product <span class="text-bold"> Items </span></h4>
        <div class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <table width="100%" class="table">
          <tr>
            <th class="sectiontableheader" colspan="2">Product</th>
            <th class="sectiontableheader" style="text-align:center;">QTY</th>
            <th class="sectiontableheader" style="text-align:right;" colspan="2">Subtotal</th>
          </tr>
          <?php $tot = 0;$totw = 0; foreach($pi as $item){ 
					?>
          <tr id="<?php echo $item->id ?>">
            <td valign="top"><div class="thumb" style="float: left;"> <span><img style="width: 100px;height: auto;" src="<?php echo str_replace('_thumb1', '_thumb1', $item->thumb) ?>" class="" draggable="false"> </span> </div></td>
            <td><div class="desc" style=""> <a href="<?php echo ContentHelperRoute::getArticleRoute($item->id); ?>"><strong><?php echo $item->title ?></strong></a>
                <div class="size"><?php echo $item->option ?></a></div>
                <?php if($item->duration){ ?>
                <div class="opt-desc">
                  Deliver on : <?php echo JHtml::_('date', $item->deliver); ?> <br>
                  Pickup on : <?php echo JHtml::_('date', $item->pickup); ?>
                </div>
                <?php } ?>
              </div></td>
            <td style="line-height: 30px;" valign="top" align="center"><?php echo $item->count ?></td>
            <td style="line-height: 30px;" valign="top" align="right" colspan="2"><div class="price">Rp. <?php echo number_format($item->price * $item->count, 0, '', '.') ?></div></td>
          </tr>
          <?php $tot += $item->price * $item->count; $totw += ($item->weight/10) * $item->count;} 
								
								if($ts->disc_code){
									
									$discount = ($shipment->pricing + $tot) - $ts->value;
								}
								
								?>
          <?php if($ts->disc_code){ 
					
					
					?>
          <tr>
            <td colspan="4" align="right" valign="top"><strong>Discount Code #<?php echo $ts->disc_code; ?></strong></td>
            <td align="right" valign="top">-Rp. <?php echo number_format($discount); ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="4" align="right" valign="top"><strong>TOTAL</strong></td>
            <td align="right" valign="top"><strong>Rp. <?php echo number_format($tot - $discount, 0, '', '.'); ?></strong></td>
          </tr>
        </table>
      </div>
    </div>
    <?php 
		if($tracking){
		?>
    <div class="panel panel-white">
      <div class="panel-heading">
        <h4 class="panel-title">Shipment <span class="text-bold"> Status</span></h4>
        <div class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel-body"> <strong class="padding-5">Manifest Tracking</strong>
        <div class="row no-margin">
          <?php foreach($tracking->manifest as $manifests){ ?>
          <div class="col-sm-4 padding-5">
            <div class="list-group-item small"> <strong><?php echo JHTML::_('date',$manifests->manifest_date); ?> <?php echo $manifests->manifest_time; ?></strong> </div>
            <div class="list-group">
              <div class="list-group-item small"> <strong>Status - <?php echo $manifests->manifest_description; ?></strong> </div>
              <div class="list-group-item small"> <strong><?php echo $manifests->city_name; ?></strong> </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <table class="table">
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
          </tbody>
        </table>
      </div>
    </div>
    <?php } ?>
    <div class="panel panel-white">
      <div class="panel-heading">
        <h4 class="panel-title">Shipment <span class="text-bold"> Destination</span></h4>
        <div class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <table class="table">
          <tbody>
            <tr>
              <td width="40%"><strong><?php echo JText::_( 'NAME' ); ?></strong></td>
              <td><?php echo $shipment->address->name; ?></td>
            </tr>
            <tr>
              <td width="40%"><strong><?php echo JText::_( 'PHONE' ); ?></strong></td>
              <td><?php echo $shipment->address->phone; ?></td>
            </tr>
            <tr>
              <td><strong><?php echo JText::_( 'WEIGHT' ); ?></strong></td>
              <td><?php echo $totw ?> Kg</td>
            </tr>
            <tr>
              <td><strong><?php echo JText::_( 'METHOD' ); ?></strong></td>
              <td><?php echo html_entity_decode($shipment->method_desc); ?></td>
            </tr>
            <tr>
              <td><strong><?php echo JText::_( 'ADDRESS' ); ?></strong></td>
              <td><?php echo $shipment->address->address.' '.$shipment->address->address_opt; ?> <br />
                <?php echo $shipment->address->district.' '.$shipment->address->province.' '.$shipment->address->country_name; ?></td>
            </tr>
            <tr>
              <td><strong><?php echo JText::_( 'Shipment Cost' ); ?></strong></td>
              <td><strong>IDR
                <?php
							$totship = $ts->value - $tot;
							echo number_format($shipment->pricing, 0, '', '.'); ?>
                </strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="panel panel-white">
      <div class="panel-heading">
        <h4 class="panel-title">Payment <span class="text-bold"> Information</span></h4>
        <div class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <?php if($ts->submit_date){ ?>
        <table class="table">
          <tr>
            <td><strong><?php echo JText::_( 'From account' ); ?></strong></td>
            <td><?php echo $ts->from; ?> - <?php echo $ts->from_acc; ?></td>
          </tr>
          <tr>
            <td><strong><?php echo JText::_( 'To account' ); ?></strong></td>
            <td><?php echo $ts->to; ?></td>
          </tr>
          <tr>
            <td><strong><?php echo JText::_( 'Amount' ); ?></strong></td>
            <td>Rp. <?php echo number_format(str_replace('.','',$ts->payment_amount), 0, '', '.'); ?></td>
          </tr>
          <tr>
            <td><strong><?php echo JText::_( 'Submit date' ); ?></strong></td>
            <td><?php echo JHtml::_('date', $ts->submit_date, '%a, %d %B %Y %H:%M'); ?></td>
          </tr>
          <tr>
            <td><strong><?php echo JText::_( 'Transfer date' ); ?></strong></td>
            <td><?php echo JHtml::_('date', $ts->payment_date, '%a, %d %B %Y'); ?></td>
          </tr>
          <tr>
            <td style="vertical-align: top;"><strong><?php echo JText::_( 'Files' ); ?></strong></td>
            <td>
							<div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="thumbnail">
                    <img src="<?php echo JURI::base().'images/transactions/'.$ts->id.'_ident.jpg'; ?>" style="height: auto; width: 100%; display: block;">
                    <div class="caption">
                      <h4>Tanda Pengenal</h4>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="thumbnail">
                    <img src="<?php echo JURI::base().'images/transactions/'.$ts->id.'_bukti_bayar.jpg'; ?>" style="height: auto; width: 100%; display: block;">
                    <div class="caption">
                      <h4>Bukti Bayar</h4>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>
        <?php }else{ ?>
        <h4 class="text-center">Waiting Payment </h4>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-white">
      <div class="panel-heading">
        <h4 class="panel-title">Status : <span class="text-bold"> <?php echo $model->statuslabel($ts->status);	?> </span></h4>
        <div class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <form method="post" action="<?php echo JURI::current(); ?>">
          <div class="form-group">
            <label for="status">Change Status</label>
            <?php 
						$statuses = array();
						$stat_arr = 'new, pending, processing, paid, complete, expired';
						$stat_arr = explode(',', $stat_arr);
						foreach($stat_arr as $status){
							$statuses[] = (object) array('text' => ucfirst(str_replace('_', ' ', trim($status))), 'value' => trim($status));
						}
						echo JHTML::_('select.genericlist', $statuses, 'status', 'id="status" class="form-control"', 'value', 'text', $ts->status ); ?>
          </div>
          <div class="form-group hidden">
            <label>Delivery Tracking</label>
            <div class="row no-margin">
              <div class="col-xs-8 no-padding">
                <?php 
								$cur = json_decode($ts->resi);
							?>
                <input type="text" name="resi[code]" placeholder="Nomor resi pengiriman" class="form-control" value="<?php echo $cur->code; ?>" />
              </div>
              <div class="col-xs-4 no-padding">
                <?php 
                $couriers = array();
                $arr = 'jne, pos, tiki, rpx, esl, pcp, pandu, wahana, sicepat, jnt, pahala, cahaya, sap, jet, indah, dse, slis, first, ncs, star';
                $arr = explode(',', $arr);
                foreach($arr as $courier){
                  $couriers[] = (object) array('text' => strtoupper($courier), 'value' => $courier);
                }
                echo JHTML::_('select.genericlist', $couriers, 'resi[courier]', 'class="form-control"', 'value', 'text', $cur->courier ); ?>
              </div>
            </div>
          </div>
          <div class="form-group">
          	<label>Admin message (optional)</label>
            <textarea name="admin_message" placeholder="Message will show on body email (see email template)" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <input type="checkbox" name="sendmail" value="1" id="sendmail" />
            <label for="sendmail">Send Notification Email To User</label>
          </div>
          <div class="form-group">
            <input type="hidden" name="task" value="stat" />
            <input type="hidden" name="return" value="<?php echo JURI::current(); ?>?invoice=<?php echo $ts->id; ?>" />
            <input type="hidden" name="invoice" value="<?php echo $ts->id; ?>" />
            <button class="btn btn-primary" type="submit">Change Status</button>
          </div>
        </form>
      </div>
    </div>
    
    <a class="btn btn-block btn-lg btn-red text-small m-b-5" target="_blank" href="<?php echo JURI::base(); ?>transactions?layout=transaction_view&id=<?php echo base64_encode($ts->id); ?>&format=pdf" style="display: inline-block;"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
  </div>
</div>
<?php }else{ 
	$listing = $model->transaction;
?>
<div class="row">
<div class="col-md-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title text-bold">Orders</h4>
      <ul class="panel-heading-tabs border-light">
        <li>
          <form class="pull-right" id="searchform" method="post" action="<?php echo JURI::current(); ?>">
            <div class="input-group">
              <input style="float: none;" name="keyword" class="form-control" value="<?php echo JRequest::getVar('keyword'); ?>" type="text" placeholder="Search" />
              <span class="input-group-btn">
              <button type="submit" class="btn btn-purple">Go</button>
              </span> </div>
          </form>
          <script>
jQuery(document).ready(function(e) {
    jQuery('.reset').click(function(){
		jQuery('#searchform').find('input').val('')
		jQuery('#searchform').submit()
	})
});
</script></li>
        <li class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a> </li>
              <li> <a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a> </li>
              <li> <a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span> </a> </li>
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <div class="panel-body">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th width="20" class="sectiontableheader" align="center"> Invoice ID </th>
            <th width="60" class="sectiontableheader" align="center"> Customer </th>
            <th width="75" class="sectiontableheader" align="center"> Phone </th>
            <th width="75" class="sectiontableheader" align="center"> Rp. </th>
            <th width="30" class="sectiontableheader" align="center"> Status </th>
            <th width="100" class="sectiontableheader" align="center"> Date </th>
            <th width="30" class="sectiontableheader" align="center"> Action </th>
          </tr>
        </thead>
        <tbody>
          <?php
$base = JURI::base(); 
 $i=0; foreach($listing as $item){ $i++;
 
 ?>
          <tr class="sectiontableentry<?php echo ( $i % 2 == 0 ) ? 2 : 1;?>">
            <td><?php echo $item->id; ?></td>
            <td><a href="<?php echo $base; ?>administration/users/registered-user?view=user&layout=customform&userid=<?php echo $item->user; ?>"><i class="fa fa-user"></i> <?php echo $item->name; ?></a></td>
            <td><?php echo $item->user_phone; ?></td>
            <td><?php echo number_format($item->value, 0, '', '.') ?></td>
            <td><?php echo $model->statuslabel($item->status);	?></td>
            <td><?php echo JHtml::_('date',$item->order_date, '%a, %d %B %Y %H:%M'); ?></td>
            <td><a class="btn btn-xs btn-primary" href="<?php echo JURI::base() ?>administration/store/invoices?invoice=<?php echo $item->id; ?>">View</a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php echo $model->pageNav->getPagesLinks(); ?> </div>
  </div>
</div>
<?php } ?>
