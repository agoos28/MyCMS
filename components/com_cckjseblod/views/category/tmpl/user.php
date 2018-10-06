<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
JHTML::_('jquery.datatable', '.datatable');

require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php' );

if ( $this->menu_params->get( 'enable_ordering' ) ){
	$ordering = '&enableorder=1';
}
	
$n	=	count( $this->categoryItems );

$javascript ='
	';
$this->document->addScriptDeclaration( $javascript );



?>

<div class="col-ms-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title"><?php echo $this->page_title; ?></h4>
      <ul class="panel-heading-tabs border-light">
        <?php echo $this->loadTemplate( 'toolbar' ); ?>
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
              <th width="30" style="text-align: center;" >
                #
              </th>
                <td class="sectiontableheader" align="left" data-orderable="false"><?php echo JText::_( 'Category' ); ?></td>
                <td class="sectiontableheader" align="center"><?php echo JText::_( 'Content Count' ); ?></td>
                <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" class="sectiontableheader" align="left"><?php echo JText::_( 'State' ); ?></td>
                <?php endif; ?>
                <?php if ( $this->menu_params->get( 'show_edit' ) ) : ?>
                <th class="sectiontableheader" align="right" width="120" data-orderable="false"> Action </th>
                <?php endif; ?>
              </tr>
            </thead>
            <?php endif; ?>
            <tbody>
              <?php $ss=0; for ( $i = 0; $i < $n; $i++ ) {
								$row			=	$this->categoryItems[$i];
													//echo'<pre>';print_r($row);die();
								$row->link		=	'index.php?option=com_cckjseblod&view=article&layout=user&catid='.$row->id.'&title='.$row->title.$ordering;
								//$row->link		=	JRoute::_( ContentHelperRoute::getCategoryRoute( $row->slug, $row->section ).'&layout=default' );
								$row->edit_link	=	JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=category&typeid='.$row->content_typeid.'&cckid='.$row->id );
							?>
              <tr class="sectiontableentry<?php echo ( $i % 2 == 0 ) ? 2 : 1;?>">
                	<td width="24" align="right" style="padding-right: 10px;">
									<?php 
										echo $i + 1; 
									?>
                </td>
                <td align="left">
                	<i class="fa fa-folder"></i>&nbsp;&nbsp;
                  <a class="tooltips" data-original-title="View content list" href="<?php echo $row->link; ?>"><strong><?php echo $row->title; ?></strong></a>
                  </td>
                <td class="sectiontableheader" align="center"><?php echo $row->count; ?></td>
                <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
                <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" align="left">
								<?php if( $row->published ){ ?>
									<a href="#" class="btn btn-xs btn-success tooltips publishing" data-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Click to disable" data-action="disable">Active</a>
                  <?php }else{ ?>
                  <a href="#" class="btn btn-xs btn-light-grey tooltips publishing" data-action="enable" data-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Click to activate">Disable</a>
                  <?php }; ?>
                 </td>
                 <?php endif; ?>
                <td><?php if ( $row->content_typeid && ! $row->checked_out ) { ?>
                  <?php if ( $this->menu_params->get( 'show_edit' ) ) : ?>
                  <a href="<?php echo $row->edit_link; ?>" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                  <?php endif; ?>
                  <?php if ( $this->menu_params->get( 'enable_delete' ) ) : ?>
                  <a href="#" class="btn btn-xs btn-red tooltips delete" data-delete-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                  <?php endif; ?>
                <?php }?></td>
              </tr>
              	<?php 
								if(count($this->categoryItems[$i]->child) > 0){ 
									$sss=0; for ( $ii = 0; $ii < count($this->categoryItems[$i]->child); $ii++ ) { 
									$child = $this->categoryItems[$i]->child[$ii];
									$child->link		=	'index.php?option=com_cckjseblod&view=article&layout=user&catid='.$child->id.'&title='.$child->title.$ordering;
									$child->edit_link	=	JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=category&typeid='.$child->content_typeid.'&cckid='.$child->id );
							?>
                <tr class="sectiontableentry<?php echo ( $i % 2 == 0 ) ? 2 : 1;?>">
                    <td width="24" align="right" style="padding-right: 10px; opacity:0;">
                    <?php echo $i + 1; ?>
                  </td>
                  <td align="left">
                      &nbsp;&nbsp;<i class="fa fa-level-up fa-rotate-90"></i>&nbsp;&nbsp; 
                      <i class="fa fa-folder"></i>&nbsp;&nbsp;
                    	<a class="tooltips" data-original-title="View content list" href="<?php echo $child->link; ?>"><strong><?php echo $child->title; ?></strong></a>
                    </td>
                  <td class="sectiontableheader" align="center"><?php echo $child->count; ?></td>
                  <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
                  <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" align="left">
                  <?php if( $child->published ){ ?>
                    <a href="#" class="btn btn-xs btn-success tooltips publishing" data-id="<?php echo $child->id; ?>" data-placement="top" data-original-title="Click to disable" data-action="disable">Active</a>
                    <?php }else{ ?>
                    <a href="#" class="btn btn-xs btn-light-grey tooltips publishing" data-action="enable" data-id="<?php echo $child->id; ?>" data-placement="top" data-original-title="Click to activate">Disable</a>
                    <?php }; ?>
                   </td>
                   <?php endif; ?>
                  <td><?php if ( $child->content_typeid && ! $child->checked_out ) { ?>
                    <?php if ( $this->menu_params->get( 'show_edit' ) ) : ?>
                    <a href="<?php echo $child->edit_link; ?>" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                    <?php endif; ?>
                    <?php if ( $this->menu_params->get( 'enable_delete' ) ) : ?>
                    <a href="#" class="btn btn-xs btn-red tooltips delete" data-delete-id="<?php echo $child->id; ?>" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                    <?php endif; ?>
                  <?php }?></td>
                </tr>
              <?php } ?>
              <?php } ?>
              <?php } ?>
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
$(document).ready(function(e) {
  $('#adminForm').on('click', '.publishing', function(e){
		var th = $(this)
		th.text('Wait')
		var cid = th.data('id')
		if(th.data('action') == 'enable'){
			var params = $('#adminForm').serialize()+'&task=category_publish&methode=ajax&cid='+cid
			var classreplace = 'btn btn-xs btn-success tooltips disable publishing'
			var tooltip = 'Click to disable'
			var text = 'Active'
			var dataAction = 'disable'
		}else{
			var params = $('#adminForm').serialize()+'&task=category_unpublish&methode=ajax&cid='+cid
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
	$('#adminForm').on('click', 'a.delete', function(e){
		var th = $(this)
		var cid = th.data('delete-id')
		var r = confirm("Delete Item!");
		if(r == true){
		}else{
			return false
		}
		var params = $('#adminForm').serialize()+'&task=category_trash&methode=ajax&cid='+cid
		e.preventDefault()
		$.post('index.php', params, function(data){
			if(data.type == 'success'){
				th.parent().parent().remove()
			}else{
				alert(data.message)
			}
			
		})
	})
});
</script>