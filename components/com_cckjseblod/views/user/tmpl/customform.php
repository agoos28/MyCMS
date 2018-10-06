<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
JModel::addIncludePath (JPATH_SITE . DS . 'components' . DS . 'com_cckjseblod' . DS . 'models');
$cart_model =& JModel::getInstance('cart', 'CCKjSeblodModel');
$model = $this->getmodel();
if(JRequest::getVar('userid')){
	$user = $model->getuser(JRequest::getVar('userid'));
}

$ts = $user->transaction;
?>
<form id="default_action_user" name="default_action_user" method="post" action="/index.php?option=com_cckjseblod&view=user&layout=customform" enctype="multipart/form-data" target="_self">
<div class="row">
<div class="col-md-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title">User <span class="text-bold">Credential</span></h4>
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
    	<div class="form-group">
      	<label for="username">Name</label>
        <input type="text" value="<?php echo $user->name ?>" size="32" maxlength="50" name="username" id="username" class="form-control">
      </div>
      <div class="form-group">
      	<label for="email">E-mail</label>
        <input type="text" value="<?php echo $user->email ?>" size="32" maxlength="50" name="email" id="email" class="form-control">
      </div>
      <div class="form-group">
      	<label for="phone">Phone</label>
        <input type="text" value="<?php echo $user->phone ?>" size="32" maxlength="50" name="phone" id="phone" class="form-control">
      </div>
      <div class="form-group">
      	<label for="usertype">User Level</label>
        <select size="1" class="form-control" id="usertype" name="usertype">
          <option value="Registered" <?php if($user->usertype == 'Registered'){echo 'selected="selected"';} ?>>Member</option>
          <option <?php if($user->usertype == 'Super Administrator'){echo 'selected="selected"';} ?> value="Super Administrator">Super Administrator</option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      	<?php 
					$address = json_decode($user->address);
					$address = $address->address;
				?>
      	<label for="address">Default Shipping Address</label>
      </div>
      <div class="row gutter-10 margin-bottom-30">
        <div class="col-sm-7 margin-bottom-10">
          <input id="reciever_name" name="address[name]" type="text" class="form-control no-empty" placeholder="Receiver Name" value="<?php echo $address->name; ?>">
        </div>
        <div class="col-sm-5 margin-bottom-10">
          <input id="reciever_phone" name="address[phone]" type="text" class="form-control no-empty" placeholder="Receiver Phone" value="<?php echo $address->phone; ?>">
        </div>
        <div class="col-sm-6 margin-bottom-10">
          <select id="country" name="address[country]" class="form-control no-empty">
            <?php if($address->country){ ?>
            <option value="<?php echo $address->country; ?>" selected="selected"><?php echo $address->country_name; ?></option>
            <?php }else{ ?>
            <option value="999" selected="selected">Indonesia</option>
            <?php } ?>
          </select>
          <input id="country_name" type="hidden" name="address[country_name]" value="<?php echo $address->country_name; ?>">
        </div>
        <div class="col-sm-6 margin-bottom-10">
          <select id="province" name="address[province]" class="form-control no-empty">
            <?php if($address->province){ ?>
            <option value="<?php echo $address->province; ?>" selected="selected"><?php echo $address->province; ?></option>
            <?php }else{ ?>
            <option value="">Select Province/Kota</option>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-8 margin-bottom-10">
          <select id="district" name="address[district]" class="form-control no-empty">
            <?php if($address->district){ ?>
            <option value="<?php echo $address->district; ?>" selected="selected"><?php echo $address->district_name; ?></option>
            <?php }else{ ?>
            <option value="">Select District/Kecamatan</option>
            <?php } ?>
          </select>
          <input id="district_name" type="hidden" name="address[district_name]" value="<?php echo $address->district_name; ?>">
        </div>
        <div class="col-sm-4 margin-bottom-10">
          <input id="postal" name="address[postal]" type="text" class="form-control no-empty" placeholder="Postal code" value="<?php echo $address->postal; ?>">
        </div>
        <div class="col-sm-9 margin-bottom-10">
          <input type="text" class="form-control no-empty" id="address1" name="address[address]" value="<?php echo $address->address; ?>" placeholder="Address">
        </div>
        <div class="col-sm-3 margin-bottom-10">
          <input type="text" class="form-control" id="address2" name="address[address_opt]" placeholder="Apt, suit, etc (optional)" value="<?php echo $address->address_opt; ?>">
        </div>
      </div>
      <div class="form-group margin-bottom-10 text-right">
      	<button style="" name="button_back" onclick="javascript: history.go(-1); return false;" type="button" class="btn btn-default">Back </button> <button type="submit" class="btn btn-primary">Save Change</button>
      </div>
    </div>
  </div>
</div>  
</div>
</div>
<div class="col-md-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title">User Have <span class="text-bold"><?php echo count($user->transaction); ?> Transaction</span></h4>
      <div class="panel-tools">
        <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
          <ul class="dropdown-menu dropdown-light pull-right" role="menu">
            <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="panel-body">

<table class="table table-striped table-hover">
<thead>
<tr>
	<th class="sectiontableheader" width="20" align="center">
		Invoice
	</th>
  <th class="sectiontableheader" width="100" align="center">
		Shipping
	</th>
  <th class="sectiontableheader" width="75" align="center">
		Total
  	</th>
  <th class="sectiontableheader" width="30" align="center">
		Status
	</th>
    <th class="sectiontableheader" width="30" align="center">
		Action
	</th>
</tr>
</thead>
<tbody>
<?php for ( $i = 0, $n = count($user->transaction); $i < $n; $i++ ) { 
$shipment = json_decode($ts[$i]->shipment);
?>
<tr>
  <td><strong>ID-<?php echo $ts[$i]->id; ?></strong><br /><?php echo JHtml::_('date',$ts[$i]->order_date); ?></td>
  <td><?php echo $shipment->address->district.' '.$shipment->address->province.' <br /> Rp. '.number_format($shipment->pricing * $shipment->weight, 0, '', '.'); ?></td>
  <td>Rp. <?php echo number_format($ts[$i]->value, 0, '', '.'); ?></td>
  <td><?php echo $cart_model->statuslabel($ts[$i]->status); ?></td>
	<td><a class="btn btn-xs btn-primary" href="<?php echo JURI::base().'administration/store/invoices?invoice='.$ts[$i]->id; ?>">View</a></td>
</tr>
<?php } ?>
</tbody>
</table>
<input type="hidden" name="usrid" value="<?php echo JRequest::getVar('userid'); ?>" />
<input type="hidden" name="task" value="saveedit" />
<input type="hidden" name="return" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
<?php echo JHTML::_('form.token'); ?>
</div>
</div>
</div>
</div>
</form>
