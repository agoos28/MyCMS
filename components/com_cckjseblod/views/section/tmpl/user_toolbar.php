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
	$newcnt = JRoute::_('index.php?option=com_cckjseblod&view=section&layout=form&grouping='.$this->articleItems[0]->content_typeid.'&templateid=1');
}else{
	if($this->menu_params->get( 'secgroup' )){
	$newcnt = JRoute::_('index.php?option=com_cckjseblod&view=section&layout=form&grouping='.$this->menu_params->get( 'secgroup' ).'&templateid=1');
	}
}
?>
<?php //if ( $this->menu_params->get( 'show_prod_search' ) ) : ?>
<?php echo $this->loadTemplate( 'searchbar' ); ?>
<?php //endif; ?>
<?php if ( $this->menu_params->get( 'enable_add' ) == 'right' || $newcnt) : ?>
	
        <li>
            <div class="pull-right">
                <div class="btn-group">
                    <a class="btn btn-sm btn-primary" href="<?php echo $newcnt; ?>"><i class="fa fa-plus"></i> <?php echo JText::_( 'NEW_CATEGORY' ); ?></a>
                </div>
            </div>
        </li>
<?php endif; ?>