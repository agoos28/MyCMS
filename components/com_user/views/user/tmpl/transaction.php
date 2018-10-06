<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$model = $this->getModel();
$ts = $model->transaction;
$total = $model->tr_total;

JModel::addIncludePath (JPATH_SITE . DS . 'components' . DS . 'com_cckjseblod' . DS . 'models');
$cart_model =& JModel::getInstance('cart', 'CCKjSeblodModel');

//echo'<pre>';print_r($ts[0]);echo'</pre>';

?>

<div id="content">
  <div class="container">
    <div class="cart_c frm">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-right">
          <div class="history">
            <div class="list-group">
              <div class="list-group-item hidden-xs partition-purple">
              	<div class="row">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 pull-right"><h5>Status</h5></div>
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6"><h5>Order Date</h5></div>
                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6"><h5>Shipping</h5></div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6"><h5>Value</h5></div>
                </div>
              </div>
              <div class="list-group-item hidden-lg hidden-md hidden-sm">
              	<h5>Transaction List</h5>
              </div>
              <?php for ( $i = 0, $n = $total; $i < $n; $i++ ) { 
							$shipment = json_decode($ts[$i]->shipment);
							if(!trim($shipment->address->province)){
								$addr = $shipment->address->country_name;
							}else{
								$addr = $shipment->address->province;
							}
                ?>
              <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=user&layout=transaction_view&id='.base64_encode($ts[$i]->id)); ?>" class="row list-group-item no-margin" style="display: block;">
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 pull-right"><?php echo $cart_model->statuslabel($ts[$i]->status); ?></div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6"><strong>ID-<?php echo $ts[$i]->id; ?></strong><br />
                <?php echo JHtml::_('date',$ts[$i]->order_date); ?><br />
                <span class="small btn-link">> View Transaction</span>
                </div>
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6"><?php echo strtoupper($shipment->method).'<br />'.$addr; ?></div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">Rp. <?php echo number_format($ts[$i]->value, 0, '', '.'); ?></div>
              
              </a>
              <?php } ?>
            </div>
          </div>
          <div class="page_c clearfix red5 pagination"> <?php echo $model->pageNav->getPagesLinks(); ?> </div>
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
