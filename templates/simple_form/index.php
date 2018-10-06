<?php
/**
* @version 			1.9.0
* @author       	http://www.seblod.com
* @copyright		Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
* @package			SEBLOD 1.x (CCK for Joomla!)
**/

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php
/**
 * Init jSeblod Process Object { !Important; !Required; }
 **/
$jSeblod	=	clone $this;

if ( array_key_exists( 'cckform', get_object_vars( $jSeblod ) ) && array_key_exists( 'cckitems', get_object_vars( $jSeblod ) ) ) {
$cckform	=	$jSeblod->cckform;
$cckitems	=	$jSeblod->cckitems;
} else {
	global $mainframe;
	$mainframe->enqueueMessage( 'This Templtate is an Auto Form Template, it can\'t be used to render Content. (Only Forms!) So... do not assign any Site View on it.', "error" );
	return true;
}
?>

<?php
/**
 * Init Style Parameters
 **/
include( dirname(__FILE__) . '/params.php' );
?>

<?php
/**
 * Push jSeblod Form Action Content Field
 **/
echo $jSeblod->$cckform->form;
?>

<?php
/**
 * Push Any jSeblod Content Fields
 **/
if ( sizeof( $cckitems ) ):
?>
<fieldset class="adminform" <?php echo $fieldsetStyle; ?>>
<?php if ( $showTitle ) { ?>
<legend <?php echo $legendStyle; ?>><?php echo ( @$this->menu->title ) ? @$this->menu->title : JText::_( 'CCK SITE FORM' ); ?></legend>
<?php } ?>
<table class="admintable" width="100%" cellpadding="0" cellspacing="0" border="0">
<?php for ( $i = 0, $n = count( $cckitems ); $i < $n; $i++ ) {
    $item	=	$cckitems[$i];

    if ( $jSeblod->$item ) { ?>
        <!-- Field Types (Array) -->
        <?php if ( is_array ( $jSeblod->$item ) ) { ?>
        	<tr>
            <td>
	        <table id="<?php echo 'add-elem-parent-'.$jSeblod->{$item}[0]->name; ?>" class="admintable" width="100%" cellpadding="0" cellspacing="0" border="0">
            <?php for ( $i2 = 0, $n2 = count( $jSeblod->$item ); $i2 < $n2; $i2++ ) {
                if ( $jSeblod->{$item}[$i2] ) { ?>
                <?php if ( $jSeblod->{$item}[$i2]->displayfield == 0 || ( $jSeblod->{$item}[$i2]->displayfield == 1 && $client->id ) || ( $jSeblod->{$item}[$i2]->displayfield == 2 && !$client->id ) ) { ?>
                    <tr id="<?php echo 'add-elem-child-'.$i2.'-'.$jSeblod->{$item}[$i2]->name; ?>"> 
                        <td class="cck_field">
                        	<?php if ( $displayLabel == 1 ) { ?>
                            <?php if ( $jSeblod->{$item}[$i2]->display == 3 ||  $jSeblod->{$item}[$i2]->display == 2 ) { ?>
                            <a href="javascript: addOption();">
                            <label class="cck_label" for="<?php echo $jSeblod->{$item}[$i2]->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.';cursor:pointer;"'; } 
							else { echo 'style="cursor:pointer;"'; } ?>>
								<?php echo ( $jSeblod->{$item}[$i2]->label ) ? $jSeblod->{$item}[$i2]->label . $labelSeparator : ''; ?>
                            </label></a><br />
                            <?php } } ?>
                            <?php echo @$jSeblod->{$item}[$i2]->codebefore; ?>
                            <?php echo CCK_CONTENT_SimpleForm( @$jSeblod->{$item}[$i2]->form, $jSeblod->{$item}[$i2], true, $displayLabel ); ?>
                            <?php echo @$jSeblod->{$item}[$i2]->codebefore; ?>
                        </td>
                    </tr>
                <?php } ?>
            	<?php } ?>
        	<?php } ?>
            </table>
            </td>
            </tr>
	<?php } else { ?>

        <!-- Field Types (Var)-->
        <?php if ( $jSeblod->$item->display == -3 ) {
				echo '<tr><td colspan="3"><h3 '.$panelTitleStyle.'>'.$jSeblod->$item->label.'</h3></td></tr>';
    	    } else if ( $jSeblod->$item->display == -2 ) {
	            echo '<tr><td colspan="3"><h3 '.$panelTitleStyle.'>'.$jSeblod->$item->label.'</h3></td></tr>';
            } else { ?>
                <?php if ( $jSeblod->$item->displayfield == 0 || ( $jSeblod->$item->displayfield == 1 && $client->id ) || ( $jSeblod->$item->displayfield == 2 && ! $client->id ) ) { ?>
                    <tr> 
                    	<td class="cck_field" id="<?php echo $jSeblod->$item->container; ?>">
                        	<?php if ( $displayLabel == 1 ) { ?>
                            <?php if ( $jSeblod->$item->display == 3 ||  $jSeblod->$item->display == 2 ) { ?>
                            <label class="cck_label" for="<?php echo $jSeblod->$item->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.'"'; } ?>>
								<?php echo ( $jSeblod->$item->label ) ? $jSeblod->$item->label . $labelSeparator : ''; ?>
                            </label><br />
                            <?php } } ?>
							<?php echo @$jSeblod->$item->codebefore; ?>
                            <?php echo CCK_CONTENT_SimpleForm( @$jSeblod->$item->form, $jSeblod->$item, false, $displayLabel ); ?>
                            <?php echo @$jSeblod->$item->codeafter; ?>
                    	</td>
                    </tr>
                <?php } ?>
        <?php } ?>
		<?php } ?>
    
<?php } } ?>
</table>
</fieldset>

<?php endif;
/**
 * End
 **/
?>