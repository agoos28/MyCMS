<?php 


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$model = &$this->getModel();
$curUrl = JURI::current();
$promo = $model->getPromocode();
JHTML::_('jquery.datatable', '.datatable');
$i = 1;



?>

<div class="row"> </div>
<div class="row">
<div class="col-xs-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <?php if(JRequest::getInt('edit',0)){ ?>
      <h4 class="panel-title text-bold">Edit Promo Code</h4>
      <?php }else{ ?>
      <h4 class="panel-title text-bold">Add New Promo Code</h4>
      <?php } ?>
    </div>
    <div class="panel-body">
      <form class="" id="" method="get" action="<?php echo JURI::current(); ?>">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Discount value</label>
              <div class="row gutter-5">
                <div class="col-xs-8">
                  <input style="float: none;" name="value" class="form-control" value="<?php echo JRequest::getVar('value'); ?>" type="text" placeholder="Number Only" />
                </div>
                <div class="col-xs-4">
                  <select name="type" class="form-control">
                    <option value="amount" selected="selected">Rp</option>
                    <option value="percent" selected="selected">%</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
            	<div class="row">
          			<div class="col-md-8">
                  <label>Rule</label>
                  <select name="rule" class="form-control">
                    <option value="unlimited" selected="selected">Unlimited</option>
                    <option value="limited">limited</option>
                  </select>
                 </div>
                 <div class="col-xs-4">
                 	<label>Limit</label>
                  <input style="float: none;" name="limit" class="form-control" value="" type="text" placeholder="Number Only" />
                </div>
               </div>
            </div>
            <div class="form-group">
              <label>Custom Code</label>
              <input style="float: none;" class="form-control" type="text" name="code" value="<?php echo JRequest::getVar('code'); ?>" placeholder="" />
              <div class="form-info">Leave empty to auto generate.</div>
            </div>
            <div class="form-group">
              <label>Specified Product Only</label>
              <?php 
          $db = JFactory::getDBO();
          $query = "SELECT a.id AS value, CONCAT_WS(' - ',a.title,b.title) AS text FROM #__content AS a LEFT JOIN #__categories AS b ON b.id = a.catid WHERE a.sectionid= 2";
          $db->setQuery($query);
					$blank = array();
					$blank[] = (object) array('value' => 0, 'text' => 'All Product');
          $result = $db->loadObjectList();
          $products = array_merge($blank, $result);
          echo JHtml::_('select.genericlist', $products, 'product_id', 'class="search-select form-control" id="product_select"'); 
          ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Send to Email</label>
              <input style="float: none; margin-bottom: 5px;" class="form-control" type="text" name="owner" value="<?php echo JRequest::getVar('owner'); ?>" placeholder="Email" />
              <textarea name="email_desc" class="form-control" placeholder="Description email"></textarea>
              <div class="form-info">Will shown in email body, see email template.</div>
            </div>
          </div>
        </div>
        <div class="text-right">
          <button type="submit" class="btn btn-purple">Save</button>
        </div>
        <input type="hidden" name="task" value="savecode" />
        <input type="hidden" name="return_url" value="<?php echo JURI::current(); ?>" />
      </form>
    </div>
  </div>
</div>
<div class="col-xs-12">
<div class="panel panel-white">
<div class="panel-heading border-light">
  <h4 class="panel-title text-bold">Promo Codes</h4>
  <ul class="panel-heading-tabs border-light">
    <!--<li>
      <form class="pull-right" method="post">
        <div class="input-group">
          <input class="form-control" style="float: none;" type="text" name="code" value="" placeholder="Search Code" />
          <span class="input-group-btn">
          <button type="submit" class="btn btn-purple">Go</button>
          </span> </div>
      </form>
    </li>-->
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
<table class="table table-striped datatable">
  <thead>
    <tr>
      <th width="100" align="left" class="">Code</th>
      <th align="left">Type</th>
      <th align="left">Value</th>
      <th align="left">Rule</th>
      <th align="left">Owner</th>
      <th width="100" align="center" class="text-center">Usage</th>
      <th width="50" align="center" class="text-center">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($promo->result as $item){ 
			if(!$item->product){
				$item->product = 'All product';
			}
			if($item->type == 'amount'){
				$rp = 'Rp. ';
				$pr = '';
			}else{
				$rp = '';
				$pr = '%';
			}
		?>
    <tr class="sectiontableentry<?php if($i % 2){ echo 2; }else{ echo 1; }; ?>">
      <td align="left"><?php echo $item->code; ?></td>
      <td align="left" style="text-transform: capitalize;"><?php echo $item->type; ?></td>
      <td align="left"><?php echo $rp.$item->value.$pr; ?></td>
      <td align="left" style="text-transform: capitalize;"><?php echo $item->rule; ?></td>
      <td><?php echo $item->owner; ?></td>
      <td><?php echo $item->use_count; ?></td>
      <td align="center"><a href="<?php echo $curUrl; ?>?delcode=<?php echo $item->id; ?>" class="btn btn-xs btn-red btn-edit tooltips deleteitem" data-id="<?php echo $item->id; ?>" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a></td>
    </tr>
    <?php $i++; }; ?>
  </tbody>
</table>
<script src="<?php echo JURI::base(); ?>templates/admin/plugins/select2/select2.min.js"></script>
<script>
$(document).ready(function(e) {
  $('#product_id').select2({

  })
});
</script>
<?php //echo $promo->pageNav->getPagesLinks(); ?>
