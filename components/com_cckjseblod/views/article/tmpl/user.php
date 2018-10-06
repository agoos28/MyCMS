<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<style>
.sectiontableentry1, .sectiontableentry2{
	transition: all 0s;
	transform: translate(0,0);
}
.slideup{
	transition: all 0.2s ease;
	transform: translate(0,-100%);
}
.slidedown{
	transition: all 0.2s ease;
	transform: translate(0,100%);
}
</style>
<script type="text/javascript">
jQuery(document).ready(function(e) {
    function hidefirst(){
		jQuery('a.mup:first').addClass('disabled')
		jQuery('a.mup').not(jQuery('a.mup:first')).removeClass('disabled')
		jQuery('a.mdown:last').addClass('disabled')
		jQuery('a.mdown').not(jQuery('a.mdown:last')).removeClass('disabled')
	}
	hidefirst()
	$('body').on('click', 'a.mup', function(e){
		var th = jQuery(this)
		var parent = th.closest('tr')
		var prev = parent.prev()
		var next = parent.next()
		var curvar = parent.find('input.order').val()
		prev.find('input.order').val(parseInt(curvar))
		parent.find('input.order').val(parseInt(curvar) - 1)
		parent.addClass('slideup')
		prev.addClass('slidedown')
		setTimeout(function(){
			parent.removeClass('slideup')
			parent.insertBefore(prev)
			prev.removeClass('slidedown')
			hidefirst()
		}, 200)
		
		//parent.insertBefore(prev)
		//jQuery('.reorder').click()
		e.preventDefault()
	})
	$('body').on('click', 'a.mdown', function(e){
		var th = jQuery(this)
		var parent = th.closest('tr')
		var prev = parent.prev()
		var next = parent.next()
		var curvar = parent.find('input.order').val()
		next.find('input.order').val(parseInt(curvar))
		parent.find('input.order').val(parseInt(curvar) + 1)
		parent.addClass('slidedown')
		next.addClass('slideup')
		setTimeout(function(){
			parent.removeClass('slidedown')
			parent.insertAfter(next)
			next.removeClass('slideup')
			hidefirst()
		}, 200)
		
		//parent.insertAfter(next);
		//jQuery('.reorder').click()
		e.preventDefault()
	})
	$('.datatable').on( 'draw.dt', function () {
    hidefirst()
} );
	$('#adminForm').on('click', '.publishing', function(e){
		var th = $(this)
		th.text('Wait')
		var cid = th.data('id')
		if(th.data('action') == 'enable'){
			var params = $('#adminForm').serialize()+'&task=article_publish&methode=ajax&cid='+cid
			var classreplace = 'btn btn-xs btn-success tooltips disable publishing'
			var tooltip = 'Click to disable'
			var text = 'Active'
			var dataAction = 'disable'
		}else{
			var params = $('#adminForm').serialize()+'&task=article_unpublish&methode=ajax&cid='+cid
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
			var params = $('#adminForm').serialize()+'&task=article_trash&methode=ajax&cid='+cid
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
});
</script>
<?php
//JHTML::_( 'behavior.mootools' );
//JHTML::_( 'behavior.modal' );
JHTML::_('jquery.datatable', '.datatable');


require_once ( JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php' );
	
$n	=	count( $this->articleItems );

$javascript ='
		';
$this->document->addScriptDeclaration( $javascript );

if(JRequest::getVar('title')){
	$cat_title = ' '.JRequest::getVar('title');
}

?>

<?php if ( $this->menu_params->get( 'show_prod_search' ) ) : ?>
<?php echo $this->loadTemplate( 'searchbar' ); ?>
<?php endif; ?>
<div class="col-ms-12">
<div class="panel panel-white">
<form action="index.php" method="post" id="adminForm" name="adminForm">
<div class="panel-heading border-light">
    <h4 class="panel-title"><?php echo $this->page_title.$cat_title; ?></h4>
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
<?php if ( $this->menu_params->get( 'show_headings' ) ) : ?>
<table class="table table-striped datatable border-bottom" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-color: #dfe1e5;">
<thead>
<tr>
	<?php if ( $this->menu_params->get( 'enable_publish' ) || $this->menu_params->get( 'enable_unpublish' ) || $this->menu_params->get( 'enable_delete' ) ) : ?>
    <th width="30" style="text-align: center;" >
		#
	</th>
    <?php endif; ?>
   	<th class="sectiontableheader" align="left">
		<?php echo JText::_( 'Title' ); ?>
	</th>
    <?php if ( $this->menu_params->get( 'show_category' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'category_width' ); ?>" class="sectiontableheader" align="left">
		<?php echo JText::_( 'Category' ); ?>
	</th>
    <?php endif; ?>
    
    <?php if ( $this->menu_params->get( 'show_date' ) ) : ?>
    <th width="<?php echo $this->menu_params->get( 'date_width' ); ?>" class="sectiontableheader" align="left">
		<?php echo JText::_( 'Date' ); ?>
	</th>
    <?php endif; ?>
    
    <?php if ( $this->page_title == 'Product Category' || $this->page_title == 'All Products' ) : ?>
    <th width="100" class="sectiontableheader" align="center">
		Stock
	</th>
    <?php endif; ?>
    <th width="50" class="sectiontableheader" align="left">
		<?php echo JText::_( 'Hits' ); ?>
	</th>
    <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
    <th width="<?php echo $this->menu_params->get( 'state_width' ); ?>" class="sectiontableheader" align="left">
		<?php echo JText::_( 'State' ); ?>
	</th>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'enable_ordering' ) || JRequest::getVar('enableorder')) : ?>
    <th width="40" class="sectiontableheader" align="center">
		Order
	</th>
    <?php endif; ?>
    <?php if ( $this->menu_params->get( 'show_edit' ) ) : ?>
    <th style="width: 120px;" class="sectiontableheader" align="right" width="120" data-orderable="false">
		Action
	</th>
    <?php endif; ?>
	
</tr>
</thead>
<?php endif; ?>
<tbody>
<?php for ( $i = 0; $i < $n; $i++ ) {
	$row				=	$this->articleItems[$i];
	$row->hrefpoll		=	JURI::base().'administration/poll-result?pollid='.$row->id;
	$row->link		=	JRoute::_( ContentHelperRoute::getArticleRoute( $row->slug, $row->catslug, $row->sectionid ) );
	require_once ( JPATH_SITE.DS.'components'.DS.'com_cckjseblod'.DS.'helpers'.DS.'route.php' );
	if ( CCKjSeblodHelperRoute::isSEF() ) {
		$sef_option		=	'';
		$sef			=	0;
	} else {
		$sef_option		=	'option=com_content';
		$sef			=	0;
	}
	$row->href			=	CCKjSeblodHelperRoute::getArticleRoute( $row->slug, $row->catslug, $sef, $sef_option, $this->itemId );
	//$row->link		=	JRoute::_( $row->href );							
	$row->edit_link		=	JRoute::_( 'index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$row->content_typeid.'&cckid='.$row->id );
?>
<tr class="sectiontableentry<?php echo ( $i % 2 == 0 ) ? 2 : 1;?>">
<?php if ( $this->menu_params->get( 'enable_publish' ) || $this->menu_params->get( 'enable_unpublish' ) || $this->menu_params->get( 'enable_delete' ) ) : ?>
    <?php if ( ! $row->checked_out ) { ?>
    	<td width="24" align="right" style="padding-right: 10px;">
			<?php echo $i + 1; ?>
		</td>
    <?php } else { ?>
    	<td width="24" align="center">
			<?php echo '-'; ?>
		</td>
    <?php } endif; ?>
    <td align="left">
    	<i class="fa fa-file-text"></i>&nbsp;&nbsp;<strong><?php echo $row->title; ?></strong>
    </td>
    <?php if ( $this->menu_params->get( 'show_category' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'category_width' ); ?>" align="left">
        <?php echo ( $row->category ) ? $row->category : '-'; ?>
    </td>
    <?php endif; ?>
    
    <?php if ( $this->menu_params->get( 'show_date' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'date_width' ); ?>" align="left">
        <?php echo JHTML::_('date',  $row->created, $this->date_format ); ?>
    </td>
    <?php endif; ?>

    
    <?php if ( $this->page_title == 'Product Category' || $this->page_title == 'All Products' ) : ?>
    <td width="50">
		<?php echo $row->stock; ?>
	</td>
    <?php endif; ?>
    <td width="50">
        <?php echo $row->hits; ?>
    </td>

    <?php if ( $this->menu_params->get( 'show_state' ) ) : ?>
    <td width="<?php echo $this->menu_params->get( 'state_width' ); ?>" align="left">
    <?php if (!$row->checked_out) { ?>
        <?php if ($row->state) { ?>
        	<a href="#" class="btn btn-xs btn-success tooltips publishing" data-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Click to disable" data-action="disable">Active</a>
            <?php }else{ ?>
            <a href="#" class="btn btn-xs btn-light-grey tooltips publishing" data-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Click to activate" data-action="enable">Disable</a>
            <?php }; ?>
        <?php }else{ ?>
        	<span class="label label-sm label-danger">Locked</span>
        <?php }; ?>
    </td>
    <?php endif; ?>
    
    <?php if ( $this->menu_params->get( 'enable_ordering' ) || JRequest::getVar('enableorder')) : ?>
    <td style="width: 100px;">
    <a class="mup btn btn-xs btn-default" title="Move Up" href="#reorder">
        <i class="fa fa-arrow-circle-up"></i>
    </a>
    <a class="mdown btn btn-xs btn-default" title="Move Down" href="#reorder">
        <i class="fa fa-arrow-circle-down"></i>
    </a>
    <input type="text" class="order" name="order[]" value="<?php echo $row->ordering; ?>" style="width: 30px; text-align: center; display: inline; font-size: 10px; padding: 4px;" autocomplete="off" />
    <input type="hidden" name="cids[]" value="<?php echo $row->id; ?>" autocomplete="off" />
    </td>
    <?php endif; ?>
    
    <td width="120">
    
    	<?php if ( $row->content_typeid && ! $row->checked_out ) { ?>
        <?php if ( $this->menu_params->get( 'show_edit' ) ) : ?>
			<a href="<?php echo $row->edit_link; ?>" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
        <?php endif; ?>
        <?php if ( $this->menu_params->get( 'enable_delete' ) ) : ?>
    <a href="#" class="btn btn-xs btn-red btn-edit deleteitem tooltips" data-id="<?php echo $row->id; ?>" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
    <?php endif; ?>
        <?php }?>
        <?php if ( $this->menu_params->get( 'show_duplicate' ) ) : ?>
			<a href="<?php echo $row->edit_link; ?>&asnew=1" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Duplicate"><i class="fa fa-copy"></i></a>
        <?php endif; ?>
        <?php if ( $row->state && ( ! $row->category || ( $row->category && $row->cat_state ) ) ) { ?>
        <a target="_blank" class="btn btn-xs btn-primary tooltips" href="<?php echo str_replace('home','products',$row->link); ?>" data-placement="top" data-original-title="Preview"><i class="fa fa-share"></i></a>
        <?php }?>
	</td>
    
    
</tr>
<?php } ?>
</tbody>

</table>
</div>
</div>

<input type="hidden" name="redir" value="<?php echo JURI::getInstance()->toString();; ?>" />
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
</div>
</div>