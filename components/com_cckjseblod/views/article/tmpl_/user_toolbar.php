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
}elseif($activemenu->id == 8 || $activemenu->id == 27){
	$newcnt = JRoute::_($menus->_items[11]->link);
}elseif($activemenu->id == 13){
	$newcnt = JRoute::_($menus->_items[15]->link);
}
//echo'<pre>';print_r($newcnt);die();

?>

<style type="text/css">
button.common_submit {
    background-color:<?php echo $this->menu_params->get( 'button_bgcolor', '#6cc634' ); ?>;
    border:0 none;
    color:<?php echo $this->menu_params->get( 'button_color', '#ffffff' ); ?>;
    font-size:11px;
    font-weight:bold;
    height:24px;
	margin-left:2px;
	margin-right:2px;
	cursor:pointer;
}
a.common_submit {
    background-color: #6cc634;
    border: 0 none;
    color: #ffffff;
    cursor: pointer;
    font-family: MS Shell Dlg;
    font-size: 11px;
    font-weight: bold;
    margin-left: 2px;
    margin-right: 2px;
    padding: 3px 12px;
    text-decoration: none;
}
</style>
<br />
<?php if ( $this->menu_params->get( 'enable_add' ) == 'left' ) : ?>
    <button style="float: <?php echo $this->menu_params->get( 'enable_add', 'left' ) ?>;" onclick="window.location.href='<?php echo $newcnt; ?>';" class="common_submit">
        <?php echo JText::_( 'NEW' ); ?>
    </button>
<?php endif; ?>
<?php if ( $this->menu_params->get( 'enable_publish' ) == 'left' ) : ?>
	<button style="float: <?php echo $this->menu_params->get( 'enable_publish', 'left' ) ?>;" class="common_submit" type="submit" name="task" value="article_publish">
		<?php echo JText::_( 'PUBLISH' ); ?>
	</button>
<?php endif; ?>
<?php if ( $this->menu_params->get( 'enable_unpublish' ) == 'left' ) : ?>
	<button style="float: <?php echo $this->menu_params->get( 'enable_unpublish', 'left' ) ?>;" class="common_submit" type="submit" name="task" value="article_unpublish">
		<?php echo JText::_( 'UNPUBLISH' ); ?>
	</button>
<?php endif; ?>
<?php if ( $this->menu_params->get( 'enable_delete' ) == 'left' ) : ?>
    <button style="float: <?php echo $this->menu_params->get( 'enable_delete', 'left' ) ?>;" class="common_submit" type="submit" name="task" value="article_trash">
        <?php echo JText::_( 'DELETE' ); ?>
    </button>
<?php endif; ?>

<?php if ( $this->menu_params->get( 'enable_delete' ) == 'right' ) : ?>
    <button style="float: <?php echo $this->menu_params->get( 'enable_delete', 'left' ) ?>;" class="common_submit" type="submit" name="task" value="article_trash">
        <?php echo JText::_( 'DELETE' ); ?>
    </button>
<?php endif; ?>
<?php if ( $this->menu_params->get( 'enable_unpublish' ) == 'right' ) : ?>
	<button style="float: <?php echo $this->menu_params->get( 'enable_unpublish', 'left' ) ?>;" class="common_submit" type="submit" name="task" value="article_unpublish">
		<?php echo JText::_( 'UNPUBLISH' ); ?>
	</button>
<?php endif; ?>
<?php if ( $this->menu_params->get( 'enable_publish' ) == 'right' ) : ?>
	<button style="float: <?php echo $this->menu_params->get( 'enable_publish', 'left' ) ?>;" class="common_submit" type="submit" name="task" value="article_publish">
		<?php echo JText::_( 'PUBLISH' ); ?>
	</button>
<?php endif; ?>
<?php if ( $this->menu_params->get( 'enable_add' ) == 'right') : ?>
	<?php if(JRequest::getVar('catid')){ ?>
    	<a class="common_submit" style="float: right;" href="<?php echo $newcnt; ?>&catid=<?php echo JRequest::getVar('catid'); ?>"><?php echo JText::_( 'NEW' ); ?></a>
    <?php }else{ ?>
    	<a class="common_submit" style="float: right;" href="<?php echo $newcnt; ?>"><?php echo JText::_( 'NEW' ); ?></a>
    <?php } ?>
<?php endif; ?>