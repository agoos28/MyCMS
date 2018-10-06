<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php
JHTML::_( 'behavior.mootools' );
JHTML::_( 'behavior.modal' );

require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php' );
	
$n	=	count( $this->articleItems );


?>


<div class="col-ms-12">
<div class="panel panel-white">
<form  method="post" id="adminForm" name="adminForm">
<div class="panel-heading border-light">
    <h4 class="panel-title"><?php echo $this->page_title; ?></h4>
    <ul class="panel-heading-tabs border-light">
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
<?php if ( $this->menu_params->get( 'show_headings' ) ) : ?>
<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
<thead>
<tr>
	<th width="30" class="sectiontableheader" align="center">
		<?php echo JText::_( 'Num' ); ?>
	</th>
  <th class="sectiontableheader" align="left">
		<?php echo JText::_( 'Email' ); ?>
	</th>
  <th class="sectiontableheader" align="left">
		<?php echo JText::_( 'Name' ); ?>
	</th>
   	
    
    <th width="<?php echo $this->menu_params->get( 'category_width' ); ?>" align="center" style="text-align: center;">
		<?php echo JText::_( 'User ID' ); ?>
	</th>

    
    <th width="<?php echo $this->menu_params->get( 'state_width' ); ?>" class="sectiontableheader" align="left">
		<?php echo JText::_( 'State' ); ?>
	</th>
    
    
    <?php if ( $this->menu_params->get( 'show_author' ) ) : ?>
    <th width="<?php echo $this->menu_params->get( 'author_width' ); ?>" class="sectiontableheader" align="left">
		<?php echo JText::_( 'Author' ); ?>
	</th>
    <?php endif; ?>
    
    
	
</tr>
<?php endif; ?>
</thead>
<tbody>
<?php for ( $i = 0; $i < $n; $i++ ) {
	$row				=	$this->articleItems[$i];
	//$row->link		=	JRoute::_( ContentHelperRoute::getArticleRoute( $row->slug, $row->catslug, $row->sectionid ) );
	require_once ( JPATH_SITE.DS.'components'.DS.'com_cckjseblod'.DS.'helpers'.DS.'route.php' );
	if ( CCKjSeblodHelperRoute::isSEF() ) {
		$sef_option		=	'';
		$sef			=	0;
	} else {
		$sef_option		=	'option=com_content';
		$sef			=	0;
	}
	$row->href			=	CCKjSeblodHelperRoute::getArticleRoute( $row->slug, $row->catslug, $sef, $sef_option, $this->itemId );
	$row->link			=	JRoute::_( $row->href );							
	$row->edit_link		=	JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$row->content_typeid.'&cckid='.$row->id );
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
    	<?php 
        	echo $row->email;
        ?>
    </td>
    <td align="left">
    	<?php 
			if($row->userid){
        	echo $row->name;
			}else{
				echo $row->full_name;
			}
        ?>
    </td>
    <td width="<?php echo $this->menu_params->get( 'category_width' ); ?>" align="center">
        <?php 
				if($row->userid){
					echo '#'.$row->userid;
				}
				?>
    </td>
   
   
    <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" align="left">
	    <?php echo ( $row->status ) ?  '<a href="#" class="btn btn-xs btn-success">Active</a>' : '<a href="#" class="btn btn-xs btn-light-grey tooltips enable publishing">Disable</a>'; ?>
    </td>

  
    <?php if ( $this->menu_params->get( 'show_author' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'author_width' ); ?>" align="left">
        <?php echo $row->author; ?>
    </td>
    <?php endif; ?>
    
    
    
</tr>
<?php } ?>
</tbody>
</table>
<div style="height:20px;"></div>
<?php echo $this->pagination->getListFooter(); ?>
<?php echo $this->loadTemplate( 'toolbar' ); ?>

<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
<?php echo JHTML::_('form.token'); ?>
</div>
</form>
</div>
</div>