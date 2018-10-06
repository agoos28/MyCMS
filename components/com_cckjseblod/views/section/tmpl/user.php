<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php
JHTML::_('jquery.datatable', '.datatable');

require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php' );
	
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
            <div class="dropdown">
                <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                    <i class="fa fa-cog"></i>
                </a>
                <ul class="dropdown-menu dropdown-light pull-right" role="menu">
                    <li>
                        <a class="panel-refresh" href="#">
                            <i class="fa fa-refresh"></i> <span>Refresh</span>
                        </a>
                    </li>
                    <li>
                        <a class="panel-config" href="#panel-config" data-toggle="modal">
                            <i class="fa fa-wrench"></i> <span>Configurations</span>
                        </a>
                    </li>
                    <li>
                        <a class="panel-expand" href="#">
                            <i class="fa fa-expand"></i> <span>Fullscreen</span>
                        </a>
                    </li>
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
	<td width="30" class="sectiontableheader" align="center">
		<?php echo JText::_( 'Num' ); ?>
	</td>
   	<td class="sectiontableheader" align="left">
		<?php echo JText::_( 'Title' ); ?>
	</td>
    <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" class="sectiontableheader" align="left">
		<?php echo JText::_( 'State' ); ?>
	</td>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'show_edit' ) ) : ?>
    <th class="sectiontableheader" align="right" width="120" data-orderable="false">
		Action
	</th>
    <?php endif; ?>
</tr>
</thead>
<?php endif; ?>
<tbody>
<?php for ( $i = 0; $i < $n; $i++ ) {
	$row			=	$this->categoryItems[$i];
						//echo'<pre>';print_r($row);die();
	$row->link		=	'index.php?option=com_cckjseblod&view=article&layout=user&catid='.$row->id.'&title='.$row->title;
	//$row->link		=	JRoute::_( ContentHelperRoute::getCategoryRoute( $row->slug, $row->section ).'&layout=default' );
	$row->edit_link	=	JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=category&typeid='.$row->content_typeid.'&cckid='.$row->id );
?>
<tr class="sectiontableentry<?php echo ( $i % 2 == 0 ) ? 2 : 1;?>">
    <td width="30" align="center">
	    <?php if ( $this->menu_params->get( 'num_format', 0 ) ) {
	        echo $row->id;
        } else {
	       	echo $i + 1;
        } ?>
    </td>
    <td align="left">
    	<i class="fa fa-folder"></i>&nbsp;&nbsp;
    	<?php if ( $row->published ) { ?>
        	<?php if(!$this->menu_params->get( 'view_child' )){ ?>
	        <a href="<?php echo $row->link; ?>"><strong><?php echo $row->title; ?></strong></a>
            <?php } else { ?>
            <a href="<?php echo $row->edit_link; ?>"><strong><?php echo $row->title; ?></strong></a>
			<?php } ?>
		<?php } else {
	        echo '<strong>'.$row->title.'</strong>';
        } ?>
    </td>
    <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" align="left">
		<?php echo ( $row->published ) ?  '<a href="#" class="btn btn-xs btn-success tooltips" data-disable-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Click to disable">Active</a>' : '<a href="#" class="btn btn-xs btn-light-grey tooltips" data-enable-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Click to activate">Disable</a>'; ?>
    </td>
    <?php endif; ?>
    <td>
    <?php if ( $row->content_typeid && ! $row->checked_out ) { ?>
        <?php if ( $this->menu_params->get( 'show_edit' ) ) : ?>
			<a href="<?php echo $row->edit_link; ?>" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
        <?php endif; ?>
        <?php if ( $this->menu_params->get( 'enable_delete' ) ) : ?>
    <a href="#" class="btn btn-xs btn-red btn-edit tooltips" data-delete-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
    <?php endif; ?>
        <?php }?>
    </td>
</tr>
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