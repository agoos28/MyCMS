<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
$menuid = $this->menu_params->get( 'newlink' );
$menus = &JSite::getMenu();
$activemenu = $menus->getActive();
$cururl = JURI::current();
if($menuid){
	$newcnt = JRoute::_($menus->_items[$menuid]->link);
}elseif($this->articleItems[0]->content_typeid){
	$newcnt = JRoute::_('index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$this->articleItems[0]->content_typeid.'&templateid=1');
}else{
	
}
if($this->menu_params->get( 'cattypeid' )){
	$newcnt = JRoute::_('index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$this->menu_params->get( 'cattypeid' ).'&secid='.$this->menu_params->get( 'secid' ));
}else{
}
?>
<?php if ( $this->menu_params->get( 'show_search' ) ) : ?>
	<li>
<form id="searchform" method="post" action="<?php echo JURI::current(); ?>">
    	<input name="keyword" value="<?php echo JRequest::getVar('keyword'); ?>" type="text" placeholder="Search <?php echo $activemenu->name; ?>"> <button type="submit" class="btn btn-sm btn-primary">GO</button>
        <input type="hidden" name="view" value="article" />
        <input type="hidden" name="layout" value="user" />
        <input type="hidden" name="title" value="Search Product" />
</form>
<script>
jQuery(document).ready(function(e) {
    jQuery('.reset').click(function(){
		jQuery('#searchform').find('input').val('')
		jQuery('#searchform').submit()
	})
});
</script>
</li>
<?php endif; ?>
<?php if ( $this->menu_params->get( 'enable_add' ) == 'right' || $newcnt) : ?>
				
        <li>
            <div class="pull-right">
                <div class="btn-group">
                    <a class="btn btn-sm btn-primary" href="<?php echo $newcnt; ?>"><i class="fa fa-plus"></i> New Category</a>
                </div>
            </div>
        </li>
<?php endif; ?>