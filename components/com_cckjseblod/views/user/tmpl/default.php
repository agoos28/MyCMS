<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
JHTML::_('jquery.datatable', '.datatable');

require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php' );
	
$n	=	count( $this->userItems );

$javascript ='
		';
$this->document->addScriptDeclaration( $javascript );
?>

<div class="col-ms-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title"><?php echo $this->page_title; ?></h4>
      <ul class="panel-heading-tabs border-light">
        <li class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a> </li>
              <li> <a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span> </a> </li>
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <form action="index.php" method="post" id="adminForm" name="adminForm">
          <?php if ( $this->menu_params->get( 'show_headings' ) ) : ?>
          <table class="table table-striped datatable border-bottom" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-color: #dfe1e5;">
            <thead>
              <tr>
                <td width="30" class="sectiontableheader" align="center"><?php echo JText::_( 'Num' ); ?></td>
                <td class="sectiontableheader" align="left"><?php echo JText::_( 'Name' ); ?></td>
                <?php if ( $this->menu_params->get( 'show_category' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'category_width' ); ?>" class="sectiontableheader" align="left"><?php echo JText::_( 'Category' ); ?></td>
                <?php endif; ?>
                <?php if ( $this->menu_params->get( 'show_usergroup' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'usergroup_width' ); ?>" class="sectiontableheader" align="left"><?php echo JText::_( 'Group' ); ?></td>
                <?php endif; ?>
                <?php if ( $this->menu_params->get( 'show_date' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'date_width' ); ?>" class="sectiontableheader" align="left"><?php echo JText::_( 'Date' ); ?></td>
                <?php endif; ?>
                <?php if ( $this->menu_params->get( 'show_hits' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'hits_width' ); ?>" class="sectiontableheader" align="left"><?php echo JText::_( 'Hits' ); ?></td>
                <?php endif; ?>
                <td class="sectiontableheader" align="left"> Phone </td>
                <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" class="sectiontableheader" align="left"><?php echo JText::_( 'State' ); ?></td>
                <?php endif; ?>
                <th class="sectiontableheader" align="right" width="120" data-orderable="false"> Action </th>
              </tr>
            </thead>
            <?php endif; ?>
            <tbody>
              <?php for ( $i = 0; $i < $n; $i++ ) {
	$row				=	$this->userItems[$i];
	$row->link			=	( @$row->slug && @$row->catslug && @$row->sectionid ) ? JRoute::_( ContentHelperRoute::getArticleRoute( $row->slug, $row->catslug, $row->sectionid ) ) : '';
	$row->edit_link		=	( @$row->content_typeid ) ? JRoute::_( 'index.php?option=com_cckjseblod&view=user&layout=form&typeid='.$row->content_typeid.'&cckid='.$row->id ) : '';
	
	if(!@$row->content_typeid){
		$row->edit_link = JRoute::_( 'index.php?option=com_cckjseblod&view=user&layout=customform&userid='.$row->id );
	}
?>
              <tr class="sectiontableentry<?php echo ( $i % 2 == 0 ) ? 2 : 1;?>">
                <td width="30" align="center"><?php if ( $this->menu_params->get( 'num_format', 0 ) ) {
	        echo $row->id;
        } else {
	       	echo $i + 1;
        } ?></td>
                <td align="left"><?php if ( $row->edit_link ) { ?>
                  <a href="<?php echo $row->edit_link; ?>"><strong><?php echo $row->name; ?></strong></a>
                  <?php } else {
        	echo $row->name;
        } ?></td>
                <?php if ( $this->menu_params->get( 'show_category' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'category_width' ); ?>" align="left"><?php echo ( $row->category ) ? $row->category : '-'; ?></td>
                <?php endif; ?>
                <?php if ( $this->menu_params->get( 'show_usergroup' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'usergroup_width' ); ?>" align="left"><?php 
		if($row->usertype == 'Registered'){
			echo 'Member'; 
		}elseif($row->usertype == 'Author'){
			echo 'Author'; 
		}else{
			echo $row->usertype; 
		}
		?></td>
                <?php endif; ?>
                <td align="left"><?php echo $row->phone; ?></td>
                <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" align="left">
								<?php echo ( $row->block ) ?  '<a href="#" class="btn btn-xs btn-light-grey tooltips publishing" data-action="enable" data-id="'.$row->id.'" data-placement="top" data-original-title="Click to activate">Disable</a>' : '<a href="#" class="btn btn-xs btn-success tooltips publishing" data-id="'.$row->id.'" data-placement="top" data-original-title="Click to disable" data-action="disable">Active</a>'; ?></td>
                <?php endif; ?>
                <?php if ( $this->menu_params->get( 'show_date' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'date_width' ); ?>" align="left"><?php echo JHTML::_('date',  $row->created, $this->date_format ); ?></td>
                <?php endif; ?>
                <?php if ( $this->menu_params->get( 'show_hits' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'hits_width' ); ?>" align="left"><?php echo $row->hits; ?></td>
                <?php endif; ?>
                <td><a href="mailto:<?php echo $row->email; ?>" class="btn btn-xs btn-yellow tooltips" data-placement="top" data-original-title="Send email"><i class="fa fa-envelope-o fa-white"></i></a>
                  <?php if ( $this->menu_params->get( 'enable_delete' ) ) : ?>
                  <a href="#" class="btn btn-xs btn-red btn-edit tooltips deleteitem" data-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                  <?php endif; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
          <input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />
          <input type="hidden" name="boxchecked" value="0" />
          <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
          <?php echo JHTML::_('form.token'); ?>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
jQuery(document).ready(function(e) {
$('#adminForm').on('click', '.publishing', function(e){
		var th = $(this)
		th.text('Wait')
		var cid = th.data('id')
		if(th.data('action') == 'enable'){
			var params = $('#adminForm').serialize()+'&task=user_eanable&methode=ajax&cid='+cid
			var classreplace = 'btn btn-xs btn-success tooltips disable publishing'
			var tooltip = 'Click to disable'
			var text = 'Active'
			var dataAction = 'disable'
		}else{
			var params = $('#adminForm').serialize()+'&task=user_block&methode=ajax&cid='+cid
			var classreplace = 'btn btn-xs btn-light-grey tooltips enable publishing'
			var tooltip = 'Click to enable'
			var text = 'Disable'
			var dataAction = 'enable'
		}
		e.preventDefault()
		$.post('index.php', params, function(data){
			data = jQuery.parseJSON(data)
			if(data.type == 'success'){
				th.attr('class', classreplace)
				th.attr('data-action', dataAction)
				th.data('action', dataAction)
				th.attr('data-original-title', tooltip)
				th.text(text)
			}else{
				alert(data.message)
			}
		})
	})
	$('#adminForm').on('click', '.deleteitem', function(e){
		var th = $(this)
		var r = confirm('Delete Item?');
		var cid = th.data('id')
		if(r == true){
			var params = $('#adminForm').serialize()+'&task=user_delete&methode=ajax&cid='+cid
		}else{
			return false
		}
		//console.log(params)
		e.preventDefault()
		$.post('index.php', params, function(data){
			data = jQuery.parseJSON(data)
			if(data.type == 'success'){
				th.parent().parent().remove()
			}else{
				alert(data.message)
			}
		})
	})
})
</script>