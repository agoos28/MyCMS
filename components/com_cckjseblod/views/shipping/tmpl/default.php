<?php 


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$model = &$this->getModel();

if(JRequest::getVar('update')){
	if($model->updateCountry(JRequest::getVar('update'), JRequest::getVar('reg'), JRequest::getVar('exp')) == 'Succcess update'){
		echo 'ok';
	}
	exit();die();
}

$countries = $model->getCountry(JRequest::getVar('keyword'));
$i = 1;
?>

<div class="row">
<div class="col-md-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title text-bold">International Shipment</h4>
      <ul class="panel-heading-tabs border-light">
        <li>
          <p>0 = Unavailable, 1 = Free</p>
        </li>
        <li>
          <form class="pull-right" id="searchform" method="get" action="<?php echo JURI::current(); ?>">
            <div class="input-group">
              <input style="float: none;" name="keyword" class="form-control" value="<?php echo JRequest::getVar('keyword'); ?>" type="text" placeholder="Search Country" />
              <span class="input-group-btn">
              <button type="submit" class="btn btn-purple">Go</button>
              </span> </div>
          </form>
        </li>
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
      <table class="table table-striped">
        <thead>
          <tr>
            <th width="30" align="center" class="sectiontableheader">ID</th>
            <th align="left" class="sectiontableheader">Country</th>
            <th width="15%" align="center" class="sectiontableheader text-center">Regular/Kg (IDR)</th>
            <th width="15%" align="center" class="sectiontableheader text-center">Express/Kg (IDR)</th>
            <th width="120" align="center" class="sectiontableheader text-center">Edit</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($countries->result as $country){ ?>
          <tr class="sectiontableentry<?php if($i % 2){ echo 2; }else{ echo 1; }; ?>">
            <td align="center"><?php echo $country->country_id; ?></td>
            <td align="left"><?php echo $country->short_name; ?></td>
            <td align="center" class="regular" data-name="regular"><?php echo $country->regular; ?></td>
            <td align="center" class="express" data-name="express"><?php echo $country->express; ?></td>
            <td align="center"><a href="#" class="btn btn-xs btn-blue tooltips edit" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a> <a href="#" class="btn btn-xs btn-success tooltips save hide" data-placement="top" data-original-title="Save Change">Save</a> <a href="#" class="btn btn-xs btn-default tooltips cancel hide" data-placement="top" data-original-title="Cancel">Cancel</a></td>
          </tr>
          <?php $i++; }; ?>
        </tbody>
      </table>
      <?php echo $countries->pageNav->getPagesLinks(); ?> </div>
  </div>
</div>
<script type="text/javascript">
function startEdit(parent_el){
	parent_el.find('[data-name]').each(function() {
    var el = $(this)
		var value = el.text()
		var name = el.attr('data-name')
		el.attr('data-value', value)
		el.html('<input class="form-control" type="text" name="'+name+'" value="'+value+'">')
  });
	parent_el.find('a.edit').addClass('hide')
	parent_el.find('a.save, a.cancel').removeClass('hide')
}
function cancelEdit(parent_el){
	parent_el.find('[data-name]').each(function() {
    var el = $(this)
		var value = el.attr('data-value')
		el.html(value)
  });
	parent_el.find('a.edit').removeClass('hide')
	parent_el.find('a.save, a.cancel').addClass('hide')
}
function submitEdit(parent_el){
	var id = parent_el.data('id')
	var regular = parent_el.find('[name="reg"]').val()
	var express = parent_el.find('[name="exp"]').val()
	var cod = parent_el.find('[name="cod"]').val()
	$.post('<?php echo JURI::current(); ?>', {'update':id, 'reg':regular, 'exp':express }, function(data){
		if(data == 'ok'){
			parent_el.find('.regular').html(regular)
			parent_el.find('.express').html(express)
			parent_el.find('a.edit').removeClass('hide')
			parent_el.find('a.save, a.cancel').addClass('hide')
		}else{
			alert('Failed')
		}
	})
}

$(document).ready(function(e) {
  $('a.edit').click(function(e){
		e.preventDefault()
		var th = $(this)
		startEdit(th.parent().parent())
	})
	$('a.cancel').click(function(e){
		e.preventDefault()
		var th = $(this)
		cancelEdit(th.parent().parent())
	})
	$('a.save').click(function(e){
		e.preventDefault()
		var th = $(this)
		submitEdit(th.parent().parent())
	})
});
</script>