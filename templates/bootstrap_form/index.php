<?php
/**
* @version 			1.9.0
* @author       	http://www.seblod.com
* @copyright		Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
* @package			Product Form Template (Custom) - jSeblod CCK ( Content Construction Kit )
**/

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php
/**
 * Init jSeblod Process Object { !Important; !Required; }
 **/
$jSeblod	=	clone $this;


?>

<?php 
/**
 * Init Style Parameters
 **/
include( dirname(__FILE__) . '/params.php' );
$jSeblod	=	clone $this;
if ( array_key_exists( 'cckform', get_object_vars( $jSeblod ) ) && array_key_exists( 'cckitems', get_object_vars( $jSeblod ) ) ) {
	$cckform	=	$jSeblod->cckform;
	$cckitems	=	$jSeblod->cckitems;
} else {
	global $mainframe;
	$mainframe->enqueueMessage( 'This Templtate is an Auto Form Template, it can\'t be used to render Content. (Only Forms!) So... do not assign any Site View on it.', "error" );
	return true;
} 

$panelId	=	0;
$subPanelId =	0;

echo $jSeblod->$cckform->form;
$panel = 0;
?>
<style>
ul.grid{
	padding: 0;
}
ul.grid::after{
	content: '';
	display: block;
	clear: both;
}
ul.grid li{
	float: left;
	list-style: none;
}
</style>

<div class="row">

<?php 
$col_layout = 0;
foreach($jSeblod as $cckitem){ 
	if($cckitem->type == 17){
		$col_layout++;
	}
}

if(!$col_layout){ ?>
	<div class="col-md-12">
    	<div class="panel panel-white">
                <div class="panel-heading border-light">
                <h4 class="panel-title"><?php echo $this->menu->title; ?></h4>
                <div class="panel-tools">
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                            <i class="fa fa-cog"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-light pull-right" role="menu" style="display: none;">
                            <li>
                                <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
                            </li>
                            <li>
                                <a class="panel-refresh" href="#">
                                    <i class="fa fa-refresh"></i> <span>Refresh</span>
                                </a>
                            </li>
                            <li>
                                <a class="panel-expand" href="#">
                                    <i class="fa fa-expand"></i> <span>Fullscreen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
              </div>
            <div class="panel-body">
			
<?php }

