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
	$newcnt = JRoute::_('index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$this->articleItems[0]->content_typeid);
}else{
	if($this->menu_params->get( 'typeid' )){
	$newcnt = JRoute::_('index.php?option=com_cckjseblod&view=type&layout=form&typeid='.$this->menu_params->get( 'typeid' ));
	}
}
?>

<?php if ( $this->menu_params->get( 'enable_add' ) == 'right' || $newcnt) : ?>
	<?php if(JRequest::getVar('catid')){ ?>
        <li>
            <div class="pull-right">
                <div class="btn-group">
                    <a class="btn btn-sm btn-primary" href="<?php echo $newcnt; ?>&catid=<?php echo JRequest::getVar('catid'); ?>"><i class="fa fa-plus"></i> <?php echo JText::_( 'NEW' ); ?></a>
                </div>
            </div>
        </li>
    <?php }else{ ?>
    	<li>
            <div class="pull-right">
                <div class="btn-group">
                    <a class="btn btn-sm btn-primary" href="<?php echo $newcnt; ?>"><i class="fa fa-plus"></i> <?php echo JText::_( 'NEW' ); ?></a>
                </div>
            </div>
        </li>
    <?php } ?>
	<?php if ( $this->menu_params->get( 'enable_ordering' ) || JRequest::getVar('enableorder')) : ?>
		<li>
            <div class="pull-right">
                <div class="btn-group">
					<button class="btn btn-sm btn-primary" type="submit" name="task" value="saveOrder">
						Save Ordering
					</button>
				</div>
            </div>
        </li>
	<?php endif; ?>
<?php endif; ?>