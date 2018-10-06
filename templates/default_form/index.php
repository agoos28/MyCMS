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

$panelId	=	0;
$subPanelId =	0;
jimport( 'joomla.html.pane' );
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
    <div id="validation-alert-container" style="float: right;"></div>
	<table class="admintable" width="100%">
	<?php for ( $i = 0, $n = count( $cckitems ); $i < $n; $i++ ) {
		$item	=	$cckitems[$i];
		
		
		
		if ( $jSeblod->$item ) { ?>
	        <!-- Fields Types (Array) -->
			<?php if ( is_array ( $jSeblod->$item ) ) { ?>
                                    
            	<?php if ( is_array ( @$jSeblod->{$item}[0] ) ) { ?>
					
                <tr>
                	<?php if ( $jSeblod->{$item}['group']->display == 3 ) { ?>
                    <td width="25" class="key_balloon">
						<?php if ( $jSeblod->{$item}['group']->light ) { ?>
                            <?php if ( $jSeblod->{$item}['group']->description ) { ?>
                            <span class="DescriptionTip" title="<?php echo $jSeblod->{$item}['group']->label; ?>::<?php echo $jSeblod->{$item}['group']->tooltip; ?>">
                                <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                            </span>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td width="140" class="key">
                    	<?php echo @$jSeblod->{$item}['group']->label; ?>
                    </td>
                    <td>
                    <?php } else { ?>
                    <td width="25" class="key_balloon">
						<?php if ( $jSeblod->{$item}['group']->light ) { ?>
                            <?php if ( $jSeblod->{$item}['group']->description ) { ?>
                            <span class="DescriptionTip" title="<?php echo $jSeblod->{$item}['group']->label; ?>::<?php echo $jSeblod->{$item}['group']->tooltip; ?>">
                                <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                            </span>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td colspan="2">
                    <?php } ?>
                    	<?php if ( $jSeblod->{$item}['group']->orientation == 2 ) {
						// List
						?>
                            <?php
                            $n2	=	count ( $jSeblod->{$item} );
                            for ( $i2 = 0; $i2 < $n2 - 1; $i2++ ) {
                                $n3	=	count ( $jSeblod->{$item}[$i2] );
								if ( $i2 == 0 ) { ?>
								<table class="adminlist" cellpadding="0" cellspacing="0" border="0" >
                                <tbody id="<?php echo $jSeblod->{$item}['group']->name; ?>">
								<tr class="header">
								<?php
								foreach ( $jSeblod->{$item}[$i2] as $field ) { ?>
									<td>
										<?php if ( $field->light ) { ?>
                                            <?php if ( $field->description ) { ?>
                                            <span class="DescriptionTip" title="<?php echo $field->label; ?>::<?php echo $field->tooltip; ?>">
                                                <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                                            </span>
                                            <?php } ?>
                                        <?php } ?>
										<?php if ( $field->display > 0 ) { ?>
										<?php echo $field->label; ?>
										<?php } ?>
									</td>
								<?php } ?>
                                	<td>Action</td>
								</tr>
								<?php } ?>                     
								<tr class="row<?php echo ( $i2 % 2 == 0 ) ? 0 : 1;?>  xitem" id="<?php echo $jSeblod->{$item}['group']->name; ?>-<?php echo $i2;?>">
								<?php
								foreach ( $jSeblod->{$item}[$i2] as $field ) { ?>
									<?php if ( $field->display != -1 ) { ?>
									<td id="<?php echo $field->container; ?>">
										<?php echo $field->form; ?>
									</td>
									<?php } else { echo $field->form; } ?>
								<?php } ?>
                                	<td>
                                        <?php if ( @$jSeblod->{$item}['group']->deletable ) { ?>
                                        <img class="button-del" onclick="GROUP_Remove(this);" src="<?php echo $root; ?>/media/jseblod/_icons/del-default.gif" alt="Del" />
                                        <?php } ?>
                                        <?php if ( @$jSeblod->{$item}['group']->draggable ) { ?>
                                            <img class="button-drag" src="<?php echo $root; ?>/media/jseblod/_icons/drag-default.gif" alt="Drag" />
                                        <?php } ?>
                                    </td>
								</tr>
								<?php if ( $i2 == $n2 - 2 ) { ?>
                                </tbody>
								</table>
                                <div style="padding: 10px 0;"><button data-id="<?php echo $jSeblod->{$item}['group']->name; ?>-0" data-max="<?php echo $jSeblod->{$item}['group']->maximum; ?>);" style="float: right;" class="newitemgroup">Add new item</button></div>
                                <script type="text/javascript">
                              window.addEvent('domready', function(){
                                new Sortables($('<?php echo $jSeblod->{$item}['group']->name; ?>'), {
                                    'handles': $('<?php echo $jSeblod->{$item}['group']->name; ?>').getElements('img.button-drag')
                                });			
                            });
                            </script>
								<?php } ?>
                        	<?php } ?>
                        <?php } else {
						// Default (Vertical / Horizontal )?>
                        
						<?php if ( @$jSeblod->{$item}['group']->draggable ) { ?>
                            <script type="text/javascript">
                              window.addEvent('domready', function(){
                                new Sortables($('<?php echo $jSeblod->{$item}['group']->name; ?>'), {
                                    'handles': $('<?php echo $jSeblod->{$item}['group']->name; ?>').getElements('img.button-drag')
                                });			
                            });
                            </script>
                            <?php } ?>
                            <ul id="<?php echo $jSeblod->{$item}['group']->name; ?>" class="collection-group-repeatable"> 
                            <?php
                            $n2	=	count ( $jSeblod->{$item} );
                            for ( $i2 = 0; $i2 < $n2 - 1; $i2++ ) { ?>
                            
                            <li class="collection-group-repeatable">
                                <div class="collection-group-wrap">
                                    <div class="collection-group-form">
                                        <?php
                                        $n3	=	count ( $jSeblod->{$item}[$i2] );
                                        if ( $jSeblod->{$item}['group']->orientation ) { ?>
											<table cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                <?php
                                                foreach ( $jSeblod->{$item}[$i2] as $field ) { ?>
	                                                <td width="15">
                       	                            <?php if ( $field->light ) { ?>
														<?php if ( $field->description ) { ?>
                                                        <span class="DescriptionTip" title="<?php echo $field->label; ?>::<?php echo $field->tooltip; ?>">
                                                            <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                                                        </span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </td>
                                                    <?php if ( $field->display > 0 ) { ?>
                                                    <td style="color: #666666; font-weight: bold;">
                                                        <?php echo $field->label; ?>:
                                                    </td>
                                                    <?php } ?>
                                                    <td id="<?php echo $field->container; ?>">
                                                        <?php echo $field->form; ?>
                                                    </td>
                                                <?php } ?>
                                                </tr>
                                            </table>
                                        <?php } else { ?>
                                            <table cellpadding="0" cellspacing="0" border="0">
                                            <?php foreach ( $jSeblod->{$item}[$i2] as $field ) { // Vertical ?>
                                                <?php if ( $field->display != -1 ) { ?>
                                                <tr>
	                                                <td width="5">
                       	                            <?php if ( $field->light ) { ?>
														<?php if ( $field->description ) { ?>
                                                        <span class="DescriptionTip" title="<?php echo $field->label; ?>::<?php echo $field->tooltip; ?>">
                                                            <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                                                        </span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </td>
                                                	<?php if ( $field->display > 0 ) { ?>
                                                    <td style="color: #666666; font-weight: bold;">
                                                        <?php echo $field->label; ?>:
                                                    </td>
                                                    <?php } ?>
                                                    <td id="<?php echo $field->container; ?>">
                                                        <?php echo $field->form; ?>
                                                    </td>
                                                </tr>
												<?php } else { echo $field->form; } ?>
                                        <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </div>
                                    <div class="collection-group-button">
                                        <?php if ( @$jSeblod->{$item}['group']->deletable ) { ?>
                                        <img class="button-del" onclick="CCK_GROUP_Remove(this);" src="<?php echo $root; ?>/media/jseblod/_icons/del-default.gif" alt="Del" />
                                        <?php } ?>
                                        <?php if ( @$jSeblod->{$item}['group']->repeatable ) { ?>
                                            <img class="button-add" onclick="CCK_GROUP_Copy(this, <?php echo $jSeblod->{$item}['group']->maximum; ?>);" src="<?php echo $root; ?>/media/jseblod/_icons/add-default.gif" alt="Add" />
                                        <?php } ?>
                                        <?php if ( @$jSeblod->{$item}['group']->draggable ) { ?>
                                            <img class="button-drag" src="<?php echo $root; ?>/media/jseblod/_icons/drag-default.gif" alt="Drag" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                        
                            </ul>
                        <?php } ?>
                        
                        </td>
                    </tr>
                
                <?php } else { ?>
                                
                <?php if ( @$jSeblod->{$item}[0]->display != -1 ) {
                  $n2	=	count( $jSeblod->$item ); ?>
                  
              <?php if ( @$jSeblod->{$item}[0]->display == 0 ) { 
                  for ( $i2 = 0; $i2 < @$n2; $i2++ ) {
                    if ( $jSeblod->{$item}[$i2] ) {
                      echo $jSeblod->{$item}[$i2]->form;
                    }
                  }
              } else { ?>
				<tr>
				<td width="25" <?php echo ( ! ( @$jSeblod->{$item}[0]->light || @$jSeblod->{$item}[0]->display == 3 ) ) ? '' : 'class="key_balloon"'; ?>>
                <?php if ( @$jSeblod->{$item}[0]->light ) { ?>
                    <?php if ( $jSeblod->{$item}[0]->description ) { ?>
                    <span class="DescriptionTip" title="<?php echo $jSeblod->{$item}[0]->label; ?>::<?php echo $jSeblod->{$item}[0]->tooltip; ?>">
                        <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                    </span>
                    <?php } ?>
                <?php } ?>
                </td>
                <td width="140" <?php echo ( ! ( @$jSeblod->{$item}[0]->light || @$jSeblod->{$item}[0]->display == 3 ) ) ? '' : 'class="key"'; ?>>
                <?php if ( @$jSeblod->{$item}[0]->display == 3 || @$jSeblod->{$item}[0]->display == 2 ) { ?>
                    <label for="<?php echo $jSeblod->{$item}[0]->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.';"'; } ?>><?php echo ( $jSeblod->{$item}[0]->label ) ? $jSeblod->{$item}[0]->label . $labelSeparator : ''; ?></label>
                <?php } ?>
                </td>
                <td align="left">
                <?php if ( @$jSeblod->{$item}[0]->draggable ) { ?>
                <script type="text/javascript">
					window.addEvent('domready', function(){
						new Sortables($('<?php echo $jSeblod->{$item}[0]->name; ?>'), {
							'handles': $('<?php echo $jSeblod->{$item}[0]->name; ?>').getElements('img.button-drag')
						});	
					});
				</script>
                <?php } ?>
                <ul id="<?php echo $jSeblod->{$item}[0]->name; ?>" class="collection-elem-repeatable">
				<?php for ( $i2 = 0; $i2 < @$n2; $i2++ ) {
				
					if ( $jSeblod->{$item}[$i2] ) { ?>
					
                    <?php $colspan = 0; ?>
                    <?php if ( $jSeblod->{$item}[$i2]->display != -1 ) { ?>
					<?php if ( $jSeblod->{$item}[$i2]->displayfield == 0 || ( $jSeblod->{$item}[$i2]->displayfield == 1 && $client->id ) || ( $jSeblod->{$item}[$i2]->displayfield == 2 && !$client->id ) ) { ?>
                        <li class="collection-elem-repeatable"> 
                        	<div class="collection-elem-wrap">   
                                <div class="collection-elem-form">
                                    <?php echo $jSeblod->{$item}[$i2]->codebefore; ?>
                                    <?php echo $jSeblod->{$item}[$i2]->form; ?>
                                    <?php echo $jSeblod->{$item}[$i2]->codeafter; ?>
                                </div>
                                <div class="collection-elem-button">
	                                <?php if ( @$jSeblod->{$item}[0]->deletable ) { ?>
                                    <img class="button-del" onclick="CCK_ELEM_Remove(this);" src="<?php echo $root; ?>/media/jseblod/_icons/del-default.gif" alt="Del" />
                                    <?php } ?>
                                    <?php if ( @$jSeblod->{$item}[0]->repeatable ) { ?>
                                    <img class="button-add" onclick="CCK_ELEM_Copy(this, <?php echo $jSeblod->{$item}[0]->maximum; ?>);" src="<?php echo $root; ?>/media/jseblod/_icons/add-default.gif" alt="Add" />
                                    <?php } ?>
                                    <?php if ( @$jSeblod->{$item}[0]->draggable ) { ?>
	                                    <img class="button-drag" src="<?php echo $root; ?>/media/jseblod/_icons/drag-default.gif" alt="Drag" />
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                    <?php } else { echo $jSeblod->{$item}[$i2]->form; }?>
			        <?php } ?>

				<?php } ?>
  				<?php } ?>
               	</ul>
    	        </td>
	            </tr>
                <?php } } ?>
                
                <?php } ?>
                
			<?php } else { ?>

            <!-- Field Types (Var)-->
			<?php if ( $jSeblod->$item->display == -3 ) {
                    if ( $animPanels ) {
                        echo '</table>';
                        if ( $panelId == 0 ) {
							echo '<br />';
                            $objPanel =& JPane::getInstance( 'Sliders', array( 'startOffset' => 0, 'startTransition' => 0, 'allowAllClose' => true ) ); 
                            echo $objPanel->startPane( 'panel_'.$jSeblod->$item->name );
                            echo $objPanel->startPanel( $jSeblod->$item->label, 'panel'.$panelId );
                            echo '<table class="admintable">';
                        } else {
                            if ( $subPanelId > 0 ) {
                                echo $objSubPanel->endPanel();
                                echo $objSubPanel->endPane();	//
                                echo '</table>';
								$subPanelId = -1;
                            }
                            echo $objPanel->endPanel().'<br />';
							if ( $jSeblod->$item->bool2 ) {
								$closed	=	1;
								echo $objPanel->endPane();
							} else {
                            	echo $objPanel->startPanel( $jSeblod->$item->label, 'panel'.$panelId );
							}
                            echo '<table class="admintable">';
                        }
                        $panelId++;
                    } else {
                        echo '<tr><td colspan="3"><h3 '.$panelTitleStyle.'>'.$jSeblod->$item->label.'</h3></td></tr>';
                    }
                } else if ( $jSeblod->$item->display == -2 ) {
                    if ( $animPanels ) {
                        if ( $subPanelId == 0 ) {
	                        echo '</table>';
                            $objSubPanel =& JPane::getInstance( 'tabs', array( 'startOffset' => 0 ) );	//!! $objSubPanel =& JPane::getInstance( 'tabs', array( 'startOffset' => 1 ) ); 
                            echo $objSubPanel->startPane( 'panel_'.$jSeblod->$item->name );
                            echo $objSubPanel->startPanel( $jSeblod->$item->label, 'subpanel'.$subPanelId );
                            echo '<table class="admintable">';
                        } else {
                            echo '</table>';
                            echo $objSubPanel->endPanel();
							if ( $jSeblod->$item->bool2 ) {
								$subClosed	=	1;
								echo $objSubPanel->endPane();
								echo '<br />';
							} else {
                            	echo $objSubPanel->startPanel( $jSeblod->$item->label, 'subpanel'.$subPanelId );
							}
                            echo '<table class="admintable">';
                        }
                        $subPanelId++;
                    } else {
                        echo '<tr><td colspan="3"><h3 '.$panelTitleStyle.'>'.$jSeblod->$item->label.'</h3></td></tr>';
                    }
                } else { ?>
                    <?php $colspan = 0; ?>            
                    <?php if ( $jSeblod->$item->display != -1 ) { ?>
					<?php if ( @$jSeblod->$item->formdisplay != 'none' && ($jSeblod->$item->displayfield == 0 || ( $jSeblod->$item->displayfield == 1 && $client->id ) || ( $jSeblod->$item->displayfield == 2 && !$client->id) ) ) { ?>
                        <tr> 
                            <td width="25" <?php echo ( ! ( $jSeblod->$item->light || $jSeblod->$item->display == 3 ) ) ? '' : 'class="key_balloon"'; ?>>
                            <?php if ( $jSeblod->$item->light ) { ?>
                                <?php if ( $jSeblod->$item->description ) { ?>
                                <span class="DescriptionTip" title="<?php echo $jSeblod->$item->label; ?>::<?php echo $jSeblod->$item->tooltip; ?>">
                                    <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                                </span>
                                <?php } ?>
                            <?php } ?>
                            </td>
                            <td width="140" <?php echo ( ! ( $jSeblod->$item->light || $jSeblod->$item->display == 3 ) ) ? 'class="cck_label"' : 'class="key cck_label"'; ?>>
                            <?php if ( $jSeblod->$item->display == 3 ||  $jSeblod->$item->display == 2 ) { ?>
                                <label for="<?php echo $jSeblod->$item->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.'"'; } ?>><?php echo ( $jSeblod->$item->label ) ? $jSeblod->$item->label . $labelSeparator : ''; ?></label>
                            <?php } ?>
                            </td>
                            <td class="cck_field" id="<?php echo $jSeblod->$item->container; ?>">
                            	<?php echo $jSeblod->$item->codebefore; ?>
                                <?php if($item == 'gl_tags'){
									$document = JFactory::getDocument();
									$renderer = $document->loadRenderer('module');
									$module = JModuleHelper::getModule('newsflash_jseblod','Admin tags');
									echo $renderer->render($module);
								}else{
									echo $jSeblod->$item->form;
								} ?>
                              	<?php echo $jSeblod->$item->codeafter; ?>
                            </td>
                        </tr>
                    <?php } else { echo $jSeblod->$item->form; }?>
			        <?php } ?>
            <?php } } ?>
		
	<?php } } ?>
	</table>
	<?php
	if ( $subPanelId && $animPanels && ! $panelId && ! @$subClosed ) {
		echo $objSubPanel->endPanel();
		echo $objSubPanel->endPane();
	}
	if ( $panelId && $animPanels && ! @$closed ) {
		echo $objPanel->endPanel();
		echo $objPanel->endPane();
	}
	?>
</fieldset>
	
<?php endif;
/**
 * End
 **/
?>