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

$javascript ='
		';
$this->document->addScriptDeclaration( $javascript );
?>

<?php if ( $this->menu_params->get( 'show_page_title', 1 ) ) : ?>
<div class="componentheading"><?php echo $this->page_title; ?></div>
<?php endif; ?>

<form  method="post" id="adminForm" name="adminForm">
<?php if ( $this->menu_params->get( 'show_headings' ) ) : ?>
<table class="category" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td width="30" class="sectiontableheader" align="center">
		<?php echo JText::_( 'Num' ); ?>
	</td>
   	<td class="sectiontableheader" align="left">
		<?php echo JText::_( 'Title' ); ?>
	</td>
    <?php if ( $this->menu_params->get( 'show_category' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'category_width' ); ?>" class="sectiontableheader" align="left">
		<?php echo JText::_( 'Category' ); ?>
	</td>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" class="sectiontableheader" align="center">
		<?php echo JText::_( 'State' ); ?>
	</td>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'show_date' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'date_width' ); ?>" class="sectiontableheader" align="right">
		Subscribe Date
	</td>
    <?php endif; ?>
	<?php if ( $this->menu_params->get( 'enable_publish' ) || $this->menu_params->get( 'enable_unpublish' ) || $this->menu_params->get( 'enable_delete' ) ) : ?>
    <td width="24" class="sectiontableheader" align="right" style="padding-right: 9px;">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->articleItems ); ?>);" />
	</td>
    <?php endif; ?>
</tr>
<?php endif; ?>

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
	       	echo $i + 1 + (int)JRequest::getVar('start');
        } ?>
    </td>
    <td align="left">
    	<?php if ( $row->state && ( ! $row->category || ( $row->category && $row->cat_state ) ) ) { ?>
	        <a href="<?php echo $row->email; ?>"><?php echo $row->title; ?></a>
        <?php } else {
        	echo $row->email;
        } ?>
    </td>
    <?php if ( $this->menu_params->get( 'show_category' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'category_width' ); ?>" align="left">
        <?php echo ( $row->category ) ? $row->category : '-'; ?>
    </td>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" align="center">
	    <?php echo ( $row->status ) ?  '<img src="administrator/images/publish_g.png" alt=" " border="0" />' : '<img src="administrator/images/publish_x.png" alt=" " border="0" />'; ?>
    </td>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'show_date' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'date_width' ); ?>" align="right">
        <?php echo $row->date; ?>
    </td>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'enable_publish' ) || $this->menu_params->get( 'enable_unpublish' ) || $this->menu_params->get( 'enable_delete' ) ) : ?>
    	<td width="24" align="right" style="padding-right: 10px;">
			<?php echo JHTML::_( 'grid.checkedout', $row, $i ); ?>
		</td>
    <?php endif; ?>
</tr>
<?php } ?>

</table>
<?php echo $this->pagination->getListFooter(); ?>
<?php echo $this->loadTemplate( 'toolbar' ); ?>

<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>