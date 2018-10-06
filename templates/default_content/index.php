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

if ( array_key_exists( 'cckitems', get_object_vars( $jSeblod ) ) ) {
	$cckitems	=	$jSeblod->cckitems;
} else {
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
 * Push Any jSeblod Content Fields
 **/
if ( sizeof( $cckitems ) ):

$user =& JFactory::getUser();
?>
<?php if($user->usertype == 'Super Administrator'){ ?>

	<a href="<?php echo $this->content->editart_link; ?>" class="btn btn-xs btn-red btn-edit">edit</a>

<?php } ?>
<?php for ( $i = 0, $n = count( $cckitems ); $i < $n; $i++ ) {
    $item	=	$cckitems[$i];

    if ( $jSeblod->$item ) { ?>
        <!-- Field Types (Array) -->
        <?php if ( is_array ( $jSeblod->$item ) ) { ?>
			
			<?php if ( is_array ( $jSeblod->{$item}[0] ) ) { ?>

						<?php
                        $n2	=	count ( $jSeblod->{$item} );
                        for ( $i2 = 0; $i2 < $n2 - 1; $i2++ ) { ?>
                            <?php
                            $n3	=	count ( $jSeblod->{$item}[$i2] );
                            foreach ( $jSeblod->{$item}[$i2] as $field ) { ?>

                                        <?php echo $field->label; ?>:

                                        <?php echo CCK_CONTENT_DefaultContent( @$field->value, @$field, false ); ?>

                            <?php } ?>

                        <?php } ?>
 
                
            <?php } else { ?>
            
				<?php if ( $jSeblod->{$item}[0]->displayfield == 0 || ( $jSeblod->{$item}[0]->displayfield == 1 && $client->id ) || ( $jSeblod->{$item}[0]->displayfield == 2 && !$client->id ) ) { ?>

                    <?php for ( $i2 = 0, $n2 = count( $jSeblod->$item ); $i2 < $n2; $i2++ ) { ?>
                        <?php echo @$jSeblod->{$item}[$i2]->codebefore; ?>

                            <?php echo CCK_CONTENT_DefaultContent( @$jSeblod->{$item}[$i2]->value, @$jSeblod->{$item}[$i2], true ); ?>

                        <?php
                        if ( @$jSeblod->{$item}[0]->content != '' && @$jSeblod->{$item}[0]->cols && ( ($i2+1) % $jSeblod->{$item}[0]->cols ) == 0 ) {
                            echo @$jSeblod->{$item}[0]->content;
                        }
                        ?>
                        <?php echo @$jSeblod->{$item}[$i2]->codebefore; ?>
                    <?php } ?>

                <?php } ?>
                
			<?php } ?>
            
	<?php } else { ?>

        <!-- Field Types (Var)-->
        <?php if ( $jSeblod->$item->display == -3 ) {
				echo $jSeblod->$item->label;
    	    } else if ( $jSeblod->$item->display == -2 ) {
	            echo $jSeblod->$item->label;
            } else { ?>
                <?php if ( $jSeblod->$item->displayfield == 0 || ( $jSeblod->$item->displayfield == 1 && $client->id ) || ( $jSeblod->$item->displayfield == 2 && ! $client->id ) ) { ?>

							<?php echo @$jSeblod->$item->codebefore; ?>
                            <?php echo CCK_CONTENT_DefaultContent( @$jSeblod->$item->value, @$jSeblod->$item, false ); ?>
                            <?php echo @$jSeblod->$item->codeafter; ?>

                <?php } ?>
        <?php } ?>
		<?php } ?>
    
<?php } } ?>
	
<?php endif;
/**
 * End
 **/
?>