foreach($jSeblod as $cckitem){ 
	
if($cckitem->type == 25){
	echo $cckitem->form;
}
		
?>


<?php if(is_array($cckitem) == true && is_object($cckitem[0]) == true){ ?>
<div class="row">
    <div class="col-md-6">
        <h5 class="text-bold"><?php echo $cckitem[0]->label; ?></h5>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-xs btn-primary" href="#"><i class="fa fa-plus"></i> Add Item</a>
    </div>
</div>
<ul class="ui-sortable <?php echo ($cckitem[0]->name == 'imagex') ? 'grid' : 'list-unstyled'; ?>">
	<?php foreach($cckitem as $cckitemx){ ?>
	<li class="ui-state-default">
        <?php echo $cckitemx->form; ?>
     </li>
    <?php } ?>
</ul>
<?php }else if(is_array($cckitem) == true && $cckitem['group'] == true){ ?>	
<div class="row">
    <div class="col-md-6">
        <h5 class="text-bold"><?php echo $cckitem['group']->label; ?></h5>
    </div>
    <div class="col-md-6 text-right">
        
    </div>
</div>
<div id="<?php echo $cckitem[group]->name; ?>"  class="dd">
<?php 
if($cckitem[group]->content){
	$separator = explode('-',$cckitem[group]->content);
}
 ?>
<ol class="dd-list <?php echo ($cckitem[0]->name == 'imagex') ? 'grid' : 'list-unstyled'; ?>">

	<?php for($i=0; $i < count($cckitem)-1; $i++){ ?>
	<li class="dd-item dd3-item" data-id="<?php echo $i+1; ?>">
  	<div class="dd-handle dd3-handle"></div>
    <div class="dd3-content">
		<?php $ccount = count($cckitem[$i]); ?>
    			<a href="#" class="btn btn-xs btn-red tooltips del pull-right" data-delete-id="<?php echo $i+1; ?>" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
        	<div class="row">
        	<?php $ii=0; foreach($cckitem[$i] as $cckitemxx){  
						$column = 12/$ccount;
						if($cckitemxx->type == 9 && $cckitemxx->bool > 0){
							$column = 12;
						}
						if($separator[$ii]){
							$column = $separator[$ii];
						}
					?>
            	<div class="col-xs-<?php echo $column; ?>" data-type="<?php echo $cckitemxx->type; ?>">
                <?php if($cckitemxx->display){ ?>
            	<label for="<?php echo $cckitemxx->name; ?>">
							<strong><?php echo $cckitemxx->label; ?></strong>
                </label>
                <?php } ?>
                <?php echo $cckitemxx->form; ?>
                </div>
        	<?php $ii++; } ?>
            </div>
            
      </div>
     </li>
    <?php } ?>
</ol>
</div>
<a class="btn btn-sm btn-primary additem" href="#" data-id="<?php echo $cckitem['group']->name; ?>"><i class="fa fa-plus"></i> Add Item</a>
<?php }else if($cckitem->type == true && $cckitem->type != 25){{ ?>

<?php if($cckitem->type == 17){ ?>

	<?php if(!$panel){ $panel = 1; ?>
	<div class="col-md-8">
    	<div class="panel panel-white">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo $cckitem->label; ?></h4>
                <div class="panel-tools">
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                            <i class="fa fa-cog"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-light pull-right" role="menu" style="display: none;">
                            <li>
                                <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
                            </li>
                            <li>
                                <a class="panel-refresh" href="#">
                                    <i class="fa fa-refresh"></i> <span>Refresh</span>
                                </a>
                            </li>
                            <li>
                                <a class="panel-expand" href="#">
                                    <i class="fa fa-expand"></i> <span>Fullscreen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
			<?php }else{ $panel = 0;?>            
            </div>
        </div>
    </div>
    <?php if($cckitem->name != 'panel_end'){ ?>
    <div class="col-md-4">
    	<div class="panel panel-blue">
    		<div class="panel-body">
    <?php $panel = 1;}} ?>


<!--type text-->
<?php }else{ ?>
    <div class="form-group <?php echo $cckitem->name; ?>-wrap" data-type="<?php echo $cckitem->type; ?>" data-visibility="<?php echo $cckitem->display; ?>">
    		<?php if($cckitem->display){ ?>
        <?php if($cckitem->type != 21){ ?>
        <label for="<?php echo $cckitem->name; ?>">
            <span class="text-bold"><?php echo $cckitem->label; ?></span>
        </label>
        <?php }} ?>
        <?php if($cckitem->type == 27){ ?>
        	<div class="text-right">
        	<button class="color-button btn btn-default" type="button" onclick="javascript: history.go(-1);" name="button_back" style="">Back </button>&nbsp;&nbsp;&nbsp;<button class="color-button btn btn-primary" type="submit" onclick="javascript: submitbutton('save');" name="button_submit" style="">Save It !</button>
          </div>
         <?php }else if($cckitem->type == 21){ ?>
         <div class="alert alert-block alert-info">
         <h4 class="alert-heading"><i class="fa fa-info"></i> <?php echo $cckitem->label; ?></h4>
         <?php echo $cckitem->form; ?>
         </div>
        <?php }else{ ?>
          <?php echo $cckitem->form; ?>
        <?php } ?>
    </div>
<?php } ?>


<?php } ?> 
<?php } ?>
<?php  //echo '<pre>';print_r($cckitem);echo '</pre>'; ?>
<?php } ?>

<?php if(!$col_layout){ ?>          
            </div>
        </div>
    </div>
<?php } ?>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(e) {
	$('.dd').nestable({
		maxDepth: 1
	})
	$('.dd').on('click', '.del', function(e){
		if($(this).parentsUntil('.dd-list').parent().find('.dd-item').length > 1){
			$(this).parentsUntil('.dd-item').parent().remove()
		}
		e.preventDefault()
	})
	$('.additem').click(function(e){
		e.preventDefault()
		var panel = $(this).parent().parent()
		var newItem = panel.find('.dd-list li:first').clone(true,true)
		var length = panel.find('.dd-list li').length
		newItem = newItem.prop('outerHTML').replace(/\[[0-9]+?\]/g,'['+length+']').replace(/\-[0-9]+?\-/g,'-'+length+'-')
		panel.find('ol').append(newItem)
		panel.find('.dd-list li:last').find('input').each(function(){
			$(this).attr('value', '')
			
		})
		panel.find('.dd-list li:last').find('.fileupload').removeClass('fileupload-exists').addClass('fileupload-new')
		panel.find('.dd-list li:last').find('.fileupload-preview').empty()
		panel.find('.dd-list li:last').find('img').attr('src', '')
		
	})
	
	$('input[type="radio"]').on('ifChecked', function(event){
		if($('input[name="subcategories"]:checked').val() == 1){
			$('.parent_id-wrap').show()
		}else{
			$('.parent_id-wrap').hide()
		}
	})
	if($('input[name="subcategories"]:checked').val() == 1){
		$('.parent_id-wrap').show()
	}else{
		$('.parent_id-wrap').hide()
	}
	$('.ui-sortable').nestable({
		maxDepth: 1
	})
});
</script>